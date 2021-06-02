<?php

namespace Derhub\Integration\ModuleService;

class MessageNameResolver
{
    public function __invoke(string $className): string
    {
        $extract = explode('\\', $className);

        return end($extract);
    }
}
