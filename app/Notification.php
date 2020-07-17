<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'title','message','job_id','sender','client_id','mark_read'
    ];
}
