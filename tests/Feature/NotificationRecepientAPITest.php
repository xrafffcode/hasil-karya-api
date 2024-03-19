<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\NotificationRecepient;
use App\Models\User;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NotificationRecepientAPITest extends TestCase
{
    public function test_notification_recepient_api_call_index_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        NotificationRecepient::factory()
            ->count(5)->create();

        $response = $this->json('GET', '/api/v1/notification-recepients');

        $response->assertSuccessful();
    }

    public function test_notification_recepient_api_call_create_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $notificationRecepient = NotificationRecepient::factory()
            ->make()
            ->toArray();

        $response = $this->json('POST', '/api/v1/notification-recepient', $notificationRecepient);

        $response->assertSuccessful();

        $this->assertDatabaseHas('notification_recepients', $notificationRecepient);
    }

    public function test_notification_recepient_api_call_update_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $notificationRecepient = NotificationRecepient::factory()
            ->create();

        $updateNotificationRecepient = NotificationRecepient::factory()
            ->make()
            ->toArray();

        $response = $this->json('POST', '/api/v1/notification-recepient/'.$notificationRecepient->id, $updateNotificationRecepient);

        $response->assertSuccessful();

        $this->assertDatabaseHas('notification_recepients', $updateNotificationRecepient);
    }

    public function test_notification_recepient_api_call_show_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $notificationRecepient = NotificationRecepient::factory()
            ->create();

        $response = $this->json('GET', '/api/v1/notification-recepient/'.$notificationRecepient->id);

        $response->assertSuccessful();
    }

    public function test_notification_recepient_api_call_destroy_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $notificationRecepient = NotificationRecepient::factory()
            ->create();

        $response = $this->json('DELETE', '/api/v1/notification-recepient/'.$notificationRecepient->id);

        $response->assertSuccessful();

        $notificationRecepient = $notificationRecepient->toArray();
        $notificationRecepient = Arr::except($notificationRecepient, ['created_at', 'updated_at', 'deleted_at']);

        $this->assertSoftDeleted('notification_recepients', $notificationRecepient);
    }
}
