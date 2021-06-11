<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectInt;
use Derhub\IdentityAccess\Account\Shared\UserStatusTypes;

class Status implements ValueObjectInt
{
    private int $value;

    public function __construct()
    {
        $this->value = UserStatusTypes::ACTIVATED;
    }

    /**
     * @param int $value
     * @return \Derhub\IdentityAccess\Account\Model\Values\Status
     */
    protected static function init(int $value): Status
    {
        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function __toString()
    {
        return 'user status '.$this->toInt();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toInt() === $this->toInt();
    }

    public static function fromInt(int $value): ValueObjectInt
    {
        Assert::inArray(
            $value,
            [UserStatusTypes::ACTIVATED, UserStatusTypes::ACTIVATED]
        );

        return self::init($value);
    }

    public static function activated(): self
    {
        return self::init(UserStatusTypes::ACTIVATED);
    }

    public static function deactivated(): self
    {
        return self::init(UserStatusTypes::DEACTIVATED);
    }

    public function toInt(): int
    {
        return $this->value;
    }
}