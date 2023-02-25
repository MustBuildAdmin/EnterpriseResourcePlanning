<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
    }
}
