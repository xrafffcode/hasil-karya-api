<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRecepientRequest;
use App\Http\Requests\UpdateNotificationRecepientRequest;
use App\Http\Resources\NotificationRecepientResource;
use App\Interfaces\NotificationRecepientRepositoryInterface;
use Illuminate\Http\Request;

class NotificationRecepientController extends Controller
{
    protected $NotificationRecepientRepository;

    public function __construct(NotificationRecepientRepositoryInterface $NotificationRecepientRepository)
    {
        $this->NotificationRecepientRepository = $NotificationRecepientRepository;
    }

    public function index(Request $request)
    {
        try {
            $notificationRecepients = $this->NotificationRecepientRepository->getAllNotificationRecepients();

            return ResponseHelper::jsonResponse(true, 'Success', NotificationRecepientResource::collection($notificationRecepients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreNotificationRecepientRequest $request)
    {
        $request = $request->validated();

        try {
            $notificationRecepient = $this->NotificationRecepientRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data notification recepient berhasil ditambahkan.', new NotificationRecepientResource($notificationRecepient), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $notificationRecepient = $this->NotificationRecepientRepository->getAllNotificationRecepientById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new NotificationRecepientResource($notificationRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateNotificationRecepientRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $notificationRecepient = $this->NotificationRecepientRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data notification recepient berhasil diubah.', new NotificationRecepientResource($notificationRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $notificationRecepient = $this->NotificationRecepientRepository->updateActiveStatus($id, $status);

            $message = $status ? 'Penerima notifikasi berhasil diaktifkan.' : 'Penerima notifikasi berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new NotificationRecepientResource($notificationRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $notificationRecepient = $this->NotificationRecepientRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data notification recepient berhasil dihapus.', new NotificationRecepientResource($notificationRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
