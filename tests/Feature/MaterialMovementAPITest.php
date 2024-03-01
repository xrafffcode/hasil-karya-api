<?php

namespace Tests\Feature;

use App\Models\Checker;
use App\Models\Driver;
use App\Models\MaterialMovement;
use App\Models\Station;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MaterialMovementAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_material_movement_api_call_index_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $materialMovements = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->count(5)
            ->create();

        $response = $this->json('GET', '/api/v1/material-movements');

        $response->assertSuccessful();

        foreach ($materialMovements as $materialMovement) {
            $this->assertDatabaseHas('material_movements', $materialMovement->toArray());
        }
    }

    public function test_material_movement_api_call_create_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->make(['code' => 'AUTO'])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement', $materialMovement);

        $response->assertSuccessful();

        $materialMovement['code'] = $response['data']['code'];

        $this->assertDatabaseHas('material_movements', $materialMovement);
    }

    public function test_material_movement_api_call_show_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->create();

        $response = $this->json('GET', '/api/v1/material-movement/'.$materialMovement->id);

        $response->assertSuccessful();
    }

    public function test_material_movement_api_call_update_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->create();

        $updatedMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->make(['code' => 'AUTO'])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement/'.$materialMovement->id, $updatedMaterialMovement);

        $response->assertSuccessful();

        $updatedMaterialMovement['code'] = $response['data']['code'];

        $this->assertDatabaseHas('material_movements', $updatedMaterialMovement);
    }

    public function test_material_movement_api_call_delete_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(), 'driver')
            ->for(Truck::factory()->create(), 'truck')
            ->for(Station::factory()->create(), 'station')
            ->for(Checker::factory()->create(), 'checker')
            ->create();

        $response = $this->json('DELETE', '/api/v1/material-movement/'.$materialMovement->id);

        $this->assertSoftDeleted('material_movements', $materialMovement->toArray());
    }
}
