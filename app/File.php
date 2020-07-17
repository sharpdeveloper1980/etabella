<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'files';
    protected $primaryKey = 'file_id';
    public $timestamps = false;



    protected $fillable = [
        'job_id','file_name','file_upload_name','file_type','file_parent_id','file_date_modified','file_size','file_shared','file_status','file_added','file_added_time','files_updated_at'
    ];

    public function isDownloaded($clientid){
        return $this->hasOne('App\Download', 'download_file_id', 'file_id')->where('download_client_id',$clientid);
    }
}
