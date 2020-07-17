<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bookmarked';
    protected $primaryKey = 'bookmarked_id';
    public $timestamps = false;



    protected $fillable = [
        'bookmarked_client_id','bookmarked_file_id','bookmarked_page','bookmarked_data','bookmarked_date'
    ];
}
