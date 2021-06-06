<?php

namespace App;

use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManager;

class DoctrineEntityManagerDecorator extends EntityManagerDecorator
{
    /**
     * @var callable
     */
    private $creator;

    public function __construct(callable $wrapped)
    {
        parent::__construct($wrapped());
        $this->creator = $wrapped;
    }

    private function createEntity(): EntityManager
    {
        return ($this->creator)();
    }

    public function endConnection(): void
    {
        if (! $this->isOpen()) {
            return;
        }

        $this->getConnection()->close();
        $this->close();
    }

    public function startConnection(): void
    {
        if (! $this->isOpen()) {
            $this->wrapped = $this->createEntity();
        }
    }
}
