<?php

namespace App\Imports;

use App\Models\weatherdata;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class weatherdataimport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new weatherdata([
            'location' => $row[0],
            'temperature' => $row[1],
            'weather' => $row[2],
            'datentime' => $row[3],
            'timeofday' => $row[4],
        ]);
    }
}
