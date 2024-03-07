<?php

namespace App\Http\Controllers\Api;

use App\Enum\StationCategoryEnum;
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

        $category = $request['category'];
        if (StationCategoryEnum::isValid($category)) {
            $request['category'] = StationCategoryEnum::resolveToEnum($category)->value;
        } else {
            return ResponseHelper::jsonResponse(false, 'Kategori station tidak valid.', null, 400);
        }

        try {
            $station = $this->StationRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data station berhasil ditambahkan.', new StationResource($station), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $station = $this->StationRepository->getStationById($id);

            if (! $station) {
                return ResponseHelper::jsonResponse(false, 'Data station tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getStationCategory()
    {
        try {
            $categories = $this->StationRepository->getStationCategory();

            return ResponseHelper::jsonResponse(true, 'Success', $categories, 200);
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

        $category = $request['category'];
        if (StationCategoryEnum::isValid($category)) {
            $request['category'] = StationCategoryEnum::resolveToEnum($category)->value;
        } else {
            return ResponseHelper::jsonResponse(false, 'Kategori station tidak valid.', null, 400);
        }

        try {
            $station = $this->StationRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data station berhasil di perbaharui.', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $station = $this->StationRepository->updateActiveStatus($id, $status);

            $message = $station->is_active ? 'Station berhasil diaktifkan.' : 'Station berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $station = $this->StationRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data station berhasil dihapus.', new StationResource($station), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
