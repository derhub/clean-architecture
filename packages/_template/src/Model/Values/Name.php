<?php

namespace Derhub\Template\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectStr;

class Name implements ValueObjectStr
{
    private ?string $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty template name';
        }

        return 'template name: '.$this->toString();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toString() === $this->toString();
    }

    public static function fromString(string $value): self
    {
        Assert::betweenLength($value, 2, 100);

        $self = new self();
        $self->value = $value;
        return $self;
    }

    public function toString(): ?string
    {
        return $this->value;
    }

    private function isEmpty(): bool
    {
        return empty($this->value);
    }
}