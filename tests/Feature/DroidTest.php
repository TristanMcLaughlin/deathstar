<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DroidTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInitiateDroid()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson('/api/droid');

        $response->assertStatus(200);
    }
}
