<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ftp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ftp';
    protected $primaryKey = 'ftp_id';
    public $timestamps = false;



    protected $fillable = [
        'ftp_host','ftp_user','ftp_pass','ftp_download_user','ftp_download_pass'
    ];
}
