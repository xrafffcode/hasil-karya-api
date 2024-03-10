<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnicalAdminRequest;
use App\Http\Requests\UpdateTechnicalAdminRequest;
use App\Http\Resources\TechnicalAdminResource;
use App\Interfaces\TechnicalAdminRepositoryInterface;
use Illuminate\Http\Request;

class TechnicalAdminController extends Controller
{
    protected $TechnicalAdminRepository;

    public function __construct(TechnicalAdminRepositoryInterface $TechnicalAdminRepository)
    {
        $this->TechnicalAdminRepository = $TechnicalAdminRepository;
    }

    public function index(Request $request)
    {
        try {
            $technicalAdmins = $this->TechnicalAdminRepository->getAllTechnicalAdmins($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', TechnicalAdminResource::collection($technicalAdmins), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreTechnicalAdminRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->TechnicalAdminRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->TechnicalAdminRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $technicalAdmin = $this->TechnicalAdminRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data technical admin berhasil ditambahkan.', new TechnicalAdminResource($technicalAdmin), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $technicalAdmin = $this->TechnicalAdminRepository->getTechnicalAdminById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new TechnicalAdminResource($technicalAdmin), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateTechnicalAdminRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->TechnicalAdminRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->TechnicalAdminRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $technicalAdmin = $this->TechnicalAdminRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data technical admin berhasil diubah.', new TechnicalAdminResource($technicalAdmin), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->is_active;

        try {
            $technicalAdmin = $this->TechnicalAdminRepository->updateActiveStatus($id, $status);

            $message = $technicalAdmin->is_active ? 'Admin teknik berhasil diaktifkan.' : 'Admin teknik berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new TechnicalAdminResource($technicalAdmin), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $technicalAdmin = $this->TechnicalAdminRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data technical admin berhasil dihapus.', new TechnicalAdminResource($technicalAdmin), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
