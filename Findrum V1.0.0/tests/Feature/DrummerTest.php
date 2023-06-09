<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DrummerTest extends TestCase
{
    /**
     * Can collect drummers out of the database.
     */
    public function test_index(): void
    {
        $response = $this->get('/api/drummers');
        $response->assertStatus(200);
    }

    /**
     * Can store a drummer in the database.
     */
    public function test_store(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". DrummerTest::log_in()
        ])->post('/api/drummers', ["first_name" => "Test", "last_name" => "Drummer"]);
        $response->assertStatus(201);
    }

    /**
     * The store function is protected.
     */
    public function test_store_is_protected(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/drummers', ["first_name" => "Test", "second_name" => "Drummer"]);
        $response->assertStatus(500);
        // $response = $this->withHeaders([
        //     'X-Header' => 'Value',
        //     'Authorization' => "Bearer 1|45"
        // ])->post('/api/drummers', ["first_name" => "Test", "last_name" => "Drummer"]);
        // $response->assertStatus(403);
    }

    /**
     * Can find a drummer in the database.
     */
    public function test_show(): void
    {
        $response = $this->get('/api/drummers/'. DrummerTest::find_last());
        $response->assertStatus(200);
    }
    
    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit_is_protected()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->patch('/api/drummers/'. DrummerTest::find_last(), ["first_name" => "Test", "second_name" => "Drummer"]);
        $response->assertStatus(500);
        // $response = $this->withHeaders([
        //     'X-Header' => 'Value',
        //     'Authorization' => "Bearer 1|45"
        // ])->patch('/api/drummers/'. DrummerTest::find_last(), ["first_name" => "Test", "second_name" => "Drummer"]);
        // $response->assertStatus(403);
    }
    
    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". DrummerTest::log_in()
        ])->patch('/api/drummers/'. DrummerTest::find_last(), ["first_name" => "Test", "last_name" => "Drummer"]);
        $response->assertStatus(200);
    }
                
    /**
     * Can delete a drummer from the database.
    */
    public function test_delete_is_protected(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->delete('/api/drummers/'. DrummerTest::find_last());
        $response->assertStatus(500);
        // $response = $this->withHeaders([
        //     'X-Header' => 'Value',
        //     'Authorization' => "Bearer 1|45"
        // ])->delete('/api/drummers/'. DrummerTest::find_last());
        // $response->assertStatus(403);
    }

    /**
     * Can delete a drummer from the database.
    */
    public function test_delete(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer ". DrummerTest::log_in()
        ])->delete('/api/drummers/'. DrummerTest::find_last());
        $response->assertStatus(200);
    }

    private function log_in()
    {
        $response = $this->withHeaders([
            'X-Header' => "Value",
        ])->post('/api/login', ['password' => '-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8', 'email' => 'root@development.com']);
        return $response->baseResponse->original['access_token'];
    }

    private function find_last() {
        $response = $this->get('/api/drummers');
        return $response->baseResponse->original[count($response->baseResponse->original) - 1]->id;
    }
}
