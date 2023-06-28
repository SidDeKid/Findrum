<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * Can collect drummers out of the database.
     */
    public function test_index(): void
    {
        $response = $this->get('/api/merken');
        $response->assertStatus(200);
    }

    /**
     * Can store a drummer in the database.
     */
    public function test_store(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BrandTest::log_in()
        ])->post('/api/merken', ["name" => "TEST"]);
        $response->assertStatus(201);
    }

    /**
     * Can find a drummer in the database.
     */
    public function test_show(): void
    {
        $response = $this->get('/api/merken/'. BrandTest::find_last());
        $response->assertStatus(200);
    }
    
    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BrandTest::log_in()
        ])->patch('/api/merken/'. BrandTest::find_last(), ["name" => "TEST"]);
        $response->assertStatus(200);
    }

    /**
     * Can delete a drummer from the database.
    */
    public function test_delete(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BrandTest::log_in()
        ])->delete('/api/merken/'. BrandTest::find_last());
        $response->assertStatus(200);
    }

    /*
     * Return a personal access token.
    */
    private function log_in() : string
    {
        $response = $this->withHeaders([
            'X-Header' => "Value",
        ])->post('/api/login', ['password' => '-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8', 'email' => 'root@development.com']);
        return $response->baseResponse->original['access_token'];
    }

    /*
     * Find the last drummer added to the database.
    */
    public function find_last() : int
    {
        $response = $this->get('/api/merken');
        return $response->baseResponse->original[count($response->baseResponse->original) - 1]->id;
    }
}
