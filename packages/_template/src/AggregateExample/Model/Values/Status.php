<?php

namespace Derhub\Template\AggregateExample\Model\Values;

use Derhub\Shared\Utils\Assert;
use Derhub\Shared\Values\ValueObject;
use Derhub\Shared\Values\ValueObjectInt;
use Derhub\Shared\Values\ValueObjectStr;

use function array_flip;

class Status implements ValueObjectStr, ValueObjectInt
{
    public const DRAFT = 0;
    public const PUBLISH = 1;

    public const STATUSES = [
        self::DRAFT => 'draft',
        self::PUBLISH => 'publish',
        self::UN_PUBLISH => 'un-publish',
    ];
    public const UN_PUBLISH = 2;
    /**
     * @var string[]
     */
    private static array $stringStatuses;

    private int $value;

    public static function draft(): self
    {
        return self::init(self::DRAFT);
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function fromInt(int $value): self
    {
        Assert::inArray($value, self::STATUSES);

        return self::init($value);
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function fromString(string $value): self
    {
        Assert::keyIsset(self::$stringStatuses, $value);

        return self::init(self::$stringStatuses[$value]);
    }

    private static function init(int $value): self
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }

    public static function publish(): self
    {
        return self::init(self::PUBLISH);
    }

    public static function unPublish(): self
    {
        return self::init(self::UN_PUBLISH);
    }

    public function __construct()
    {
        $this->value = self::DRAFT;
        self::$stringStatuses = array_flip(self::STATUSES);
    }

    public function __toString()
    {
        return 'template status: '.$this->toString();
    }

    public function sameAs(ValueObject $other): bool
    {
        return $other instanceof self
            && $other->toString() === $this->toString();
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return self::STATUSES[$this->value];
    }
}
