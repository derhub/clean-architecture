<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonQueryResponse;
use Derhub\IdentityAccess\Account\Shared\DBColumns;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByUsernameHandler
{
    public function __construct(
        private QueryUserAccountRepository $repo
    ) {
    }

    public function __invoke(GetByUsername $msg): QueryResponse
    {
        $username = Username::fromString($msg->username());

        $queryResult = $this->repo
            ->addFilter(
                OperationFilter::eq(
                    DBColumns::DBAL_USERNAME, $username->toString()
                )
            )
            ->singleResult()
        ;

        $result = [];
        if ($queryResult) {
            $result = [$queryResult];
        }

        return new CommonQueryResponse($result);
    }
}