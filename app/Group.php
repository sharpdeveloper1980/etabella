<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'groups';
    protected $primaryKey = 'group_id';



    protected $fillable = [
        'client_id','group_name','created_at','updated_at'
    ];
}
