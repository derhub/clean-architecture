<?php

namespace App\Console\Commands;

use App\BuildingBlocks\ActionGenerator\MessageClassParameterParser;
use App\BuildingBlocks\ActionGenerator\TypesValidationRulesGenerator;
use App\BuildingBlocks\ActionGenerator\StubActionClassWriter;
use App\BuildingBlocks\Actions\Fields\ArrayField;
use App\BuildingBlocks\Actions\Fields\BooleanField;
use App\BuildingBlocks\Actions\Fields\NumericFiled;
use App\BuildingBlocks\Actions\Fields\StringField;
use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Shared\Utils\ClassName;
use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Module\ModuleInterface;
use Derhub\Shared\Utils\Str;
use File;
use Generator;
use Illuminate\Console\Command as BaseCommand;
use Composer\Console\Application as ComposerApp;


use Symfony\Component\Console\Input\ArrayInput;

use function array_diff;
use function array_merge;
use function base_path;


use function explode;
use function implode;
use function sprintf;

use function strlen;

use function strtolower;

use const PHP_EOL;

class GenerateActionsConsole extends BaseCommand
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
    protected $signature = 'derhub:module:actions
                            {moduleId? : Generated action for specific module}
                            {--f|force : Create or Recreate generated action files}
                            {--ff|force-all : Create or Recreate generated action and extend action files}
                            ';
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private string $stubForGeneratedActions;
    private string $stubForExtendActions;

    public function __construct(private ModuleService $moduleService)
    {
        parent::__construct();
        $this->stubForGeneratedActions =
            File::get(base_path('stubs/command-generated-actions.stub'));
        $this->stubForExtendActions =
            File::get(base_path('stubs/command-extend-generated-actions.stub'));
    }

    public function handle(): void
    {
        $list = $this->moduleService->list();
        if ($id = $this->argument('moduleId')) {
            $module = $list->get($id);
            if ($module) {
                $this->createActions($module);
            } else {
                $this->error(sprintf('Module %s not found', $module->getId()));

                return;
            }
        } else {
            $modules = $list->all();
            foreach ($modules as $module) {
                $this->createActions($module);
            }
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

    private function createFields(array $params): string
    {
        if (empty($params)) {
            return '[]';
        }

        $fields = '['.PHP_EOL;
        foreach ($params as $name => $param) {
            if (empty($param['rules'])) {
                $rules = '';
            } else {
                $rules = implode(
                    ',',
                    array_map(static fn ($item) => "'$item'", $param['rules'])
                );
            }

            $types = implode(
                ', ',
                array_map(static fn ($item) => "'$item'", $param['types'])
            );

            $fields .= sprintf(
                "'%s' => [
                        'name' => '%s',
                        'alias' => '%s',
                        'required' => %s,
                        'types' => %s,
                        'default' => %s, 
                        'rules' => %s,
                    ],",
                $name,
                $name,
                $param['alias'],
                $param['required'] === true ? 'true' : 'false',
                "[$types]",
                $param['default'] ?? 'null',
                "[$rules]"
            );
            $fields .= PHP_EOL;
        }

        $fields .= ']'.PHP_EOL;

        return $fields;
    }

    private function getCommandParams(string $commandClass): ?array
    {
        $parser = MessageClassParameterParser::for($commandClass);
        $result = [];
        foreach ($parser->params() as $name => $config) {
            $config['rules'] ??= $this->getRules($config);
            $result[$name] = $config;
        }

        return $result;
    }

    private function getRules(array $paramConf): array
    {
        /** @var \ReflectionParameter $param */
        [
            'reflectionParam' => $param,
            'types' => $types,
        ] = $paramConf;


        $ruleGenerator =
            new TypesValidationRulesGenerator($param->name, $types);

        return $ruleGenerator->rules();
    }

    public function createActions(ModuleInterface $module): void
    {
        $force = $this->option('force')
            || $this->option('force-all');
        /** @var StubActionClassWriter $stub */
        foreach ($this->generator($module) as $stub) {
            [
                '__class__' => $class,
                '__namespace__' => $namespace,
            ] = $stub->getData();

            $status = $stub->write($force);

            if ($status === $stub::FILE_EXIST) {
                $this->info(
                    "skip because its already exist: $namespace\\$class",
                );
            } else {
                $this->info(
                    'generating: '.$namespace.'\\'.$class
                );
            }

            $this->createExtendGeneratedAction($stub)
                ->write($force)
            ;
        }
    }

    public function generateActionSub(
        ModuleInterface $module,
        string $commandClass
    ): ?StubActionClassWriter {
        $extractClass = explode('\\', $module::class);
        // remove Module class name
        array_pop($extractClass);
//        // remove vendor name ?
//        array_shift($extractClass);

        $namespace =
            'App\\Actions\\'.implode('\\', $extractClass).'\\Generated';
        $commandClassName = ClassName::for($commandClass);
        $actionClass = ucfirst(Str::camelCase($commandClassName).'Action');

        $commandType = match (true) {
            is_a($commandClass, Command::class, true) => 'command',
            is_a($commandClass, Query::class, true) => 'query',
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

        $moduleId = strtolower($module->getId());
        $actionNameExtract = explode('_', Str::snakeCase($commandClassName));
        $possibleModuleIdWords = array_merge(
            Str::pluralize($moduleId),
            Str::pluralize($moduleId),
            [$moduleId],
            ['command', 'query']
        );
        $cleanActionName = implode(
            '-',
            array_diff($actionNameExtract, $possibleModuleIdWords)
        );

        if (empty($cleanActionName) || strlen($cleanActionName) === 2) {
            // we tried to clean the name but it became empty or unreadable in the process
            // in this scenario we will just use the full action class name as slug
            $cleanActionName = implode('-', $actionNameExtract);
        }

        return StubActionClassWriter::byContent(
            $this->stubForGeneratedActions,
            [
                '__module__' => Str::slug($moduleId),
                '__action_slug__' => Str::slug($cleanActionName),
                '__action_id__' => "{$moduleId}.actions.{$actionClass}",
                '__http_method__' => $commandType === 'command'
                    ? 'post'
                    : 'get',
                '__command_type__' => $commandType,
                '__namespace__' => $namespace,
                '__class__' => 'Generated'.$actionClass,
                '__commandClass__' => $commandClass,
                '__fields__' => $this->createFields($params),
                '__field_manager_params__' => $this->createFieldManagerParameters(
                    $params
                ),
            ],
        );
    }

    /**
     * @param \Derhub\Shared\Module\ModuleInterface $module
     * @return \Generator<StubActionClassWriter>
     */
    public function generator(ModuleInterface $module): Generator
    {
        $services = $module->services();

        $queries = $services[$module::SERVICE_QUERIES] ?? [];

        foreach ($queries as $query => $handler) {
            yield $this->generateActionSub($module, $query);
        }

        $commands = $services[$module::SERVICE_COMMANDS] ?? [];

        foreach ($commands as $command => $handler) {
            yield $this->generateActionSub($module, $command);
        }
    }

    private function createExtendGeneratedAction(
        StubActionClassWriter $stub
    ): StubActionClassWriter {
        $generatedData = $stub->getData();
        $data = array_merge(
            $generatedData,
            [

                '__namespace__' => str_replace(
                    '\\Generated',
                    '',
                    $generatedData['__namespace__']
                ),
                '__class__' => str_replace(
                    'Generated',
                    '',
                    $generatedData['__class__']
                ),
                '__extend_class__' => $generatedData['__class__'],
                '__extend_class_full__' => $generatedData['__namespace__'].'\\'.$generatedData['__class__'],
            ]
        );

        $directory =
            str_replace('\\', '/', $data['__namespace__']);

        $file = $directory.'/'.$data['__class__'].'.php';
        $data['__file__'] = $file;

        return StubActionClassWriter::byContent(
            $this->stubForExtendActions,
            $data
        );
    }

    private function createFieldManagerParameters(array $params): string
    {
        $fieldTypes = [
            'ArrayField' => ArrayField::class,
            'NumericFiled' => NumericFiled::class,
            'BooleanField' => BooleanField::class,
            'StringField' => StringField::class,
        ];

        $result = '['.PHP_EOL;
        foreach ($params as $fieldName => $config) {
            $types = $config['types'] ?? [];

            $fieldType = match (true) {
                in_array('array', $types, true) => 'ArrayField',

                in_array('int', $types, true),
                in_array('float', $types, true),
                in_array('double', $types, true) => 'NumericFiled',

                in_array('bool', $types, true) => 'BooleanField',
                default => 'StringField'
            };

            $result .= sprintf(
                '\'%s\' => new \%s(self::FIELDS[\'%s\']),',
                $fieldName,
                $fieldTypes[$fieldType],
                $fieldName,
            ).PHP_EOL;
        }
        $result .= ']';

        return $result;
    }
}
