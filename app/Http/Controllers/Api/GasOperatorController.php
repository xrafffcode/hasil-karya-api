<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGasOperatorRequest;
use App\Http\Requests\UpdateGasOperatorRequest;
use App\Http\Resources\GasOperatorResource;
use App\Interfaces\GasOperatorRepositoryInterface;
use Illuminate\Http\Request;

class GasOperatorController extends Controller
{
    protected $GasOperatorRepository;

    public function __construct(GasOperatorRepositoryInterface $GasOperatorRepository)
    {
        $this->GasOperatorRepository = $GasOperatorRepository;
    }

    public function index(Request $request)
    {
        try {
            $gasOperators = $this->GasOperatorRepository->getAllGasOperators($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', GasOperatorResource::collection($gasOperators), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreGasOperatorRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->GasOperatorRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->GasOperatorRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $gasOperator = $this->GasOperatorRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data operator gas berhasil ditambahkan.', new GasOperatorResource($gasOperator), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $gasOperator = $this->GasOperatorRepository->getGasOperatorById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new GasOperatorResource($gasOperator), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateGasOperatorRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->GasOperatorRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->GasOperatorRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $gasOperator = $this->GasOperatorRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data operator gas berhasil diubah.', new GasOperatorResource($gasOperator), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $gasOperator = $this->GasOperatorRepository->updateActiveStatus($id, $status);

            $message = $gasOperator->is_active ? 'Status operator gas berhasil diaktifkan.' : 'Status operator gas berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new GasOperatorResource($gasOperator), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $gasOperator = $this->GasOperatorRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data operator gas berhasil dihapus.', new GasOperatorResource($gasOperator), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
