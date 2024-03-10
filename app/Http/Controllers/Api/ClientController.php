<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $ClientRepository;

    public function __construct(ClientRepositoryInterface $ClientRepository)
    {
        $this->ClientRepository = $ClientRepository;
    }

    public function index(Request $request)
    {
        try {
            $clients = $this->ClientRepository->getAllClients($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', ClientResource::collection($clients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreClientRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->ClientRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->ClientRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $client = $this->ClientRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data pelanggan berhasil ditambahkan.', new ClientResource($client), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $client = $this->ClientRepository->getClientById($id);

            if (! $client) {
                return ResponseHelper::jsonResponse(false, 'Data pelanggan tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new ClientResource($client), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->ClientRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->ClientRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $client = $this->ClientRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data pelanggan berhasil diubah.', new ClientResource($client), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $client = $this->ClientRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data pelanggan berhasil dihapus.', new ClientResource($client), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
