<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Services\CommonQueryResponse;
use Derhub\IdentityAccess\Account\Shared\DBColumns;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByEmailHandler
{
    public function __construct(
        private QueryUserAccountRepository $repo
    ) {
    }

    public function __invoke(GetByEmail $msg): QueryResponse
    {
        $email = Email::fromString($msg->email());

        $queryResult = $this->repo
            ->addFilter(
                OperationFilter::eq(
                    DBColumns::DBAL_EMAIL, $email->toString()
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