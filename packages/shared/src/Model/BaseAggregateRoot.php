<?php

namespace Derhub\Shared\Model;

abstract class BaseAggregateRoot implements AggregateRoot
{
    use UseAggregateRoot;
}