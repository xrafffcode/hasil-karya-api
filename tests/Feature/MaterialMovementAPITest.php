<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\Checker;
use App\Models\Driver;
use App\Models\MaterialMovement;
use App\Models\Station;
use App\Models\Truck;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
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
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovements = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->count(5)
            ->create();

        $response = $this->json('GET', '/api/v1/material-movements');

        $response->assertSuccessful();

        foreach ($materialMovements as $materialMovement) {
            $materialMovement = $materialMovement->toArray();
            $materialMovement = Arr::except($materialMovement, ['created_at', 'updated_at', 'deleted_at']);
            $this->assertDatabaseHas('material_movements', $materialMovement);
        }
    }

    public function test_material_movement_api_call_create_without_sending_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make()
            ->toArray();
        unset($materialMovement['code']);

        $response = $this->json('POST', '/api/v1/material-movement', $materialMovement);

        $response->assertSuccessful();

        $materialMovement['code'] = $response['data']['code'];
        unset($materialMovement['observation_ratio_number']);
        unset($materialMovement['solid_ratio']);
        unset($materialMovement['solid_volume_estimate']);

        $this->assertDatabaseHas('material_movements', $materialMovement);
    }

    public function test_material_movement_api_call_create_with_auto_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => 'AUTO'])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement', $materialMovement);

        $response->assertSuccessful();

        $materialMovement['code'] = $response['data']['code'];
        unset($materialMovement['observation_ratio_number']);
        unset($materialMovement['solid_ratio']);
        unset($materialMovement['solid_volume_estimate']);

        $this->assertDatabaseHas('material_movements', $materialMovement);
    }

    public function test_material_movement_api_call_create_with_auto_code_and_wrong_formatted_date_expect_failed()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => 'AUTO', 'date' => strval(mt_rand(1000000000, 9999999999))])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement', $materialMovement);

        $response->assertStatus(422);
    }

    public function test_material_movement_api_call_create_with_auto_code_and_negative_observation_ratio_percentage_expect_failed()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => 'AUTO', 'observation_ratio_percentage' => mt_rand(-1000, -2)])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement', $materialMovement);

        $response->assertStatus(422);
    }

    public function test_material_movement_api_call_create_with_auto_code_by_checker_user_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()->for($user)->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => 'AUTO'])
            ->toArray();

        $response = $this->json('POST', '/api/v1/checker/material-movement/store', $materialMovement);

        $response->assertSuccessful();

        $materialMovement['code'] = $response['data']['code'];
        unset($materialMovement['observation_ratio_number']);
        unset($materialMovement['solid_ratio']);
        unset($materialMovement['solid_volume_estimate']);

        $this->assertDatabaseHas('material_movements', $materialMovement);
    }

    public function test_material_movement_api_call_show_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $response = $this->json('GET', '/api/v1/material-movement/'.$materialMovement->id);

        $response->assertSuccessful();
    }

    public function test_material_movement_api_call_update_with_auto_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $updatedMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => 'AUTO'])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement/'.$materialMovement->id, $updatedMaterialMovement);

        $response->assertSuccessful();

        $updatedMaterialMovement['code'] = $response['data']['code'];
        unset($updatedMaterialMovement['observation_ratio_number']);
        unset($updatedMaterialMovement['solid_ratio']);
        unset($updatedMaterialMovement['solid_volume_estimate']);

        $this->assertDatabaseHas('material_movements', $updatedMaterialMovement);
    }

    public function test_material_movement_api_call_update_with_existing_code_in_same_material_movement_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $updatedMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => $materialMovement->code])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement/'.$materialMovement->id, $updatedMaterialMovement);

        $response->assertSuccessful();

        unset($updatedMaterialMovement['observation_ratio_number']);
        unset($updatedMaterialMovement['solid_ratio']);
        unset($updatedMaterialMovement['solid_volume_estimate']);

        $this->assertDatabaseHas('material_movements', $updatedMaterialMovement);
    }

    public function test_material_movement_api_call_update_with_existing_code_in_different_material_movement_expect_failed()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $existingMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $newMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $updatedMaterialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->make(['code' => $existingMaterialMovement->code])
            ->toArray();

        $response = $this->json('POST', '/api/v1/material-movement/'.$newMaterialMovement->id, $updatedMaterialMovement);

        $response->assertStatus(422);
    }

    public function test_material_movement_api_call_delete_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $checker = Checker::factory()
            ->for(User::factory()->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first()))
            ->create(['is_active' => true]);

        $materialMovement = MaterialMovement::factory()
            ->for(Driver::factory()->create(['is_active' => true]), 'driver')
            ->for(Truck::factory()->for(Vendor::factory())->create(['is_active' => true]), 'truck')
            ->for(Station::factory()->create(['is_active' => true]), 'station')
            ->for($checker, 'checker')
            ->create();

        $response = $this->json('DELETE', '/api/v1/material-movement/'.$materialMovement->id);

        $response->assertSuccessful();

        $materialMovement = $materialMovement->toArray();
        $materialMovement = Arr::except($materialMovement, ['created_at', 'updated_at', 'deleted_at']);

        $this->assertSoftDeleted('material_movements', $materialMovement);
    }
}
