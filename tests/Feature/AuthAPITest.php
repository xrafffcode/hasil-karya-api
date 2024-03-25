<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Checker;
use App\Enum\UserRoleEnum;
use App\Models\GasOperator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthAPITest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_auth_api_call_login_with_admin_user_expect_success(): void
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create(['password' => Hash::make('password')]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
    }

    public function test_auth_api_call_login_with_checker_checker_user_expect_success(): void
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create(['password' => Hash::make('password')]);

        Checker::factory()->for($user)->create(['is_active' => true]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
    }

    public function test_auth_api_call_login_with_gas_operator_user_expect_success(): void
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::GAS_OPERATOR)->first())
            ->create(['password' => Hash::make('password')]);

        GasOperator::factory()->for($user)->create(['is_active' => true]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
    }
}
