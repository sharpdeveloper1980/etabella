<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupchat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'group_chat';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'message','group_id','recipient_ids','sender_id','sender_name','reader_ids','all_read','created_at'
    ];
}
