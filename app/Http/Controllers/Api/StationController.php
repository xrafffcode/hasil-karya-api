<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Http\Resources\StationResource;
use App\Interfaces\StationRepositoryInterface;
use Illuminate\Http\Request;

class StationController extends Controller
{
    protected $StationRepository;

    public function __construct(StationRepositoryInterface $StationRepository)
    {
        $this->StationRepository = $StationRepository;
    }

    public function index(Request $request)
    {
        try {
            $stations = $this->StationRepository->getAllStations($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', StationResource::collection($stations), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreStationRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->StationRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->StationRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $station = $this->StationRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Success', new StationResource($station), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $station = $this->StationRepository->getStationById($id);

            if (! $station) {
                return ResponseHelper::jsonResponse(false, 'Station not found', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateStationRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->StationRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->StationRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $station = $this->StationRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Success', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $station = $this->StationRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Success', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
