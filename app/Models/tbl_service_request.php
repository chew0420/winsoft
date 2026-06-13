<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_service_request extends Model
{
    //
    protected $table = 'tbl_service_request';
    protected $primaryKey = 'request_id';

    public function user()
    {
        return $this->belongsTo(tbl_user::class, 'customer_id', 'user_id');
    }

    public function technician()
    {
        return $this->belongsTo(tbl_user::class, 'technician_id', 'user_id');
    }
}
