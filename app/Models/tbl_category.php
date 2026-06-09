<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_category extends Model
{
    //
    protected $table = 'tbl_category';

    public function products()
    {
        return $this->hasMany(tbl_product::class, 'category_id', 'category_id');
    }
}
