<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagstatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tags_status';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
        'tag_id','file_id','client_id'
    ];
}
