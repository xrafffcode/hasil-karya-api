<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $ProjectRepository;

    public function __construct(ProjectRepositoryInterface $ProjectRepository)
    {
        $this->ProjectRepository = $ProjectRepository;
    }

    public function index(Request $request)
    {
        try {
            $projects = $this->ProjectRepository->getAllProjects($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', ProjectResource::collection($projects), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(StoreProjectRequest $request)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->ProjectRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->ProjectRepository->isUniqueCode($code));
            $request['code'] = $code;
        }

        try {
            $project = $this->ProjectRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data project berhasil ditambahkan.', new ProjectResource($project), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $project = $this->ProjectRepository->getProjectById($id);

            if (! $project) {
                return ResponseHelper::jsonResponse(false, 'Data project tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $request = $request->validated();

        $code = $request['code'];
        if ($code == 'AUTO') {
            $tryCount = 0;
            do {
                $code = $this->ProjectRepository->generateCode($tryCount);
                $tryCount++;
            } while (! $this->ProjectRepository->isUniqueCode($code, $id));
            $request['code'] = $code;
        }

        try {
            $project = $this->ProjectRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'Data project berhasil diubah.', new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $project = $this->ProjectRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data project berhasil dihapus.', new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
