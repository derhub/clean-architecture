<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\IdentityAccess\Account\Model\Values\TenantId;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestamps;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountEmailChanged;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountPasswordChanged;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountRegistered;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountRolesActivated;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountRolesChanged;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountRolesDeactivated;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountUsernameChanged;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\Role;
use Derhub\IdentityAccess\Account\Model\Values\Status;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Model\Values\Username;

class UserAccount implements AggregateRoot
{
    use UseAggregateRoot;
    use UseTimestamps;

    private UserId $userId;
    private Credentials $credentials;
    private UserAccountRoles $roles;
    private Status $status;

    public function __construct(
        ?UserId $userId = null,
    ) {
        $this->userId = $userId ?? new UserId();
        $this->roles = new UserAccountRoles();
        $this->status = Status::activated();
        $this->credentials = new Credentials();
        $this->initTimestamps();
    }

    public function aggregateRootId(): UserId
    {
        return $this->userId;
    }

    public static function register(
        UserId $userId,
        Email $email,
        Username $username,
        Password $password,
    ): self {
        $self = new self($userId);
        $self->credentials =
            Credentials::with($username, $email, $password);

        $self->record(
            new UserAccountRegistered(
                $self->userId->toString(),
                $self->credentials->username()->toString(),
                $self->credentials->email()->toString(),
                $self->roles->toArray()
            ),
        );
        return $self;
    }

    public function changeEmail(Email $email): self
    {
        $this->credentials = $this->credentials->setEmail($email);
        $this->record(
            new UserAccountEmailChanged(
                $this->userId->toString(),
                $this->credentials->email()->toString(),
            )
        );
        return $this;
    }

    public function changeUsername(Username $username): self
    {
        $this->credentials = $this->credentials->setUsername($username);
        $this->record(
            new UserAccountUsernameChanged(
                $this->userId->toString(),
                $this->credentials->username()->toString(),
            )
        );
        return $this;
    }

    public function changePassword(Password $password): self
    {
        $this->credentials = $this->credentials->setPassword($password);
        $this->record(
            new UserAccountPasswordChanged(
                $this->userId->toString()
            )
        );
        return $this;
    }

    public function activate(): self
    {
        $this->status = Status::activated();
        $this->record(
            new UserAccountRolesActivated(
                $this->userId->toString()
            )
        );
        return $this;
    }

    public function deactivate(): self
    {
        $this->status = Status::deactivated();
        $this->record(
            new UserAccountRolesDeactivated(
                $this->userId->toString()
            )
        );
        return $this;
    }
}