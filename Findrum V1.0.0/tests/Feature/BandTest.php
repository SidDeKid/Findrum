<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BandTest extends TestCase
{
    /**
     * Can collect drummers out of the database.
     */
    public function test_index(): void
    {
        $response = $this->get('/api/bands');
        $response->assertStatus(200);
    }

    /**
     * Can store a drummer in the database.
     */
    public function test_store(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BandTest::log_in()
        ])->post('/api/bands', ["name" => "TEST"]);
        $response->assertStatus(201);
    }

    /**
     * Can store a drummer in the database.
     */
    public function test_store_drummer(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BandTest::log_in()
        ])->post('/api/bands/'. BandTest::find_last(). '/drummers/'. BandTest::find_last_drummer());
        $response->assertStatus(200);
    }
    
    /**
     * Can store a drummer in the database.
     */
    public function test_delete_drummer(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BandTest::log_in()
        ])->delete('/api/bands/'. BandTest::find_last(). '/drummers/'. BandTest::find_last_drummer());
        $response->assertStatus(200);
    }

    /**
     * Can find a drummer in the database.
     */
    public function test_show(): void
    {
        $response = $this->get('/api/bands/'. BandTest::find_last());
        $response->assertStatus(200);
    }
    
    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BandTest::log_in()
        ])->patch('/api/bands/'. BandTest::find_last(), ["name" => "TEST"]);
        $response->assertStatus(200);
    }

    /**
     * Can delete a drummer from the database.
    */
    public function test_delete(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". BandTest::log_in()
        ])->delete('/api/bands/'. BandTest::find_last());
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
        $response = $this->get('/api/bands');
        return $response->baseResponse->original[count($response->baseResponse->original) - 1]->id;
    }

    /*
     * Find the last component added to the database.
    */
    public function find_last_drummer() : int
    {
        $response = $this->get('/api/drummers');
        return $response->baseResponse->original[count($response->baseResponse->original) - 1]->id;
    }
}
