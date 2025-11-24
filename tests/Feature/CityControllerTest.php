<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\County;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_returns_all_counties()
    {
        $county1 = County::factory()->create(['name' => 'Budapest']);
        $county2 = County::factory()->create(['name' => 'Pest']);

        City::factory()->create(['name' => 'Kismaros', "postal_code" => 2623, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Bologna', 'postal_code' => 5000, 'county_id' => $county2->id]);

        $response = $this->getJson('/api/cities');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Kismaros', 'postal_code' => 2623])
            ->assertJsonFragment(['name' => 'Bologna', 'postal_code' => 5000]);
    } 

    public function test_store_creates_new_city()
    {
		$user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $county1 = County::factory()->create(['name' => 'Baranya']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/cities', [
            'name' => 'Kistarcsa',
            'postal_code' => 4231,
            'county_id' => $county1->id
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Kistarcsa']);
		
        $this->assertDatabaseHas('cities', ['name' => 'Kistarcsa']);
    }

    public function test_show_returns_specific_city() {
        $county = County::factory()->create(['name' => 'Somogy']);
        City::factory()->create(['name' => 'Test City', "postal_code" => 2000, 'county_id' => $county->id]);

        $response = $this->getJson("/api/cities/{$county->id}");

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Test City']);
    }

    public function test_delete_removes_city() {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $county = County::factory()->create(['name' => 'Vas']);
        $city = City::factory()->create(['name' => 'Test City', "postal_code" => 2000, 'county_id' => $county->id]);


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/cities/{$city->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }

    public function test_update_modifies_existing_city()
    {
        $county = County::factory()->create(['name' => 'Heves']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $city = City::factory()->create(['name' => 'Test City', "postal_code" => 2000, 'county_id' => $county->id]);


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/cities/{$city->id}", [
            'name' => 'Nógrád'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Nógrád']);

        $this->assertDatabaseHas('cities', ['id' => $city->id, 'name' => 'Nógrád']);
    } 
}
