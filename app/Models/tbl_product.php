<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_product extends Model
{
    //
    protected $table = "tbl_product";

    public function category()
    {
        return $this->belongsTo(tbl_category::class, 'category_id', 'category_id');
    }
}
