<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComponentTest extends TestCase
{
    /**
     * Can collect drummers out of the database.
     */
    public function test_index(): void
    {
        $response = $this->get('/api/onderdelen');
        $response->assertStatus(200);
    }

    /**
     * Can store a drummer in the database.
     */
    public function test_store(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". ComponentTest::log_in()
        ])->post('/api/onderdelen', ["name" => "Test", "diameter" => 5, "drummer_id" => 1, "brand_id" => 1]);
        $response->assertStatus(201);
    }

    /**
     * The store function is protected.
     */
    public function test_store_is_protected(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/onderdelen', ["name" => "Test", "diameter" => 5, "drummer_id" => 1, "brand_id" => 1]);
        $response->assertStatus(500);
    }

    /**
     * Can find a drummer in the database.
     */
    public function test_show(): void
    {
        $response = $this->get('/api/onderdelen/'. ComponentTest::find_last());
        $response->assertStatus(200);
    }

    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". ComponentTest::log_in()
        ])->patch('/api/onderdelen/'. ComponentTest::find_last(), ["name" => "Test", "diameter" => 5, "drummer_id" => 1, "brand_id" => 1]);
        $response->assertStatus(200);
    }

    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit_is_protected()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->patch('/api/onderdelen/'. ComponentTest::find_last(), ["name" => "Test", "diameter" => 5, "drummer_id" => 1, "brand_id" => 1]);
        $response->assertStatus(500);
    }
        
    /**
     * Can delete a drummer from the database.
    */
    public function test_delete(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". ComponentTest::log_in()
        ])->delete('/api/onderdelen/'. ComponentTest::find_last());
        $response->assertStatus(200);
    }
        
    /**
     * Can delete a drummer from the database.
    */
    public function test_delete_is_protected(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->delete('/api/onderdelen/'. ComponentTest::find_last());
        $response->assertStatus(500);
    }

    private function log_in()
    {
        $response = $this->withHeaders([
            'X-Header' => "Value",
        ])->post('/api/login', ['password' => '-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8', 'email' => 'root@development.com']);
        return $response->baseResponse->original['access_token'];
    }

    private function find_last() {
        $response = $this->get('/api/onderdelen');
        return $response->baseResponse->original[count($response->baseResponse->original) - 1]->id;
    }
}