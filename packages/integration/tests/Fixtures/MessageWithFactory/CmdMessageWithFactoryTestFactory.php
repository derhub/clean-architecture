<?php

namespace Tests\Integration\Fixtures\MessageWithFactory;

use Tests\Integration\Fixtures\SimpleValueObjFixture;

class CmdMessageWithFactoryTestFactory
{
    public function fromArray(array $data): CmdMessageWithFactoryTest
    {
        return new CmdMessageWithFactoryTest(
            SimpleValueObjFixture::fromString($data['param1']),
            $data['param2'],
        );
    }
}