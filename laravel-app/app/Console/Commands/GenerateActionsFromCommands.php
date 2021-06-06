<?php

namespace App\Console\Commands;

use App\StubPrinter;
use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Shared\Capabilities\ClassName;
use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\ModuleInterface;
use File;
use Illuminate\Console\Command as BaseCommand;
use Str;
use Composer\Console\Application as ComposerApp;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

use function array_filter;
use function array_intersect;
use function array_map;
use function array_merge;
use function array_pop;
use function array_shift;
use function array_unique;
use function base_path;
use function class_exists;
use function count;
use function explode;
use function file_put_contents;
use function implode;
use function in_array;
use function is_a;
use function is_array;
use function sprintf;
use function str_contains;
use function str_replace;
use function strtolower;
use function ucfirst;

use const PHP_EOL;

class GenerateActionsFromCommands extends BaseCommand
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate actions from registered command and queries';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'derhub:module:actions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ModuleService $moduleService)
    {
        parent::__construct();
    }

    private function createCallHandleParam(array $params): string
    {
        $results = '';
        foreach ($params as $snakeName => $param) {
            $defaultValue = $param['defaultValue'];
            $results .= sprintf(
                    '%s: $this->input(\'%s\'%s),',
                    $param['name'],
                    $snakeName,
                    $defaultValue === null ? '' : ', '.$defaultValue
                ).PHP_EOL;
        }

        return $results;
    }

    private function createCommandParams(array $params): string
    {
        $result = '';
        foreach ($params as $param) {
            $defaultValue = '';
            if ($param['defaultValue'] !== null) {
                $defaultValue = ' = '.$param['defaultValue'];
            }
            $result .= '$'.$param['name'].$defaultValue.','.PHP_EOL;
        }

        return $result;
    }

    private function createHandlePrams(array $params): string
    {
        $result = '';
        foreach ($params as $param) {
            $result .= $param['type'].' $'.$param['name'].','.PHP_EOL;
        }

        return $result;
    }

    private function createValidationRules(array $params): string
    {
        $results = '['.PHP_EOL;
        foreach ($params as $name => $param) {
            if (empty($param['rules'])) {
                continue;
            }

            $rules = implode(
                ',',
                array_map(static fn ($item) => "'$item'", $param['rules'])
            );
            $results .= sprintf('\'%s\' => [%s],'.PHP_EOL, $name, $rules);
        }

        return $results.']';
    }

    private function getCommandParams(string $commandClass): ?array
    {
        $refClass = new \ReflectionClass($commandClass);
        $constructor = $refClass->getConstructor();
        if (! $constructor) {
            $this->error('invalid command constructor '.$commandClass);

            return null;
        }

        if ($constructor->getNumberOfParameters() === 0) {
            return [];
        }

        $params = $constructor->getParameters();

        $result = [];
        foreach ($params as $param) {
            $type = (string)$param->getType();
            $data = [
                'name' => $param->name,
                'type' => $type,
                'rules' => [],
                'defaultValue' => null,
            ];

            if ($param->isDefaultValueAvailable()) {
                $data['defaultValue'] = $param->getDefaultValue();
            }

            $data['rules'] = $this->getRules($param);
            $result[Str::snake($param->name)] = $data;
        }

        return $result;
    }

    private function getRules(\ReflectionParameter $param): array
    {
        $rules = [];
        if (! $param->isOptional()) {
            $rules[] = 'required';
        }

        if ($param->isOptional() || $param->getType()?->allowsNull()) {
            $rules[] = 'nullable';
        }

        $typeRules = $this->getRulesFromType($param->getType());
        if ($typeRules && is_array($typeRules)) {
            $rules = array_merge($rules, $typeRules);
        } elseif ($typeRules) {
            $rules[] = $typeRules;
        }


        $diff = array_intersect(['string', 'numeric'], $rules);
        if (count($diff) === 2) {
            $rules = array_filter(
                $rules,
                fn ($r) => ! in_array($r, ['string', 'numeric'])
            );
            $rules[] = 'alpha_num';
        }

        if (! in_array('array', $rules)) {
            if ($param->name === 'aggregateRootId'
                || str_contains(strtolower($param->name), 'id')) {
                $rules[] = 'uuid';
            }

            if (str_contains(strtolower($param->name), 'email')) {
                $rules[] = 'email';
            }

            if (str_contains(strtolower($param->name), 'slug')) {
                $rules[] = 'max:100';
            }

            if (str_contains(strtolower($param->name), 'date')) {
                $rules[] = 'date';
            }
        }

        //TODO: add more automated validation

        return array_unique($rules);
    }

    public function createActions(ModuleInterface $module): void
    {
        /** @var StubPrinter $stub */
        foreach ($this->generator($module) as $stub) {
            $data = $stub->getData();
            $fullActionClass = sprintf(
                '%s\\%s',
                $data['__$actionNamespace'],
                $data['__$actionClass']
            );
            $directory =
                str_replace('\\', '/', $data['__$actionNamespace']).'/';
            $filename = $data['__$actionClass'].'.php';


            if (class_exists($fullActionClass)) {
                $this->info(
                    'ignored because its already exist: '.$fullActionClass
                );

                continue;
            }

            $this->info(
                'generating: '.$data['__$actionClass'].' -> '.$directory.$filename
            );

            $content = $stub->getContent();

            File::ensureDirectoryExists($directory);
            file_put_contents($directory.$filename, $content);
        }
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generateActions(
        ModuleInterface $module,
        string $commandClass
    ): ?StubPrinter {
        $extractClass = explode('\\', $module::class);
        /* $moduleClass = */
        array_pop($extractClass);
        /* $vendor =  */
        array_shift($extractClass);

        $namespace = 'App\\Actions\\'.implode('\\', $extractClass);
        $commandClassName = ClassName::for($commandClass);
        $actionClass = ucfirst(Str::camel($commandClassName).'Action');

        if (class_exists($namespace.'\\'.$actionClass)) {
            $this->info(
                sprintf(
                    'skipping action "%s" because its already exist',
                    $namespace.'\\'.$actionClass
                ),
                OutputInterface::VERBOSITY_NORMAL
            );
        }


        $commandType = match (true) {
            is_a($commandClass, Command::class, true) => 'Command',
            is_a($commandClass, Query::class, true) => 'Query',
            default => null
        };

        if ($commandType === null) {
            $this->error('unknown command: '.$commandClass);

            return null;
        }

        $params = $this->getCommandParams($commandClass);
        if (! $params) {
            $this->error('invalid construct params: '.$commandClass);

            return null;
        }

        return StubPrinter::byPath(
            base_path('stubs/command-generator-actions.stub'),
            [
                '__$actionNamespace' => $namespace,
                '__$actionClass' => $actionClass,

                '__$commandClass' => $commandClass,
                '__$commandParam' => $this->createCommandParams($params),
                '__$commandType' => $commandType,

                '__$handleParam' => $this->createHandlePrams($params),
                '__$handleCallParam' => $this->createCallHandleParam($params),

                '__$validationRules' => $this->createValidationRules($params),
            ],
        );
    }

    /**
     * @param \Derhub\Shared\ModuleInterface $module
     * @return \Generator<StubPrinter>
     */
    public function generator(ModuleInterface $module): \Generator
    {
        $services = $module->services();
        $commands = $services[$module::SERVICE_COMMANDS] ?? [];

        foreach ($commands as $command => $handler) {
            yield $this->generateActions($module, $command);
        }

        $queries = $services[$module::SERVICE_QUERIES] ?? [];

        foreach ($queries as $query => $handler) {
            yield $this->generateActions($module, $query);
        }
    }

    public function getRulesFromType(
        \ReflectionUnionType|\ReflectionType $paramType
    ): string|array|null {
        if ($paramType instanceof \ReflectionUnionType) {
            $rules = [];
            foreach ($paramType->getTypes() as $type) {
                $rules[] = $this->getRulesFromType($type);
            }

            if (in_array('array', $rules, true)) {
                return $rules;
            }

            return $rules;
        }

        $allowedType = in_array(
            $paramType,
            [
                'string',
                'array',
                'boolean',
            ]
        );

        if ($allowedType) {
            return $paramType;
        }

        $isNumeric = in_array($paramType, ['double', 'float', 'int']);

        if ($isNumeric) {
            return 'numeric';
        }

        return null;
    }

    public function handle(): void
    {
        $modules = $this->moduleService->list()->all();
        foreach ($modules as $module) {
            $this->createActions($module);
        }

        $application = new ComposerApp();
        $application->setAutoExit(true);

        $this->info('running: composer code:fix-actions');
        $input = new ArrayInput(
            [
                'command' => 'code:fix-actions',
                '-q' => true,
                '-d' => base_path(),
            ]
        );
        $application->run($input);
    }
}
