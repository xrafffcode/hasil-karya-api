<?php

namespace App\Repositories;

use App\Interfaces\NotificationRecepientRepositoryInterface;
use App\Models\NotificationRecepient;

class NotificationRecepientRepository implements NotificationRecepientRepositoryInterface
{
    public function getAllNotificationRecepients()
    {
        $notificationRecepients = NotificationRecepient::orderBy('job_title')->orderBy('name')->get();

        return $notificationRecepients;
    }

    public function create(array $data)
    {
        $notificationRecepient = new NotificationRecepient();
        $notificationRecepient->name = $data['name'];
        $notificationRecepient->phone_number = $data['phone_number'];
        $notificationRecepient->job_title = $data['job_title'];
        $notificationRecepient->save();

        return $notificationRecepient;
    }

    public function getAllNotificationRecepientById($id)
    {
        $notificationRecepient = NotificationRecepient::find($id);

        return $notificationRecepient;
    }

    public function update(array $data, $id)
    {
        $notificationRecepient = NotificationRecepient::find($id);
        $notificationRecepient->name = $data['name'];
        $notificationRecepient->phone_number = $data['phone_number'];
        $notificationRecepient->job_title = $data['job_title'];
        $notificationRecepient->save();

        return $notificationRecepient;
    }

    public function updateActiveStatus(string $id, bool $status)
    {
        $notificationRecepient = NotificationRecepient::find($id);
        $notificationRecepient->is_active = $status;
        $notificationRecepient->save();

        return $notificationRecepient;
    }

    public function destroy($id)
    {
        $notificationRecepient = NotificationRecepient::find($id);
        $notificationRecepient->delete();

        return $notificationRecepient;
    }
}
