<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'reports';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'client_id','file_id','page','data','type','created_at'
    ];
}
