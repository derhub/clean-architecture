<?php

namespace Derhub\Shared\Exceptions;

use Assert\InvalidArgumentException;

class AssertionFailedException extends InvalidArgumentException implements DomainException
{
}
