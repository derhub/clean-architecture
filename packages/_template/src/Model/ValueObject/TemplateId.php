<?php

declare(strict_types=1);

namespace EB\Template\Model\ValueObject;

use EB\Shared\Model\ValueObject\ValueObjectStr;
use EB\Shared\ValueObject\UuidValueObject;

final class TemplateId implements ValueObjectStr
{
    use UuidValueObject;

    public function __toString(): string
    {
        if ($value = $this->toString()) {
            return sprintf('Template id %s', $value);
        }

        return 'empty Template id';
    }
}
