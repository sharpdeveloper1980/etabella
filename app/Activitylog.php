<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use Session;

class Activitylog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'user_id','ip_address','type','action','description','created_at','user_type',
    ];

    public  function getUserIpAddr(){
      if(!empty($_SERVER['HTTP_CLIENT_IP'])){
          //ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
      }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          //ip pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else{
          $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
    }

    public function saveActivityLog($action,$user_type,$action_type = false){
    	// Save Activity Log
        $logObj = new Activitylog();

        if($user_type == 'admin'){
	        $logObj->userid = Auth::user()->user_id;
	        $logObj->username = Auth::user()->user_name;
	        $logObj->type = Auth::user()->user_level;
	        $logObj->description = ucfirst(Auth::user()->user_display_name);
        }else{
        	$logObj->userid = Session::get('client_id');
	        $logObj->type = 4;
	        $logObj->description = ucfirst(Session::get('client_display_name'));
        	$logObj->action_type = $action_type;
        }
        
        $logObj->ip_address = $this->getUserIpAddr();
        $logObj->action = $action;
        $logObj->created_at = strtotime(Carbon::now());
        $logObj->user_type = $user_type;
        $logObj = $logObj->save();
        if($logObj){
        	return true;
        }else{
         	return false;
        }
    }
}
