<?php

namespace App\Console\Commands;

use Derhub\Integration\ModuleService\ModuleService;
use Illuminate\Console\Command;

class ModuleListConsole extends Command
{
    protected $signature = 'derhub:modules';

    protected $description = 'List all modules';

    public function __construct(private ModuleService $moduleService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $modules = $this->moduleService->list()->all();

        $rows = [];
        $header = ['id', 'commands', 'queries', 'events'];
        /** @var \Derhub\Shared\ModuleInterface $module */
        foreach ($modules as $module) {
            $services = $module->services();
            $rows[] = [
                'id' => $module->getId(),
                'commands' => count($services[$module::SERVICE_COMMANDS]),
                'queries' => count($services[$module::SERVICE_QUERIES]),
                'events' => count($services[$module::SERVICE_EVENTS]),
            ];
        }
        $this->table($header, $rows);
    }
}
