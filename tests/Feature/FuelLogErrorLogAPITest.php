<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\FuelLog;
use App\Models\FuelLogErrorLog;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FuelLogErrorLogAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_fuel_log_error_log_api_call_index_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        FuelLogErrorLog::factory()->create();

        $response = $this->json('GET', '/api/v1/fuel-log-error-logs');

        $response->assertStatus(200);
    }

    public function test_fuel_log_error_log_api_call_create_truck_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make()->toArray();

        $response = $this->json('POST', '/api/v1/fuel-log-error-log/truck', $fuelLogErrorLog);

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_create_truck_without_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make()->toArray();
        unset($fuelLogErrorLog['code']);

        $response = $this->json('POST', '/api/v1/fuel-log-error-log/truck', $fuelLogErrorLog);

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_create_by_gas_operator_user_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::GAS_OPERATOR)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make();

        $response = $this->json('POST', '/api/v1/gas-operator/fuel-log-error-log/truck/store', $fuelLogErrorLog->toArray());

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_create_heavy_vehicle_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make();

        $response = $this->json('POST', '/api/v1/fuel-log-error-log/heavy-vehicle', $fuelLogErrorLog->toArray());

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_create_heavy_vehicle_without_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make()->toArray();
        unset($fuelLogErrorLog['code']);

        $response = $this->json('POST', '/api/v1/fuel-log-error-log/heavy-vehicle', $fuelLogErrorLog);

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_create_heavy_vehicle_by_gas_operator_user_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::GAS_OPERATOR)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLog::factory()->make();

        $response = $this->json('POST', '/api/v1/gas-operator/fuel-log-error-log/heavy-vehicle/store', $fuelLogErrorLog->toArray());

        $response->assertSuccessful();
    }

    public function test_fuel_log_error_log_api_call_show_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $fuelLogErrorLog = FuelLogErrorLog::factory()->create();

        $response = $this->json('GET', '/api/v1/fuel-log-error-log/'.$fuelLogErrorLog->id);

        $response->assertStatus(200);
    }
}
