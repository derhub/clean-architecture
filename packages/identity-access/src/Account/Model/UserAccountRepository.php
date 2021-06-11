<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\Shared\Model\AggregateRepository;

/**
 * @template-extends AggregateRepository<\Derhub\IdentityAccess\Account\Model\Values\UserId>
 */
interface UserAccountRepository extends AggregateRepository
{
}