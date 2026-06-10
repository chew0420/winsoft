<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_cart extends Model
{
    //
    protected $table = 'tbl_cart';
    protected $primaryKey = 'cart_id';

    public function user()
    {
        return $this->belongsTo(tbl_user::class, 'user_id', 'user_id');
    }
    
    public function product()
    {
        return $this->belongsTo(tbl_product::class, 'product_id', 'product_id');
    }
}
