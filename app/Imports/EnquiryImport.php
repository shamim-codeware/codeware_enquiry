<?php

namespace App\Imports;

use App\Models\Enquery;
use Maatwebsite\Excel\Concerns\ToModel;




class EnquiryImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Enquery([
            //
        ]);
    }
}
