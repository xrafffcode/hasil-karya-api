<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;
use App\Models\ProjectChecker;
use App\Models\ProjectDriver;
use App\Models\ProjectStation;
use App\Models\ProjectTruck;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllProjects()
    {
        $projects = Project::orderBy('name', 'asc')->get();

        return $projects;
    }

    public function create(array $data)
    {
        $project = new Project();
        $project->code = $data['code'];
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->start_date = $data['start_date'];
        $project->end_date = $data['end_date'];
        $project->person_in_charge = $data['person_in_charge'];
        $project->amount = $data['amount'];
        $project->client_id = $data['client_id'];
        $project->status = $data['status'];
        $project->save();

        if (isset($data['drivers'])) {
            $project->drivers()->attach($data['drivers']);
        }
        if (isset($data['trucks'])) {
            $project->trucks()->attach($data['trucks']);
        }
        if (isset($data['stations'])) {
            $project->stations()->attach($data['stations']);
        }
        if (isset($data['checkers'])) {
            $project->checkers()->attach($data['checkers']);
        }

        return $project;
    }

    public function getProjectById(string $id)
    {
        $project = Project::find($id);

        return $project;
    }

    public function update(array $data, string $id)
    {
        $project = Project::find($id);
        $project->code = $data['code'];
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->start_date = $data['start_date'];
        $project->end_date = $data['end_date'];
        $project->person_in_charge = $data['person_in_charge'];
        $project->amount = $data['amount'];
        $project->client_id = $data['client_id'];
        $project->status = $data['status'];
        $project->save();

        // if ($project->drivers()->exists()) {
        //     $project->drivers()->delete();
        // }
        // if (isset($data['drivers'])) {
        //             foreach ($data['drivers'] as $driver) {
        //     $projectDriver = new ProjectDriver();
        //     $projectDriver->project_id = $project->id;
        //     $projectDriver->driver_id = $driver;
        //     $projectDriver->save();
        // }
        // }
        // if ($project->trucks()->exists()) {
        //     $project->trucks()->delete();
        // }
        // if (isset($data['trucks'])) {
        //     foreach ($data['trucks'] as $truck) {
        //         $projectTruck = new ProjectTruck();
        //         $projectTruck->project_id = $project->id;
        //         $projectTruck->truck_id = $truck;
        //         $projectTruck->save();
        //     }
        // }
        // if ($project->stations()->exists()) {
        //     $project->stations()->delete();
        // }
        // if (isset($data['stations'])) {
        //     foreach ($data['stations'] as $station) {
        //         $projectStation = new ProjectStation();
        //         $projectStation->project_id = $project->id;
        //         $projectStation->station_id = $station;
        //         $projectStation->save();
        //     }
        // }
        // if ($project->checkers()->exists()) {
        //     $project->checkers()->delete();
        // }
        // if (isset($data['checkers'])) {
        //     foreach ($data['checkers'] as $checker) {
        //         $projectChecker = new ProjectChecker();
        //         $projectChecker->project_id = $project->id;
        //         $projectChecker->checker_id = $checker;
        //         $projectChecker->save();
        //     }
        // }

        if (isset($data['drivers'])) {
            $project->drivers()->sync($data['drivers']);
        }
        if (isset($data['trucks'])) {
            $project->trucks()->sync($data['trucks']);
        }
        if (isset($data['stations'])) {
            $project->stations()->sync($data['stations']);
        }
        if (isset($data['checkers'])) {
            $project->checkers()->sync($data['checkers']);
        }

        return $project;
    }

    public function delete(string $id)
    {
        $project = Project::find($id);
        $project->delete();

        return $project;
    }

    public function generateCode(int $tryCount): string
    {
        $count = Project::count() + 1 + $tryCount;
        $code = 'PRJ'.str_pad($count, 4, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $query = Project::where('code', $code);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->doesntExist();
    }
}
