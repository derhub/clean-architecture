<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
