<?php

namespace Derhub\Business\Model;

use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Model\AggregateRepository;

interface BusinessRepository extends AggregateRepository
{
    public function get(BusinessId $id): ?Business;

    public function save(Business $entity): void;

    public function getNextId(): BusinessId;
}
