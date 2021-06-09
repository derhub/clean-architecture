<?php

namespace App\Console\Commands;

use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Shared\Capabilities\MessageName;
use Derhub\Shared\ModuleInterface;
use Illuminate\Console\Command;

use function sprintf;

class ModuleListServicesConsole extends Command
{
    protected $signature = 'derhub:module:services 
                            {moduleId : The module ID}
                            {--c|command : List all commands}
                            {--qu|query : List all Queries}
                            {--e|event : List all Events}
                            {--d|dependency : List all Dependencies}
                            ';

    protected $description = 'List Module services';

    public function __construct(private ModuleService $moduleService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $id = $this->argument('moduleId');
        $module = $this->moduleService->list()->get($id);
        if (! $module) {
            $this->error(sprintf('Module %s not found', $id));
            return;
        }

        $rows = [];
        $services = $module->services();
        $header = ['name', 'message'];

        if ($this->option('command')) {
            $this->rowMessage(
                $rows,
                $module::SERVICE_COMMANDS,
                $services[$module::SERVICE_COMMANDS]
            );
        }

        if ($this->option('query')) {
            $this->rowMessage(
                $rows,
                $module::SERVICE_QUERIES,
                $services[$module::SERVICE_QUERIES]
            );
        }

        if ($this->option('event')) {
            $this->rowMessage(
                $rows, $module::SERVICE_EVENTS,
                $services[$module::SERVICE_EVENTS]
            );
        }


        $this->table($header, $rows);
    }

    private function rowMessage(
        array &$rows,
        string $type,
        array $service
    ): void {
        $id = $this->argument('moduleId');

        if ($type === ModuleInterface::SERVICE_EVENTS) {
            foreach ($service as $messageClass) {
                $rows[] = [
                    'name' => MessageName::for($id, $type, $messageClass),
                    'message' => $messageClass,
                ];
            }
            return;
        }

        foreach ($service as $messageClass => $handler) {
            $rows[] = [
                'name' => MessageName::for($id, $type, $messageClass),
                'message' => $messageClass,
            ];
        }
    }

}
