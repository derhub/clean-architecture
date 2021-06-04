<?php

return \Derhub\Shared\Database\Migration\MigrationHelper::createPhinxConfig(
    migrations: ['%%PHINX_CONFIG_DIR%%/vendor/derhub/*/configs/migrations'],
    seeders: ['%%PHINX_CONFIG_DIR%%/vendor/derhub/*/configs/seeders'],
    loadDotEnv: __DIR__
);
