<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\County;
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
}
