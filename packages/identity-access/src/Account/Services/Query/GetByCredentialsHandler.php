<?php

namespace Derhub\IdentityAccess\Account\Services\Query;

use Derhub\IdentityAccess\Account\Infrastructure\Database\QueryUserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonQueryResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Query\Filters\OperationFilter;

class GetByCredentialsHandler
{
    public function __construct(
        private QueryUserAccountRepository $repo
    ) {
    }

    public function __invoke(GetByCredentials $msg): QueryResponse
    {
        if (\str_contains($msg->emailOrUsername(), '@')) {
            $filterColumn = 'credentials.email';
            $emailOrUsername = Email::fromString($msg->emailOrUsername());
        } else {
            $filterColumn = 'credentials.username';
            $emailOrUsername = Username::fromString($msg->emailOrUsername());
        }

        $queryResult = $this->repo
            ->addFilter(
                OperationFilter::eq(
                    $filterColumn, $emailOrUsername->toString()
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