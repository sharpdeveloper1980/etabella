<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
	protected $table = 'downloads';
    protected $primaryKey = 'download_id';
    public $timestamps = false;

    protected $fillable=['download_client_id','download_file_id','download_date'];


    /**
     * Get the client that owns the download.
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'download_client_id');
    }

    public function file()
    {
        return $this->belongsTo('App\File','file_id','download_file_id');
    }

}
