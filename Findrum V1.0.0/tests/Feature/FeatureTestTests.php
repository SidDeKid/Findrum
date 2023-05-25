<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureTestTests extends TestCase
{
    /**
     * A basic test example.
     */
    public function IsRunningTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
