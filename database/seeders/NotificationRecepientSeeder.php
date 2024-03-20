<?php

namespace Database\Seeders;

use App\Models\NotificationRecepient;
use Illuminate\Database\Seeder;

class NotificationRecepientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peoples = [
            [
                'name' => 'Rafli',
                'phone_number' => '6285325483259',
                'job_title' => 'Software Engineer',
            ],
            [
                'name' => 'Hugo',
                'phone_number' => '6282227637711',
                'job_title' => 'Software Engineer',
            ],
        ];

        foreach ($peoples as $people) {
            $notificationRecepient = new NotificationRecepient();
            $notificationRecepient->name = $people['name'];
            $notificationRecepient->phone_number = $people['phone_number'];
            $notificationRecepient->job_title = $people['job_title'];
            $notificationRecepient->save();
        }
    }
}
