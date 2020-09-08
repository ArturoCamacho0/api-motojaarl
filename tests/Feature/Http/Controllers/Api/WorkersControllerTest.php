<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WorkersController extends TestCase
{
    use RefreshDatabase;

    /* Test para la función de index */
    public function test_index(){
        $this->withoutExceptionHandling();
        $response = $this->json('GET', '/api/workers');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'user', 'password']
            ]
        ])->assertStatus(200); // OK
    }

    public function test_store(){
        //$this->withoutExceptionHandling();

        $response = $this->json('POST', 'api/workers',[
            'name' => 'Arturo',
            'user' => 'arturo',
            'password' => '123'
        ]);

        $response->assertJsonStructure(['id','name','user','password'])
            ->assertJson(['name' => 'Arturo', 'user' => 'arturo', 'password' => '123'])
            ->assertStatus(201);

        $this->assertDatabaseHas('workers', ['name' => 'Arturo', 'user' => 'arturo', 'password' => '123']);
    }
}
