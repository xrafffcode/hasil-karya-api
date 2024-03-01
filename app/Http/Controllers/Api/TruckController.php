<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Http\Resources\TruckResource;
use App\Interfaces\TruckRepositoryInterface;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    protected $TruckRepository;

    public function __construct(TruckRepositoryInterface $TruckRepository)
    {
        $this->TruckRepository = $TruckRepository;
    }

    public function index(Request $request)
    {
        try {
            $trucks = $this->TruckRepository->getAllTrucks();

            return ResponseHelper::jsonResponse(true, 'Success', TruckResource::collection($trucks), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreTruckRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->TruckRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->TruckRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $truck = $this->TruckRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', new TruckResource($truck), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $truck = $this->TruckRepository->getTruckById($id);

            if (! $truck) {
                return ResponseHelper::jsonResponse(false, 'Truck not found', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new TruckResource($truck), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateTruckRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $truck = $this->TruckRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Success', new TruckResource($truck), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $truck = $this->TruckRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Success', new TruckResource($truck), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
