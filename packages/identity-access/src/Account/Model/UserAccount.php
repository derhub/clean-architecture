<?php

namespace Derhub\IdentityAccess\Account\Model;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestamps;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountEmailChanged;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountPasswordChanged;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountRegistered;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountActivated;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountDeactivated;
use Derhub\IdentityAccess\Account\Model\Event\UserAccountUsernameChanged;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\HashedPassword;
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
        $this->status = Status::registered();
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
        HashedPassword $password,
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

    public function changePassword(HashedPassword $password): self
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
            new UserAccountActivated(
                $this->userId->toString()
            )
        );
        return $this;
    }

    public function deactivate(): self
    {
        $this->status = Status::deactivated();
        $this->record(
            new UserAccountDeactivated(
                $this->userId->toString()
            )
        );
        return $this;
    }

    public function changeRememberToken(string $token): self
    {
        $this->credentials = $this->credentials->setRememberToken($token);
        return $this;
    }

    public function changeTwoWayFactor(
        string $twoFactorSecrete,
        string $twoFactorRecoveryCodes
    ): self {
        $this->credentials = $this->credentials
            ->setTwoFactorSecrete($twoFactorSecrete)
            ->setTwoFactorRecoveryCodes($twoFactorRecoveryCodes)
        ;
        return $this;
    }
}