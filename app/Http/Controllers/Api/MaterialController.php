<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Interfaces\MaterialRepositoryInterface;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected $MaterialRepository;

    public function __construct(MaterialRepositoryInterface $MaterialRepository)
    {
        $this->MaterialRepository = $MaterialRepository;
    }

    public function index(Request $request)
    {
        try {
            $materials = $this->MaterialRepository->getAllMaterials();

            return ResponseHelper::jsonResponse(true, 'Success', MaterialResource::collection($materials), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreMaterialRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->MaterialRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->MaterialRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $material = $this->MaterialRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data material berhasil ditambahkan.', new MaterialResource($material), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $material = $this->MaterialRepository->getMaterialById($id);

            if (! $material) {
                return ResponseHelper::jsonResponse(false, 'Data material tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new MaterialResource($material), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateMaterialRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->MaterialRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->MaterialRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $material = $this->MaterialRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data material berhasil diubah.', new MaterialResource($material), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $material = $this->MaterialRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data material berhasil dihapus.', new MaterialResource($material), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
