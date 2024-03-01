<?php

namespace Tests\Feature;

use App\Models\Checker;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CheckerAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_checker_api_call_index_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Checker::factory()->count(5)->create();

        $response = $this->json('GET', '/api/v1/checkers');

        $response->assertSuccessful();
    }

    public function test_checker_api_call_create_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $checker = Checker::factory()->make(['code' => 'AUTO'])->toArray();

        $response = $this->json('POST', '/api/v1/checker', $checker);

        $response->assertSuccessful();

        $checker['code'] = $response['data']['code'];

        $this->assertDatabaseHas('checkers', $checker);
    }

    public function test_checker_api_call_show_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $checker = Checker::factory()->create();

        $response = $this->json('GET', '/api/v1/checker/'.$checker->id);

        $response->assertSuccessful();
    }

    public function test_checker_api_call_update_with_auto_code_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $checker = Checker::factory()->create();

        $updatedChecker = Checker::factory()->make(['code' => 'AUTO'])->toArray();

        $response = $this->json('POST', '/api/v1/checker/'.$checker->id, $updatedChecker);

        $response->assertSuccessful();

        $updatedChecker['code'] = $response['data']['code'];

        $this->assertDatabaseHas('checkers', $updatedChecker);
    }

    public function test_checker_api_call_delete_expect_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $checker = Checker::factory()->create();

        $response = $this->json('DELETE', '/api/v1/checker/'.$checker->id);

        $response->assertSuccessful();

        $this->assertSoftDeleted('checkers', $checker->toArray());
    }
}
