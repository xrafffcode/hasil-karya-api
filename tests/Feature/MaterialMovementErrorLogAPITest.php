<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\MaterialMovementErrorLog;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MaterialMovementErrorLogAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_material_movement_error_log_api_call_index_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        MaterialMovementErrorLog::factory()->create();

        $response = $this->json('GET', '/api/v1/material-movement-error-logs');

        $response->assertStatus(200);
    }

    public function test_material_movement_error_log_api_call_create_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $materialMovementErrorLog = MaterialMovementErrorLog::factory()->make();

        $response = $this->json('POST', '/api/v1/material-movement-error-log', $materialMovementErrorLog->toArray());

        $response->assertSuccessful();
    }

    public function test_material_movement_error_log_api_call_create_without_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $materialMovementErrorLog = MaterialMovementErrorLog::factory()->make()->toArray();
        unset($materialMovementErrorLog['code']);

        $response = $this->json('POST', '/api/v1/material-movement-error-log', $materialMovementErrorLog);

        $response->assertSuccessful();
    }

    public function test_material_movement_error_log_api_call_create_by_checker_user_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::CHECKER)->first())
            ->create();

        $this->actingAs($user);

        $materialMovementErrorLog = MaterialMovementErrorLog::factory()->make();

        $response = $this->json('POST', '/api/v1/checker/material-movement-error-log/store', $materialMovementErrorLog->toArray());

        $response->assertSuccessful();
    }

    public function test_material_movement_error_log_api_call_show_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $materialMovementErrorLog = MaterialMovementErrorLog::factory()->create();

        $response = $this->json('GET', '/api/v1/material-movement-error-log/'.$materialMovementErrorLog->id);

        $response->assertSuccessful();
    }
}
