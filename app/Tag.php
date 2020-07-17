<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'title','color_tag','file_id','client_id','created_at'
    ];
}
