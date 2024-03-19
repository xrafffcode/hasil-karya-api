<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ActivityLogAPITest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_activity_log_api_test_call_index_expect_collection()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/activity-logs');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'log_name',
                    'description',
                    'subject_id',
                    'subject_type',
                    'causer_id',
                    'causer_type',
                    'properties',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
