<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickAccess extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'quick_access';
    protected $primaryKey = 'id';
    public $timestamps = false;




    protected $fillable = [
        'file_id','type','created_at','updated_at'
    ];
}
