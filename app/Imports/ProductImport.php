<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'price' => $row[1],
            'category' => $row[2],
            'tax' => $row[3],
            'stock' => $row[4],
            'image' => $row[5],
        ]);
    }
}
