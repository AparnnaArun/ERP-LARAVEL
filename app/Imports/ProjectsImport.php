<?php

namespace App\Imports;

use App\Models\itemmaster;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new itemmaster([
            'code'     => $row[0],
            'slno'     => $row[1],
              'item'     => $row[2],
            'brand'     => $row[3],
             'part_no'     => $row[4],
             

            //
        ]);
    }
}
