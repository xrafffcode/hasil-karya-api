<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTruckRentalRecordRequest;
use App\Http\Requests\UpdateTruckRentalRecordRequest;
use App\Http\Resources\TruckRentalRecordResource;
use App\Interfaces\TruckRentalRecordRepositoryInterface;
use Illuminate\Http\Request;

class TruckRentalRecordController extends Controller
{
    protected $TruckRentalRecordRepository;

    public function __construct(TruckRentalRecordRepositoryInterface $TruckRentalRecordRepository)
    {
        $this->TruckRentalRecordRepository = $TruckRentalRecordRepository;
    }

    public function index(Request $request)
    {
        try {
            $truckRentalRecords = $this->TruckRentalRecordRepository->getAllTruckRentalRecords();

            return ResponseHelper::jsonResponse(true, 'Success', TruckRentalRecordResource::collection($truckRentalRecords), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreTruckRentalRecordRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->TruckRentalRecordRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->TruckRentalRecordRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $truckRentalRecord = $this->TruckRentalRecordRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa truck berhasil ditambahkan.', new TruckRentalRecordResource($truckRentalRecord), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $truckRentalRecord = $this->TruckRentalRecordRepository->getTruckRentalRecordById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new TruckRentalRecordResource($truckRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateTruckRentalRecordRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->TruckRentalRecordRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->TruckRentalRecordRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $truckRentalRecord = $this->TruckRentalRecordRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa truck berhasil diubah.', new TruckRentalRecordResource($truckRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateRentalPaymentStatus(Request $request, $id)
    {
        $status = $request->is_paid;

        try {
            $truckRentalRecord = $this->TruckRentalRecordRepository->updateRentalPaymentStatus($id, $status);

            $message = $truckRentalRecord->is_paid ? 'Status bayar rekaman sewa truck berhasil dirubah menjadi sudah terbayar.' : 'Status bayar rekaman sewa truck berhasil diubah menjadi belum terbayar.';

            return ResponseHelper::jsonResponse(true, $message, new TruckRentalRecordResource($truckRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $truckRentalRecord = $this->TruckRentalRecordRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data rekaman sewa truck berhasil dihapus.', new TruckRentalRecordResource($truckRentalRecord), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
