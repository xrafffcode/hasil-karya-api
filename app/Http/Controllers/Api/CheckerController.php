<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckerRequest;
use App\Http\Requests\UpdateCheckerRequest;
use App\Http\Resources\CheckerResource;
use App\Interfaces\CheckerRepositoryInterface;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    protected $CheckerRepository;

    public function __construct(CheckerRepositoryInterface $CheckerRepository)
    {
        $this->CheckerRepository = $CheckerRepository;
    }

    public function index(Request $request)
    {
        try {
            $checkers = $this->CheckerRepository->getAllCheckers($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', CheckerResource::collection($checkers), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreCheckerRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->CheckerRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->CheckerRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $checker = $this->CheckerRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data checker berhasil ditambahkan.', new CheckerResource($checker), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $checker = $this->CheckerRepository->getCheckerById($id);

            if (! $checker) {
                return ResponseHelper::jsonResponse(false, 'Data checker tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new CheckerResource($checker), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateCheckerRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->CheckerRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->CheckerRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $checker = $this->CheckerRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data checker berhasil di perbaharui.', new CheckerResource($checker), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $checker = $this->CheckerRepository->updateActiveStatus($id, $status);

            $message = $checker->is_active ? 'Checker berhasil diaktifkan.' : 'Checker berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, 'Success', new CheckerResource($checker), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $checker = $this->CheckerRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Checker berhasil dihapus.', new CheckerResource($checker), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
