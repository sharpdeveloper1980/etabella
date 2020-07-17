<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editedfile extends Model
{
	protected $table = 'edited_files';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable=['id','file_id','client_id','date_uploaded'];


    /**
     * Get the client that owns the download.
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'client_id');
    }

    public function file()
    {
        return $this->belongsTo('App\File','file_id','file_id');
    }

}
