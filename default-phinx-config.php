<?php

/**
 * create phinx helper and load env files
 * this will be use when developing module
 *
 * if you want to override the default config create "phinx-config.php"
 */
$definedConfig = __DIR__.'/phinx-config.php';
if (file_exists($definedConfig)) {
    return include $definedConfig;
} else {
    return \Derhub\Shared\Database\Migration\MigrationHelper::createPhinxConfigForModule(
        __DIR__.'/laravel-app'
    );
}
