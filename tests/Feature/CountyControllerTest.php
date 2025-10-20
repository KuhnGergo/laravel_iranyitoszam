<?php

namespace Tests\Feature;

use App\Models\County;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountyControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_store_creates_new_county() {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => $token,
        ]);
    }


    public function test_index_returns_counties() {
        County::factory()->create(['name' => 'Pest']);
        County::factory()->create(['name' => 'Baranya']);

        $response = $this->getJson('/api/counties');

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Pest'])->assertJsonFragment(['name' => 'Baranya']);
    }
}
