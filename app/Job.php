<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'jobs';
    protected $primaryKey = 'job_id';



    protected $fillable = [
        'group_id','job_name'
    ];
}
