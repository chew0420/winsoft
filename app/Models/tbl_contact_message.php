<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_contact_message extends Model
{
    protected $table = 'tbl_contact_message';
    protected $primaryKey = 'message_id';

    public function customer(){
        return $this->belongsTo(tbl_user::class, 'customer_id', 'user_id');
    }
}
