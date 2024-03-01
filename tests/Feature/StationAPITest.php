<?php

namespace Tests\Feature;

use App\Models\Station;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StationAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_station_api_call_index_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Station::factory()->count(5)->create();

        $response = $this->json('GET', '/api/v1/stations');

        $response->assertSuccessful();
    }

    public function test_station_api_call_create_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $station = Station::factory()->make(['code' => 'AUTO'])->toArray();

        $response = $this->json('POST', '/api/v1/station', $station);

        $response->assertSuccessful();

        $station['code'] = $response['data']['code'];

        $this->assertDatabaseHas('stations', $station);
    }

    public function test_station_api_call_show_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $station = Station::factory()->create();

        $response = $this->json('GET', '/api/v1/station/'.$station->id);

        $response->assertSuccessful();
    }

    public function test_station_api_call_update_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $station = Station::factory()->create();

        $updatedStation = Station::factory()->make(['code' => 'AUTO'])->toArray();

        $response = $this->json('POST', '/api/v1/station/'.$station->id, $updatedStation);

        $response->assertSuccessful();

        $updatedStation['code'] = $response['data']['code'];

        $this->assertDatabaseHas('stations', $updatedStation);
    }

    public function test_station_api_call_delete_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $station = Station::factory()->create();

        $response = $this->json('DELETE', '/api/v1/station/'.$station->id);

        $response->assertSuccessful();

        $this->assertSoftDeleted('stations', $station->toArray());
    }
}
