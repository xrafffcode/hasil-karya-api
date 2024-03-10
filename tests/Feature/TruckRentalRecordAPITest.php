<?php

namespace Tests\Feature;

use App\Enum\UserRoleEnum;
use App\Models\Truck;
use App\Models\TruckRentalRecord;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TruckRentalRecordAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_truck_rental_record_api_call_index_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecords = TruckRentalRecord::factory()
            ->for($truck)
            ->count(5)->create();

        $response = $this->json('GET', '/api/v1/truck-rental-records');

        $response->assertSuccessful();

        foreach ($truckRentalRecords as $truckRentalRecord) {
            $truckRentalRecord = $truckRentalRecord->toArray();
            $truckRentalRecord = Arr::except($truckRentalRecord, ['created_at', 'updated_at', 'deleted_at']);
            $this->assertDatabaseHas('truck_rental_records', $truckRentalRecord);
        }
    }

    public function test_truck_rental_record_api_call_create_with_auto_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->make()->toArray();

        $response = $this->json('POST', '/api/v1/truck-rental-record', $truckRentalRecord);

        $response->assertSuccessful();

        $truckRentalRecord = Arr::except($truckRentalRecord, ['created_at', 'updated_at', 'deleted_at']);

        $this->assertDatabaseHas('truck_rental_records', $truckRentalRecord);
    }

    public function test_truck_rental_record_api_call_show_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $response = $this->json('GET', '/api/v1/truck-rental-record/'.$truckRentalRecord->id);

        $response->assertSuccessful();
    }

    public function test_truck_rental_record_api_call_update_with_auto_code_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $updatedTruckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->make()->toArray();

        $response = $this->json('POST', '/api/v1/truck-rental-record/'.$truckRentalRecord->id, $updatedTruckRentalRecord);

        $response->assertSuccessful();

        $updatedTruckRentalRecord = Arr::except($updatedTruckRentalRecord, ['created_at', 'updated_at', 'deleted_at']);

        $this->assertDatabaseHas('truck_rental_records', $updatedTruckRentalRecord);
    }

    public function test_truck_rental_record_api_call_update_with_existing_code_in_same_truck_rental_record_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $updatedTruckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->make(['code' => $truckRentalRecord->code])->toArray();

        $response = $this->json('POST', '/api/v1/truck-rental-record/'.$truckRentalRecord->id, $updatedTruckRentalRecord);

        $response->assertSuccessful();

        $updatedTruckRentalRecord = Arr::except($updatedTruckRentalRecord, ['created_at', 'updated_at', 'deleted_at']);

        $this->assertDatabaseHas('truck_rental_records', $updatedTruckRentalRecord);
    }

    public function test_truck_rental_record_api_call_update_with_existing_code_in_different_truck_rental_record_expect_failed()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $existingTruckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $newTruckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $updatedTruckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->make(['code' => $existingTruckRentalRecord->code])->toArray();

        $response = $this->json('POST', '/api/v1/truck-rental-record/'.$newTruckRentalRecord->id, $updatedTruckRentalRecord);

        $response->assertStatus(422);
    }

    public function test_truck_rental_record_api_call_update_rental_payment_status_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create(['is_paid' => false]);

        $response = $this->json('POST', '/api/v1/truck-rental-record/payment/'.$truckRentalRecord->id, ['is_paid' => true]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('truck_rental_records', ['id' => $truckRentalRecord->id, 'is_paid' => true]);

        $response = $this->json('POST', '/api/v1/truck-rental-record/payment/'.$truckRentalRecord->id, ['is_paid' => false]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('truck_rental_records', ['id' => $truckRentalRecord->id, 'is_paid' => false]);
    }

    public function test_truck_rental_record_api_call_delete_expect_success()
    {
        $user = User::factory()
            ->hasAttached(Role::where('name', '=', UserRoleEnum::ADMIN)->first())
            ->create();

        $this->actingAs($user);

        $truck = Truck::factory()
            ->for(Vendor::factory())
            ->create();

        $truckRentalRecord = TruckRentalRecord::factory()
            ->for($truck)
            ->create();

        $response = $this->json('DELETE', '/api/v1/truck-rental-record/'.$truckRentalRecord->id);

        $response->assertSuccessful();

        $truckRentalRecord = Arr::except($truckRentalRecord->toArray(), ['created_at', 'updated_at', 'deleted_at']);

        $this->assertSoftDeleted('truck_rental_records', $truckRentalRecord);
    }
}
