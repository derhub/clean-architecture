<?php

return [
    'bootstraps' => glob(base_path('vendor/derhub/*/configs/bootstrap.php')) ?? [],
    'modules' => [
        Derhub\BusinessManagement\Business\Module::class,
        Derhub\BusinessManagement\Employee\Module::class,
    ],
];
