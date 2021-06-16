<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Model\MultiTenantAggregateRoot;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class TenantSqlFilter extends SQLFilter
{
    public const COLUMN_NAME = 'tenant_id';
    public const NAME = 'tenantIdentity';
    public const PARAM_KEY = 'tenantIdentity';

    public function addFilterConstraint(
        ClassMetadata $targetEntity,
        $targetTableAlias
    ): string {
        $isMultiTenantAggregate = $targetEntity->reflClass
            ->implementsInterface(MultiTenantAggregateRoot::class)
        ;
        if ($isMultiTenantAggregate) {
            return '';
        }

        return \sprintf(
            '%s.%s = %s',
            $targetTableAlias,
            self::COLUMN_NAME,
            $this->getParameter(self::PARAM_KEY)
        );
//        return $targetTableAlias.'.tenant_id = ' . $this->getParameter('tenantId');
    }
}
