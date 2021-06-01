<?php

namespace Tests\Template;

use Derhub\Template\AggregateExample\Module;

trait GetModule
{
    protected function getModule(): \Derhub\Shared\ModuleInterface
    {
        return new Module();
    }
}