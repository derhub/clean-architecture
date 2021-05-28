<?php

namespace Tests\Template\Services;

use EB\Integration\TestUtils\MessageTestCase;
use EB\Shared\ModuleInterface;
use EB\Template\Infrastructure\InMemoryTemplateRepository;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Template\Module;

abstract class ModuleServiceTest extends MessageTestCase
{
    /**
     * @var \EB\Template\Model\ValueObject\TemplateId
     */
    protected TemplateId $lastId;

    public function setUp(): void
    {
        parent::setUp();
        $this->lastId = $this->createId();
    }

    protected function getModule(): ModuleInterface
    {
        return new Module();
    }

    protected function createId(): TemplateId
    {
        return $this->lastId = TemplateId::generate();
    }

    protected function getRepository(): InMemoryTemplateRepository
    {
        return new InMemoryTemplateRepository();
    }
}