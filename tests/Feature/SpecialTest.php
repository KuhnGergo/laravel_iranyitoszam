<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\County;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_cities_abc_in_one_county()
    {
        $county1 = County::factory()->create(['name' => 'Budapest']);

        City::factory()->create(['name' => 'Kismaros', "postal_code" => 2623, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Bologna', 'postal_code' => 5000, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Vác', 'postal_code' => 1222, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Veresegyháza', 'postal_code' => 1502, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Abdul', 'postal_code' => 2026, 'county_id' => $county1->id]);

        $response = $this->getJson("/api/counties/{$county1->id}/abc");

        $response->assertStatus(200)
            ->assertJsonFragment(['data' => ['A','B','K','V']]);
    } 

    public function test_show_returns_cities_in_one_county()
    {
        $county1 = County::factory()->create(['name' => 'Budapest']);

        City::factory()->create(['name' => 'Kismaros', "postal_code" => 2623, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Bologna', 'postal_code' => 5000, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Vác', 'postal_code' => 1222, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Veresegyháza', 'postal_code' => 1502, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Abdul', 'postal_code' => 2026, 'county_id' => $county1->id]);

        $response = $this->getJson("/api/counties/{$county1->id}/cities");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Kismaros'])
            ->assertJsonFragment(['name' => 'Veresegyháza']);
    } 

    public function test_show_returns_cities_by_name_fragment()
    {
        $county1 = County::factory()->create(['name' => 'Budapest']);
        $county2 = County::factory()->create(['name' => 'Heves']);

        City::factory()->create(['name' => 'Kismaros', "postal_code" => 2623, 'county_id' => $county2->id]);
        City::factory()->create(['name' => 'Bologna', 'postal_code' => 5000, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Székesfehérvár', 'postal_code' => 1222, 'county_id' => $county2->id]);
        City::factory()->create(['name' => 'Veresegyháza', 'postal_code' => 1502, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Verőce', 'postal_code' => 2026, 'county_id' => $county2->id]);

        $response = $this->getJson("/api/cities/names/ver");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Verőce'])
            ->assertJsonFragment(['name' => 'Veresegyháza']);
    } 

    public function test_show_returns_cities_in_one_county_by_name_fragment()
    {
        $county1 = County::factory()->create(['name' => 'Budapest']);
        $county2 = County::factory()->create(['name' => 'Heves']);

        City::factory()->create(['name' => 'Kismaros', "postal_code" => 2623, 'county_id' => $county2->id]);
        City::factory()->create(['name' => 'Bologna', 'postal_code' => 5000, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Székesfehérvár', 'postal_code' => 1222, 'county_id' => $county2->id]);
        City::factory()->create(['name' => 'Veresegyháza', 'postal_code' => 1502, 'county_id' => $county1->id]);
        City::factory()->create(['name' => 'Verőce', 'postal_code' => 2026, 'county_id' => $county2->id]);

        $response = $this->getJson("/api/counties/{$county2->id}/cities/names/ver");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Verőce']);
    } 
}
