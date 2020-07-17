<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'annotations';
    protected $primaryKey = 'annotation_id';
    public $timestamps = false;



    protected $fillable = [
        'annotation_client_id','annotation_file_id','annotation_page','annotation_data','annotation_date'
    ];
    
}
