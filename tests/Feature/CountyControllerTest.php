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
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/counties', [
            'name' => 'Test County',
        ]);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Test County']);
        $this->assertDatabaseHas('counties', ['name' => 'Test County']);
    }
    public function test_index_returns_counties() {
        County::factory()->create(['name' => 'Baranya']);
        County::factory()->create(['name' => 'Pest']);

        $response = $this->getJson('/api/counties');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Baranya'])
                 ->assertJsonFragment(['name' => 'Pest']);
    }

    public function test_show_returns_specific_county() {
        $county = County::factory()->create(['name' => 'Somogy']);

        $response = $this->getJson("/api/counties/{$county->id}");

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Somogy']);
    }

    public function test_delete_removes_county() {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $county = County::factory()->create(['name' => 'Vas']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/counties/{$county->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('counties', ['id' => $county->id]);
    }

    public function test_update_modifies_existing_county()
    {
        $county = County::factory()->create(['name' => 'Heves']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/counties/{$county->id}", [
            'name' => 'Tolna'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Tolna']);

        $this->assertDatabaseHas('counties', ['id' => $county->id, 'name' => 'Tolna']);
    } 
}
