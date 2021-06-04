<?php

namespace Derhub\BusinessManagement\Employee\Model;

use Derhub\BusinessManagement\Employee\Model\Values\EmployeePosition;
use Derhub\BusinessManagement\Employee\Model\Values\Initial;
use Derhub\Shared\Values\DateTimeLiteral;
use Derhub\Shared\Values\Email;
use Derhub\Shared\Values\ValueObject;

class Details implements ValueObject
{
    private ?string $name;
    private Initial $initial;
    private EmployeePosition $position;
    private Email $email;
    private DateTimeLiteral $birthday;

    public function __construct()
    {
        $this->name = null;
        $this->initial = new Initial();
        $this->position = new EmployeePosition();
        $this->email = new Email();
        $this->birthday = new DateTimeLiteral();
    }

    public static function with(
        string $name,
        Initial $initial,
        EmployeePosition $position,
        Email $email,
        DateTimeLiteral $birthday,
    ): self {
        $self = new self();
        $self->name = $name;
        $self->initial = $initial;
        $self->position = $position;
        $self->email = $email;
        $self->birthday = $birthday;

        return $self;
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $this->initial()->sameAs($other->initial())
            && $this->position()->sameAs($other->position())
            && $this->email()->sameAs($other->email())
            && $this->birthday()->sameAs($other->birthday())
            && $this->name() === $other->name();
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function initial(): Initial
    {
        return $this->initial;
    }

    public function position(): EmployeePosition
    {
        return $this->position;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function birthday(): DateTimeLiteral
    {
        return $this->birthday;
    }
}