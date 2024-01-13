<?php

namespace App\Services;

use App\Models\SQLModel;

class SQLService
{
    public function GetAll()
    {
        $data = SQLModel::factory()->count(10)->make();
        return $data;
    }
}
