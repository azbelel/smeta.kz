<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    public function excelProduct()
    {
        return $this->belongsTo('App\Imports\ProductsImport');
    }
}
