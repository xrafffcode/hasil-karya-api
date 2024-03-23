<?php

namespace App\Interfaces;

interface NotificationRecepientRepositoryInterface
{
    public function getAllNotificationRecepients();

    public function create(array $data);

    public function getAllNotificationRecepientById($id);

    public function update(array $data, $id);

    public function updateActiveStatus(string $id, bool $status);

    public function delete(string $id);
}
