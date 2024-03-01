<?php

namespace App\Repositories;

use App\Interfaces\CheckerRepositoryInterface;
use App\Models\Checker;

class CheckerRepository implements CheckerRepositoryInterface
{
    public function getAllCheckers()
    {
        $checkers = Checker::orderBy('name', 'asc')->get();

        return $checkers;
    }

    public function create(array $data)
    {
        $checker = new Checker();
        $checker->code = $data['code'];
        $checker->name = $data['name'];
        $checker->email = $data['email'];
        $checker->is_active = $data['is_active'];
        $checker->save();

        return $checker;
    }

    public function getCheckerById($id)
    {
        $checker = Checker::find($id);

        return $checker;
    }

    public function update(array $data, $id)
    {
        $checker = Checker::find($id);
        $checker->code = $data['code'];
        $checker->name = $data['name'];
        $checker->email = $data['email'];
        $checker->is_active = $data['is_active'];
        $checker->save();

        return $checker;
    }

    public function delete($id)
    {
        $checker = Checker::find($id);
        $checker->delete();

        return $checker;
    }

    public function generateCode(int $tryCount): string
    {
        $count = Checker::count() + 1 + $tryCount;
        $code = 'CHK'.str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, $exceptId = null): bool
    {
        $checker = Checker::where('code', $code);
        if ($exceptId) {
            $checker->where('id', '!=', $exceptId);
        }

        return $checker->count() == 0;
    }
}
