<?php
/**
 * Include this file will be called on app bootstrap
 */


use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\BusinessDoctrineTypes;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\EmployeeDoctrineTypes;

BusinessDoctrineTypes::register();
EmployeeDoctrineTypes::register();