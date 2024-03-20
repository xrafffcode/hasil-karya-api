<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommonControllerAPITest extends TestCase
{
    public function test_common_api_call_read_date_periods_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/commons/read/date-periods');

        $response->assertSuccessful();
    }

    public function test_common_api_call_read_aggregate_functions_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/commons/read/aggregate-functions');

        $response->assertSuccessful();
    }
}
