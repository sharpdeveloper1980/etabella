<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $timestamps = false;



    protected $fillable = [
        'client_unique_id','username','user_password','jobs','access_token','client_device_token','quickblox_id','client_display_name','client_date_created','client_date_last_update','client_share_files_to_all','client_share_screen_to_all','client_last_screenshot','client_status'
    ];

    public function mydownloads(){
        return $this->hasMany('App\Download', 'download_client_id', 'client_id');
    }
}
