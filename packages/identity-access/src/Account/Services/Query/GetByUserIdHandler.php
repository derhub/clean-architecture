<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Services\CommonQueryResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByUserIdHandler
{
    public function __construct(
        private QueryUserAccountRepository $repo
    ) {
    }

    public function __invoke(GetByUserId $msg): QueryResponse
    {
        $userId = UserId::fromString($msg->userId());
        $result = $this->repo
            ->addFilter(OperationFilter::eq('userId', $userId->toBytes()))
            ->singleResult();

        return new CommonQueryResponse([$result]);
    }
}