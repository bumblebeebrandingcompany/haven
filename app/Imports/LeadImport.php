<?php

namespace App\Imports;

use App\Models\FileImport;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new FileImport([

            'father_name'     => $row['father_name'],
            'mother_name'    => $row['mother_name'],
        ]);
    }
}
