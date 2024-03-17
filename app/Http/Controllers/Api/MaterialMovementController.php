<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialMovementRequest;
use App\Http\Requests\UpdateMaterialMovementRequest;
use App\Http\Resources\MaterialMovementResource;
use App\Interfaces\MaterialMovementRepositoryInterface;
use App\Models\Checker;
use App\Models\Driver;
use App\Models\MaterialMovement;
use App\Models\Station;
use App\Models\Truck;
use Illuminate\Http\Request;

class MaterialMovementController extends Controller
{
    protected $MaterialMovementRepository;

    public function __construct(MaterialMovementRepositoryInterface $MaterialMovementRepository)
    {
        $this->MaterialMovementRepository = $MaterialMovementRepository;
    }

    public function index(Request $request)
    {
        try {
            $materialMovements = $this->MaterialMovementRepository->getAllMaterialMovements($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', MaterialMovementResource::collection($materialMovements), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreMaterialMovementRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->MaterialMovementRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->MaterialMovementRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $truck = Truck::find($request['truck_id']);
        if ($truck->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Truck tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $checker = Checker::find($request['checker_id']);
        if ($checker->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Checker tidak aktif.', null, 405);
        }

        if ($request['truck_capacity'] == 0) {
            $truck = Truck::find($request['truck_id']);
            $request['truck_capacity'] = $truck->capacity;
        }

        try {
            $materialMovement = $this->MaterialMovementRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Material movement berhasil ditambahkan.', new MaterialMovementResource($materialMovement), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $materialMovement = $this->MaterialMovementRepository->getMaterialMovementById($id);

            if (! $materialMovement) {
                return ResponseHelper::jsonResponse(false, 'Material movement tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new MaterialMovementResource($materialMovement), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateMaterialMovementRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->MaterialMovementRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->MaterialMovementRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        $driver = Driver::find($request['driver_id']);
        if ($driver->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Driver tidak aktif.', null, 405);
        }

        $truck = Truck::find($request['truck_id']);
        if ($truck->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Truck tidak aktif.', null, 405);
        }

        $station = Station::find($request['station_id']);
        if ($station->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Station tidak aktif.', null, 405);
        }

        $checker = Checker::find($request['checker_id']);
        if ($checker->is_active == false) {
            return ResponseHelper::jsonResponse(false, 'Checker tidak aktif.', null, 405);
        }

        if ($request['truck_capacity'] == 0) {
            $oldTruck = MaterialMovement::find($id)->truck;
            $newTruck = Truck::find($request['truck_id']);

            if ($oldTruck->id == $newTruck->id) {
                $request['truck_capacity'] = MaterialMovement::find($id)->truck_capacity;
            } else {
                $request['truck_capacity'] = $newTruck->capacity;
            }
        }

        try {
            $materialMovement = $this->MaterialMovementRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Material movement berhasil diperbaharui.', new MaterialMovementResource($materialMovement), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $materialMovement = $this->MaterialMovementRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Material movement berhasil dihapus.', new MaterialMovementResource($materialMovement), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
