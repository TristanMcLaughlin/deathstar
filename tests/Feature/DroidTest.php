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
    public function testCrashInitiateDroid()
    {
        $response = $this->post('/map', [
            'direction' => 'f'
        ]);

        $response->assertStatus(417);
    }

    public function testEmptyInitiateDroid()
    {
        $response = $this->post('/map', [
            'direction' => 'rfff'
        ]);

        $response->assertStatus(410);
    }
}
