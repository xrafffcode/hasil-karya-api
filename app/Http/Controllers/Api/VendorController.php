<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Http\Resources\VendorResource;
use App\Interfaces\VendorRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class VendorController extends Controller
{
    protected $VendorRepository;

    public function __construct(VendorRepositoryInterface $VendorRepository)
    {
        $this->VendorRepository = $VendorRepository;
    }

    public function index(Request $request)
    {
        try {
            $vendors = $this->VendorRepository->getAllVendors($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', VendorResource::collection($vendors), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreVendorRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->VendorRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->VendorRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $vendor = $this->VendorRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data vendor berhasil ditambahkan.', new VendorResource($vendor), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $vendor = $this->VendorRepository->getVendorById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new VendorResource($vendor), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }

    }

    public function update(UpdateVendorRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $vendor = $this->VendorRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data vendor berhasil diubah.', new VendorResource($vendor), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function updateActiveStatus(Request $request, $id)
    {
        $status = $request->input('is_active');

        try {
            $vendor = $this->VendorRepository->updateActiveStatus($id, $status);

            $message = $vendor->is_active ? 'Vendor berhasil di aktifkan.' : 'Vendor berhasil dinonaktifkan.';

            return ResponseHelper::jsonResponse(true, $message, new VendorResource($vendor), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vendor = $this->VendorRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Vendor berhasil dihapus.', new VendorResource($vendor), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
