<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DrummerTest extends TestCase
{
    private $access_token = 0;

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
        if ($access_token == 0) {
            log_in();
        }
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer " + $access_token
        ])->post('/api/drummers', ["first_name" => "Test", "second_name" => "Drummer"]);
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
    }

    /**
     * Can find a drummer in the database.
     */
    public function test_show(): void
    {
        $response = $this->get('/api/drummers/1');
        $response->assertStatus(200);
    }

    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit()
    {
        // if ($access_token == 0) {
        //     log_in();
        // }
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer " + auth()->user()->createToken('API Token')->plainTextToken
        ])->post('/api/drummers', ["first_name" => "Test", "second_name" => "Drummer"]);
        $response->assertStatus(200);
    }

    /** 
     * Can edit an existing drummer in the database
     */
    public function test_edit_is_protected()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/drummers', ["first_name" => "Test", "second_name" => "Drummer"]);
        $response->assertStatus(500);
    }
        
    /**
     * Can delete a drummer from the database.
    */
    public function test_delete(): void
    {
        if ($access_token == 0) {
            log_in();
        }
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => "Bearer " + $access_token
        ])->delete('/api/drummers/2');
        $response->assertStatus(200);
    }
        
    /**
     * Can delete a drummer from the database.
    */
    public function test_delete_is_protected(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->delete('/api/drummers/2');
        $response->assertStatus(500);
    }

    public function log_in()
    {
        $response = $this->withHeaders([
            'X-Header' => "Value",
        ])->post('/api/login', ['password' => '-2c@BPJ8:WmFfSk5JF+$(/R5e-GEfph,cVWjM8X8', 'email' => 'root@development.com']);
        dd($response);
        return $response['headers']['data']['access_token'];
    }
}
