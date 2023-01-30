<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
 
class CSVImport implements ToArray
{
        use Importable;

    public function array(array $rows)
    {
       return $rows;
    }
}
