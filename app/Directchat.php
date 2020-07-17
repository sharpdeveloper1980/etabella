<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directchat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'one_to_one';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'message','msg_type','file_type','recipient_id','sender_id','sender_name','new_msg','created_at'
    ];
}
