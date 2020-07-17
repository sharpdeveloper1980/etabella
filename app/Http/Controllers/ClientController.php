<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\SelectedTextInformation;
use App\SelectedTextComment;
use App\Pdf_file_overlay;
use App\Hyperlink;
use App\Notification;
use App\Activitylog;
use App\QuickAccess;
use App\Annotation;
use App\Directchat;
use App\Editedfile;
use App\Groupchat;
use App\TopicChat;
use Carbon\Carbon;
use App\Tagstatus;
use App\Bookmark;
use App\Download;
use App\Client;
use App\Report;
use App\Group;
use Validator;
use PDFMerger;
use App\Topic;
use App\Issue;
use App\File;
use Session;
use App\Job;
use App\Tag;
use Config;
use DB;
use URL;
use App\Witnes;
use App\Witness_file;

class ClientController extends Controller
{
	public $arr_merge = [];
    public $files_arr=[];
	public function __construct()
    {
		$this->curl_url='http://'.request()->getHttpHost().":5000/";
    }
    public function getNotifications(){
        $my_notifications = [];
        $client_jobs_arr = explode(',',Session::get('jobs'));
        
        $my_notifications1 = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('mark_read',1)->where(function($q){
			$q->where('is_annotation','0')->orwhere('is_annotation','1');
		})->orderBy('created_at','desc')->get();
		
		 $my_notifications2 = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where(function($q1){
			 $q1->where('is_annotation','2')->Orwhere('is_annotation','3');
		 })->where('mark_read',1)->orderBy('created_at','desc')->get();
        
        return array('all_notification'=>$my_notifications1,'message_notification'=>$my_notifications2);              
    }

    public function getNewNotifications(){
		
        $arr_result = [];
        $client_jobs_arr = explode(',',Session::get('jobs'));
        
        $my_notifications = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('mark_read',1)->where(function($q){
			$q->where('is_annotation','0')->orwhere('is_annotation','1');
		})->orderBy('created_at','desc')->get();
    
    	$notif_count11 = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('mark_read',1)->where(function($q){
			$q->where('is_annotation','2')->orwhere('is_annotation','3');
		})->orderBy('created_at','desc')->get();
		
       /* if(count($my_notifications) > 0){*/
            $arr_result['success'] = 1;
            $arr_result['notif_count'] = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('mark_read',1)->where(function($q){
			$q->where('is_annotation','0')->orwhere('is_annotation','1');
		})->orderBy('created_at','desc')->count();
		
		$arr_result['notif_count1'] = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('mark_read',1)->where(function($q){
			$q->where('is_annotation','2')->orwhere('is_annotation','3');
		})->orderBy('created_at','desc')->count();
    
     
 

    
           $arr_result['notif_html'] = view('clients.render.notifications',['notifications'=>$my_notifications])->render();
    		$arr_result['notif_html1'] = view('clients.render.notifications',['notifications'=>$notif_count11])->render();
      /*  }else{
            $arr_result['error'] = 1;
        }*/
        return json_encode($arr_result);              
    }

    public function clientDashboard(Request $request,$whchjobs=false){
        if($request->session()->has('client_id')){
        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
        
        	$my_notifications = $this->getNotifications();

            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
        
        	$active_job = Job::find(Session::get('job_id'));
            

            $my_clouds = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and `is_copied_moved` = 0 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $move_icon = url('public/images/move-icon.png');
            $url = URL::to('/clients/from/dashboard/');

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	/**$targetclick = 'window.open("'.$target.'","","width=500,height=400,margin=auto");return false;';**/
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                	// $targetclick = 'popupwindow("public/storage/files/".$my_cloud->file_upload_name)';
                    /**$isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->exists();**/
						$checked = "name='file_id'";
                        $classes_folder = "class='check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
                        $classes_file = "class='check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                    

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a id='check_node_".$my_cloud->file_id."' onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' ".$classes_folder." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                        if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='".$url.'/'.$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
                            $arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File added yet</strong>');
            }
            
            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';
            
            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }

	 	   	return view('clients.dashboard',['active_job'=>$active_job,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'all_nods'=>$all_nods,'notifications'=>$my_notifications]);
	 	}
	 	    return redirect('/clients/login');
	 }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

/**
method Fetching all Sub files
**/    
    public function subFiles(Request $request,$id,$whchjobs=false)
    {
    	if($request->session()->has('client_id')){
            $my_notifications = $this->getNotifications();
    		$jobs = '';
    		$job_id = '';
	        if(Session::has('jobs')){
             	$job_id = explode(',', Session::get('jobs')); 
             	$jobs = Job::whereIn('job_id',$job_id)->get();
	        }
	        if($job_id[0] && $whchjobs==false){
	 			$whchjobs = $job_id[0];
	 		}

            $my_clouds = DB::select('select * from `files` where `file_parent_id` = '.$id.' and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');

	        
        	/*for Breadcrumb*/
	        $arr_bread = [];
	        $arr_bread_bk = []; 
	        
	        $file = File::where('file_id',$id)->first(); 
	        $arr_bread[] = ucfirst($file->file_name); 

	        $arr_bread_bk[0]['file_id'] = ucfirst($file->file_id); 
	        $arr_bread_bk[0]['filename'] = ucfirst($file->file_name); 

	        
	        $parentid = $file->file_parent_id;

	        $i = 1;
	        $last_i = '';
	        while ($parentid){
	           $file = File::where('file_id',$file->file_parent_id)->first(); 
	           $arr_bread[] = ucfirst($file->file_name); 

	            $arr_bread_bk[$i]['file_id'] = ucfirst($file->file_id); 
	            $arr_bread_bk[$i]['filename'] = ucfirst($file->file_name); 

	           $parentid = $file->file_parent_id;
	           $i++;
	           $last_i = $i; 
	        }
	        $arr_bread[] = 'Home';

	        if($last_i){
	            $arr_bread_bk[$last_i]['file_id'] = ''; 
	            $arr_bread_bk[$last_i]['filename'] = 'Home';
	        }else{
	            $arr_bread_bk[1]['file_id'] = ''; 
	            $arr_bread_bk[1]['filename'] = 'Home';
	        }

	        $arr_bread = array_reverse($arr_bread);
	        $arr_bread_bk = array_reverse($arr_bread_bk);
	        
	        /*get downloaded files here*/
	        $clientid = Session::has('client_id') ? Session::get('client_id') : '';
	        $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
			if($AllMyFiles){
				foreach ($AllMyFiles as $myfile){
				    $arr_my_dfiles[] = $myfile->download_file_id;
				}
			}
        return view('clients.dashboard',['my_clouds'=>$my_clouds,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'notifications'=>$my_notifications]);
        }
        return redirect('/clients/login');
    }
/**end**/

/**
Start Sorting method
**/
    public function sortingFiles(Request $request,$whchjobs=false,$order){
    	
        if(Session::get($order) == 'asc'){
            $request->session()->forget($order);
            $request->session()->put($order,'desc');
        }else{
            $request->session()->forget($order);
            $request->session()->put($order,'asc');
        }

        if($request->session()->has('client_id')){
        $jobs = '';
        $job_id = '';
            if(Session::has('jobs')){
                $job_id = explode(',', Session::get('jobs')); 
                $jobs = Job::whereIn('job_id',$job_id)->get();
            }
        
            $whchjobs = Session::get('job_id');

            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
            
            $my_clouds = DB::select('select * from `files` where  `file_shared` = 1 and `file_status` = 1 and `is_copied_moved` = 0 and FIND_IN_SET('.$whchjobs.',`job_id`) order by '.$order.' '.Session::get($order).'');

            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $move_icon = url('public/images/move-icon.png');
        	$url = URL::to('/clients/from/dashboard/');
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                    
                	$isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->exists();
                   
                         $checked = "name='file_id'";
                         $classes_folder = "class='check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
                         $classes_file = "class='check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' ".$classes_folder." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                        	// $arr_nods["name"] = "<a href='file/render/".$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:21px;'><i class='fa fa-edit'></i></a><a type='button' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:12px;'><img src='".$move_icon."' height='20' width='20' style='padding-bottom:5px;color:#ccc'></a></p>";
						if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='".$url.'/'.$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
                            $arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }                    
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File added yet</strong>');
            }
        }

        // $html = view('clients.single', ['my_clouds'=>$my_clouds,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles])->render();
        echo json_encode($all_nods);
    }

    public function sortingMyFiles(Request $request,$whchjobs=false,$order){
        if(Session::get($order) == 'asc'){
            $request->session()->forget($order);
            $request->session()->put($order,'desc');
        }else{
            $request->session()->forget($order);
            $request->session()->put($order,'asc');
        }
        
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            $whchjobs = Session::get('job_id');

            /*get downloaded files here*/
            $arr_my_dfiles=[];
           $clientid = Session::has('client_id') ? Session::get('client_id') : '';
           $AllMyFiles = Download::where('download_client_id',$clientid)->get();
           $arr_my_dfiles[]=array();
           if($AllMyFiles){
               foreach ($AllMyFiles as $myfile){
                   $arr_my_dfiles[] = $myfile->download_file_id;
               }
           }

            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';

       $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
         if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
         }
    
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by '.$order.' '.Session::get($order).'');
         // $my_clouds = DB::select('select * from `files` where  `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by '.$order.' '.Session::get($order).'');

     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
         if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
         }
        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
    		$move_icon = url('public/images/move-icon.png');
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
					
                	$url = url('clients/file/render/'.$my_cloud->file_id);
                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                
                	$editedfile = Editedfile::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                	if($editedfile){
                    	$myfilename = $editedfile->name;
                    }else{
                    	$myfilename = $my_cloud->file_name;
                    }
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' class='nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";

                    }else{
                    	if($file_extension=='pdf'){
                        	$tagstatus = Tagstatus::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                        	if($tagstatus){
                            	$tag = Tag::find($tagstatus->tag_id);
                               	$tagcolor = $tag->color_tag;
                            }else{
                            	$tagcolor = '#FFFFFF';
                            }
                        	$arr_nods["name"] = "<i class='fa fa-circle' style='color:".$tagcolor."'></i><a href='".$url."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";
                    	}else{
	                    	$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";
                    	}
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
          $this->arr_merge=[];
          echo json_encode($all_nods);
        
    }
/**end**/
    
    public function downloading(Request $request){
        if($request->arr_fileid){
            $file_arr=array();
            foreach ($request->arr_fileid as $fkey => $fileidd) {
            $file_info = File::where('file_id',$fileidd)->get()->toArray();
            
				$is_exist = Download::where("download_client_id",Session::get('client_id'))->where("download_file_id",$fileidd)->first();
				if(!$is_exist){
					$lay='doc_'.Session::get('client_id').$fileidd.date('is');
                $arr_parents = [];
					$downloadObj = new Download(); 
					$downloadObj->download_client_id = Session::get('client_id');
					$downloadObj->download_file_id = $fileidd;
					$downloadObj->download_date = strtotime(Carbon::now());
					$downloadObj->layer = $lay;
					$downloadObj->save();
					
					$this->create_layer($file_info[0]['pspdf_file_id'],$lay);
					
                	$this->getAllParents($fileidd,'add');
                    if(isset(explode('.',$file_info[0]['file_name'])[1]))
                    {
                    	if(explode('.',$file_info[0]['file_name'])[1]=='pdf')
                        {
                    		$file_arr[]=$fileidd;  	
                        }
                    }
                    
				}
            }
           /*if($file_arr) {
            $this->uploadodfonserver($file_arr); 
           }*/
            $activitylogObj = new Activitylog();
            $action = 'Download Files';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type);

            $arr = array('message' => 'Files downloaded Successfully', 'title' => 'Downloaded');
        }else{
            $arr = array('message' => 'Somthing went wrong', 'title' => 'Downloading error..');
        }
        echo json_encode($arr);
    }

	/**
Method Get Parent Id
**/
	
    public function getAllParents($fileId,$type)
    {
        $file=File::find($fileId);
    		if($type == 'add'){
            	$edFile = Editedfile::where('file_id',$file->file_id)->where('client_id',Session::get('client_id'))->first();
            	if($edFile){
                	$editfileObj = $edFile;
                }else{
        			$editfileObj = new Editedfile();
                }
				$editfileObj->file_id = $file->file_id;
        		$editfileObj->client_id = Session::get('client_id');
        		$editfileObj->name = $file->file_name;
				$editfileObj->date_uploaded = strtotime(Carbon::now());
				$editfileObj->save();
            }else{
            	$editedfile = Editedfile::where('file_id',$file->file_id)->where('client_id',Session::get('client_id'))->delete();
            }
        if($file->file_parent_id==0){
            return $file->file_id;
         }else{
            $parent_id=$this->getAllParents($file->file_parent_id,$type);
            return $parent_id;
         }
    }

/**
End
**/

    public function deleteDownloaded(Request $request){
        if($request->arr_fileid){
            foreach ($request->arr_fileid as $fkey => $fileidd) {
                $down = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$fileidd)->delete();
            	$this->getAllParents($fileidd,'delete');
                 $file_info=File::where('file_id',$fileidd)->get()->toArray();
 				if(isset($file_info[0]))
                {
                	$file_pspdf_id=$file_info[0]['pspdf_file_id'];
                    $layer='doc_'.$fileidd.Session::get('client_id');
                    $this->delete_layer($file_pspdf_id,$layer);
                }
            }
			
            $activitylogObj = new Activitylog();
            $action = 'Delete downloaded files';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type,1);

            $arr = array('message' => 'Files deleted Successfully', 'title' => 'Deleted');
        }else{
            $arr = array('message' => 'Somthing went wrong', 'title' => 'Error ocuur');
        }
        echo json_encode($arr);
    }

	public function downloadFile(Request $request)
	{
			$str=$request->input("file_id");
			$file_id=array_map('intval', explode(',', $str));
            $clientId=$request->session()->get('client_id');
            $downloads=Download::where('download_client_id',$clientId)->get();
            for($e=0;$e<count($downloads);$e++)
             {
                $downloadFileId=$downloads[$e]->download_file_id;
                for($f=0;$f<count($file_id);$f++)
                 {
                    if($file_id[$f]==$downloadFileId)
                     {
                        $file_id[$f]=0;
                     }
                 }
             }
			$client_id=$request->session()->get('client_id');
			$current_time=time();
			for($p=0;$p<count($file_id);$p++)
			{
				if($file_id[$p]==0)
				{
					continue;
				}
				DB::table('downloads')->insert(
			     ['download_client_id'=>$client_id,'download_file_id'=>$file_id[$p],'download_date'=>$current_time]
				);
			}
			Toastr::success('File Downloaded Successfully !!', 'Success', ['"debug": false']);

			return redirect()->back();
	}

	/**
Method Upload Multiple Files
**/
 
    public function uploadFiles(Request $request){
       	$this->validate($request, [
            'file_name' => 'required|unique:files',
            'jobs' => 'required',
        ]);

    
        if(!Storage::disk('public')->exists('files')){
            Storage::disk('public')->makeDirectory('files');
        }

        $totalFileSize = 0;

        if($files=$request->file('file_name')){
            foreach($files as $file){

                $fileOriginalName = $file->getClientOriginalName();

                $file_size = filesize($file);

                $exist = File::where('file_name',$fileOriginalName)->first();

                $imagename = md5(time() . $fileOriginalName . $this->generateRandomString()) . '.' . pathinfo($fileOriginalName, PATHINFO_EXTENSION);

                if(!$exist){
                    $file->move(public_path("storage/files/"), $imagename);
                    
                    $file_job_id = implode(',',$request->jobs);
                    $parent_id = $request->file_parent_id;
                    $finfo=explode('.',$imagename);
                    $file = new File();
                    $file->job_id = $file_job_id;
                    $file->file_name = $fileOriginalName;
                    $file->file_upload_name=$imagename;
                    $file->file_type = 2;
                    $file->file_size = $file_size;
                    $file->file_parent_id = $request->file_parent_id;
                    $file->file_date_modified = strtotime(Carbon::now());
                    $file->file_status = 1;
                	$file->is_copied_moved = 1;
                    $file->file_shared = 1;
                    $savefile = $file->save();
                    if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $this->files_arr[]=$file->file_id;
                        }
                    }
					if($savefile){
                    	$downloadObj = new Download(); 
                        $downloadObj->download_client_id = Session::get('client_id');
                        $downloadObj->download_file_id = $file->file_id;
                        $downloadObj->download_date = strtotime(Carbon::now());
                        $downloadObj->save();
                    	
                    	$editfileObj = new Editedfile();
						$editfileObj->file_id = $file->file_id;
        				$editfileObj->client_id = Session::get('client_id');
        				$editfileObj->name = $file->file_name;
						$editfileObj->date_uploaded = strtotime(Carbon::now());
						$editfileObj->save();
                    }	
                
                    if (pathinfo($imagename, PATHINFO_EXTENSION) == "zip") {

                        $response = $this->extractZipFile($fileOriginalName, $imagename, $parent_id, $file_job_id);
							
                        if($response){
                            if(file_exists(public_path('storage/files/'.$imagename)))
                               {
                                unlink(public_path('storage/files/'.$imagename));
                               }
                        $this->deleteZipFile($fileOriginalName, $parent_id);
                            Toastr::success('File Extracted Successfully Uploaded !!', 'Success', ['"debug": false']);
                        }
                    }
                }else{
                    $savefile = '';
                    Toastr::error('This '.$fileOriginalName.' is already Exist', 'Error', ['"debug": false']);
                }
            }
        }
         if($this->files_arr)
         {
             $this->uploadodfonserver($this->files_arr);
             $this->files_arr=array();
         }
        if($savefile){
            $activitylogObj = new Activitylog();
            $action = 'File Uploading';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type);

            Toastr::success('File Successfully Uploaded !!', 'Success', ['"debug": false']);
        }
    
        return redirect()->back();
    }
/**End**/

/**
Method Generating Random String
**/
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
/**End**/

public function extractZipFile($old_name, $file_name, $parent_id, $file_job_id) {
        $oldName = explode('.',$old_name);
        $folder_name = $oldName[0];
        
        $oldmask = umask(0);

        $createFolder = public_path('storage/files/zipupload/'.time());
        mkdir($createFolder,0777);
        umask($oldmask);
        $cCommand = '"'.Config::get('constraints.zip_path').'" x "'.public_path('storage/files/').$file_name.'" -o'.$createFolder.' -r';
        exec($cCommand);
            $dir = $createFolder;
            $this->scanDirectory($dir, $parent_id, $file_job_id);
            $this->rmdir_recursive($createFolder);
            return TRUE;
    }

    function rmdir_recursive($dir) {
        $total_size = 0;
        $count = 0;
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file){

            }elseif (is_dir("$dir/$file")){
               $new_foldersize =  $this->rmdir_recursive("$dir/$file");
               $total_size = $total_size+ $new_foldersize;
            }
            else {
                unlink("$dir/$file");
            }
        }
        //echo $dir;exit;
         rmdir($dir);
    }

    public function scanDirectory($dir, $parent_id, $file_job_id){
        $zipFile = scandir($dir);
            foreach ($zipFile as $f) {
                if($f == '.' || $f == '..'){
                }else{
                    if (is_dir($dir . '/' . $f)) {
                        $sub_dir = $dir.'/'.$f;
                        $result = $this->createNewDirectory($f, $parent_id, $file_job_id,$sub_dir);                        
                        $this->scanDirectory($sub_dir, $result, $file_job_id);
                    } else {
                        $this->createNewFile($f, $parent_id, $dir, $file_job_id);
                    }
                }
            }
    }

    public function folderSize($dir){
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
          foreach($dir_array as $key=>$filename){
            if($filename!=".." && $filename!="."){
               if(is_dir($dir."/".$filename)){
                  $new_foldersize = $this->foldersize($dir."/".$filename);
                  $total_size = $total_size+ $new_foldersize;
                }else if(is_file($dir."/".$filename)){
                  $total_size = $total_size + filesize($dir."/".$filename);
                  $count++;
                }
           }
         }
        return $total_size;
    }


    public function createNewDirectory($folder_name, $parent_id, $file_job_id,$sub_dir) {
        $folderCount = $this->checkDirectoryIsAvailableOrNot($folder_name, $parent_id);
        $folder_path = realpath($sub_dir);
        $folder_size = $this->folderSize($folder_path);
         
        /* Create New directory - start */
        if (!$folderCount) {
                $file = new File();
                $file->file_name = $folder_name;
                $file->file_type = 1;
                $file->file_parent_id = $parent_id;
                $file->job_id = $file_job_id;
                $file->file_date_modified = strtotime(Carbon::now());
                $file->file_size = $folder_size;
                $file->file_shared = 1;
        		$file->is_copied_moved = 1;
                $file->save();
            $response = $file->file_id;
        }else{
                $file = File::where('file_id', $folderCount->file_id)->first();
                $file->job_id = $file_job_id;
                $file->files_updated_at = time();   
                $file->update();         
            $response = $folderCount->file_id;
        }
			$editfileObj = new Editedfile();
			$editfileObj->file_id = $file->file_id;
        	$editfileObj->client_id = Session::get('client_id');
        	$editfileObj->name = $file->file_name;
			$editfileObj->date_uploaded = strtotime(Carbon::now());
			$editfileObj->save();
        return $response;
        /* Create New directory - end */
    }

    public function createNewFile($file_name, $parent_id, $from_directory, $file_job_id) {
    	//$files_arr = [];
        $fileCount = $this->checkFileIsAvailableOrNot($file_name, $parent_id);

        $new_name = md5(time() . $file_name . $this->generateRandomString()) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
        
        @copy($from_directory . '/' . $file_name, public_path('storage/files/').$new_name);

        /* Create New file - start */
        if (!$fileCount) {
            $data = array(
                'file_name' => $file_name,
                'file_type' => 2,
                'file_parent_id' => $parent_id,
                'job_id' => $file_job_id,
                'file_date_modified' => time(),
                'file_upload_name' => $new_name,
                'file_shared' => 1,
                'file_size' => filesize(public_path('storage/files/'). $new_name),
            );
            $file = new File();
                $file->file_name = $file_name;
                $file->file_upload_name = $new_name;
                $file->file_type = 2;
                $file->file_parent_id = $parent_id;
                $file->job_id = $file_job_id;
                $file->file_date_modified = time();
                $file->file_shared = 1;
        		$file->is_copied_moved = 1;
                $file->file_size = filesize(public_path('storage/files/'). $new_name);
                $file->save();
                $finfo=explode('.',$new_name);
                if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $this->files_arr[]=$file->file_id;
                        }
                    }
           // $this->updateFolderSize($parent_id);
        }
        /* Create New file - end */
        /* Modify existing file - start */ else {

            $file = File::where('file_id', $fileCount->file_id)->first();
                $file->file_name = $file_name;
                $file->file_type = 2;
                $file->file_parent_id = $parent_id;
                $file->job_id = $file_job_id;
                $file->file_date_modified = time();
                $file->file_upload_name = $new_name;
                $file->file_shared = 1;
        		$file->is_copied_moved = 1;
                $file->file_size = filesize(public_path('storage/files/'). $new_name);
                $file->files_updated_at = time();   
                $file->update();     
        		$finfo=explode('.',$new_name);
                if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $this->files_arr[]=$file->file_id;
                        }
                    }

        }
         	$downloadObj = new Download(); 
        	$downloadObj->download_client_id = Session::get('client_id');
        	$downloadObj->download_file_id = $file->file_id;
        	$downloadObj->download_date = strtotime(Carbon::now());
        	$downloadObj->save();
    
			$editfileObj = new Editedfile();
			$editfileObj->file_id = $file->file_id;
        	$editfileObj->client_id = Session::get('client_id');
        	$editfileObj->name = $file->file_name;
			$editfileObj->date_uploaded = strtotime(Carbon::now());
			$editfileObj->save();
        /* Modify existing file - end */
   /* if($files_arr)
    	$this->uploadodfonserver($files_arr);*/
    }

     public function updateFolderSize($parent_id) {
        // echo $parent_id . "</br>";
        if ($parent_id != '') {
            $foldesize = $this->user_model->getsumbyproductId($parent_id);
            if ($foldesize && $foldesize != '') {
                $this->user_model->updateFoldersizeParentId($parent_id, $foldesize[0]->file_size);
            }
        }
    }

    public function checkDirectoryIsAvailableOrNot($folder_name, $parent_id) {
        $query = File::where('file_name',$folder_name)->where('file_parent_id',$parent_id)->where('file_status',1)->where('file_type',1)->first();

        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function checkFileIsAvailableOrNot($file_name, $parent_id) {
        $query = File::where('file_name',$file_name)->where('file_parent_id',$parent_id)->where('file_status',1)->where('file_type',2)->first();
        
        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function deleteZipFile($file_name, $parent_id) {
        $file = File::where('file_name', $file_name)->where('file_parent_id', $parent_id)->first();
        $file->delete();
        return true;
    }
    
    /**
    My Files Function Start
    **/
	
	
	public function myFiles(Request $request,$whchjobs=false)
    {
        $my_notifications = $this->getNotifications();
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
    
    		$active_job = Job::find(Session::get('job_id'));
            
            /*get downloaded files here*/
            $arr_my_dfiles=[];
           $clientid = Session::has('client_id') ? Session::get('client_id') : '';
           $AllMyFiles = Download::where('download_client_id',$clientid)->get();
           $arr_my_dfiles[]=array();
           if($AllMyFiles){
               foreach ($AllMyFiles as $myfile){
                   $arr_my_dfiles[] = $myfile->download_file_id;
               }
           }

            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';

       $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
		 }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
		 if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
		}

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->orderBy('file_type', 'asc')->get();
    
    	/** only folders **/
    	$my_dirs = File::whereIn('file_id',$final_clouds)->where('file_type',1)->orderBy('file_type', 'asc')->get();
	
        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $url = URL::to('/clients/file/render/');
            $move_icon = url('public/images/move-icon.png');

            $arr_nods_move = [];
            $all_nods_move = [];

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }
					elseif($file_extension == 'pdf'){
						$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/file-pdf-icon_32.png');
					}
					else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                    // $iframDoc = '<iframe class="doc" src="https://docs.google.com/gview?url=http://web.etabella.com/etabellaweb/public/storage/files/51f1101833f3145685dfbefba586e2f4.docx&embedded=true"></iframe>';

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_move["id"] = $my_cloud->file_id;
                    $arr_nods_move["pId"] = $my_cloud->file_parent_id;

                	$editedfile = Editedfile::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                	if($editedfile){
                    	$myfilename = $editedfile->name;
                    }else{
                    	$myfilename = $my_cloud->file_name;
                    } 
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' id='check_node_".$my_cloud->file_id."' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($myfilename)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon copy_icon' style=' margin-right: 19px; ' ><i class='fa fa-copy'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."'  onchange='folderCheck(".$my_cloud->file_id.")' class='check_file_cls nodefile filecheck checkmyfile-".$my_cloud->file_id." main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."'> 	  <p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_move["name"] = "<a style='width: 100%; height: 33px !important; ' id='check_node_popup_".$my_cloud->file_id."' onclick='moveHere(".$my_cloud->file_id.")' class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($myfilename)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none;color:lightgreen;'></i></a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                    }else{
                    	if($file_extension == 'pdf'){
                        	$tagstatus = Tagstatus::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                        	if($tagstatus){
                            	$tag = Tag::find($tagstatus->tag_id);
                               	$tagcolor = $tag->color_tag;
                            }else{
                            	$tagcolor = '#FFFFFF';
                            }
                        	$arr_nods["name"] = "<i class='fa fa-circle' style='color:".$tagcolor."'></i><a href='".$url."/".$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($myfilename)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon copy_icon'><i class='fa fa-copy' style='margin-right:19px'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='check_file_cls nodefile filecheck  checkmyfile-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
							$arr_nods["name"] = "<a onclick='".$targetclick."' target='_blank' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($myfilename)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='check_file_cls nodefile filecheck  checkmyfile-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."<a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";                        
                        }
                        $arr_nods_move["name"] = "<a class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($myfilename)."</a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_move["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_move[] = $arr_nods_move;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_move = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
          $this->arr_merge=[];
            return view('clients.myfiles',['my_dirs'=>$my_dirs,'active_job'=>$active_job,'all_nods'=>$all_nods,'all_nods_move'=>$all_nods_move,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'notifications'=>$my_notifications]);

    }
	
   /** public function myFiles(Request $request,$whchjobs=false)
    {
        $my_notifications = $this->getNotifications();
            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            if($alljobs[0] && $whchjobs==false){
                $whchjobs = $alljobs[0];
            }

            /*get downloaded files here*/
    /**        $arr_my_dfiles=[];
           $clientid = Session::has('client_id') ? Session::get('client_id') : '';
           $AllMyFiles = Download::where('download_client_id',$clientid)->get();
           $arr_my_dfiles[]=array();
    /**       if($AllMyFiles){
               foreach ($AllMyFiles as $myfile){
                   $arr_my_dfiles[] = $myfile->download_file_id;
               }
           }

            /**for breadcrumb**/
    /**        $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';

       $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
		 }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
		 if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
		}

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $url = URL::to('/clients/file/render/');

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' class='nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                    }else{
                        $arr_nods["name"] = "<a href='".$url."/".$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
          $this->arr_merge=[];
            return view('clients.myfiles',['all_nods'=>$all_nods,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'notifications'=>$my_notifications]);

    }**/
	

    /**
    End
    **/


    /**
    Method Get Files Id
    **/

    public function getFilesId($file_id)
     {
        //$arr = [];
        $childs=File::where('file_parent_id',$file_id)->get();
        
        if(count($childs) > 0){
            foreach($childs as $i => $child)
            {
                if($child->file_type == 1)
                 {
                    array_push($this->arr_merge, $child->file_id);
                    $this->getFilesId($child->file_id);

                 }
                 elseif($child->file_type == 2)
                  {
                   //$this->arr_merge=$child->file_id;
                   array_push($this->arr_merge, $child->file_id);
                  }
            }
                    // array_merge($arr_merge,$arr);
        }
           

     }

    /**
    End
    **/

    /**
    Method Sub Downloaded Files
    **/

    public function subDownloadedFiles(Request $request,$id,$whchjobs=false)
     {
        $my_notifications = $this->getNotifications();
        $clientId=$request->session()->get('client_id');
                  $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');

            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
            /**for breadcrumb**/
 //           $arr_bread[] = 'Home';

   //         $arr_bread_bk[0]['file_id'] = ''; 
     //       $arr_bread_bk[0]['filename'] = 'Home';
                        /*for Breadcrumb*/
            $arr_bread = [];
            $arr_bread_bk = []; 
            
            $file = File::where('file_id',$id)->first(); 
            $arr_bread[] = ucfirst($file->file_name); 

            $arr_bread_bk[0]['file_id'] = ucfirst($file->file_id); 
            $arr_bread_bk[0]['filename'] = ucfirst($file->file_name); 

            
            $parentid = $file->file_parent_id;

            $i = 1;
            $last_i = '';
            while ($parentid){
               $file = File::where('file_id',$file->file_parent_id)->first(); 
               $arr_bread[] = ucfirst($file->file_name); 

                $arr_bread_bk[$i]['file_id'] = ucfirst($file->file_id); 
                $arr_bread_bk[$i]['filename'] = ucfirst($file->file_name); 

               $parentid = $file->file_parent_id;
               $i++;
               $last_i = $i; 
            }
            $arr_bread[] = 'Home';

            if($last_i){
                $arr_bread_bk[$last_i]['file_id'] = ''; 
                $arr_bread_bk[$last_i]['filename'] = 'Home';
            }else{
                $arr_bread_bk[1]['file_id'] = ''; 
                $arr_bread_bk[1]['filename'] = 'Home';
            }

            $arr_bread = array_reverse($arr_bread);
            $arr_bread_bk = array_reverse($arr_bread_bk);


         $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
			 foreach($downloadedFiles as $key=>$downloadedFile)
			  {
				$downloadedFilesId[$key]=$downloadedFile->download_file_id;
			  }
		 }
        $my_files = DB::select('select * from `files` where `file_parent_id` = '.$id.' and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');

     //    $my_files = File::where('file_parent_id',$id)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         
         $i=0;
		if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
//                        $this->arr_merge=[];
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
		}
          $this->arr_merge=[];
            return view('clients.myfiles',['my_clouds'=>$my_clouds,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'notifications'=>$my_notifications]);
     }
     
    /**
    End
    **/

    public function searchByKeywords(Request $request,$keywords,$whchjobs=false){
        $html = '';
        
        if($request->session()->has('client_id')){
        $jobs = '';
        $job_id = '';
            if(Session::has('jobs')){
                $job_id = explode(',', Session::get('jobs')); 
                $jobs = Job::whereIn('job_id',$job_id)->get();
            }
        
            if(!$whchjobs){
            	$whchjobs = Session::get('job_id');
        	}

            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
        }

        $keyword_clouds = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and `is_copied_moved` = 0 and FIND_IN_SET('.$whchjobs.',`job_id`) and `file_name` like "%'.$keywords.'%" order by `file_type` ASC');

        $my_clouds=[];
         
         $i=0;
        if(count($keyword_clouds) > 0){
         foreach($keyword_clouds as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type ==1)
             {
                $my_clouds[$i]=$my_file->file_id;
                $i++;
                 $this->getFilesId($my_file->file_id);
          
                if(count($this->arr_merge) > 0){
                 foreach($this->arr_merge as $fileId)
                  {
                    
                        $my_clouds[$i]=$fileId;
                        $i++;
//                        $this->arr_merge=[];
                       
                     
                  }
                }
             }
            else
              {
                
                    $my_clouds[$i]=$my_file->file_id;
                    $i++;
                   
              }
          }
        }
          $this->arr_merge=[];

    if(count($my_clouds) > 0){
       $my_clouds_str = implode(',', $my_clouds);   
       $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 and `is_copied_moved` = 0 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');   
    }
    // echo "<pre>";
        // print_r($my_clouds);
        // die;
        // if(count($my_clouds) > 0){
        //     $html = view('clients.single', ['my_clouds'=>$my_clouds,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles])->render();
        // }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();

        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $move_icon = url('public/images/move-icon.png');
    		$url = URL::to('/clients/from/dashboard/');

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                    
                	// $isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->exists();    
                         $checked = "name='file_id'";
                         $classes_folder = "class='check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
                         $classes_file = "class='check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' ".$classes_folder." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                        // $arr_nods["name"] = "<a href='file/render/".$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:21px;'><i class='fa fa-edit'></i></a><a type='button' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:12px;'><img src='".$move_icon."' height='20' width='20' style='padding-bottom:5px;color:#ccc'></a></p>";
						if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='".$url.'/'.$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
                            $arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File added yet</strong>');
            }
        echo json_encode($all_nods);
    }

    public function check($id,Request $request){

        $my_notifications = $this->getNotifications();

        $notification = Notification::findOrfail($id); 
		$notification_using_file=Notification::where('file_id',$notification->file_id)->get()->toArray();
	   /* echo "<pre>";
        print_r($notification);
		echo 
		die();*/
		$sender = $notification->sender;
    	$download_info=Download::where('download_client_id',$notification->sender)->where('download_file_id',$notification->file_id)->get()->toArray();
		//print_r($download_info);
        //die();
		if(isset($download_info[0]))
		{
			$download_id=$download_info[0]['download_id'];
			$layer_token=$download_info[0]['layer'];
		}
		else 
		{
			$download_info=Download::where('download_client_id',$notification->client_id)->where('download_file_id',$notification->file_id)->get()->toArray();
			$download_id=$download_info[0]['download_id'];
			$layer_token=$download_info[0]['layer'];
			
		}
		
		
		
        
        $file = File::where('file_id',$notification->file_id)->first();
        // if($notification){
            // $annot = Notification::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$id)->first();

            if($notification){
                $annotJson = $notification->annotation_data;
            }else{
                $annotJson = [];
            }
        
            if($notification->mark_read == 1){
                $notification->mark_read = 2;    
                $notification->save();
            }
            
            // $book = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$notification->id)->first();

            // if($book){
            //     $bookJson = $book->bookmarked_data;
            // }else{
            //     $bookJson = [];
            // } 
            
        // }
		
	/*	echo "<pre>";
		print_r($notification_using_file);
		die();*/
		
        return view('clients.file_render',['download_id'=>$download_id,'client_id'=>Session::get('client_id'),'file'=>$file,'annotJson'=>$annotJson,'notifications'=>$my_notifications,'notofocation_main'=>$notification,'sender'=>$sender,'layer_token'=>$layer_token]);
    }

    public function sortMyFiles(Request $request,$whchjobs=false){

        $my_clouds=$request->input("myClouds");
        $orderName=$request->input("orderName");
        if(Session::get($orderName) == 'asc'){
            $request->session()->forget($orderName);
            $request->session()->put($orderName,'desc');
        }else{
            $request->session()->forget($orderName);
            $request->session()->put($orderName,'asc');
        }
        $type=$request->session()->get($orderName);
        $temp=[];
        /** Sory by file name **/
        if($orderName=="file_name")
         {
           if($type=="desc")
             {
               for($e=0;$e<count($my_clouds);$e++)
                {
                  for($f=$e+1;$f<count($my_clouds);$f++)
                    {
                       $file1=$my_clouds[$e]["file_name"];
                       $file2=$my_clouds[$f]["file_name"];
                       if(strcasecmp($file1,$file2)<0)
                        {
                          $temp=$my_clouds[$e];
                          $my_clouds[$e]=$my_clouds[$f];
                          $my_clouds[$f]=$temp;
                        }
                    }
                }
             }
             else
              {
                 for($e=0;$e<count($my_clouds);$e++)
                    {
                     for($f=$e+1;$f<count($my_clouds);$f++)
                        {
                          $file1=$my_clouds[$e]["file_name"];
                          $file2=$my_clouds[$f]["file_name"];
                          if(strcasecmp($file1,$file2)>0)
                            {
                              $temp=$my_clouds[$e];
                              $my_clouds[$e]=$my_clouds[$f];
                              $my_clouds[$f]=$temp;
                            }
                        }
                    }
              }
        }

       /** Sory by file date,file size,file type **/
       else
         {
           if($type=="desc")
             {
               for($e=0;$e<count($my_clouds);$e++)
                {
                  for($f=$e+1;$f<count($my_clouds);$f++)
                    {
                       $file1=$my_clouds[$e][$orderName];
                       $file2=$my_clouds[$f][$orderName];
                       if($file1<$file2)
                        {
                          $temp=$my_clouds[$e];
                          $my_clouds[$e]=$my_clouds[$f];
                          $my_clouds[$f]=$temp;
                        }
                    }
                }
             }
             else
              {
                 for($e=0;$e<count($my_clouds);$e++)
                    {
                     for($f=$e+1;$f<count($my_clouds);$f++)
                        {
                          $file1=$my_clouds[$e][$orderName];
                          $file2=$my_clouds[$f][$orderName];
                          if($file1>$file2)
                            {
                              $temp=$my_clouds[$e];
                              $my_clouds[$e]=$my_clouds[$f];
                              $my_clouds[$f]=$temp;
                            }
                        }
                    }
              }
        }
            if($request->session()->has('client_id')){
               $jobs = '';
               $job_id = '';
                   if(Session::has('jobs')){
                       $job_id = explode(',', Session::get('jobs'));
                       $jobs = Job::whereIn('job_id',$job_id)->get();
                   }
                   if($whchjobs){
            			$request->session()->put('job_id',$whchjobs);
        			}
            		$whchjobs = Session::get('job_id');
               }
            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
        $html = view('clients.myfiles-single', ['my_clouds'=>$my_clouds,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles])->render();
        echo $html;
    }

    /**
    Search My Files Start
    **/
   public function searchMyFilesByKeywords(Request $request,$keywords,$whchjobs=false)
     {
    
        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');

        // $my_files = $request->session()->get('downloaded_recursive_files');
    	$my_files = Editedfile::where('client_id',Session::get('client_id'))->get();
    
        $filter_ids = [];
        if(count($my_files) > 0){
            foreach ($my_files as $fkey => $mfile) {
                if (preg_match('/.*'.$keywords.'.*/i', $mfile->name)) {
                    $filter_ids[] = $mfile->file_id;
                }
            }
        }

        $my_clouds=[];
        

    if(count($filter_ids) > 0){
            $filter_ids_str = implode(',', $filter_ids);
            
            $keyword_clouds = DB::select('select * from `files` where `file_id` in('.$filter_ids_str.') order by `file_type` ASC');
        


        /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
         
         $i=0;
        if(count($keyword_clouds) > 0){
            foreach($keyword_clouds as $key=>$my_file)
              {
                $this->arr_merge=[];

                if($my_file->file_type ==1)
                 {
                    $my_clouds[$i]=$my_file->file_id;
                    $i++;
                     $this->getFilesId($my_file->file_id);
              
                    if(count($this->arr_merge) > 0){
                     foreach($this->arr_merge as $fileId)
                      {
                        // check this fileid is folder or file
                        $check_this_file = File::where('file_id',$fileId)->first();
                        if($check_this_file->file_type == 2){
                            if(in_array($fileId,$arr_my_dfiles))
                                {
                                $my_clouds[$i]=$fileId;
                                $i++;
                                }
                        }else{
                                $my_clouds[$i]=$fileId;
                                $i++;
                        }
                      }
                    }
                }
                else
                {
                    if(in_array($my_file->file_id,$arr_my_dfiles))
                        {
                            $my_clouds[$i]=$my_file->file_id;
                            $i++;
                        }
                }
            }
        }
          $this->arr_merge=[];

       $my_clouds_str = implode(',', $my_clouds);   
       $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC'); 
    }   

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();     

        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
    		$move_icon = url('public/images/move-icon.png');
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                $file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }

                	$url = url('clients/file/render/'.$my_cloud->file_id);
                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                
                	$editedfile = Editedfile::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                	if($editedfile){
                    	$myfilename = $editedfile->name;
                    }else{
                    	$myfilename = $my_cloud->file_name;
                    }
                    
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' class='nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";

                    }else{
                    	if($file_extension=='pdf'){
                        	$tagstatus = Tagstatus::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                        	if($tagstatus){
                            	$tag = Tag::find($tagstatus->tag_id);
                               	$tagcolor = $tag->color_tag;
                            }else{
                            	$tagcolor = '#FFFFFF';
                            }
                        	$arr_nods["name"] = "<i class='fa fa-circle' style='color:".$tagcolor."'></i><a href='".$url."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";
                    	}else{
							$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($myfilename)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";                        
                        }
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:135%">No Folder & File found for this keyword</strong>');
            }
        echo json_encode($all_nods);
    }
    /**
    End
    **/

    public function searchMyFilesInModal(Request $request,$keywords)
     {
        $my_files = $request->session()->get('downloaded_recursive_files');
        

        $filter_ids = [];
        if(count($my_files) > 0){
            foreach ($my_files as $fkey => $mfile) {
                if (preg_match('/.*'.$keywords.'.*/i', $mfile->file_name)) {
                    $filter_ids[] = $mfile->file_id;
                }
            }
        }

        $my_clouds=[];
        // echo "<pre>";
        // print_r($filter_ids); die;

    if(count($filter_ids) > 0){
            $filter_ids_str = implode(',', $filter_ids);
            
            $keyword_clouds = DB::select('select * from `files` where `file_id` in('.$filter_ids_str.') order by `file_type` ASC');
        


        /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
         
         $i=0;
        if(count($keyword_clouds) > 0){
            foreach($keyword_clouds as $key=>$my_file)
              {
                $this->arr_merge=[];

                if($my_file->file_type ==1)
                 {
                    $my_clouds[$i]=$my_file->file_id;
                    $i++;
                     $this->getFilesId($my_file->file_id);
              
                    if(count($this->arr_merge) > 0){
                     foreach($this->arr_merge as $fileId)
                      {
                        // check this fileid is folder or file
                        $check_this_file = File::where('file_id',$fileId)->first();
                        if($check_this_file->file_type == 2){
                            if(in_array($fileId,$arr_my_dfiles))
                                {
                                $my_clouds[$i]=$fileId;
                                $i++;
                                }
                        }else{
                                $my_clouds[$i]=$fileId;
                                $i++;
                        }
                      }
                    }
                }
                else
                {
                    if(in_array($my_file->file_id,$arr_my_dfiles))
                        {
                            $my_clouds[$i]=$my_file->file_id;
                            $i++;
                        }
                }
            }
        }
          $this->arr_merge=[];

       $my_clouds_str = implode(',', $my_clouds);   
       $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 order by `file_type` ASC'); 
    }   
        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                        $arr_nods["name"] = "<a href='file/render/".$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."</a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck' data-file_id='".$my_cloud->file_id."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:135%">No Folder & File found for this keyword</strong>');
            }
        echo json_encode($all_nods);
    }

    public function searchMyFilesInHyperlink(Request $request,$keywords)
     {
        $my_files = $request->session()->get('downloaded_recursive_files');
        

        $filter_ids = [];
        if(count($my_files) > 0){
            foreach ($my_files as $fkey => $mfile) {
                if (preg_match('/.*'.$keywords.'.*/i', $mfile->file_name)) {
                    $filter_ids[] = $mfile->file_id;
                }
            }
        }

        $my_clouds=[];
        // echo "<pre>";
        // print_r($filter_ids); die;

    if(count($filter_ids) > 0){
            $filter_ids_str = implode(',', $filter_ids);
            
            $keyword_clouds = DB::select('select * from `files` where `file_id` in('.$filter_ids_str.') order by `file_type` ASC');
        


        /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
         
         $i=0;
        if(count($keyword_clouds) > 0){
            foreach($keyword_clouds as $key=>$my_file)
              {
                $this->arr_merge=[];

                if($my_file->file_type ==1)
                 {
                    $my_clouds[$i]=$my_file->file_id;
                    $i++;
                     $this->getFilesId($my_file->file_id);
              
                    if(count($this->arr_merge) > 0){
                     foreach($this->arr_merge as $fileId)
                      {
                        // check this fileid is folder or file
                        $check_this_file = File::where('file_id',$fileId)->first();
                        if($check_this_file->file_type == 2){
                            if(in_array($fileId,$arr_my_dfiles))
                                {
                                $my_clouds[$i]=$fileId;
                                $i++;
                                }
                        }else{
                                $my_clouds[$i]=$fileId;
                                $i++;
                        }
                      }
                    }
                }
                else
                {
                    if(in_array($my_file->file_id,$arr_my_dfiles))
                        {
                            $my_clouds[$i]=$my_file->file_id;
                            $i++;
                        }
                }
            }
        }
          $this->arr_merge=[];

       $my_clouds_str = implode(',', $my_clouds);   
       $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 order by `file_type` ASC'); 
    }   
        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $all_add_to_links=[];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {

                    $add_to_link["id"] = $my_cloud->file_id;
                    $add_to_link["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $add_to_link["name"] = "<a class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='top:5px; margin-left: 75px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                        $add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    $all_add_to_links[]=$add_to_link;
                }
            }else{
                $all_add_to_links = array('name'=>'<strong style="color:#A8A2A2;margin:135%">No Folder & File found for this keyword</strong>');
            }
        echo json_encode($all_add_to_links);
    }
    public function get_annotation_for_file($doc,$layer)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://web.etabella.com:5000/api/documents/'.$doc.'/layers/'.$layer.'/document.json');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


		$headers = array();
		$headers[] = 'Authorization: Token token=secret';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		return json_decode(json_encode(json_decode($result)),true); 
		/*echo "<pre>";
		print_r(json_decode($result));*/
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
	}
    public function instantJson1(Request $request){
		
        //$request->alll_instance=json_decode(json_encode(json_decode($request->alll_instance)),true);
		$open_files=json_decode(json_encode(json_decode($request->open_file_info)),true);
		$annotation_info=array();
		foreach($open_files as $fil)
		{
			$ann = $this->get_annotation_for_file($fil['psppdf_file_id'],$fil['layer']);
			$annotation_info[]=array('instance'=>$ann,'file_id'=>$fil['file_id']);
		}
    
		/*echo "<pre>";
		print_r($annotation_info);
		die();*/
        if($request->overlay_ids)
        {
            foreach($request->overlay_ids as $d1)
            {
                $pdf_overlay_info = Pdf_file_overlay::where('id',$d1['id'])->get()->toArray();
                if($pdf_overlay_info)
                {

                    $reportData =Report::where('annotation_id',$d1['id'])->get()->toArray();
                    foreach($reportData as $rd)
                    {
                        $r1 = Report::where('id',$rd['id'])->get()->first();
                        if($r1)
                        {
                            $r1->delete();
                        }
                    }
                        $file_info = File::where('file_id',$pdf_overlay_info[0]['file_id'])->get()->toArray();
                      
                        $reportData = new Report();
                        $reportData->client_id = Session::get('client_id');
                        $reportData->file_id = $pdf_overlay_info[0]['file_id'];
                        $reportData->job_id = Session::get('job_id');
                        $reportData->file_name = $file_info[0]['file_name'];
                        $reportData->page = $d1['page_no'];
                        $reportData->data=json_encode(array());
                        $reportData->type= "Annotation";
                        $reportData->annotation_id=$d1['id'];
                        $reportData->created_at= strtotime(Carbon::now());
                        $reportData->save();

                        $ovr =Pdf_file_overlay::where('id',$d1['id'])->get()->first();
                        if($ovr)
                        {
                            $ovr->status=1;
                            $ovr->update();
                        }     
                }
                 
            }
        }
       $file = File::where('file_id',$request->fileid)->first();
            if($file){
            $filename = $file->file_name;
            }else{
                $filename = "";
            }
       if(isset($request->all()['delete_id']))
        {
            $reportD = Report::where('client_id',Session::get('client_id'))->where('file_id',$request->fileid)->where('annotation_id',$request->all()['delete_id'])->first();
            if($reportD){
                    $reportD->delete();
            }
        }
	    
        foreach($annotation_info as $instance_data)
        {
			if(isset($instance_data['instance']['bookmarks']))
			{
				$mbk=0;
				foreach($instance_data['instance']['bookmarks'] as $bm)
				{
					$report_status=Report::where('annotation_id',$bm['id'])->where('type','Bookmarked')->where('file_id',$instance_data['file_id'])->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->get()->toArray();
                    if(!$report_status)
                    {
                        $file_info_bmk=File::where('file_id',$instance_data['file_id'])->get()->toArray();
                        $report = new Report();
                        $report->client_id = Session::get('client_id');
                        $report->file_id = $instance_data['file_id'];
                        $report->job_id = Session::get('job_id');
                        $report->file_name =$file_info_bmk[0]['file_name'];
                        $report->page = $bm['action']['pageIndex']+1;
                        $report->data= $bm['id'];
                        $report->annotation_id= $bm['id'];
                        $report->type= 'Bookmarked';
                        $report->created_at= strtotime(Carbon::now());
                        $report->save();
                    $mbk=1;
					}
					
				}
				if($mbk)
				{
					$activitylogObj = new Activitylog();
					$action = 'Add Bookmark';
					$user_type = 'client';
					$activitylogObj->saveActivityLog($action,$user_type);
				}
			}
			if(isset($instance_data['instance']['annotations']))
			{
			   $nnrp=0;
			   foreach($instance_data['instance']['annotations'] as $key => $ann)
			   {    
					if(isset($ann['action']['type']))
					{
						if($ann['action']['type']=='uri')
						{
							unset($instance_data['instance']['annotations'][$key]);
						}   
					}
			   }
			   
				$arr_instant = json_decode($request->instant_json);
				
				$annotObj = '';
				$bookObj = '';
				
				foreach($instance_data['instance']['annotations'] as $inn) {
					
					$reportData1 = Report::where('client_id',Session::get('client_id'))->where('file_id',$instance_data['file_id'])->where('annotation_id',$inn['id'])->first();
					
					
					if(!$reportData1)
					{
						$nnrp=1;
						$file_info_data=File::where('file_id',$instance_data['file_id'])->get()->toArray();
						$reportData = new Report();
						$reportData->client_id = Session::get('client_id');
						$reportData->file_id = $instance_data['file_id'];
						$reportData->job_id = Session::get('job_id');
						$reportData->file_name =$file_info_data[0]['file_name'];
						$reportData->page = $inn['pageIndex']+1;
						$reportData->data=json_encode($instance_data['instance']['annotations']);
						$reportData->type= "Annotation";
						$reportData->annotation_id=$inn['id'];
						$reportData->created_at= strtotime(Carbon::now());
						$reportData->save();
					}
				}
				if($nnrp)
				{
					$activitylogObj = new Activitylog();
					$action = 'Add Annotation';
					$user_type = 'client';
					$activitylogObj->saveActivityLog($action,$user_type);
				}
			}
        } 			
	
        echo true;
    }
   public function instantJson(Request $request){
	  /* echo "<pre>";
	   print_r($request->all());
	   die();*/
       $file = File::where('file_id',$request->fileid)->first();
            if($file){
            $filename = $file->file_name;
            }else{
                $filename = ""; 
            }
        $ij=json_decode(json_encode(json_decode($request->all()['instant_json'])),true);
      
        $arr_report_ids = json_decode($request->report_all);
    /** For Issue,Bookmark and Hyperlink Report **/
        if(count($arr_report_ids) > 0){
            foreach($arr_report_ids  as $bkey => $bookid){
				
				$rep_status=Report::where('client_id',Session::get('client_id'))->where('file_id',$request->fileid)->where('annotation_id',$bookid->Data_id)->where('type',$bookid->Data_type)->get()->toArray();
				if(!$rep_status)
				{
					if($bookid->Data_type!='Annotation')
					{
						$report = new Report();
						$report->client_id = Session::get('client_id');
						$report->file_id = $request->fileid;
						$report->job_id = Session::get('job_id');
						$report->file_name = $filename;
						$report->page = $bookid->Data_page+1;
						$report->data= $bookid->Data_id;
						$report->annotation_id= $bookid->Data_id;
						$report->type= $bookid->Data_type;
						$report->created_at= strtotime(Carbon::now());
						$report->save();
					}
				}
			}
        }
		//print_r($request->all()['delete_id']);
        if(isset($request->all()['delete_id']))
        {
			$reportD = Report::where('client_id',Session::get('client_id'))->where('file_id',$request->fileid)->where('annotation_id',$request->all()['delete_id'])->first();
			//print_r($reportD);
          //  if($reportD){
                    $reportD->delete();
           // }
        }

        $activitylogObj = new Activitylog();
        $action = 'Add Bookmark';
        $user_type = 'client';
        $activitylogObj->saveActivityLog($action,$user_type);
        echo true;
    } 
    public function shareAnnotation(Request $request){
        $title = ucfirst(Session::get('client_display_name'))." shared file";
        $message = ucfirst(Session::get('client_display_name'))." shared annotated file to you";
        $arr_instant = json_decode($request->instant_json);
        
        $annotObj = '';
        
       /* if(isset(json_decode(json_encode($arr_instant),true)['annotations'])){*/

            $find_annot = Notification::where('sender',Session::get('client_id'))->where('file_id',$request->fileid)->where('client_id',$request->client_id)->first();
            
            if($find_annot){
                $annotObj = $find_annot;
            }else{
                $annotObj = new Notification();
            }

            if(isset(json_decode(json_encode($arr_instant),true)['annotations']))
                $ann=json_encode($arr_instant->annotations);
            else 
                $ann='';
            $annotObj->title = $title;
            $annotObj->message = $message;
            $annotObj->sender = Session::get('client_id');
            $annotObj->client_id = $request->client_id;
            $annotObj->file_id = $request->fileid;
        	$annotObj->job_id = Session::get('job_id');
            $annotObj->annotation_data = $ann;
            $annotObj->is_annotation = 1;
            $annotObj->mark_read = 1;
            $annotObj->created_at = strtotime(Carbon::now());
            $annotObj->updated_at = strtotime(Carbon::now());
            $annotObj->save();

            $activitylogObj = new Activitylog();
            $action = 'Shared Annotation';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type);
       // }

        if($annotObj){
            echo true;
        }else{
            echo false;
        }
    }

	public function reports(Request $request,$whchjobs=false){
     $start = date('m/d/Y');
    
        $my_notifications = $this->getNotifications();
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    	$active_job = Job::find(Session::get('job_id'));
        $startDate = strtotime($start." 00:00:00");
        $endDate = strtotime($start." 23:59:59");
        $reports = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        
        $annotations = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type', 'LIKE', '%Annotation%')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        $hyperlinks = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type', 'LIKE', '%Hyperlink%')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        $bookmarks = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type', 'LIKE', '%Bookmark%')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
    	$issues = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type', 'LIKE', '%Issue%')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        
        return view('clients.reports',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'reports'=>$reports,'annotations'=>$annotations,'hyperlinks'=>$hyperlinks,'bookmarks'=>$bookmarks,'issues'=>$issues]);
    }

    /***public function reports($whchjobs=false){
        $my_notifications = $this->getNotifications();
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            if($alljobs[0] && $whchjobs==false){
                $whchjobs = $alljobs[0];
            }

        $annots = Annotation::where('annotation_client_id',Session::get('client_id'))->orderBy('annotation_date','desc')->get();

        $books = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->orderBy('bookmarked_date','desc')->get();

        $my_clouds= [];
        $arr_id = [];
        $arr_annot_id = [];
        $arr_book_id = [];
        $arr_nods = [];
        if(count($annots) > 0) {
            foreach($annots as $annot)
            {
                $arr_annot_id[] = $annot->annotation_file_id; 
            }
        } 
        if(count($books) > 0) {
            foreach($books as $book)
            {
                $arr_book_id[] = $book->bookmarked_file_id; 
            }
        }  
        $arr_id = array_merge($arr_annot_id, $arr_book_id);

        if($arr_id){
            $str_id = implode(',', $arr_id);

            $my_clouds = DB::select('select * from `files` where `file_id` in('.$str_id.') and `file_shared` = 1 and `file_status` = 1 order by `file_date_modified` DESC');
        }

        return view('clients.reports',['jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'myclouds'=>$my_clouds,'book_ids'=>$arr_book_id,'annot_ids'=>$arr_annot_id]);
    }**/

    public function dashPlugin(Request $request,$whchjobs=false){
        $my_notifications = $this->getNotifications();
        if($request->session()->has('client_id')){

            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');

            $my_clouds = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
            $arr_nods = [];
            $all_nods = [];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    $arr_nods["name"] = $my_cloud->file_name;
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }
            
            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';
            
            /*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
        }
        return view('clients.dashboardplugin',['jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles,'all_nods'=>$all_nods,'notifications'=>$my_notifications]);
    }

    public function markAsRead($id){
        $notification = Notification::where('id',$id)->where('client_id',Session::get('client_id'))->first();
        $notification->mark_read = 2;
        $notification->update();
        if($notification){
            $count = Notification::where('client_id',Session::get('client_id'))->where('mark_read',1)->count();
            return json_encode(['message'=>true,'count'=>$count]);
        }else{
            return json_encode(['message'=>false,'count'=>$count]);
        }

    }

    public function markAllRead(){
        $notifications = Notification::where('mark_read',1)->where('client_id',Session::get('client_id'))->get();

        if(count($notifications) > 0){
            foreach ($notifications as $nkey => $notification) {
                $notification->mark_read = 2;
                $notification->update(); 
            }
        }
        return json_encode(['message'=>true,'count'=>0]);
    }

    // public function inbox($whchjobs=false,$selected_grp_id=false){
    //     $my_notifications = $this->getNotifications();
    //     $sess_client_id = Session::get('client_id');
    //     $job_id = Session::get('jobs');
    //         $alljobs = explode(',', $job_id); 
            
    //         $jobs = Job::whereIn('job_id',$alljobs)->get();
    //         if($alljobs[0] && $whchjobs==false){
    //             $whchjobs = $alljobs[0];
    //         }

    //         $groups = '';
    //         $members = '';
    //         $selected_grp = '';
    //         $member_names = [];
    //         $arr_client = '';
    //         $this_job = Job::findOrfail($whchjobs);
    //         if($this_job){
                
    //             $this_job_groups = $this_job->group_id;

    //             $arr_grps = explode(',', $this_job_groups);
                
    //             if($arr_grps[0] && $selected_grp_id==false){
    //                 $selected_grp_id = $arr_grps[0];
    //             }

    //             $groups = Group::whereIn('group_id',$arr_grps)->get();

    //             if($selected_grp_id){
    //                 $selected_grp = Group::where('group_id',$selected_grp_id)->first();  
    //             }
                
    //             if($selected_grp){
    //                 $arr_client = explode(",", $selected_grp->client_id);
    //                 // $members = DB::select('select * from `clients` where FIND_IN_SET('.$selected_grp->client_id.',`client_id`) order by `client_display_name` ASC');
    //                 $members = Client::whereIn('client_id',$arr_client)->get();
    //                 if(count($members) > 0){
    //                     foreach ($members as $memkey => $member) {
    //                         $member_names[] = ucfirst($member->client_display_name);
    //                     }
    //                 }
    //             }

    //         }


    //         $all_users = DB::select('select * from `clients` where FIND_IN_SET('.$whchjobs.',`jobs`) order by `client_display_name` DESC');

    //         // $startDate = strtotime(date('Y-m-d')." 00:00:00");
    //         $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
    //         $endDate = strtotime(date('Y-m-d')." 23:59:59");
            
    //         $messages = Groupchat::where('group_id',$selected_grp_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','asc')->get();
                
                
    //         // echo "<pre>";
    //         // echo $messages;
    //         // die;
            
            
    //     return view('clients.chat.inbox',['jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'selected_grp'=>$selected_grp,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages]);
    // }

    public function directChat(Request $request,$whchjobs=false,$selected_user_id=false){
       /* if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
							|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
							, $_SERVER["HTTP_USER_AGENT"]))
		{
			return redirect(url('clients/user-single/'.$whchjobs.'/'.$selected_user_id)); 
			die();
		}*/

        Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('sender',$selected_user_id)->where('type','3')->update(array('mark_read'=>'2'));


        $my_notifications = $this->getNotifications();
        $sess_client_id = Session::get('client_id');
    	
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);
    	
    
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
			
    		$active_job = Job::find(Session::get('job_id'));
    
            $groups = '';
            $members = '';
            $selected_user = '';
            $member_names = [];
            $arr_client_ids = [];
            $arr_client = '';
            $this_job = Job::findOrfail($whchjobs);
            if($this_job){
                
                $this_job_groups = $this_job->group_id;


              /*  $arr_grps = explode(',', $this_job_groups);
                
                $groups = Group::whereIn('group_id',$arr_grps)->get();
                if(count($groups) > 0){
                    foreach ($groups as $key => $grp) {
                        
                        $arr_clients = explode(",", $grp->client_id);
                        if(count($arr_clients) > 0){
                            foreach ($arr_clients as $clkey => $cl) {
                                $arr_client_ids[] =$cl; 
                            }
                        }
                    }
                }

                if($arr_client_ids){
                    $all_users = Client::whereIn('client_id',$arr_client_ids)->get();
                }*/


                $myjobs1 = Session::get('jobs');
       

        $jobs = Job::where('job_id',$myjobs1)->get();
      /*  print_r($jobs);
        die();*/
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            /*print_r($arr_group_ids);
            die();*/
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();

            //$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
          /*  foreach($groups as $gp)
            {
                $c1=$gp['client_id']
            }*/
            $grp=array();
            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
           /* echo "<pre>";
            print_r($grp);
            die();*/
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        $all_users = [];
        if(count($arr_client_ids) > 0){
            $all_users = Client::whereIn('client_id',$arr_client_ids)->get();
        }



                if($selected_user_id){
                    $selected_user = Client::where('client_id',$selected_user_id)->first();  
                }

            }

            $senderid = $selected_user_id;
            $receiverid = Session::get('client_id');
            
            $messages = Directchat::Where(function($query) use ($senderid, $receiverid)
                {
                    $query->where("sender_id",$senderid)
                          ->where("recipient_id",$receiverid)
                          ->where('new_msg',0);
                })
                    ->orWhere(function($query) use ($senderid, $receiverid)
                {
                    $query->Where("sender_id",$receiverid)
                          ->Where("recipient_id",$senderid);
                })->orderBy('created_at','desc')->limit(7)->get();

            $messages = $messages->reverse();

			foreach($messages as $m1)
			{
				$msgObj = Directchat::findOrfail($m1->id);
                if($msgObj)
                {
    				$msgObj->new_msg = 0;
    				$msgObj->save();
                }
			}
            /** start for change status of new messages **/
            // $new_messages = Directchat::where('sender_id',$selected_user_id)->where('recipient_id',Session::get('client_id'))->where('new_msg',1)->get();

            // if(count($new_messages) > 0){
            //     foreach ($new_messages as $newkey => $new_msg) {
            //         $msgObj = Directchat::findOrfail($new_msg->id);
            //         $msgObj->new_msg = 0;
            //         $msgObj->save();
            //     }
            // }
            /** end for change status of new messages **/


            // echo "<pre>";
            // print_r($messages->last);
            // die;
            $msg_count = count($messages);
            
           
         /*  $notification->mark_read = 2;
    	   $notification->update();*/
            return view('clients.chat.direct',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'selected_user'=>$selected_user,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages,'msg_count'=>$msg_count,'authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
    }
	public function user_single(Request $request,$whchjobs=false,$selected_user_id=false)
	{
		 Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('sender',$selected_user_id)->where('type','3')->update(array('mark_read'=>'2'));


        $my_notifications = $this->getNotifications();
        $sess_client_id = Session::get('client_id');
    	
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);
    	
    
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
			
    		$active_job = Job::find(Session::get('job_id'));
    
            $groups = '';
            $members = '';
            $selected_user = '';
            $member_names = [];
            $arr_client_ids = [];
            $arr_client = '';
            $this_job = Job::findOrfail($whchjobs);
            if($this_job){
                
                $this_job_groups = $this_job->group_id;
                $myjobs1 = Session::get('jobs');
       

        $jobs = Job::where('job_id',$myjobs1)->get();
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();

            $grp=array();
            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        $all_users = [];
        if(count($arr_client_ids) > 0){
            $all_users = Client::whereIn('client_id',$arr_client_ids)->get();
        }



                if($selected_user_id){
                    $selected_user = Client::where('client_id',$selected_user_id)->first();  
                }

            }

            $senderid = $selected_user_id;
            $receiverid = Session::get('client_id');
            
            $messages = Directchat::Where(function($query) use ($senderid, $receiverid)
                {
                    $query->where("sender_id",$senderid)
                          ->where("recipient_id",$receiverid)
                          ->where('new_msg',0);
                })
                    ->orWhere(function($query) use ($senderid, $receiverid)
                {
                    $query->Where("sender_id",$receiverid)
                          ->Where("recipient_id",$senderid);
                })->orderBy('created_at','desc')->limit(7)->get();

            $messages = $messages->reverse();

			foreach($messages as $m1)
			{
				$msgObj = Directchat::findOrfail($m1->id);
                if($msgObj)
                {
    				$msgObj->new_msg = 0;
    				$msgObj->save();
                }
			}
            $msg_count = count($messages);
            return view('clients.chat.user_single',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'selected_user'=>$selected_user,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages,'msg_count'=>$msg_count,'authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
	}
	

    // public function sendMsgGroup(Request $request){
    //     $message = $request->message;
    //     $group_id = $request->group_id;
    //     $sender_id = $request->sender_id;
    //     $group = Group::where('group_id',$group_id)->first();
    //     $all_group_members_str = $group->client_id;
    //     $all_group_members_arr = explode(",", $all_group_members_str);
    //     $arr_sender[] = $sender_id;
    //     //removing sender in all group members for preparing reciepient
    //     $reciepient_ids_arr = array_diff($all_group_members_arr, $arr_sender);
    //     $reciepient_ids_str = implode(",", $reciepient_ids_arr);
    //     $sender_detail = Client::where('client_id',$sender_id)->first(); 
    //     $sender_name = $sender_detail->client_display_name;
        
    //     $groupchatObj = new Groupchat();

    //     $groupchatObj->message = $message;
    //     $groupchatObj->group_id = $group_id;
    //     $groupchatObj->recipient_ids = $reciepient_ids_str;
    //     $groupchatObj->sender_id = $sender_id;
    //     $groupchatObj->sender_name = $sender_name;
    //     $groupchatObj->created_at = strtotime(Carbon::now());
    //     $save = $groupchatObj->save();
    //     if($save){
    //         $result = true;
    //     }else{
    //         $result = false;
    //     }
    //     echo $result;
    // }
    public function read_message($id)
	{
        $notifications = Notification::where('mark_read',1)->where('client_id',Session::get('client_id'))->where('sender',$id)->where(function($q1){
			 $q1->where('is_annotation','2')->Orwhere('is_annotation','3');
		 })->get();

        if(count($notifications) > 0){
            foreach ($notifications as $nkey => $notification) {
                $notification->mark_read = 2;
                $notification->update(); 
            }
        }
		echo '1';
	}
	
    public function sendMsgGroup(Request $request){
        $message = $request->message;
        $fileType = $request->fileType;
        $content = $request->content;
    	$job = Session::get('job_id');
        $group_id = $request->group_id;
        $msgType = $request->msg_type;
        $sender_id = Session::get('client_id');
    	$file = $request->file;
    
    	$group = Group::where('group_id',$group_id)->first();

    	$notif_title = ucfirst(Session::get('client_display_name'))." send message in ".$group->group_name;
        //$message1=strip_tags($message);
    //	$notif_message = strlen($message1) > 10  ? substr($message1, 0, 7) . '...' : $message1;
    
        if($file){
            // $image = str_replace('data:image/png;base64,', '', $content);
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $content);
            // Storage::disk('local')->put($message, file_get_contents($image));
        	
        	// $notif_title = ucfirst(Session::get('client_display_name'))." send image in ".$group->group_name;
        	$notif_message = ucfirst(Session::get('client_display_name'))." send message in ".$group->group_name;
        
        	$fileOriginalName = $file->getClientOriginalName();
        	$file->move(public_path("storage/app/"), $fileOriginalName);
    		//chmod(public_path("storage/app/"), 0777);	
        }
    	
    	$all_group_members_str = $group->client_id;
        $all_group_members_arr = explode(",", $all_group_members_str);
        $arr_sender[] = $sender_id;
        //removing sender in all group members for preparing reciepient
        $reciepient_ids_arr = array_diff($all_group_members_arr, $arr_sender);
        $reciepient_ids_str = implode(",", $reciepient_ids_arr);
        $sender_detail = Client::where('client_id',$sender_id)->first(); 
        $sender_name = $sender_detail->client_display_name;
        
        $groupchatObj = new Groupchat();
        $groupchatObj->message = $message;
        $groupchatObj->group_id = $group_id;
        $groupchatObj->msg_type  = $msgType;
        $groupchatObj->file_type  = $fileType;
        $groupchatObj->recipient_ids = $reciepient_ids_str;
        $groupchatObj->sender_id = $sender_id;
        $groupchatObj->sender_name = $sender_name;
    	$groupchatObj->reader_ids = $reciepient_ids_str;
        $groupchatObj->created_at = strtotime(Carbon::now());
        $save = $groupchatObj->save();
        if($save){
        
        /** Send Notifications **/
        if(count($reciepient_ids_arr) > 0){
        	foreach($reciepient_ids_arr as $notkey => $rec_id){
            	
            	$notification = new Notification();
            	$notification->title = $notif_title;
                $notification->message =$message;
            	$notification->job_id = $job;
            	$notification->sender = Session::get('client_id');
            	$notification->client_id = $rec_id;
            	$notification->file_id = $group_id;
            	$notification->is_annotation = 2;
            	$notification->mark_read = 1;
				$notification->type = 1;
            	$notification->created_at = strtotime(Carbon::now());
            	$notification->updated_at = strtotime(Carbon::now());
            	$notification->save();
               
         
            
        	}
        }
        
            $result = true;
        }else{
            $result = false;
        }
        echo $result;
    }

    // public function groupMessages($group_id,$last_msg){
    //     // $startDate = strtotime(date('Y-m-d')." 00:00:00");
    //     $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
    //     $endDate = strtotime(date('Y-m-d')." 23:59:59");
        
    //     $messages = Groupchat::where('group_id',$group_id)->where('new_msg',1)->where('sender_id','!=',Session::get('client_id'))->get();


    //     if(count($messages) > 0){
    //         $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();   

    //         // $resutl_arr['count_msgs'] =  count($messages);
    //         $msgIds = array();
            
    //         foreach ($messages as $mkey => $message) {
    //             $msgIds[] = $message->id;
    //         }
    //          $resutl_arr['html'] =  $html;
    //         $resutl_arr['here_append'] =  $last_msg;
    //         $resutl_arr['last_msg_id'] =  $messages[count($messages)-1]->id;
    //         $resutl_arr['success'] =  1;
    //         $resutl_arr['ids'] = $msgIds ;


    //     }else{
    //         $resutl_arr['html'] =  '';
    //         $resutl_arr['success'] =  0;
    //     }

    //     echo json_encode($resutl_arr);
    // }  

    public function groupMessages($group_id,$last_msg){
        // $startDate = strtotime(date('Y-m-d')." 00:00:00");
        // $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
        // $endDate = strtotime(date('Y-m-d')." 23:59:59");
        
        $messages = Groupchat::where('group_id',$group_id)->where('new_msg',1)->where('sender_id','!=',Session::get('client_id'))->get();

        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();   

            // $resutl_arr['count_msgs'] =  count($messages);
            $msgIds = array();
         foreach($messages as $m1)
		 {
			$msgObj = Groupchat::findOrfail($m1->id);
			$msgObj->new_msg = 0;
			$msgObj->save();
		 }
            foreach ($messages as $mkey => $message) {
                $msgIds[] = $message->id;
            }
             $resutl_arr['html'] =  $html;
            $resutl_arr['here_append'] =  $last_msg;
            $resutl_arr['last_msg_id'] =  $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
            $resutl_arr['ids'] = $msgIds ;						


        }else{
            $resutl_arr['html'] =  '';
            $resutl_arr['success'] =  0;
        }

        echo json_encode($resutl_arr);
    }    

    public function changeMsgStatus(Request $request){
        $arr_ids = $request->ids;
    	
    	if($arr_ids){
        foreach ($arr_ids as $mkey => $messageid) {
        $msgObj = Groupchat::findOrfail($messageid);
        $msgObj->new_msg = 0;
        $msgObj->save();
        }
    	$res['success'] = 1;
        }else{
        $res['error'] = 1;
        }
		echo json_encode($res);
    }
	
	public function changeNotifStatus(Request $request){
		$grp_id = $request->group_id;
		echo $grp_id;
    	
    	if($grp_id){
        $notifications = Notification::where('file_id',$grp_id)->where('client_id',Session::get('client_id'))->where('type',1)->where('mark_read',1)->get(); 
		
        foreach ($notifications as $nkey => $notification) {
                $msgObj = Notification::findOrfail($notification->id);
                $msgObj->mark_read = 2;
                $msgObj->save();
            }
        $this->getNewNotifications();
        $res['success'] = 1;
        }else{
        $res['error'] = 1;
        }
		echo json_encode($res);
    }
	
	
	
	
	public function changeMsgStatus1(Request $request){
        $arr_ids = $request->ids;
    	
    	if($arr_ids){
        foreach ($arr_ids as $mkey => $messageid) {
        $msgObj = TopicChat::findOrfail($messageid);
        $msgObj->new_msg = 0;
        $msgObj->save();
        }
    	$res['success'] = 1;
        }else{
        $res['error'] = 1;
        }
		echo json_encode($res);
    }
	
	public function changeNotifStatus1(Request $request){
		$grp_id = $request->group_id;
		echo $grp_id;
    	
    	if($grp_id){
        $notifications = Notification::where('file_id',$grp_id)->where('client_id',Session::get('client_id'))->where('type',2)->where('mark_read',1)->get(); 
		
        foreach ($notifications as $nkey => $notification) {
                $msgObj = Notification::findOrfail($notification->id);
                $msgObj->mark_read = 2;
                $msgObj->save();
            }
        $this->getNewNotifications();
        $res['success'] = 1;
        }else{
        $res['error'] = 1;
        }
		echo json_encode($res);
    }

    // public function changeMsgStatus(Request $request){
    //     $arr_ids = $request->ids;
    //     if($arr_ids){
    //     foreach ($arr_ids as $mkey => $messageid) {
    //             $msgObj = Groupchat::findOrfail($messageid);
    //             $msgObj->new_msg = 0;
    //             $msgObj->save();

    //             $msgObj_dir = Directchat::findOrfail($messageid);
    //             $msgObj_dir->new_msg = 0;
    //             $msgObj_dir->save();
    //         }
    //     }
    // }

    // public function groupPrevMessages($group_id,$last_start_date){
    //     $str_lst_date = strtotime("-2 day", $last_start_date);
        
    //     $startDate = strtotime(date('Y-m-d h:i:s',$str_lst_date));
    //     $endDate = strtotime(date('Y-m-d h:i:s',$last_start_date));
        
    //     $messages = Groupchat::where('group_id',$group_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','asc')->get();

    //     if(count($messages) > 0){
    //         $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();   

    //         $resutl_arr['html'] =  $html;
    //         $resutl_arr['last_start_date'] =  $messages[0]->created_at;
    //         $resutl_arr['success'] =  1;
    //     }else{
    //         $resutl_arr['html'] =  '<center><label class="alert alert-info">No Message Available</center></label>';
    //         $resutl_arr['success'] =  0;
    //     }

    //     echo json_encode($resutl_arr);
    // }

    public function groupPrevMessages($group_id,$last_id){
        // $str_lst_date = strtotime("-2 day", $last_start_date);
        
        // $startDate = strtotime(date('Y-m-d h:i:s',$str_lst_date));
        // $endDate = strtotime(date('Y-m-d h:i:s',$last_start_date));
        
     // $messages = Groupchat::where('group_id',$group_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','asc')->get();

        $messages = Groupchat::where('group_id',$group_id)->where('id','<',$last_id)->orderBy('created_at','desc')->limit(7)->get();


             $messages = $messages->reverse();


        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();

            $resutl_arr['html'] =  $html;
            $resutl_arr['last_id'] =  $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
        }else{
            $resutl_arr['html'] =  '<center class="no-msg"><label class="alert alert-info">No Message Available</center></label>';
            $resutl_arr['success'] =  0;
        }

        echo json_encode($resutl_arr);
    }

    public function fileRender($id,$page=1,Request $request){
        
        if($request->session()->has('client_id')){
        
        //$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$id)->get()->toArray()[0]['download_id'];
		$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$id)->get()->toArray();
		$download_info=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$id)->get()->toArray();
		if(isset($download_id[0]['download_id']))
		{
			$layer_toke=$download_id[0]['layer'];
		$download_id=$download_id[0]['download_id'];
		
        $myjobs = Session::get('jobs');
        $arr_myjobs = explode(',', $myjobs);

        $jobs = Job::where('job_id',$myjobs)->get();
      /*  print_r($jobs);
        die();*/
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            /*print_r($arr_group_ids);
            die();*/
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();

            //$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
          /*  foreach($groups as $gp)
            {
                $c1=$gp['client_id']
            }*/
            $grp=array();
            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
           /* echo "<pre>";
            print_r($grp);
            die();*/
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        $clients = [];
        if(count($arr_client_ids) > 0){
            $clients = Client::whereIn('client_id',$arr_client_ids)->get();
        }
        
        
        $my_notifications = $this->getNotifications();
        $file = File::where('file_id',$id)->first();
        if($file){
            $annot = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$id)->first();

            if($annot){
                $annotJson = $annot->annotation_data;
            }else{
                $annotJson = [];
            }

            $book = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$id)->first();

            if($book){
                $bookJson = $book->bookmarked_data;
            }else{
                $bookJson = [];
            } 
            
            $my_DFile = Download::where('download_client_id',Session::get('client_id'))->orderBy('download_date','desc')->get();

            $arr_Dfiles = [];
            $myFiles = '';
            if(count($my_DFile) > 0){
                foreach ($my_DFile as $key => $Dfile) {
                    $arr_Dfiles[] = $Dfile->download_file_id;
                }
            }
            $myFiles = File::whereIn('file_id',$arr_Dfiles)->orderBy('file_date_modified','desc')->get();
        }


        /** MyFIles For Ztree **/
        // $my_notifications = $this->getNotifications();
        //     $job_id = Session::get('jobs');
        //     $alljobs = explode(',', $job_id); 
            
        //     $jobs = Job::whereIn('job_id',$alljobs)->get();
        //     if($alljobs[0] && $whchjobs==false){
        //         $whchjobs = $alljobs[0];
        //     }

            /*get downloaded files here*/
            $arr_my_dfiles=[];
           $clientid = Session::has('client_id') ? Session::get('client_id') : '';
           $AllMyFiles = Download::where('download_client_id',$clientid)->get();
           $arr_my_dfiles[]=array();
           if($AllMyFiles){
               foreach ($AllMyFiles as $myfile){
                   $arr_my_dfiles[] = $myfile->download_file_id;
               }
           }

            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';

       $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
         if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
         }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
         if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
        }

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();        

            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $arr_nods_dd = [];
            $all_nods_dd = [];
            $all_add_to_links = [];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                	$ly_info1=Download::select('layer')->where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->get()->toArray();
					if(isset($ly_info1[0]['layer']))
						$l1=$ly_info1[0]['layer'];
					else 
						$l1='';
                
                	$contactclick = 'addContact('.$my_cloud->file_id.',"'.$my_cloud->file_name.'","'.$l1.'")';

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_dd["id"] = $my_cloud->file_id;
                    $arr_nods_dd["pId"] = $my_cloud->file_parent_id;
                    
                    $add_to_link["id"] = $my_cloud->file_id;
                    $add_to_link["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a id='compare_".$my_cloud->file_id."'  onclick='nodefiless(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_dd["name"] = "<a style=' height: 38px; width: 96%; ' onclick='addtocontactfolder(".$my_cloud->file_id.")' id='add_contact_".$my_cloud->file_id."' class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>"; 

                        $add_to_link["name"] = "<a style=' height: 38px; width: 96%; ' onclick='hyperlinkfolder(".$my_cloud->file_id.")' id='hyperlinkfolder_".$my_cloud->file_id."' class='add-contact nodefile' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='top:5px; margin-left: 75px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                    		
                        	
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck' data-file_id='".$my_cloud->file_id."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        $add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='nodefile add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        
                        	$arr_nods_dd["name"] = "<a onclick='".$contactclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                            
                        }else{
                        	$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck' data-file_id='".$my_cloud->file_id."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
							$add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='nodefile add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        	$arr_nods_dd["name"] = "<a onclick='".$targetclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        }	
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_dd["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_dd[] = $arr_nods_dd;
                    $all_add_to_links[] = $add_to_link;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_dd = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
        $this->arr_merge=[];
        $all_issue=$this->get_all_issue();
      /*  if($file->pspdf_file_id)
        {
          $all_annotation= $this->get_annotation($file->pspdf_file_id);
          if(isset($all_annotation['data']['annotations']))
          {
       
       			foreach($all_annotation['data']['annotations'] as $an)
                {
                	 $this->delete_annotation($file->pspdf_file_id,$an['id']);
                }
          }
       
        }*/
        $pdf_overlay_info = Pdf_file_overlay::where('user_id',Session::get('client_id'))->where('file_id',$id)->where('status','0')->get()->toArray();
          if($pdf_overlay_info)
          {
                foreach($pdf_overlay_info as $po)
                {
                    $pdf_resp = Pdf_file_overlay::where('id',$po['id'])->get()->first();    
                    if($pdf_resp)
                    {
                        $pdf_resp->delete();
                    }
                }
                
           } 
            
        	return view('clients.check',['download_id'=>$download_id,'client_id'=>Session::get('client_id'),'clients'=>$clients,'myFiles'=>$myFiles,'file'=>$file,'annotJson'=>$annotJson,'bookJson'=>$bookJson,'id'=>$id,'notifications'=>$my_notifications,'all_nods'=>$all_nods,'all_nods_dd' => $all_nods_dd,'page'=>$page,'all_issue'=>json_decode(json_encode(json_decode($all_issue)),true),'all_add_to_links'=>$all_add_to_links,'layer_token'=>$layer_toke,'download_info'=>$download_info,'page_status'=>'1']);
		  }
		  else 
		  {
			  
			  $my_notifications = $this->getNotifications();
			  return view('not_found',['notifications'=>$my_notifications,'page_status'=>'0']);
		  }
        }else{
            return redirect('/clients/login');
        }
    }

    public function getForRender($id){
        $result = [];
        $file = File::where('file_id',$id)->first();
        if($file){
            $result['file'] = $file;
            $annot = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$id)->first();

            if($annot){
                $result['annotJson'] = $annot->annotation_data;
            }else{
                $result['annotJson'] = [];
            }
            
            $book = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$id)->first();

            $arr_book_pages = [];

            if($book){
                $result['bookJson'] = $book->bookmarked_data;

                $bookmrks = json_decode($result['bookJson']);
                if($bookmrks){
                  foreach ($bookmrks as $key => $mrk) {
                    $arr_book_pages[] = $mrk->action->pageIndex;
                  }
                }
                $result['arr_book_pages'] = $arr_book_pages;
            }else{
                $result['bookJson'] = [];
                $result['arr_book_pages'] = [];
            } 
            
        }
        return json_encode($result);
    }

    public function compareFiles(Request $request){
        if($request->session()->has('client_id')){
        
            $my_notifications = $this->getNotifications();
            $this->validate($request, [
                'compare_first_file' => 'required',
                'compare_second_file' => 'required'
                ], [

                    'compare_first_file.required' => 'Please choose first comparing file',

                    'compare_second_file.required' => 'Please choose second comparing file'
            ]);
            $first_id = $request->compare_first_file;
            $second_id = $request->compare_second_file;
            $first_file_info=Download::where('download_file_id',$first_id)->where('download_client_id',Session::get('client_id'))->get()->toArray();
			$layer1=$first_file_info[0]['layer'];
			
			$second_file_info=Download::where('download_file_id',$second_id)->where('download_client_id',Session::get('client_id'))->get()->toArray();
			$layer2=$second_file_info[0]['layer'];
			
                $file_1 = File::where('file_id',$first_id)->first();
                if($file_1){
                    $annot_1 = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$first_id)->first();

                    if($annot_1){
                        $annotJson_1 = $annot_1->annotation_data;
                    }else{
                        $annotJson_1 = [];
                    }
                    
                    $book_1 = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$first_id)->first();

                    if($book_1){
                        $bookJson_1 = $book_1->bookmarked_data;
                    }else{
                        $bookJson_1 = [];
                    } 
                }

                $file_2 = File::where('file_id',$second_id)->first();
                if($file_2){
                    $annot_2 = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$second_id)->first();

                    if($annot_2){
                        $annotJson_2 = $annot_2->annotation_data;
                    }else{
                        $annotJson_2 = [];
                    }
                    
                    $book_2 = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$second_id)->first();

                    if($book_2){
                        $bookJson_2 = $book_2->bookmarked_data;
                    }else{
                        $bookJson_2 = [];
                    } 
                }
				
		    /*deependra*/
	     $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
         if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
         }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
         if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
        }

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();        

            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $arr_nods_dd = [];
            $all_nods_dd = [];
            $all_add_to_links = [];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
					$ly_info=Download::select('layer')->where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->get()->toArray();
					if(isset($ly_info[0]['layer']))
						$l1=$ly_info[0]['layer'];
					else 
						$l1='';
                	$contactclick = 'addContact('.$my_cloud->file_id.',"'.$my_cloud->file_name.'","'.$l1.'")';

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_dd["id"] = $my_cloud->file_id;
                    $arr_nods_dd["pId"] = $my_cloud->file_parent_id;
                    
                    $add_to_link["id"] = $my_cloud->file_id;
                    $add_to_link["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){   
                        $arr_nods["name"] = "<a id='check_node_".$my_cloud->file_id."' onclick='nodefiless(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_dd["name"] = "<a id='check_node1_".$my_cloud->file_id."' onclick='nodefiless1(".$my_cloud->file_id.")'  class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $add_to_link["name"] = "<a id='check_node2_".$my_cloud->file_id."' onclick='nodefiless2(".$my_cloud->file_id.")' class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='top:5px; margin-left: 75px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                    		
                        	$add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        	$arr_nods_dd["name"] = "<a onclick='".$contactclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                            
                        }else{
                        	$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        	$arr_nods_dd["name"] = "<a onclick='".$targetclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        }	
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_dd["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_dd[] = $arr_nods_dd;
                    $all_add_to_links[] = $add_to_link;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_dd = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
			/*deepndra*/
            return view('clients.compare',['layer1'=>$layer1,'layer2'=>$layer2,'client_id'=>Session::get('client_id'),'all_nods'=>$all_nods,'file_1'=>$file_1,'annotJson_1'=>$annotJson_1,'bookJson_1'=>$bookJson_1,'file_2'=>$file_2,'annotJson_2'=>$annotJson_2,'bookJson_2'=>$bookJson_2,'notifications'=>$my_notifications,'first_id'=>$first_id,'second_id'=>$second_id]);
        }else{
            return redirect('clients/login');
        }
    }

public function compareFilesFirst(Request $request){
        if($request->session()->has('client_id')){
        
            $my_notifications = $this->getNotifications();
            $this->validate($request, [
                'compare_first_file' => 'required',
                'compare_second_file' => 'required'
                ], [

                    'compare_first_file.required' => 'Please choose first comparing file',

                    'compare_second_file.required' => 'Please choose second comparing file'
            ]);
            $second_id = $request->compare_first_file;
            $first_id = $request->compare_second_file;

                $file_1 = File::where('file_id',$first_id)->first();
                if($file_1){
                    $annot_1 = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$first_id)->first();

                    if($annot_1){
                        $annotJson_1 = $annot_1->annotation_data;
                    }else{
                        $annotJson_1 = [];
                    }
                    
                    $book_1 = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$first_id)->first();

                    if($book_1){
                        $bookJson_1 = $book_1->bookmarked_data;
                    }else{
                        $bookJson_1 = [];
                    } 
                }

                $file_2 = File::where('file_id',$second_id)->first();
                if($file_2){
                    $annot_2 = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$second_id)->first();

                    if($annot_2){
                        $annotJson_2 = $annot_2->annotation_data;
                    }else{
                        $annotJson_2 = [];
                    }
                    
                    $book_2 = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$second_id)->first();

                    if($book_2){
                        $bookJson_2 = $book_2->bookmarked_data;
                    }else{
                        $bookJson_2 = [];
                    } 
                }
				
		    /*deependra*/
	     $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
         if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
         }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
     //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
         $my_clouds=[];
         $i=0;
         if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
        }

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();        

            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $arr_nods_dd = [];
            $all_nods_dd = [];
            $all_add_to_links = [];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
					$ly_info=Download::select('layer')->where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->get()->toArray();
					if(isset($ly_info[0]['layer']))
						$ly=$ly_info[0]['layer'];
					else 
						$ly='';
                	$contactclick = 'addContact('.$my_cloud->file_id.',"'.$my_cloud->file_name.'","'.$ly.'")';

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_dd["id"] = $my_cloud->file_id;
                    $arr_nods_dd["pId"] = $my_cloud->file_parent_id;
                    
                    $add_to_link["id"] = $my_cloud->file_id;
                    $add_to_link["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){  
                        $arr_nods["name"] = "<a id='check_node_".$my_cloud->file_id."' onclick='nodefiless(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_dd["name"] = "<a id='check_node1_".$my_cloud->file_id."' onclick='nodefiless1(".$my_cloud->file_id.")'  class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $add_to_link["name"] = "<a id='check_node2_".$my_cloud->file_id."' onclick='nodefiless2(".$my_cloud->file_id.")' class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='top:5px; margin-left: 75px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                    		
                        	$add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        	$arr_nods_dd["name"] = "<a onclick='".$contactclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                            
                        }else{
                        	$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        	$arr_nods_dd["name"] = "<a onclick='".$targetclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        }	
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_dd["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_dd[] = $arr_nods_dd;
                    $all_add_to_links[] = $add_to_link;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_dd = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
			/*deepndra*/
            return view('clients.compare',['client_id'=>Session::get('client_id'),'all_nods'=>$all_nods,'file_1'=>$file_1,'annotJson_1'=>$annotJson_1,'bookJson_1'=>$bookJson_1,'file_2'=>$file_2,'annotJson_2'=>$annotJson_2,'bookJson_2'=>$bookJson_2,'notifications'=>$my_notifications,'first_id'=>$first_id,'second_id'=>$second_id]);
        }else{
            return redirect('clients/login');
        }
    }

    public function getTags($fileid){
        $tags = Tag::where('client_id',Session::get('client_id'))->orderBy('created_at','desc')->get();

        $html = view('clients.render.tags', ['tags'=>$tags])->render();
        echo $html;
    }

    public function addTag(Request $request){
        $tagObj = new Tag();
        $tagObj->title = $request->title;
        $tagObj->client_id = Session::get('client_id');
        // $tagObj->file_id = $request->fileid;
        $tagObj->color_tag = $request->color_tag;
        $tagObj->created_at = strtotime(Carbon::now());
        $tagObj->save();
        echo true;
    }

    public function deleteTag($tagid){
        $tag = Tag::findOrfail($tagid);
        if ($tag != null) {
            $del = $tag->delete();

            if($del){
                $tagstatus = Tagstatus::where('tag_id',$tagid)->get();
                if(count($tagstatus) > 0){
                    foreach ($tagstatus as $key => $tagvalue) {
                        $tagvalue->delete();
                    }
                }
            }

            echo true;
        }else{
            echo false;
        }
    }

    public function changeTag($tagid,$fileid){
        $checked_tags = Tagstatus::where('file_id',$fileid)->where('client_id',Session::get('client_id'))->first();

        if($checked_tags){
            $checked_tags->tag_id = $tagid;
            $checked_tags->update();
        }else{
            $tagstatObj = new Tagstatus();
            $tagstatObj->tag_id = $tagid;
            $tagstatObj->file_id = $fileid;
            $tagstatObj->client_id = Session::get('client_id');
            $tagstatObj->save();
        }

        $tagmainObj = Tag::where('id',$tagid)->first();
        
        if($tagmainObj){
            $res_arr['success'] = 1;
            $res_arr['tag'] = $tagmainObj;
        }else{
            $res_arr['success'] = 0;
        }
        echo json_encode($res_arr);
    }

    public function getActiveTag($fileid){ 
        $tag = '';
        $tagstatus = Tagstatus::where('file_id',$fileid)->where('client_id',Session::get('client_id'))->first();
        if($tagstatus){
            $tag = Tag::findOrfail($tagstatus->tag_id);
        }
        if($tag){
            $res_arr['success'] = 1;
            $res_arr['tag'] = $tag;
        }else{
            $res_arr['success'] = 0;
        }
        echo json_encode($res_arr);
    }

    public function allnotifications(Request $request,$whchjobs=false){
        $my_notifications = $this->getNotifications();
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    	
    		$active_job = Job::find(Session::get('job_id'));

        //$allnotifications = Notification::where('client_id',Session::get('client_id'))->orderBy('created_at','desc')->get();
        $startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
    	//$allnotifications = DB::select('select * from `notifications` WHERE created_at >= '.$startDate.' AND created_at <= '.$endDate.' is_annotation=0 OR is_annotation=1 And `client_id` = '.Session::get('client_id').' and FIND_IN_SET('.$whchjobs.',`job_id`) order by `created_at` DESC');   
        $allnotifications = Notification::where('client_id',Session::get('client_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('job_id',Session::get('job_id'))->where(function($q1){
             $q1->where('is_annotation','0')->Orwhere('is_annotation','1');
            })->orderBy('created_at','desc')->get();
        return view('clients.notifications',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'allnotifications'=>$allnotifications]);
    }
	public function message_notofication(Request $request,$whchjobs=false)
	{
        $startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
		$my_notifications = $this->getNotifications();
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    	
    		$active_job = Job::find(Session::get('job_id'));
        $allnotifications = Notification::where('client_id',Session::get('client_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('job_id',Session::get('job_id'))->where(function($q1){
			 $q1->where('is_annotation','2')->Orwhere('is_annotation','3');
		 })->orderBy('created_at','desc')->get();
		 
	//	$allnotifications = DB::select('select * from `notifications` WHERE is_annotation=2 OR is_annotation=3 And `client_id` = '.Session::get('client_id').' and FIND_IN_SET('.$whchjobs.',`job_id`) order by `created_at` DESC');   
		
		
		/*echo "<pre>";
		print_r($allnotifications);*/

        return view('clients.notifications',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'allnotifications'=>$allnotifications]);
	}
    public function read_message_notification(Request $request,$whchjobs=false)
    {
           $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
            if($whchjobs){
                $request->session()->put('job_id',$whchjobs);
            }
            $whchjobs = Session::get('job_id');
        
            $active_job = Job::find(Session::get('job_id'));
        $allnotifications = Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where(function($q1){
             $q1->where('is_annotation','2')->Orwhere('is_annotation','3');
         })->orderBy('created_at','desc')->get();   
        foreach($allnotifications as $noti)
        {
            $n=Notification::where('id',$noti->id)->get()->first();
            $n->mark_read=2;
            $n->update();
        }
        return redirect(url('clients/message_notification/'.$whchjobs));
    }

    public function render_notification(Request $request)
    {
        $startDate = strtotime($request->startDate." 00:00:00");
        $endDate = strtotime($request->endDate." 23:59:59");
        if($request->access==1)
        {
            $allnotifications = Notification::where('client_id',Session::get('client_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('job_id',Session::get('job_id'))->where(function($q1){
             $q1->where('is_annotation','0')->Orwhere('is_annotation','1');
            })->orderBy('created_at','desc')->get();
        }
        else 
        {
            $allnotifications = Notification::where('client_id',Session::get('client_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('job_id',Session::get('job_id'))->where(function($q1){
             $q1->where('is_annotation','2')->Orwhere('is_annotation','3');
            })->orderBy('created_at','desc')->get();
        }
        $result = view('clients.render.renderNotification',['allnotifications'=>$allnotifications])->render();
        if(sizeof($allnotifications)>0)
        {
            $arr=array('status'=>'1','data'=>$result);
        }
        else 
        {
            $arr=array('status'=>'0','data'=>$result);
        }
        echo json_encode($arr);
    }
    public function renderQuick(Request $request,$job,$type)
	{
		if($type=='shared')
			$type_index=4;
		else if($type=='opened')
			$type_index=1;
		else if($type=='annoted')
			$type_index=2;
		else if($type=='commented')
			$type_index=3;
		
		/*echo 'Job :'.$job;
		echo "<br>";
		echo 'Type :'.$type;
		echo "<br>";
		echo 'Type :'.$type_index;
		print_r($_POST);*/
		$startDate = strtotime($request->startDate." 00:00:00");
        $endDate = strtotime($request->endDate." 23:59:59");
		$quicks = QuickAccess::where('type',$type_index)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','desc')->get();
		
		$result = view('clients.render.renderQuick',['quicks'=>$quicks,'type'=>$type])->render();
		if(sizeof($quicks)>0)
		{
			$arr=array('status'=>'1','data'=>$result);
		}
		else 
		{
			$arr=array('status'=>'0','data'=>$result);
		}
		echo json_encode($arr);
	}
    public function recentOpened($id){

        $file = File::where('file_id',$id)->first();
        $isexist = QuickAccess::where('file_id',$id)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type',1)->first();

        if($isexist){
            $quickObj = $isexist;
        }else{
            $quickObj = new QuickAccess();
        }
        
        $quickObj->file_id = $id;
        $quickObj->client_id = Session::get('client_id');
    	$quickObj->job_id = Session::get('job_id');
        $quickObj->file_name = $file->file_name;
        $quickObj->type = 1;
        $quickObj->created_at = strtotime(Carbon::now());
        $quickObj->updated_at = strtotime(Carbon::now());
        $quickObj->save();

        echo json_encode(['result'=>'true']);
    }

    public function getRecentOpened(Request $request,$whchjobs=false,$type="opened"){
        $my_notifications = $this->getNotifications();
        $title="Recent Opened files";
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
    	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    	$active_job = Job::find($whchjobs);
            
  
		$startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
		
		
        $quicks = QuickAccess::where('type',1)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
		
        return view('clients.quick',['whchjobs'=>$whchjobs,'active_job'=>$active_job,'jobs'=>$jobs,'quicks'=>$quicks,'notifications'=>$my_notifications,'title'=>$title,'type'=>$type]);
    }

    public function recentAnnoted($id){

        $file = File::where('file_id',$id)->first();
        $isexist = QuickAccess::where('file_id',$id)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type',2)->first();

        if($isexist){
            $quickObj = $isexist;
        }else{
            $quickObj = new QuickAccess();
        }
        
        $quickObj->file_id = $id;
        $quickObj->client_id = Session::get('client_id');
    	$quickObj->job_id = Session::get('job_id');
        $quickObj->file_name = $file->file_name;
        $quickObj->type = 2;
        $quickObj->created_at = strtotime(Carbon::now());
        $quickObj->updated_at = strtotime(Carbon::now());
        $quickObj->save();

        echo true;
    }

    public function getRecentAnnoted(Request $request,$whchjobs=false,$type="annoted"){
        $my_notifications = $this->getNotifications();
        $title="Recent Annotated files";
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
    	    
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    	$active_job = Job::find($whchjobs);
    	$startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
        $quicks = QuickAccess::where('type',2)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();

        return view('clients.quick',['whchjobs'=>$whchjobs,'active_job'=>$active_job,'jobs'=>$jobs,'quicks'=>$quicks,'notifications'=>$my_notifications,'title'=>$title,'type'=>$type]);
    }

    public function recentShared($id,$rec_id){

        $file = File::where('file_id',$id)->first();
        $reciepient = Client::where('client_id',$rec_id)->first();

        $isexist = QuickAccess::where('file_id',$id)->where('client_id',Session::get('client_id'))->where('reciepient_id',$rec_id)->where('job_id',Session::get('job_id'))->where('type',4)->first();

        if($isexist){
            $quickObj = $isexist;
        }else{
            $quickObj = new QuickAccess();
        }
        
        $quickObj->file_id = $id;
        $quickObj->client_id = Session::get('client_id');
    	$quickObj->job_id = Session::get('job_id');
        $quickObj->file_name = $file->file_name;
        $quickObj->type = 4;
        $quickObj->reciepient_id = $reciepient->client_id;
        $quickObj->reciepient = "Shared with ".$reciepient->client_display_name;
        $quickObj->created_at = strtotime(Carbon::now());
        $quickObj->updated_at = strtotime(Carbon::now());
        $quickObj->save();

        echo true;
    }

    public function getRecentShared(Request $request,$whchjobs=false,$type="shared"){
        $my_notifications = $this->getNotifications();
        $title="Recent Shared files";
    
    	$job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
    	
    	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    	
    	$active_job = Job::find($whchjobs);
		$startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
		
        $quicks = QuickAccess::where('type',4)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();

        return view('clients.quick',['whchjobs'=>$whchjobs,'active_job'=>$active_job,'jobs'=>$jobs,'quicks'=>$quicks,'notifications'=>$my_notifications,'title'=>$title,'type'=>$type]);
    }
 
    public function recentCommented($id){

        $file = File::where('file_id',$id)->first();
        $isexist = QuickAccess::where('file_id',$id)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type',3)->first();
        if($isexist){
            $quickObj = $isexist;
        }else{
            $quickObj = new QuickAccess();
        }
        
        $quickObj->file_id = $id;
        $quickObj->client_id = Session::get('client_id');
    	$quickObj->job_id = Session::get('job_id');
        $quickObj->file_name = $file->file_name;
        $quickObj->type = 3;
        $quickObj->created_at = strtotime(Carbon::now());
        $quickObj->updated_at = strtotime(Carbon::now());
        $quickObj->save();

        echo true;
    }

    public function getRecentCommented(Request $request,$whchjobs=false,$type="commented"){
        $my_notifications = $this->getNotifications();
        $title="Recent Commented files";
        $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
    		
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    		$active_job = Job::find($whchjobs);
            

       // $quicks = QuickAccess::where('type',3)->where('client_id',Session::get('client_id'))->orderBy('created_at','desc')->get();
	   
	   $startDate = strtotime(date('m/d/Y')." 00:00:00");
        $endDate = strtotime(date('m/d/Y')." 23:59:59");
		
	    /*$quicks = SelectedTextComment::select(['id','comment','file_name','created_at','file_id'])->where('user_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();*/
		
		$quicks = QuickAccess::where('type',3)->where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
		
		$quicks=$quicks->reverse();
    	
		return view('clients.quick',['whchjobs'=>$whchjobs,'active_job'=>$active_job,'jobs'=>$jobs,'quicks'=>$quicks,'notifications'=>$my_notifications,'title'=>$title,'type'=>$type]);
    }

    public function vueRender(){
        return view('welcome');
    }

    public function inbox(Request $request,$whchjobs=false,$selected_grp_id=false){
       
        $sess_client_id = Session::get('client_id');
		
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);
        
    	$job_id = Session::get('jobs');

            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    		$active_job = Job::find(Session::get('job_id'));

            $groups = '';
            $members = '';
            $selected_grp = '';
            $member_names = [];
            $arr_client = '';
            $this_job = Job::findOrfail($whchjobs);
			/*echo "<pre>";
			print_r($this_job);
			die();*/
            if($this_job){
                
                $this_job_groups = $this_job->group_id;

                $arr_grps = explode(',', $this_job_groups);
                
                
				// 
                /*$groups = Group::whereIn('group_id',$arr_grps)->where(function($q){
					$q->whereIn('client_id',array(Session::get('client_id'));
				})->get();*/
				$query="select *from groups where group_id In (".$this_job_groups.") AND FIND_IN_SET(".Session::get('client_id').",`client_id`)";
				$groups=DB::select($query);

                

            }
        $all_users = DB::select('select * from `clients` where FIND_IN_SET('.$whchjobs.',`jobs`) order by `client_display_name` DESC');
      	if(isset($groups[0]) && $selected_grp_id==false){
			$selected_grp_id = $groups[0]->group_id;
		}
		if($selected_grp_id){
		   /// $selected_grp = Group::where('group_id',$selected_grp_id)->first();  
		   $query1="select * from groups where group_id = ".$selected_grp_id;
			$selected_grp=DB::select($query1);
		}
		if(isset($selected_grp[0]))
			$selected_grp=$selected_grp[0];
		
		if($selected_grp){
			$arr_client = explode(",", $selected_grp->client_id);
			// $members = DB::select('select * from `clients` where FIND_IN_SET('.$selected_grp->client_id.',`client_id`) order by `client_display_name` ASC');
			$members = Client::whereIn('client_id',$arr_client)->get();
			if(count($members) > 0){
				foreach ($members as $memkey => $member) {
					$member_names[] = ucfirst($member->client_display_name);
				}
			}
		}  
        $messages = Groupchat::where('group_id',$selected_grp_id)->orderBy('created_at','desc')->limit(7)->get();
        $messages = $messages->reverse();
        foreach($messages as $m1)
		{
			$msgObj = Groupchat::findOrfail($m1->id);
			$msgObj->new_msg = 0;
			$msgObj->save();
		}
        $count = Groupchat::where('group_id',$selected_grp_id)->get();
        $msg_count = count($count);

   
        $members_str = '"' . implode ( '", "', $member_names ) . '"';
        $my_notifications = $this->getNotifications();
    	
		
		
		$notifications = Notification::where('file_id',$selected_grp_id)->where('job_id',Session::get('job_id'))->where('client_id',Session::get('client_id'))->where('type',1)->where('mark_read',1)->get(); 
		
        foreach ($notifications as $nkey => $notification) {
                $msgObj = Notification::findOrfail($notification->id);
                $msgObj->mark_read = 2;
                $msgObj->save();
            }
	
			
        return view('clients.chat.inbox',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'members_str'=>$members_str,'selected_grp'=>$selected_grp,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages,'msg_count'=>$msg_count,'authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
    }
	public function groups_single(Request $request,$whchjobs=false,$selected_grp_id=false)
	{
		 $sess_client_id = Session::get('client_id');
		
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);
        
    	$job_id = Session::get('jobs');

            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');
    
    		$active_job = Job::find(Session::get('job_id'));

            $groups = '';
            $members = '';
            $selected_grp = '';
            $member_names = [];
            $arr_client = '';
            $this_job = Job::findOrfail($whchjobs);
			/*echo "<pre>";
			print_r($this_job);
			die();*/
            if($this_job){
                
                $this_job_groups = $this_job->group_id;

                $arr_grps = explode(',', $this_job_groups);
                
                
				// 
                /*$groups = Group::whereIn('group_id',$arr_grps)->where(function($q){
					$q->whereIn('client_id',array(Session::get('client_id'));
				})->get();*/
				$query="select *from groups where group_id In (".$this_job_groups.") AND FIND_IN_SET(".Session::get('client_id').",`client_id`)";
				$groups=DB::select($query);

                

            }
        $all_users = DB::select('select * from `clients` where FIND_IN_SET('.$whchjobs.',`jobs`) order by `client_display_name` DESC');
      	if(isset($groups[0]) && $selected_grp_id==false){
			$selected_grp_id = $groups[0]->group_id;
		}
		if($selected_grp_id){
		   /// $selected_grp = Group::where('group_id',$selected_grp_id)->first();  
		   $query1="select * from groups where group_id = ".$selected_grp_id;
			$selected_grp=DB::select($query1);
		}
		if(isset($selected_grp[0]))
			$selected_grp=$selected_grp[0];
		
		if($selected_grp){
			$arr_client = explode(",", $selected_grp->client_id);
			// $members = DB::select('select * from `clients` where FIND_IN_SET('.$selected_grp->client_id.',`client_id`) order by `client_display_name` ASC');
			$members = Client::whereIn('client_id',$arr_client)->get();
			if(count($members) > 0){
				foreach ($members as $memkey => $member) {
					$member_names[] = ucfirst($member->client_display_name);
				}
			}
		}  
        $messages = Groupchat::where('group_id',$selected_grp_id)->orderBy('created_at','desc')->limit(7)->get();
        $messages = $messages->reverse();
        foreach($messages as $m1)
		{
			$msgObj = Groupchat::findOrfail($m1->id);
			$msgObj->new_msg = 0;
			$msgObj->save();
		}
        $count = Groupchat::where('group_id',$selected_grp_id)->get();
        $msg_count = count($count);

   
        $members_str = '"' . implode ( '", "', $member_names ) . '"';
        $my_notifications = $this->getNotifications();
    	
		
		
		$notifications = Notification::where('file_id',$selected_grp_id)->where('job_id',Session::get('job_id'))->where('client_id',Session::get('client_id'))->where('type',1)->where('mark_read',1)->get(); 
		
        foreach ($notifications as $nkey => $notification) {
                $msgObj = Notification::findOrfail($notification->id);
                $msgObj->mark_read = 2;
                $msgObj->save();
            }
	
			
        return view('clients.chat.groups_single',['active_job'=>$active_job,'jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'members_str'=>$members_str,'selected_grp'=>$selected_grp,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages,'msg_count'=>$msg_count,'authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
	}

    /*deependra*/
	function export_group_chat($group_id)
	{
		
		$group_name=Group::where('group_id',$group_id)->get()->toArray();
		$messages = Groupchat::select(['group_chat.message','group_chat.msg_type','group_chat.created_at','clients.username'])->where('group_id',$group_id)->where('new_msg',0)->join('clients','group_chat.sender_id','=','clients.client_id')->orderBy('created_at','desc')->get()->toArray();
		$export_arr=array(array('date'=>'Date','sender'=>'Sender','message'=>'Message'));
		$i=1;
		foreach($messages as $msg)
		{
			if($msg['msg_type']=='msg')
			{
				$export_arr[$i]['date']= date('d,M Y, H:i A',$msg['created_at']);
				$export_arr[$i]['sender']=$msg['username'];
				$export_arr[$i]['message']=str_replace('#','',str_replace('@','',str_replace('&nbsp;',' ',strip_tags($msg['message']))));
				$i++;
			}
		}
		
       $fp = fopen('php://output', 'w');
		$filename = $group_name[0]['group_name']."_groupChat.csv"; // File Name
		foreach($export_arr as $result) {
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			fputcsv($fp, $result);
		}
	}
	function export_topic_chat($topic_id)
	{
		
		$group_name=Topic::where('topic_id',$topic_id)->get()->toArray();
		$messages = TopicChat::select(['topic_chat.message','topic_chat.msg_type','topic_chat.created_at','clients.username'])->where('topic_id', $topic_id)->join('clients','topic_chat.sender_id','=','clients.client_id')->orderBy('created_at', 'desc')->get();
		$export_arr=array(array('date'=>'Date','sender'=>'Sender','message'=>'Message'));
		$i=1;
		foreach($messages as $msg)
		{
			if($msg['msg_type']=='msg')
			{
				$export_arr[$i]['date']= date("d,M Y, H:i A", strtotime($msg['created_at']));
				$export_arr[$i]['sender']=$msg['username'];
				$export_arr[$i]['message']=str_replace('#','',str_replace('@','',str_replace('&nbsp;',' ',strip_tags($msg['message']))));
				$i++;
			}
		}
        $fp = fopen('php://output', 'w');
		$filename = $group_name[0]['topic_name']."_topicChat.csv"; // File Name
		foreach($export_arr as $result) {
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			fputcsv($fp, $result);
		}
	}
	function export_direct_chat($id)
	{
			$client_name=Client::where('client_id',$id)->get()->toArray();
			$senderid = $id;
			$receiverid = Session::get('client_id');
            
            $messages = Directchat::Where(function($query) use ($senderid, $receiverid)
			{
				$query->where("sender_id",$senderid)
					  ->where("recipient_id",$receiverid)
					  ->where('new_msg',0);
			})
				->orWhere(function($query) use ($senderid, $receiverid)
			{
				$query->Where("sender_id",$receiverid)
					  ->Where("recipient_id",$senderid);
			})->orderBy('created_at','desc')->get()->toArray();
			$export_arr=array(array('date'=>'Date','sender'=>'Sender','message'=>'Message'));
			$i=1;
			
			foreach($messages as $msg)
			{
				if($msg['msg_type']=='msg')
				{
					$export_arr[$i]['date']= date("d,M Y, H:i A", strtotime($msg['created_at']));
					$export_arr[$i]['sender']=$msg['sender_name'];
					$export_arr[$i]['message']=str_replace('#','',str_replace('@','',str_replace('&nbsp;',' ',strip_tags($msg['message']))));
					$i++;
				}
			}
			$fp = fopen('php://output', 'w');
			$filename = $client_name[0]['username']."_oneToOneChat.csv"; // File Name
			foreach($export_arr as $result) {
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename='.$filename);
				fputcsv($fp, $result);
			}
		
	}
    public function send_msg_direct_file(Request $request)
    {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $msg_type="file";
        if($ext=='JPG' || $ext=='PNG' || $ext=='JPEG' || $ext=='png' || $ext=='jpg' || $ext=='jpeg')
        {
            $file_type='image';
        }
        else 
        {
            $file_type='other';
        }
       /* echo "<pre>";
        print_r($_FILES);
        echo "</pre>";*/

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        
   
          //Display File Name
         $file_name = $file->getClientOriginalName();
         $path = $file->getRealPath();
         $file_size = $file->getSize();
         $destinationPath = public_path('storage/app/');
         $file->move($destinationPath,$file->getClientOriginalName());

         $message = $file->getClientOriginalName();
         $fileType = $file_type;
         $content = $file->getClientOriginalName();
         $recipient_id = $request->user_id;
         $msgType = $msg_type;
         $sender_id = Session::get('client_id');
         $job = $request->job;

        $sender_detail = Client::where('client_id',$sender_id)->first(); 
        $sender_name = $sender_detail->client_display_name;

        $directchatObj = new Directchat();
        $directchatObj->message = $message;
        $directchatObj->msg_type  = $msgType;
        $directchatObj->file_type  = $fileType;
        $directchatObj->recipient_id = $recipient_id;
        $directchatObj->sender_id = $sender_id;
        $directchatObj->sender_name = $sender_name;
        $directchatObj->created_at = strtotime(Carbon::now());
        $save = $directchatObj->save();
        if($save){
            $message=strip_tags($message);
            $notif_title = ucfirst(Session::get('client_display_name'))." send message to you";
            $notif_message = strlen($message) > 10  ? substr($message, 0, 7) . '...' : $message;    

            /** Send Notifications **/
                $notification = new Notification();
                $notification->title = $notif_title;
                $notification->message =trim(strip_tags($notif_message));
                $notification->job_id = $job;
                $notification->sender = Session::get('client_id');
                $notification->client_id = $recipient_id;
                $notification->is_annotation = 3;
                $notification->mark_read = 1;
                $notification->file_id =$request->user_id;
                $notification->type = 3;
                $notification->created_at = strtotime(Carbon::now());
                $notification->updated_at = strtotime(Carbon::now());
                $notification->save();

            $result = true;
        }else{
            $result = false;
        }
        echo $result;
 
    }
	/*deependra*/
    public function sendMsgDirect(Request $request){
        
        $message = $request->message;
        $fileType = $request->fileType;
        $content = $request->content;
        $recipient_id = $request->user_id;
        $msgType = $request->msg_type;
        $sender_id = Session::get('client_id');
        $job = $request->job;

        if($fileType == 'image'){
            $image = str_replace('data:image,', '', $content);
            $image = str_replace('data:image,', '', $image);
            $image = str_replace(' ', '+', $image);
            Storage::disk('local')->put($message, file_get_contents($image));
        }
        else{
            Storage::disk('local')->put($message, $content);
        }

        // $group = Directchat::where('group_id',$group_id)->first();
        // $all_group_members_str = $group->client_id;
        // $all_group_members_arr = explode(",", $all_group_members_str);
        // $arr_sender[] = $sender_id;
        // //removing sender in all group members for preparing reciepient
        // $reciepient_ids_arr = array_diff($all_group_members_arr, $arr_sender);
        // $reciepient_ids_str = implode(",", $reciepient_ids_arr);
        $sender_detail = Client::where('client_id',$sender_id)->first(); 
        $sender_name = $sender_detail->client_display_name;
        
        $directchatObj = new Directchat();
        $directchatObj->message = $message;
        $directchatObj->msg_type  = $msgType;
        $directchatObj->file_type  = $fileType;
        $directchatObj->recipient_id = $recipient_id;
        $directchatObj->sender_id = $sender_id;
        $directchatObj->sender_name = $sender_name;
        $directchatObj->created_at = strtotime(Carbon::now());
        $save = $directchatObj->save();
        if($save){
           // $message=strip_tags($message);
            $notif_title = ucfirst(Session::get('client_display_name'))." send message to you";
           // $notif_message = strlen($message) > 10  ? substr($message, 0, 7) . '...' : $message;    

            /** Send Notifications **/
                $notification = new Notification();
                $notification->title = $notif_title;
                $notification->message = $message;
                $notification->job_id = $job;
                $notification->sender = Session::get('client_id');
                $notification->client_id = $recipient_id;
                $notification->is_annotation = 3;
                $notification->mark_read = 1;
				$notification->file_id =$request->user_id;
				$notification->type = 3;
                $notification->created_at = strtotime(Carbon::now());
                $notification->updated_at = strtotime(Carbon::now());
                $notification->save();

            $result = true;
        }else{
            $result = false;
        }
        echo $result;
    }

    public function getDirectMessages($client_id,$last_msg){
        // $startDate = strtotime(date('Y-m-d')." 00:00:00");
        // $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
        // $endDate = strtotime(date('Y-m-d')." 23:59:59");
        
        $messages = Directchat::where('recipient_id',Session::get('client_id'))->where('new_msg',1)->where('sender_id',$client_id)->get();
        
        $other_messages = Directchat::where('recipient_id',Session::get('client_id'))->where('new_msg',1)->where('sender_id','!=',$client_id)->get();
        
        $resutl_arr = [];
        $arr_msg_count = [];
        $arr_sender_ids = [];
        if(count($other_messages) > 0){
            foreach ($other_messages as $othrkey => $other_message) {
                if(!in_array($other_message->sender_id, $arr_sender_ids)){
                    $count_sender_msgs = Directchat::where('recipient_id',Session::get('client_id'))->where('sender_id',$other_message->sender_id)->where('new_msg',1)->count();

                    $arr_msg_count[$other_message->sender_id] = $count_sender_msgs;
                    $arr_sender_ids[] = $other_message->sender_id;
                }
            }
        $resutl_arr['msg_counter'] = $arr_msg_count;
        }

        // echo "<pre>";
        // print_r($arr_msg_count);
        // die;

        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();   

            // $resutl_arr['count_msgs'] =  count($messages);
            $msgIds = array();
            
            foreach ($messages as $mkey => $message) {
                $msgIds[] = $message->id;
            }
             $resutl_arr['html'] =  $html;
            $resutl_arr['here_append'] =  $last_msg;
            $resutl_arr['last_msg_id'] =  $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
            $resutl_arr['ids'] = $msgIds;


        }else{
            $resutl_arr['html'] =  '';
            $resutl_arr['success'] =  0;
        }

        echo json_encode($resutl_arr);
    }    

    public function changeDirectMsgStatus(Request $request){
        $arr_ids = $request->ids;
        $selected_user = $request->sel_user_id;
        if($arr_ids){
        foreach ($arr_ids as $mkey => $messageid) {
                $msgObj = Directchat::findOrfail($messageid);
                $msgObj->new_msg = 0;
                $msgObj->save();
            }
        }

    }

    public function changeDirectNotifStatus(Request $request){
        $notifications = Notification::where('client_id',Session::get('client_id'))->where('sender',$request->sel_user_id)->where('type',3)->where('mark_read',1)->get();
        foreach ($notifications as $nkey => $notification) {
                $msgObj = Notification::findOrfail($notification->id);
                $msgObj->mark_read = 2;
                $msgObj->save();
            }
       // Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('sender',$request->selected_user)->where('type','3')->update(array('mark_read'=>'2'));
        $this->getNewNotifications();
        echo true;
    }

    public function directPrevMessages($client_id,$last_id){
        // $str_lst_date = strtotime("-2 day", $last_start_date);
        
        // $startDate = strtotime(date('Y-m-d h:i:s',$str_lst_date));
        // $endDate = strtotime(date('Y-m-d h:i:s',$last_start_date));
        
        // $messages = Groupchat::where('client_id',$client_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','asc')->get();

        $senderid = $client_id;
        $receiverid = Session::get('client_id');
            
            $messages = Directchat::where(function($query) use($receiverid,$senderid){
                    $query->where('recipient_id', $receiverid)
                    ->orWhere('recipient_id', $senderid);
                    })
                    ->where(function($query) use($receiverid,$senderid){
                        $query->where('sender_id', $receiverid)
                        ->orWhere('sender_id', $senderid);
                    })
                    ->where('id','<',$last_id)
                    ->orderBy('created_at','desc')->limit(7)->get();

            // echo count($messages);   

            $messages = $messages->reverse();

        // // echo $messages[count($messages)-1]->id;

        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();

            $resutl_arr['html'] =  $html;
            $resutl_arr['last_id'] = $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
        }else{
            $resutl_arr['html'] =  '<center class="no-msg"><label class="alert alert-info">No Message Available</center></label>';
            $resutl_arr['success'] =  0;
        }
        echo json_encode($resutl_arr);
    }

    public function printing(Request $request){
        $res = [];
        $arr_fileid = $request->arr_fileid;
        if($arr_fileid){
            // Create an instance of PDFMerger
            // $pdf = new PDFMerger();

            //get all files
            $files = File::whereIn('file_id',$arr_fileid)->get();

            $arr_FilePath = [];
            if(count($files) > 0){
                foreach ($files as $filekey => $file) {
                    if($file->file_type == 2){
                        $arr_FilePath[] = public_path('storage/files/').$file->file_upload_name;
                    }
                    // Add 2 PDFs to the final PDF
                    // $pdf->addPDF($FilePath, 'all');
                }
                // Merge the files into a file in some directory
                // $pathForTheMergedPdf = public_path() . "/storage/mergeall/a4.pdf";
                $pdf_files = implode(" ",$arr_FilePath);
                $output_file = public_path('storage/mergeall/merge.pdf');

                shell_exec("gs -dNOPAUSE -sDEVICE=pdfwrite -sOUTPUTFILE=$output_file -dBATCH $pdf_files");
                
                // Merge PDFs into a file
                // $pdf->merge('file', $pathForTheMergedPdf);
                $res['success'] = 1;
                $res['output'] = $output_file;
            }else{
                $res['error'] = 1;
            }
        }
        echo json_encode($res);
    }

    /** Topics Methods **/

    public function topicMessages($group_id,$last_msg){
    
        // $startDate = strtotime(date('Y-m-d')." 00:00:00");
        // $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
        // $endDate = strtotime(date('Y-m-d')." 23:59:59");

        $messages = TopicChat::where('topic_id',$group_id)->where('new_msg',1)->where('sender_id','!=',Session::get('client_id'))->get();
      // TopicChat::where(array('new_msg'=>'1'))->update(array('new_msg'=>'0'));
        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();

            // $resutl_arr['count_msgs'] =  count($messages);
            $msgIds = array();

            foreach ($messages as $mkey => $message) {
                $msgIds[] = $message->id;
            }
            $resutl_arr['html'] =  $html;
            $resutl_arr['here_append'] =  $last_msg;
            $resutl_arr['last_msg_id'] =  $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
            $resutl_arr['ids'] = $msgIds ;


        }else{
            $resutl_arr['html'] =  '';
            $resutl_arr['success'] =  0;
        }

        echo json_encode($resutl_arr);
    }

    public function changeMsgStatus_topic(Request $request)
    {
        $arr_ids = $request->ids;
        if($arr_ids){
            foreach ($arr_ids as $mkey => $messageid) {
                $msgObj = TopicChat::findOrfail($messageid);
                $msgObj->new_msg = 0;
                $msgObj->save();
            }
        }
    }

    public function tokenPrevMessages($group_id,$last_id){
        // $str_lst_date = strtotime("-2 day", $last_start_date);

        // $startDate = strtotime(date('Y-m-d h:i:s',$str_lst_date));
        // $endDate = strtotime(date('Y-m-d h:i:s',$last_start_date));

        // $messages = Groupchat::where('group_id',$group_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','asc')->get();

        $messages = TopicChat::where('topic_id',$group_id)->where('id','<',$last_id)->orderBy('created_at','desc')->limit(7)->get();

        $messages = $messages->reverse();


        if(count($messages) > 0){
            $html = view('clients.chat.single_chat', ['messages'=>$messages,'from'=>'1'])->render();

            $resutl_arr['html'] =  $html;
            $resutl_arr['last_id'] =  $messages[count($messages)-1]->id;
            $resutl_arr['success'] =  1;
        }else{
            $resutl_arr['html'] =  '<center><label class="alert alert-info no_message_fount">No Message Available</center></label>';
            $resutl_arr['success'] =  0;
        }

        echo json_encode($resutl_arr);
    }

    public function topics(Request $request,$whchjobs=false,$selected_grp_id=false){

        
        $sess_client_id = Session::get('client_id');
    
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);

        $job_id = Session::get('jobs');

        $alljobs = explode(',', $job_id);
        $jobs = Job::whereIn('job_id',$alljobs)->get();

        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
    
            $whchjobs = Session::get('job_id');
    
    		$active_job = Job::find(Session::get('job_id'));
    
         //  $topics = Topic::whereRaw('client_id',array($sess_client_id))->get()->toArray();
        $topics = Topic::whereRaw('FIND_IN_SET('.$sess_client_id.',client_id)')->where('job_id',$whchjobs)->get()->toArray();

        //$topics=DB::table('topics')->select('*')->whereRaw('FIND_IN_SET('.$sess_client_id.',client_id)')->get();

        $groups = '';
        $members = '';
        $member_names = [];
        $arr_client = '';

        $this_job = Job::findOrfail($whchjobs);

        if($this_job) {
            $this_job_groups = $this_job->group_id;
            $arr_grps = explode(',', $this_job_groups);
            $d1 = $selected_grp_id;
            if ($arr_grps[0] && $selected_grp_id == false) {
                $selected_grp_id = $arr_grps[0];
            }

            $groups = Topic::whereIn('topic_id', $arr_grps)->get();
            if ($d1 == false) {
              //  $selected_grp = Topic::wherein('client_id',array($sess_client_id))->get()->toArray();
                $selected_grp = Topic::whereRaw('FIND_IN_SET('.$sess_client_id.',client_id)')->where('job_id',$whchjobs)->get()->toArray();
            } else {
                $selected_grp = Topic::where('topic_id', $selected_grp_id)->get()->toArray();
            }
            if(isset($selected_grp[0]))
            {
                $selected_grp = $selected_grp[0];
            }
            if ($jobs) {

                $members = Client::whereRaw('FIND_IN_SET('.$whchjobs.',jobs)')->get();
                $clients123=array();
                if(isset($selected_grp['client_id'])) {
                    for ($i = 0; $i < sizeof(explode(',', $selected_grp['client_id'])); $i++) {
                        $clients123[] = Client::where('client_id', explode(',', $selected_grp['client_id'])[$i])->get()->toArray();
                    }
                }

                if (count($clients123) > 0) {
                    foreach ($clients123 as  $member) {
                        $member_names[] = ucfirst($member[0]['client_display_name']);
                    }
                }
            }

        }

       // $all_users = DB::select('select * from `clients` where FIND_IN_SET('.$whchjobs.',`jobs`) order by `client_display_name` DESC');
        $myjobs1 = Session::get('jobs');
       // $arr_myjobs = explode(',', $myjobs);

        $jobs = Job::where('job_id',$myjobs1)->get();
      /*  print_r($jobs);
        die();*/
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            /*print_r($arr_group_ids);
            die();*/
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();
            
            //$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
          /*  foreach($groups as $gp)
            {
                $c1=$gp['client_id']
            }*/
            $grp=array();

            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
            /*echo "<pre>";
            print_r($grp);
            die();*/
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        
        $all_users = [];
        if(count($arr_client_ids) > 0){
            $all_users = Client::whereIn('client_id',$arr_client_ids)->get();
        }



       /* echo "<pre>";
        print_r($all_users);
        die();*/
           /* $this_job = Job::findOrfail($whchjobs);
            if($this_job){

                $this_job_groups = $this_job->group_id;

                $arr_grps = explode(',', $this_job_groups);

                if($arr_grps[0] && $selected_grp_id==false){
                    $selected_grp_id = $arr_grps[0];
                }

                $groups = Group::whereIn('group_id',$arr_grps)->get();
*/


         //    }

            // $startDate = strtotime(date('Y-m-d')." 00:00:00");
            // $startDate = strtotime(date('Y-m-d',strtotime("-2 days"))." 00:00:00");
            // $endDate = strtotime(date('Y-m-d')." 23:59:59");
        if(isset($selected_grp['topic_id']))
            $selected_grp_id= $selected_grp['topic_id'];

        if($selected_grp_id) {
            $messages = TopicChat::where('topic_id', $selected_grp_id)->orderBy('created_at', 'desc')->limit(7)->get();
            $messages = $messages->reverse()->toArray();
        }
        else{

            $messages = TopicChat::where('topic_id', $selected_grp['topic_id'])->orderBy('created_at', 'desc')->limit(7)->get();
            $messages = $messages->reverse()->toArray();

        }
		
		foreach($messages as $m1)
		{
			$msgObj = TopicChat::findOrfail($m1['id']);
			$msgObj->new_msg = 0;
			$msgObj->save();
		}
      /*  echo "<pre>";
        print_r($selected_grp_id);
        die();*/
        $count = Groupchat::where('group_id',$selected_grp_id)->get();
        $msg_count = count($count);

       // $members_str = '"' . implode ( '", "', $member_names ) . '"';
        // echo "<pre>";
        // print_r($member_names);
        // die;

        // $elements = array_map( 'mysql_real_escape_string', $member_names);

        //return view('clients.chat.topics',['jobs'=>$jobs,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'groups'=>$groups,'members'=>$members,'member_names'=>$member_names,'members_str'=>$members_str,'selected_grp'=>$selected_grp,'all_users'=>$all_users,'sess_client_id'=>$sess_client_id,'messages'=>$messages,'msg_count'=>$msg_count]);
        //TopicChat::where(array('new_msg'=>'1'))->update(array('new_msg'=>'0'));
        $my_notifications = $this->getNotifications();
        

        Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('file_id',$selected_grp_id)->where('type','2')->update(array('mark_read'=>'2'));
        
      /*  echo "<pre>";
        print_r($all_users);
        die();*/
    	return view('clients.chat.topics',['active_job'=>$active_job,'topics'=>$jobs,'whchjobs'=>$whchjobs,'all_users'=>$all_users,'groups'=>$topics,'selected_grp'=>$selected_grp,'notifications'=>$my_notifications,'member_names'=>$member_names,'members'=>$members,'messages'=>$messages,'sess_client_id'=>$sess_client_id,'msg_count'=>'0','authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
    }
	public function topics_single(Request $request,$whchjobs=false,$selected_grp_id=false)
	{
		$sess_client_id = Session::get('client_id');
    
    	$auth = Client::findOrfail($sess_client_id); 
    	$auth_name = $auth->client_display_name; 
    	
    	$authfirstTwoCharacters = substr($auth_name, 0, 2);

        $job_id = Session::get('jobs');

        $alljobs = explode(',', $job_id);
        $jobs = Job::whereIn('job_id',$alljobs)->get();

        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
    
            $whchjobs = Session::get('job_id');
    
    		$active_job = Job::find(Session::get('job_id'));
    
        $topics = Topic::whereRaw('FIND_IN_SET('.$sess_client_id.',client_id)')->where('job_id',$whchjobs)->get()->toArray();

        $groups = '';
        $members = '';
        $member_names = [];
        $arr_client = '';

        $this_job = Job::findOrfail($whchjobs);

        if($this_job) {
            $this_job_groups = $this_job->group_id;
            $arr_grps = explode(',', $this_job_groups);
            $d1 = $selected_grp_id;
            if ($arr_grps[0] && $selected_grp_id == false) {
                $selected_grp_id = $arr_grps[0];
            }

            $groups = Topic::whereIn('topic_id', $arr_grps)->get();
            if ($d1 == false) {
                $selected_grp = Topic::whereRaw('FIND_IN_SET('.$sess_client_id.',client_id)')->where('job_id',$whchjobs)->get()->toArray();
            } else {
                $selected_grp = Topic::where('topic_id', $selected_grp_id)->get()->toArray();
            }
            if(isset($selected_grp[0]))
            {
                $selected_grp = $selected_grp[0];
            }
            if ($jobs) {

                $members = Client::whereRaw('FIND_IN_SET('.$whchjobs.',jobs)')->get();
                $clients123=array();
                if(isset($selected_grp['client_id'])) {
                    for ($i = 0; $i < sizeof(explode(',', $selected_grp['client_id'])); $i++) {
                        $clients123[] = Client::where('client_id', explode(',', $selected_grp['client_id'])[$i])->get()->toArray();
                    }
                }

                if (count($clients123) > 0) {
                    foreach ($clients123 as  $member) {
                        $member_names[] = ucfirst($member[0]['client_display_name']);
                    }
                }
            }

        }

        $myjobs1 = Session::get('jobs');
       
        $jobs = Job::where('job_id',$myjobs1)->get();
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();
            
            $grp=array();

            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        
        $all_users = [];
        if(count($arr_client_ids) > 0){
            $all_users = Client::whereIn('client_id',$arr_client_ids)->get();
        }
        if(isset($selected_grp['topic_id']))
            $selected_grp_id= $selected_grp['topic_id'];

        if($selected_grp_id) {
            $messages = TopicChat::where('topic_id', $selected_grp_id)->orderBy('created_at', 'desc')->limit(7)->get();
            $messages = $messages->reverse()->toArray();
        }
        else{

            $messages = TopicChat::where('topic_id', $selected_grp['topic_id'])->orderBy('created_at', 'desc')->limit(7)->get();
            $messages = $messages->reverse()->toArray();

        }
		
		foreach($messages as $m1)
		{
			$msgObj = TopicChat::findOrfail($m1['id']);
			$msgObj->new_msg = 0;
			$msgObj->save();
		}
        $count = Groupchat::where('group_id',$selected_grp_id)->get();
        $msg_count = count($count);
        $my_notifications = $this->getNotifications();
        

        Notification::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('file_id',$selected_grp_id)->where('type','2')->update(array('mark_read'=>'2'));
    	return view('clients.chat.topics_single',['active_job'=>$active_job,'topics'=>$jobs,'whchjobs'=>$whchjobs,'all_users'=>$all_users,'groups'=>$topics,'selected_grp'=>$selected_grp,'notifications'=>$my_notifications,'member_names'=>$member_names,'members'=>$members,'messages'=>$messages,'sess_client_id'=>$sess_client_id,'msg_count'=>'0','authfirstTwoCharacters'=>strtoupper($authfirstTwoCharacters)]);
    }

    function send_msg_topic(Request $request)
    {
      /*  $data=$response->all();
        $client=Client::where('client_id',$response->sender_id)->get()->toArray();
        $data['sender_name']=$client[0]['client_display_name'];
        echo TopicChat::create($data);*/

        $message = $request->message;
        $filed = $request->filed;
        $content = $request->content;
        $topic_id = $request->group_id;
        $msgType = $request->msg_type;
        $sender_id = Session::get('client_id');
    	$file = $request->file;

        $topic = Topic::where('topic_id',$topic_id)->first();
      //  $message=strip_tags($message);
    	$notif_title = ucfirst(Session::get('client_display_name'))." send message in ".$topic->topic_name;
    	//$notif_message = strlen($message) > 10  ? substr($message, 0, 7) . '...' : $message;
        
        
        if($file){
            $ext = $file->getClientOriginalExtension();
            // $image = str_replace('data:image/png;base64,', '', $content);
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $content);
            // Storage::disk('local')->put($message, file_get_contents($image));
        	
        	// $notif_title = ucfirst(Session::get('client_display_name'))." send image in ".$group->group_name;
        	$notif_message = ucfirst(Session::get('client_display_name'))." send message in ".$topic->topic_name;
        
        	$fileOriginalName = $file->getClientOriginalName();
        	$file->move(public_path("storage/app/"), $fileOriginalName);
    		//chmod(public_path("storage/app/"), 0777);	
            if($ext=='JPG' || $ext=='PNG' || $ext=='JPEG' || $ext=='png' || $ext=='jpg' || $ext=='jpeg')
            {
                $fileType='image';
            }
            else 
            {
                $fileType='other';
            }
        }
        else 
        {
            $fileType='';
        }

        $group = Topic::where('topic_id',$topic_id)->first();

        $all_group_members_str = $group->client_id;
        $all_group_members_arr = explode(",", $all_group_members_str);
        $arr_sender[] = $sender_id;
        //removing sender in all group members for preparing reciepient
        $reciepient_ids_arr = array_diff($all_group_members_arr, $arr_sender);
        $reciepient_ids_str = implode(",", $reciepient_ids_arr);
        $sender_detail = Client::where('client_id',$sender_id)->first();
        $sender_name = $sender_detail->client_display_name;

        $groupchatObj = new TopicChat();
        $groupchatObj->message = $message;
        $groupchatObj->topic_id = $topic_id;
        $groupchatObj->msg_type  = $msgType;
        $groupchatObj->file_type  = $fileType;
        $groupchatObj->recipient_ids =json_encode(explode(',',$reciepient_ids_str));
        $groupchatObj->sender_id = $sender_id;
        $groupchatObj->sender_name = $sender_name;
        $groupchatObj->created_at = date('Y-m-d h:i:s');
        $save = $groupchatObj->save();
        if($save){
        
        /** Send Notifications **/
        if(count($reciepient_ids_arr) > 0){
        	foreach($reciepient_ids_arr as $notkey => $rec_id){
            	
            	$notification = new Notification();
            	$notification->title = $notif_title;
                $notification->message = $message;
            	$notification->job_id = Session::get('job_id');
            	$notification->sender = Session::get('client_id');
            	$notification->client_id = $rec_id;
            	$notification->file_id = $topic_id;
            	$notification->is_annotation = 2;
            	$notification->mark_read = 1;
				$notification->type = 2;
            	$notification->created_at = strtotime(Carbon::now());
            	$notification->updated_at = strtotime(Carbon::now());
            	$notification->save();
        	}
        }
        
            $result = true;
        }else{
            $result = false;
        }
        echo $result;
    }


    function add_topics(Request $request)
    {
        $validator = Validator::make($request->all(),['topic_name'=>'required','client_id'=>'required']);
        if($validator->passes())
        {
            $job_id = Session::get('jobs');

            $alljobs = explode(',', $job_id);
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
            $whchjobs = Session::get('job_id');



            $sess_client_id = Session::get('client_id');
            $data=$request->all();
            if($data['job_id']=='')
                $data['job_id']=$whchjobs;
            if(!in_array($sess_client_id,$data['client_id']))
            {
                $data['client_id'][]=$sess_client_id;
            }
           // $data['client_id']=json_encode();
            $data['client_id']=implode(',',$data['client_id']);

        $resp=Topic::create($data);
        if($resp)
            $arr=array('status'=>'true','message'=>'Topic Successfully Added','reload'=>asset('clients/topics'));
        else
            $arr=array('status'=>'false','message'=>'false');
        }
        else
        {
            $arr=array('status'=>'false','message'=>$validator->errors()->all());
        }
    echo json_encode($arr);
    }

	function update_topics(Request $request)
    {
        // $validator = Validator::make($request->all(),['topic_name'=>'required','client_id'=>'required']);
    	$this->validate($request,[
            'topic_name' => 'required',
        	'topic_id' => 'required',
            'client_id' => 'required',
        ]);
    
    // echo "<pre>";
    // print_r($request->all());
    // die;

        $topic = Topic::find($request->topic_id); 
    
    	 // if(!in_array(Session::get('client_id'),$request->client_id)){
    	 // array_push($request->client_id,Session::get('client_id'));
    	 // }
    	$arr_client_ids = $request->client_id;
    	$arr_client_ids[] = Session::get('client_id');
    	$client_id_str = implode(',',$arr_client_ids);
    	if($topic){
    		$topic->job_id = Session::get('job_id');
        	$topic->topic_name = $request->topic_name;
        	$topic->client_id = $client_id_str;
        	$topic->created_by = Session::get('client_id');
        	$topic->save();
        
        	Toastr::success('Topic Updated Successfully !!', 'Success', ['"debug": false']);
        }else{
            Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
        }
        return redirect()->back();
    }

    public function pdf_version($filepath){
        // pdf version information
        $filepdf = fopen($filepath,"r");
        if ($filepdf) {
        // dd($filepath);
        $line_first = fgets($filepdf);
        // extract number such as 1.4 ,1.5 from first read line of pdf file
        preg_match_all('!\d+!', $line_first, $matches); 
        // save that number in a variable
        $pdfversion = implode('.', $matches[0]);
        return $pdfversion;
        } else{
        return false;
        }
    }

    public function searchInsideByKeywords(Request $request,$keywords,$whchjobs=false){
        $html = '';
        if($request->session()->has('client_id')){
            $my_notifications = $this->getNotifications();

            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
        	if($whchjobs){
            	$request->session()->put('job_id',$whchjobs);
        	}
            $whchjobs = Session::get('job_id');

            $allfiles = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and `is_copied_moved`= 0 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');

            // Parse pdf file and build necessary objects.
            $parser = new \Smalot\PdfParser\Parser();
        
            $arr_result = [];    
            if(count($allfiles) > 0){
                $i =0;
                foreach ($allfiles as $filekey => $file) {
                    
                    try {
                    $arr_filename = explode('.', $file->file_upload_name);
                    if($file->file_type == 2 && $arr_filename[1] == 'pdf'){
                       $old = public_path('storage/files/'.$file->file_upload_name);
                    	
						$new = public_path('storage/files/'.$filekey.'.pdf');
						rename($old,$new);
						shell_exec("gs -sDEVICE=pdfwrite -dCompatibilitLevel=1.4 -dPDFSETTINGS=/printer -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$old $new");
						unlink($new);
                    	$pdf = $parser->parseFile($old);
                    // $pdf = $parser->parseFile(public_path('storage/files/'.$file->file_upload_name));
                    
                    if($pdf){
                        // $arr_result[]['filename'] = $file->file_name;
                        // Retrieve all pages from the pdf file.
                        $pages  = $pdf->getPages();
                            // $arr_result['detail']['filename'][] = $file->file_name;
                            // Loop over each page to extract text.
                                    // $arr_result['detail']['name'][] = $file->file_name;

                            foreach ($pages as $pageno => $page) {
                                $pagetext =  $page->getText();
                                $page_no = $pageno+1;
                                if($pageno == 0){
                                    $urll = url('clients/file/render/'.$file->file_id);
                                    $pagetext = "<p>".$pagetext."<br><b>Page No: ".$page_no."</b></p>";
                                }else{
                                    $pagetext = "<p>".$pagetext."<br><b>Page No: ".$page_no."</b></p>";
                                }
                                
                                if (preg_match("/\w*?$keywords\w*/i",$pagetext)){
                                    // $arr_result['detail']['head'][] = "<h3>Filename : <a href='".$urll."' style='color:#E54E08'>".ucfirst($file->file_name)."</a></h3><br>";
                                    
                                    $arr_result[$i]['filename'] = $file->file_name." <b>(Page No: ".$page_no.")</b>";
                                    $arr_result[$i]['pageno'] = $page_no;
                                    $arr_result[$i]['fileid'] = $file->file_id;
                                    $arr_result[$i]['text'][] = preg_replace("/\w*?$keywords\w*/i", "<b style='color:#E54E08;background-color:yellow'>$0</b>", $pagetext);
                                    // $arr_result['detail']['page_no'][] = $pageno+1;
                                    $i++;
                                }
                            }
                        }
                }
                $html = view('clients.render.search_inside', ['arr_result'=>$arr_result])->render();
                    }catch(Exception $e)  {
                        dd($e);
                    }
            }
        }else{
            return redirect('/');
        }
        echo $html;
    }
	}

	function selected_text_information_save(Request $request)
    {
        $filedata = File::where('file_id',$request->file_id)->first();
         $info=SelectedTextInformation::get()->toArray();
        $comment_arr=array('status'=>'false','message'=>'false','data'=>array());
        $counter=0;
        $arr=array();
        if(isset(json_decode(json_encode(json_decode($request->current_instanceJSON)),true)['id']))
        {
            foreach($info as $in)
            {
                if(json_decode(json_encode(json_decode($in['instance_json'])),true)['id']==json_decode(json_encode(json_decode($request->current_instanceJSON)),true)['id'])
                {
                    $selectedTextComment= new SelectedTextComment();
                    $selectedTextComment->comment=$request->comment;
                    $selectedTextComment->parent=$in['id'];
                    $selectedTextComment->user_id=Session::get('client_id');
                    $selectedTextComment->file_id=$filedata->file_id;
                    $selectedTextComment->file_name=$filedata->file_name;
                    $selectedTextComment->page_no=$request->page_no;
                	$selectedTextComment->job_id=Session::get('job_id');
                    $selectedTextComment->save();
                    $counter++;
					
					
                    $arr=array('status'=>'true','message'=>'Success','comment_id'=>$in['id']);
                }
            }
        }
       
        if($counter==0)
        {
            $selectedTextInformation = new SelectedTextInformation();
            $selectedTextInformation->text=$request->text;
            $selectedTextInformation->main_instance_json_id=$request->last_id;
            $selectedTextInformation->file_id=$filedata->file_id;
            $selectedTextInformation->file_name=$filedata->file_name;
            $selectedTextInformation->page_no=$request->page_no;
            $selectedTextInformation->instance_json=$request->current_instanceJSON;
            $selectedTextInformation->save();

            $selectedTextComment= new SelectedTextComment();
            $selectedTextComment->comment=$request->comment;
            $selectedTextComment->parent=$selectedTextInformation->id;
            $selectedTextComment->user_id=Session::get('client_id');
            $selectedTextComment->file_id=$filedata->file_id;
            $selectedTextComment->file_name=$filedata->file_name;
            $selectedTextComment->page_no=$request->page_no;
            $selectedTextComment->job_id=Session::get('job_id');
            $selectedTextComment->save();
            $arr=array('status'=>'true','message'=>'Success','comment_id'=>$selectedTextInformation->id);    
        }
		
		
		$file_info=File::where('file_id',$filedata->file_id)->get()->toArray();
		$quick_access = new QuickAccess();
		$quick_access->file_id=$filedata->file_id;
		$quick_access->client_id=Session::get('client_id');
		$quick_access->file_name=$file_info[0]['file_name'];
		$quick_access->type=3;
		$quick_access->comment=$request->comment;
		$quick_access->job_id=Session::get('job_id');
		$quick_access->created_at=strtotime(Carbon::now());
		$quick_access->updated_at=strtotime(Carbon::now());	
		$quick_access->save();
        echo json_encode($arr);

    }
    public function read_all_text_comment()
    {
        $info=SelectedTextInformation::get()->toArray();
        $comment_arr=array('status'=>'false','message'=>'false','data'=>array());
        if(isset(json_decode(json_encode(json_decode($_POST['json'])),true)['id']))
        {
            foreach($info as $in)
            {
                if(json_decode(json_encode(json_decode($in['instance_json'])),true)['id']==json_decode(json_encode(json_decode($_POST['json'])),true)['id'])
                {
                    $all_comment=SelectedTextComment::where('parent',$in['id'])->get()->toArray();
                    $comment_arr['status']='true';
                    $comment_arr['message']=$in['text'];
                    $comment_arr['data']=$all_comment;
                    $comment_arr['user_id']=Session::get('client_id');
                    $comment_arr['comment_id']=$in['id'];
                }       
            }
        }
        echo json_encode($comment_arr);  
    }
    public function shareComment(Request $request)
    {
        $client_info=Client::where('client_id',Session::get('client_id'))->get()->toArray();
        $select_text_info = SelectedTextInformation::where('id',$request->comment_id)->get()->toArray();
        $new_arr[0]=json_decode(json_encode(json_decode($select_text_info[0]['instance_json'])),true);
    	$file_info=File::where('file_id',$request->document_id)->get()->toArray();
       
       // echo $annotation_id=$new_arr[0]['id'];
        
        $notification = new Notification();
        $notification->title=$client_info[0]['client_display_name']." shared File Comment Link";
        $notification->message=$request->text;
        $notification->sender=Session::get('client_id');
        $notification->client_id=$request->client_id;
        $notification->mark_read=1;
        $notification->is_annotation=1;
        $notification->file_id=$request->document_id;
    	$notification->job_id = Session::get('job_id');
        $notification->annotation_data=json_encode($new_arr);
        $notification->page_no=$request->page_no;
        $notification->created_at = strtotime(Carbon::now());
        $notification->updated_at = strtotime(Carbon::now());
       echo $notification->save();
        
       /* $this->copy_layer($file_info[0]['pspdf_file_id'],'doc_'.$request->document_id.Session::get('client_id'),'notification'.$notification->id);
        $all_annotation=$this->get_layer_annotation($file_info[0]['pspdf_file_id'],'doc_1135');
        echo "<pre>";
        print_r($all_annotation);*/
       //echo "1";
        
    }

    function shared_file_update(Request $request)
    {
        //$_POST['json']=json_encode($_POST['json']['annotations']);
        $notification = Notification::where('id', $request->document_id)->first();
        $notification->annotation_data=$request->json;
        $notification->update();

        $filedata = File::where('file_id',$request->d1)->first();
        
        if(!$request->unique_token){
            $selectedTextInformation=new SelectedTextInformation();
            $selectedTextInformation->text=$request->text;
            $selectedTextInformation->instance_json=$request->current_instanceJSON;
            $selectedTextInformation->file_id=$filedata->file_id;
            $selectedTextInformation->file_name=$filedata->file_name;
            $selectedTextInformation->page_no=$request->page_no;
            $selectedTextInformation->created_at=strtotime(Carbon::now());
            $selectedTextInformation->updated_at=strtotime(Carbon::now());
            $selectedTextInformation->save();
            $info_id=$selectedTextInformation->id;
        }else{
            $j1=json_decode($request->current_instanceJSON);
            $info = SelectedTextInformation::where('instance_json', 'like', '%' . $j1->id . '%')->first();
            $info_id = $info->id;
        }

        $client_info=Client::where('client_id',Session::get('client_id'))->get()->toArray();
        $new_arr[0]= json_decode(json_encode(json_decode($request->current_instanceJSON)),true);
        $notification = new Notification();
        $notification->title=$client_info[0]['client_display_name']." shared File Comment Link";
        $notification->message=$request->text;
        $notification->sender=Session::get('client_id');
        $notification->client_id=$request->client_id;
        $notification->mark_read=1;
        $notification->is_annotation=1;
        $notification->file_id=$request->d1;
    	$notification->job_id = Session::get('job_id');
        $notification->page_no=$request->page_no;
        $notification->annotation_data=json_encode($new_arr);
        $notification->created_at = strtotime(Carbon::now());
        $notification->updated_at = strtotime(Carbon::now());
        $notification->save();

        $selectedTextComment= new SelectedTextComment();
        $selectedTextComment->comment=$request->comment;
        $selectedTextComment->parent=$info_id;
        $selectedTextComment->user_id=Session::get('client_id');
        $selectedTextComment->file_id=$filedata->file_id;
        $selectedTextComment->file_name=$filedata->file_name;
        $selectedTextComment->page_no=$request->page_no;
        echo $selectedTextComment->save(); 
    }
	
	/**
method Get Files and Folders Name for rename
**/
    public function getFileById($id){
        $file = File::where('file_id',$id)->first();
        if($file){
            echo json_encode($file);
        }else{
            echo false;
        }
    }
	
	public function getEditedFileById($id){
        $file = Editedfile::where('file_id',$id)->where('client_id',Session::get('client_id'))->first();
        if($file){
            echo json_encode($file);
        }else{
            echo false;
        }
    }
/**end**/

/**
method Rename Files and Folders
**/
    public function renameFiles(Request $request,$id){
        $file = Editedfile::where('file_id',$id)->where('client_id',Session::get('client_id'))->first();
        $file->name = $request->file_name;
        $res = $file->update();
        if($res){

            $activitylogObj = new Activitylog();
            $action = 'Rename File';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type,1);

            echo true;
        }else{
            echo false;
        }
    }
/**end**/

    public function getTagsForFilter(){
        $tags = Tag::where('client_id',Session::get('client_id'))->orderBy('created_at','desc')->get();

        $html = view('clients.render.tags_filter', ['tags'=>$tags])->render();
        echo $html;
    }

    public function getTagsForFilter_exe(){
        $tags = Tag::where('client_id',Session::get('client_id'))->orderBy('created_at','desc')->get();

        $html = view('clients.render.tags_filter_exe', ['tags'=>$tags])->render();
        echo $html;
    }

    public function getByTagid_OLD($tagid,$whchjobs=false){
        /*For apply tag colour*/
        $tagdata = Tag::findOrfail($tagid);
    
    	$whchjobs = Session::get('job_id');

        /** For get files **/
        $tags = Tagstatus::where('client_id',Session::get('client_id'))->where('tag_id',$tagid)->get();
        $arrfiles = [];
        if(count($tags)>0){
            foreach ($tags as $tkey => $tag) {
                $arrfiles[] = $tag->file_id;
            }
        }

       if(count($arrfiles) > 0){ 
        $my_clouds_str = implode(',', $arrfiles);   
        $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
        }
        // echo "<pre>";
        // print_r($my_clouds);
        // die;
        // if(count($my_clouds) > 0){
        //     $html = view('clients.single', ['my_clouds'=>$my_clouds,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles])->render();
        // }

        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $url = URL::to('/clients/file/render/');

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                    /**$isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->exists();**/
                        $checked = "name='file_id'";
                        $classes_folder = "class='nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
                        $classes_file = "class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                    

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' ".$classes_folder." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:21px;'><i class='fa fa-edit'></i></a></p>";
                    }else{
                        $arr_nods["name"] = "<i class='fa fa-circle' style='color:".$tagdata->color_tag."'></i><a href='".$url.'/'.$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."</a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm' style='margin-left:21px;'><i class='fa fa-edit'></i></a></p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File added yet</strong>');
            }
        echo json_encode($all_nods);
    }

	public function getByTagid($tagid,$whchjobs=false){
        /*For apply tag colour*/
        $tagdata = Tag::findOrfail($tagid);
    
    	$whchjobs = Session::get('job_id');

        /** For get files **/
        $tags = Tagstatus::where('client_id',Session::get('client_id'))->where('tag_id',$tagid)->get();
        $arrfiles = [];
        if(count($tags)>0){
            foreach ($tags as $tkey => $tag) {
                $arrfiles[] = $tag->file_id;
            }
        }

       if(count($arrfiles) > 0){ 
        $my_clouds_str = implode(',', $arrfiles);   
        $my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
        }
    
    	/*get downloaded files here*/
            $clientid = Session::has('client_id') ? Session::get('client_id') : '';
            $AllMyFiles = Download::where('download_client_id',$clientid)->get();
            $arr_my_dfiles[]=array();
            if($AllMyFiles){
                foreach ($AllMyFiles as $myfile){
                    $arr_my_dfiles[] = $myfile->download_file_id;
                }
            }
        // echo "<pre>";
        // print_r($my_clouds);
        // die;
        // if(count($my_clouds) > 0){
        //     $html = view('clients.single', ['my_clouds'=>$my_clouds,'whchjobs'=>$whchjobs,'arr_my_dfiles'=>$arr_my_dfiles])->render();
        // }

        $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $url = URL::to('/clients/file/render/');
    		$move_icon = url('public/images/move-icon.png');

            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	// if (in_array($my_cloud->file_id, $arr_my_dfiles)){
                    	if (in_array($my_cloud->file_id, $arr_my_dfiles)){
                    /**$isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->exists();**/
                        $checked = "name='file_id'";
                        $classes_folder = "class='nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
                        $classes_file = "class='nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                    

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;
                        
                    $editedfile = Editedfile::where('file_id',$my_cloud->file_id)->where('client_id',Session::get('client_id'))->first();
                    $myfilename = $editedfile->name;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($myfilename)."</a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='folderCheck(".$my_cloud->file_id.")' ".$classes_folder." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";
                    }else{
                        	$arr_nods["name"] = "<i class='fa fa-circle' style='color:".$tagdata->color_tag."'></i><a href='".$url.'/'.$my_cloud->file_id."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($myfilename)."</a><input type='checkbox' style='width:50px;margin-top:21px;float:right' id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' style='float:right'; ".$checked."><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)." <a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp;Rename&nbsp;' href='javascript:void(0)' onclick='renameFile(".$my_cloud->file_id.")' class='btn btn-sm rename right_icon'><i class='fa fa-edit'></i></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Move &nbsp;' href='javascript:void(0)' onclick='moveFile(".$my_cloud->file_id.")' class='btn btn-sm move right_icon'><img src='".$move_icon."'></a><a type='button' data-toggle='tooltip' data-placement='top' title='&nbsp; Copy &nbsp;' href='javascript:void(0)' onclick='copyFile(".$my_cloud->file_id.")' class='btn btn-sm copy right_icon'><i class='fa fa-copy'></i></a></p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                   	}
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File added yet</strong>');
            }
        echo json_encode($all_nods);
    }

    public function exportZipFiles(Request $request){
    	if(file_exists(public_path('export.zip'))){
        	chmod(public_path('export.zip'), 0777);
    		unlink(public_path('export.zip'));
        }
        
        $files = File::whereIn('file_id',$request->arr_fileid)->get();
        if(file_exists(url('public/export.zip'))){
            $dfile_path = url('public/export.zip');
        }else{
            $dfile_path = '';
        }

            if(count($files) > 0){
                 
                $zipper = \Zipper::make(public_path('export.zip'));
                foreach ($files as $fkey => $fileidd) {
                $parent_folder='';
				$parent_folder=$this->check_parent_file($fileidd->file_parent_id,$parent_folder);
                	$old = public_path('storage/files/'.$fileidd->file_upload_name);
				if($fileidd->file_type==2)
				{
                   if($parent_folder)
				   {					   
                	$zipper = $zipper->folder($parent_folder)->addString($fileidd->file_name,file_get_contents($old));
				   }
				   else 
				   {
					   $zipper = $zipper->addString($fileidd->file_name,file_get_contents($old));
				   }
				}	
                }
                 $zipper->close();
            	
            	
                $activitylogObj = new Activitylog();
                $action = 'File Exported';
                $user_type = 'client';
                $activitylogObj->saveActivityLog($action,$user_type);
                $arr = array('message' => 'Files Exported Successfully', 'title' => 'Exported','path' => $dfile_path);
            }else{
                $arr = array('message' => 'Somthing went wrong', 'title' => 'Exported error..','path' => '');
            }
        echo json_encode($arr);
    }
    function check_parent_file($parent,$folder)
	{
		if($parent!=0)
		{
			
			$files1 = File::where('file_id',$parent)->get()->toArray();
			if($folder)
				$folder=$files1[0]['file_name'].'/'.$folder;
			else 
				$folder=$files1[0]['file_name'];
			
			if($files1[0]['file_parent_id']!=0)
			{
				
				return $folder=$this->check_parent_file($files1[0]['file_parent_id'],$folder);
			}
			else 
			{
				return $folder;
			}
		}
		
	}


    public function clientActivityLog($whchjobs=false){
        $my_notifications = $this->getNotifications();

            $job_id = Session::get('jobs');
            $alljobs = explode(',', $job_id); 
            
            $jobs = Job::whereIn('job_id',$alljobs)->get();
            
    		$whchjobs = Session::get('job_id');

         /**assign page label**/
        $head_label = 'Activity Log';

        $startDate = strtotime(date('Y-m-d')." 00:00:00");
        $endDate = strtotime(date('Y-m-d')." 23:59:59");
    	$usertype = 'client';
        
        $users = Activitylog::where('userid',Session::get('client_id'))->where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        $users=$users->reverse();
      /*  echo "<pre>";
    print_r($users);
    die();*/
        return view('clients.loglist',['users'=>$users,'head_label'=>$head_label,'usertype'=>$usertype,'notifications'=>$my_notifications,'whchjobs'=>$whchjobs]);
    }

    public function myRenderLogs(Request $request){ 
        $startDate = strtotime($request->startDate." 00:00:00");
        $endDate = strtotime($request->endDate." 23:59:59");
        $usertype = 'client';
        // $users = Activitylog::where('user_type',$usertype)->whereBetween('created_at', [$startDate,$endDate])->get();

        $users = Activitylog::where('userid',Session::get('client_id'))->where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
		
        $users=$users->reverse();
        $result = view('clients.render.loglist',['users'=>$users])->render();
        
        if(sizeof($users)>0)
        {
            $arr=array('status'=>'1','data'=>$result);
        }
        else 
        {
            $arr=array('status'=>'0','data'=>$result);
        }
        echo json_encode($arr);
        
    }

    public function reportFiles(Request $request){ 
       // print_r($request->all());
         $request->reporttype;
        $startDate = strtotime($request->startDate." 00:00:00");
        $endDate = strtotime($request->endDate." 23:59:59");
        $whchjobs = Session::get('job_id');

        if($request->reporttype == 'all'){
            $reports = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','desc')->get();
        }else{
            $reports = Report::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->where('type', 'LIKE', '%' . $request->reporttype . '%')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at','desc')->get();

           
        }
		$reports=$reports->reverse();
        
        $result = view('clients.render.reports',['reports'=>$reports,'tableid'=>$request->tableid])->render();
        if(sizeof($reports)>0)
        {
            $arr=array('status'=>'1','data'=>$result);
        }
        else 
        {
            $arr=array('status'=>'0','data'=>$result);
        }
        echo json_encode($arr);
    }

    public function addIssue(Request $request){
        $issue=new Issue();
        $issue->name=$request->name;
        $issue->color=$request->color;
        $issue->client_id=Session::get('client_id');
        $issue->created_at = strtotime(Carbon::now());
        $issue->updated_at = strtotime(Carbon::now());
        echo $issue->save();
    }
    public function delete_issue($id)
    {
        $issue=Issue::where('id',$id)->get()->first();
      echo   $issue->delete();   
    }
    public function get_all_issue(){
        $all_issue=Issue::where('client_id',Session::get('client_id'))->get()->toArray();
        return json_encode($all_issue);
        
    }

    public function check_hyperlink(Request $request)
    {
        $hyperlink=Hyperlink::where('annotation_id',$request->id)->get()->toArray();
        if($hyperlink)
            $arr=array('status'=>'true','data'=>$hyperlink);
        else 
            $arr=array('status'=>'false','data'=>'');
        echo json_encode($arr);
    }

    public function add_to_link_add(Request $request)
    {   
    	if($request->is_external==3){
        	$file_data = File::find($request->file_id);
        	$file_extension = strtolower(substr(strrchr($file_data->file_upload_name, "."), 1));
        	if($file_extension != 'pdf'){
            	$request->url = url('public/storage/files/'.$file_data->file_upload_name);
            	$request->is_external = 1;
            }	
        }
    	
    	$hyperlink = new Hyperlink();
        $hyperlink->file_id=$request->file_id;
        $hyperlink->is_external=$request->is_external;
        $hyperlink->url = $request->url;
    	if($request->is_external == 2){
    	$hyperlink->page_no = $request->page_no;
        }
        $hyperlink->annotation_id = $request->annotation_id;
        
        if($hyperlink->save()){

            $file = File::where('file_id',$request->file_id)->first();
            if($file){
            $filename = $file->file_name;
            }else{
                $filename = "";
            }

            // $report = new Report();
            // $report->client_id = Session::get('client_id');
            // $report->file_id = $request->file_id;
            // $report->file_name = $filename;
            // $report->page = $request->page_no;
            // $report->data= $request->annotation_id;
            // $report->type= "Hyperlink";
            // $report->created_at= strtotime(Carbon::now());
            // $report->save();

            $res['success'] = 1;
        }else{
            $res['error'] = 1;
        }
        echo json_encode($res);
    }

    function upload_pdf_file_for_pdf(Request $request,$page_no)
    {

         $file = $request->file('file');
         $file->getClientOriginalName();
         $ext=$file->getClientOriginalExtension();
         $file->getRealPath();
         $file->getMimeType();
         $file_size=$file->getSize();
         if($file_size<100000000)
         {
         $destinationPath = 'public/storage/pdf_data/';
         $file->getClientOriginalName();
         if($ext!='sql' && $ext!='html' && $ext!='json' && $ext!='php' && $ext!='jsp' && $ext!='asp')
        {
            $file_name=$file->move($destinationPath,$file->getClientOriginalName());
            if($file_name)
            {
				$p=$page_no-1;
               $status=Pdf_file_overlay::where('user_id',Session::get('client_id'))->where('file_id',$request->file_id)->where('page_no',$p)->get()->toArray();
           /* echo "<pre>";
            print_r($status);*/
               if(count($status)>0)
               {
             //   echo "Update";
                    $pdf_file_overlay=Pdf_file_overlay::where('id',$status[0]['id'])->first();
                    $pdf_file_overlay->file_id=$request->file_id;
                    $pdf_file_overlay->file_name=$destinationPath.$file->getClientOriginalName();
                    $pdf_file_overlay->file_type=$ext;
                    $pdf_file_overlay->page_no=$p;
                    $pdf_file_overlay->update();    
               }
               else 
               {
               // echo "insert";
                    $pdf_file_overlay=new Pdf_file_overlay();
                    $pdf_file_overlay->file_id=$request->file_id;
                    $pdf_file_overlay->file_name=$destinationPath.$file->getClientOriginalName();
                    $pdf_file_overlay->file_type=$ext;
                    $pdf_file_overlay->page_no=$p;
                    $pdf_file_overlay->user_id=Session::get('client_id');
                    $pdf_file_overlay->save();
               }


               $pdf = Pdf_file_overlay::where('id',$pdf_file_overlay->id)->get()->toArray();
                $this->add_activity('File Attachment');
                $arr=array('status'=>'true','message'=>'File Successfullay Uploaded','reload'=>asset('clients/file/render/'.$request->file_id),'overlay_id'=>$pdf_file_overlay->id,'data'=>$pdf);   
            }
            else 
            {
                $arr=array('status'=>'false','message'=>'File Not Upload Please Try Again');
            }
        }
        else 
        {
            $arr=array('status'=>'false','message'=>'Please Upload Valid File');
        }
        }
        else 
        {
             $arr=array('status'=>'false','message'=>'maximum upload file size 100 mb allowed ');   
        }
    
       echo json_encode($arr);
    }

    function get_document_file(Request $request)
    {
        if(isset($_POST['sender']))
        {
            $client_id=$_POST['sender'];
        }
        else 
        {
            $client_id=Session::get('client_id');
        }
        $pdf_file_overlay=Pdf_file_overlay::where('user_id',$client_id)->where('file_id',$request->file_id)->where('status','1')->get()->toArray();
        if($pdf_file_overlay)
        {
            $arr=array('status'=>'true','data'=>$pdf_file_overlay);
        }
        else 
        {
            $arr=array('status'=>'false');
        }
        echo json_encode($arr);
    }
    public function get_document_file_one(Request $request)
    {
        $pdf_file_overlay=Pdf_file_overlay::where('user_id',Session::get('client_id'))->where('file_id',$request->file_id)->get()->toArray();
        if($pdf_file_overlay)
        {
            $arr=array('status'=>'true','data'=>$pdf_file_overlay);
        }
        else 
        {
            $arr=array('status'=>'false');
        }
        echo json_encode($arr);   
    }
    public function updateParentFolderSize($parent_id,$file_size,$type)
    {
        // $sql_q = $this->db->query("SELECT file_size,file_parent_id FROM files WHERE file_id = ?", $parent_id);
        $sql_q = File::where('file_id', $parent_id)->get();
                        
        if (count($sql_q) == 1){
            // $this->db->query("UPDATE files SET file_size = ".$file_size." WHERE file_id=?", $parent_id);
            $filfrst = File::where('file_id', $parent_id)->first();
            $current_file_size = $filfrst->file_size;

            if($type == 'add'){
                $filfrst->file_size = $current_file_size + $file_size;
            }
            else{
                $filfrst->file_size = $current_file_size - $file_size;
            }
            $filfrst->update();
        }elseif(count($sql_q) > 0 && count($sql_q) != 1){
            foreach ($sql_q as $result) {
                $current_file_size = $result->file_size;
                
                if($type == 'add'){
                    $new_file_size = $current_file_size + $file_size;
                }
                else{
                    $new_file_size = $current_file_size - $file_size;
                }
                $filfrst = File::where('file_id', $parent_id)->first();
                if($filfrst){
                    $filfrst->file_size = $new_file_size;
                    $filfrst->update();
                }
                // $this->db->query("UPDATE files SET file_size = ".$new_file_size." WHERE file_id=?", $parent_id);


                if($result->file_parent_id != 0)
                {
                    $this->updateParentFolderSize($result->file_parent_id,$file_size,$type);
                }
            }
        }
    }

    public function fromDashboard($file_id){

        $my_notifications = $this->getNotifications();

        $file = File::where('file_id',$file_id)->first();
        if($file)
		{
			return view('clients.from_dashboard',['file'=>$file,'notifications'=>$my_notifications]);
		}
		else 
		{
			return view('not_found',['notifications'=>$my_notifications]);
		}
    }

	public function moveDoc($to,$from,$sufix=false){
    	$cfile = File::find($from);
     //  $old_file=$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$from)->get()->toArray()[0]['download_id'];
        $tofile = File::find($to);
        
        if($cfile){
    	   $cfile->file_parent_id = $to;
    	    if($cfile->file_type == 1){
                $this->replicateMovedFolder($cfile->file_id,$to,1,$sufix);
            }else{
                $is_exist = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$cfile->file_id)->first();
                if($is_exist){
                    $is_exist->delete();
                	$this->getAllParents($cfile->file_id,'delete');
                    $newProduct = $cfile->replicate();
                	/** Replicate File start **/
                	if($sufix){
                		if (strpos($cfile->file_name,' - (') !== false) { //first we check if the url contains the string 'en-us'
    						$arr_fname = explode('-',$cfile->file_name);
            				$newProduct->file_name = $arr_fname[0].' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
						}else{
    						$newProduct->file_name = $cfile->file_name.' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
        				}
                	}else{
                		$newProduct->file_name = $cfile->file_name;
                	}
                    $newProduct->file_parent_id = $tofile->file_id;
                    $newProduct->job_id = $tofile->job_id;
                    $newProduct->file_date_modified = strtotime(Carbon::now());
                    $newProduct->is_copied_moved = 1;;
                    if($newProduct->save()){
						
						$layer=$is_exist->layer;
						$n_layer='doc_'.Session::get('client_id').date('his');
						$this->copy_layer($cfile->pspdf_file_id,$layer,$n_layer);
						
                        $downloadObj = new Download(); 
                        $downloadObj->download_client_id = Session::get('client_id');
                        $downloadObj->download_file_id = $newProduct->file_id;
                        $downloadObj->download_date = strtotime(Carbon::now());
						$downloadObj->layer = $n_layer;
                        $downloadObj->save();
                    	
                       //$this->copy_layer($cfile->pspdf_file_id,'doc_'.$cfile->file_id.Session::get('client_id').$old_file,'doc_'.$newProduct->file_id.Session::get('client_id').$downloadObj->download_id);
                    	$this->getAllParents($newProduct->file_id,'add');
                    /** Replicate Annotation start **/
                    	$annotation = Annotation::where('annotation_file_id',$cfile->file_id)->where('annotation_client_id',Session::get('client_id'))->first();
                    	if($annotation){
                    		$rep_annot = $annotation->replicate();
                        	$rep_annot->annotation_file_id = $newProduct->file_id;
                			$rep_annot->annotation_date = strtotime(Carbon::now());
                			$rep_annot->save();
                        }
                    /** Replicate Annotation end **/
                    /** Replicate Bookmarked start **/
                    	$bookmark = Bookmark::where('bookmarked_file_id',$cfile->file_id)->where('bookmarked_client_id',Session::get('client_id'))->first();
                    	if($bookmark){
                    		$book = $bookmark->replicate();
                        	$book->bookmarked_file_id = $newProduct->file_id;
                			$book->bookmarked_date = strtotime(Carbon::now());
                			$book->save();
                        }
                    /** Replicate Bookmarked end **/
                    /** Replicate Tagstatus start **/
                    	$tagstatus = Tagstatus::where('file_id',$cfile->file_id)->where('client_id',Session::get('client_id'))->first();
                    	if($tagstatus){
                    		$tag = $tagstatus->replicate();
                        	$tag->file_id = $newProduct->file_id;
                			$tag->save();
                        }
                    /** Replicate Tagstatus end **/
                    /** Replicate Overlay start **/
                    	$overlay = Pdf_file_overlay::where('file_id',$cfile->file_id)->first();
                    	if($overlay){
                    		$ovr = $overlay->replicate();
                        	$ovr->file_id = $newProduct->file_id;
                			$ovr->save();
                        }
                    /** Replicate overlay end **/
                    }
                }
            }

            $activitylogObj = new Activitylog();
            $action = 'Move Document';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type,1);

       	 	echo true;
            // Toastr::success('Document Moved Successfully !!', 'Success', ['"debug": false']);
        }else{
        	echo false;
            // Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
        }
        // return redirect()->back();
    }

    public function copyDoc(Request $request){
        
    	$cfile = File::find($request->copied_file);     
    	//print_r($cfile->file_id);
        
		//$old_file=$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$cfile->file_id)->get()->toArray()[0]['download_id'];
		
		

    	/*echo 'doc_'.$cfile->file_id.Session::get('client_id').$old_file;
      die();*/
       if($request->vch_tab == 1){
        	$this->validate($request,[
            	'select_folder' => 'required',
            	'jobs' => 'required',
            	'copied_file' => 'required'
        	]);
        
        	$file = File::find($request->select_folder);        
        }elseif($request->vch_tab == 2){
        	$this->validate($request,[
            	'folder_name' => 'required',
            	'jobs' => 'required',
            	'copied_file' => 'required'
        	]);
			
			
        	$file = new File();
        	$file->job_id = $cfile->job_id;
        	$file->file_name = $request->folder_name;
        	$file->file_type = 1;
        	$file->file_parent_id = 0;
        	$file->file_date_modified = strtotime(Carbon::now());
        	$file->file_size = $cfile->file_size;
            $file->file_size = $cfile->file_size;
        	$file->file_shared = 1;
        	$file->file_status = 1;
        	$file->is_copied_moved = 1;
            $file->pspdf_file_id=$cfile->pspdf_file_id;
        	$file->save();
        }
        
        if($file){
            if($cfile->file_type == 1){
                $this->replicateFolder($cfile->file_id,$file->file_id,1,$request->sufix_name);
            }else{
                $is_exist = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$cfile->file_id)->first();
                if($is_exist){
                    $newProduct = $cfile->replicate();
                /** Replicate File start **/
                if($request->sufix_name){
                	if (strpos($cfile->file_name,' - (') !== false) { //first we check if the url contains the string 'en-us'
    					$arr_fname = explode('-',$cfile->file_name);
            			$newProduct->file_name = $arr_fname[0].' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
					}else{
    					$newProduct->file_name = $cfile->file_name.' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
        			}
                }else{
                	$newProduct->file_name = $cfile->file_name;
                }
                	/** update parent folder size **/
                	/**$Pfile = File::find($file->file_id);
        			$Pfile->file_size = $Pfile->file_size + $cfile->file_size;
        			$Pfile->save();**/
                	
                    $newProduct->file_parent_id = $file->file_id;
                	$newProduct->file_date_modified = strtotime(Carbon::now());
                	$newProduct->is_copied_moved = 1;
                    if($newProduct->save()){
                    	/** Replicate File end **/
                    	/** Entry in download table of replicated file **/
                        $layer=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$cfile->file_id)->get()->toArray()[0]['layer'];
						$n_layer='doc_'.Session::get('client_id').date('his');
						$this->copy_layer($cfile->pspdf_file_id,$layer,$n_layer);
						
						$downloadObj = new Download(); 
                        $downloadObj->download_client_id = Session::get('client_id');
                        $downloadObj->download_file_id = $newProduct->file_id;
                        $downloadObj->download_date = strtotime(Carbon::now());
						$downloadObj->layer = $n_layer;
                        $downloadObj->save();
                  
                  //  $this->copy_layer($cfile->pspdf_file_id,'doc_'.$cfile->file_id.Session::get('client_id').$old_file,'doc_'.$newProduct->file_id.Session::get('client_id').$downloadObj->download_id);
                    
                    	$this->getAllParents($newProduct->file_id,'add');
                    	
                    /** Replicate Annotation start **/
                    	$annotation = Annotation::where('annotation_file_id',$cfile->file_id)->where('annotation_client_id',Session::get('client_id'))->first();
                    	if($annotation){
                    		$rep_annot = $annotation->replicate();
                        	$rep_annot->annotation_file_id = $newProduct->file_id;
                			$rep_annot->annotation_date = strtotime(Carbon::now());
                			$rep_annot->save();
                        }
                    /** Replicate Annotation end **/
                    /** Replicate Bookmarked start **/
                    	$bookmark = Bookmark::where('bookmarked_file_id',$cfile->file_id)->where('bookmarked_client_id',Session::get('client_id'))->first();
                    	if($bookmark){
                    		$book = $bookmark->replicate();
                        	$book->bookmarked_file_id = $newProduct->file_id;
                			$book->bookmarked_date = strtotime(Carbon::now());
                			$book->save();
                        }
                    /** Replicate Bookmarked end **/
                    /** Replicate Tagstatus start **/
                    	$tagstatus = Tagstatus::where('file_id',$cfile->file_id)->where('client_id',Session::get('client_id'))->first();
                    	if($tagstatus){
                    		$tag = $tagstatus->replicate();
                        	$tag->file_id = $newProduct->file_id;
                			$tag->save();
                        }
                    /** Replicate Tagstatus end **/
                    /** Replicate Overlay start **/
                    	$overlay = Pdf_file_overlay::where('file_id',$cfile->file_id)->first();
                    	if($overlay){
                    		$ovr = $overlay->replicate();
                        	$ovr->file_id = $newProduct->file_id;
                			$ovr->save();
                        }
                    /** Replicate overlay end **/
                    }
                }
            }

            $activitylogObj = new Activitylog();
            $action = 'Copy Document';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type,1);
			
        	$res['success'] = 1;
            $res['success_msg'] = 'Document Copied Successfully !!';
        }else{
            $res['success'] = 0;
            $res['success_msg'] = 'Something went wrong!!';
        }
        echo json_encode($res);
    }

    public function replicateFolder($id,$pid,$count,$sufix=false){
        $cfile1 = File::find($id);
        $newProduct1 = $cfile1->replicate();
    	if($count == 1){
        if($sufix){
			if (strpos($cfile1->file_name,' - (') !== false) { //first we check if the url contains the string 'en-us'
    			$arr_fname = explode('-',$cfile1->file_name);
            	$newProduct1->file_name = $arr_fname[0].' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
			}else{
    			$newProduct1->file_name = $cfile1->file_name.' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
        	}
        }else{
        	$newProduct1->file_name = $cfile1->file_name;
        }
        	/** update parent folder size **/
        	/**$Pfile = File::find($pid);
        	$Pfile->file_size = $Pfile->file_size + $cfile1->file_size;
        	$Pfile->save();**/
        }
        $newProduct1->file_parent_id = $pid;
    	$newProduct1->file_date_modified = strtotime(Carbon::now());
    	$newProduct1->is_copied_moved = 1;
        $newProduct1->save();
        
        $childrens = File::where('file_parent_id',$cfile1->file_id)->get();
        
        if(count($childrens) > 0){
            foreach ($childrens as $ckey => $child) {
                if($child->file_type == 1){
                	// $count = 0;
                    $this->replicateFolder($child->file_id,$newProduct1->file_id,0);
                }else{
                    $is_exist = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$child->file_id)->first();
                    if($is_exist){
                        $cfile2 = File::find($child->file_id);
                        $newProduct2 = $cfile2->replicate();
                        $newProduct2->file_parent_id = $newProduct1->file_id;
                    	$newProduct2->file_date_modified = strtotime(Carbon::now());
                    	$newProduct2->is_copied_moved = 1;
                        if($newProduct2->save()){
							
							$layer=$is_exist->layer;
							$n_layer='doc_'.Session::get('client_id').date('his');
							$this->copy_layer($cfile2->pspdf_file_id,$layer,$n_layer);
							
                            $downloadObj = new Download(); 
                            $downloadObj->download_client_id = Session::get('client_id');
                            $downloadObj->download_file_id = $newProduct2->file_id;
                            $downloadObj->download_date = strtotime(Carbon::now());
							$downloadObj->layer = $n_layer;
                            $downloadObj->save();
                        
                        	$this->getAllParents($newProduct2->file_id,'add');
                     /** Replicate Annotation start **/
                    	$annotation = Annotation::where('annotation_file_id',$cfile2->file_id)->where('annotation_client_id',Session::get('client_id'))->first();
                    	if($annotation){
                    		$rep_annot = $annotation->replicate();
                        	$rep_annot->annotation_file_id = $newProduct2->file_id;
                			$rep_annot->annotation_date = strtotime(Carbon::now());
                			$rep_annot->save();
                        }
                    /** Replicate Annotation end **/
                    /** Replicate Bookmarked start **/
                    	$bookmark = Bookmark::where('bookmarked_file_id',$cfile2->file_id)->where('bookmarked_client_id',Session::get('client_id'))->first();
                    	if($bookmark){
                    		$book = $bookmark->replicate();
                        	$book->bookmarked_file_id = $newProduct2->file_id;
                			$book->bookmarked_date = strtotime(Carbon::now());
                			$book->save();
                        }
                    /** Replicate Bookmarked end **/    
                    /** Replicate Tagstatus start **/
                    	$tagstatus = Tagstatus::where('file_id',$cfile2->file_id)->where('client_id',Session::get('client_id'))->first();
                    	if($tagstatus){
                    		$tag = $tagstatus->replicate();
                        	$tag->file_id = $newProduct2->file_id;
                			$tag->save();
                        }
                    /** Replicate Tagstatus end **/
                    /** Replicate Overlay start **/
                    	$overlay = Pdf_file_overlay::where('file_id',$cfile2->file_id)->first();
                    	if($overlay){
                    		$ovr = $overlay->replicate();
                        	$ovr->file_id = $newProduct2->file_id;
                			$ovr->save();
                        }
                    /** Replicate overlay end **/
                        }
                    }
                }
            }
        }
        return true;
    }

    public function replicateMovedFolder($id,$pid,$count,$sufix=false){
        $cfile1 = File::find($id);
        $tofile1 = File::find($pid);
        $newProduct1 = $cfile1->replicate();
    	if($count == 1){
        if($sufix){
			if (strpos($cfile1->file_name,' - (') !== false) { //first we check if the url contains the string 'en-us'
    			$arr_fname = explode('-',$cfile1->file_name);
            	$newProduct1->file_name = $arr_fname[0].' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
			}else{
    			$newProduct1->file_name = $cfile1->file_name.' - ('.date('M d, Y H:i, A', strtotime(Carbon::now())).')';
        	}
        }else{
        	$newProduct1->file_name = $cfile1->file_name;
        }
        }
        $newProduct1->file_parent_id = $pid;
        $newProduct1->job_id = $tofile1->job_id;
        $newProduct1->file_date_modified = strtotime(Carbon::now());
        $newProduct1->is_copied_moved = 1;
        $newProduct1->save();
        
        $childrens = File::where('file_parent_id',$cfile1->file_id)->get();
        
        if(count($childrens) > 0){
            foreach ($childrens as $ckey => $child) {
                if($child->file_type == 1){
                    $this->replicateMovedFolder($child->file_id,$newProduct1->file_id,0);
                }else{
                    $is_exist = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$child->file_id)->first();
                    if($is_exist){
                        $is_exist->delete();
                    	$this->getAllParents($child->file_id,'add');
                        $cfile2 = File::find($child->file_id);
                        $newProduct2 = $cfile2->replicate();
                        $newProduct2->file_parent_id = $newProduct1->file_id;
                        $newProduct2->job_id = $tofile1->job_id;
                    	$newProduct2->file_date_modified = strtotime(Carbon::now());
                        $newProduct2->is_copied_moved = 1;
                        if($newProduct2->save()){
							$layer=$is_exist->layer;
						$n_layer='doc_'.Session::get('client_id').date('his');
						$this->copy_layer($cfile2->pspdf_file_id,$layer,$n_layer);
                            $downloadObj = new Download(); 
                            $downloadObj->download_client_id = Session::get('client_id');
                            $downloadObj->download_file_id = $newProduct2->file_id;
                            $downloadObj->download_date = strtotime(Carbon::now());
							$downloadObj->layer = $n_layer;
                            $downloadObj->save();
                        
                        	$this->getAllParents($newProduct2->file_id,'add');
                        	/** Replicate Annotation start **/
                    	$annotation = Annotation::where('annotation_file_id',$cfile2->file_id)->where('annotation_client_id',Session::get('client_id'))->first();
                    	if($annotation){
                    		$rep_annot = $annotation->replicate();
                        	$rep_annot->annotation_file_id = $newProduct2->file_id;
                			$rep_annot->annotation_date = strtotime(Carbon::now());
                			$rep_annot->save();
                        }
                    /** Replicate Annotation end **/
                    /** Replicate Bookmarked start **/
                    	$bookmark = Bookmark::where('bookmarked_file_id',$cfile2->file_id)->where('bookmarked_client_id',Session::get('client_id'))->first();
                    	if($bookmark){
                    		$book = $bookmark->replicate();
                        	$book->bookmarked_file_id = $newProduct2->file_id;
                			$book->bookmarked_date = strtotime(Carbon::now());
                			$book->save();
                        }
                    /** Replicate Bookmarked end **/    
                    /** Replicate Tagstatus start **/
                    	$tagstatus = Tagstatus::where('file_id',$cfile2->file_id)->where('client_id',Session::get('client_id'))->first();
                    	if($tagstatus){
                    		$tag = $tagstatus->replicate();
                        	$tag->file_id = $newProduct2->file_id;
                			$tag->save();
                        }
                    /** Replicate Tagstatus end **/
                    /** Replicate Overlay start **/
                    	$overlay = Pdf_file_overlay::where('file_id',$cfile2->file_id)->first();
                    	if($overlay){
                    		$ovr = $overlay->replicate();
                        	$ovr->file_id = $newProduct2->file_id;
                			$ovr->save();
                        }
                    /** Replicate overlay end **/
                        }
                    }
                }
            }
        }
        return true;
    }
    
	/*deependra*/
	function examination_schedule(Request $request,$whchjobs=false)
	{
		$my_notifications = $this->getNotifications();
		if($whchjobs){
			$request->session()->put('job_id',$whchjobs);
		}
		$whchjobs = Session::get('job_id');
		$active_job = Job::find(Session::get('job_id'));
		$job_id = Session::get('jobs');
		$alljobs = explode(',', $job_id); 
		$jobs = Job::whereIn('job_id',$alljobs)->get();
		$arr_bread[] = 'Examination Schedule';
		$arr_bread_bk[0]['file_id'] = ''; 
        $arr_bread_bk[0]['filename'] = 'Examination Schedule';
	    $all_witness=Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->orderBy('list_order','ASC')->get()->toArray();
  
		return view('clients.examination_schedule',['active_job'=>$active_job,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'all_witness'=>$all_witness,'request'=>$request]);
	}


	public function examination_schedule_inner(Request $request,$whchjobs=false){
		$my_notifications = $this->getNotifications();
    
		if($whchjobs){
			$request->session()->put('job_id',$whchjobs);
		}
		$whchjobs = Session::get('job_id');
		$active_job = Job::find(Session::get('job_id'));
		$all_nods = [];
		$arr_nods_move = [];
        $all_nods_move = [];
		$job_id = Session::get('jobs');
		$alljobs = explode(',', $job_id); 
		$jobs = Job::whereIn('job_id',$alljobs)->get();
		$arr_bread[] = 'Examination Schedule';
		$arr_bread_bk[0]['file_id'] = ''; 
        $arr_bread_bk[0]['filename'] = 'Examination Schedule';
		$all_witness=Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->orderBy('list_order','ASC')->get()->toArray();
		return view('clients.examination_schedule_inner',['active_job'=>$active_job,'all_nods'=>$all_nods,'all_nods_move'=>$all_nods_move,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'all_witness'=>$all_witness]);
	}


	public function create_witness(Request $request){
		$validator=Validator::make($request->all(),['witness_name'=>'required']);
		if($validator->passes())
		{
			$all_witness=Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->orderBy('list_order','ASC')->get()->toArray();
			$witnes= new Witnes();
			$witnes->client_id=Session::get('client_id');
			$witnes->witness_name=$request->witness_name;
			$witnes->job_id=Session::get('job_id');
			$witnes->list_order=sizeof($all_witness)+1;
			$witnes->created_at=strtotime(Carbon::now());
			$witnes->updated_at=strtotime(Carbon::now());
			$witnes->save();
			$arr=array('status'=>'true','message'=>'Witnes Successfully Added','reload'=>asset('clients/examination_schedule_inner/'.Session::get('job_id')));
		}
		else 
		{
			$arr=array('status'=>'false','message'=>$validator->errors()->all());
		}
		echo json_encode($arr);
	}

	public function modify_witness(Request $request){
			$witnes = Witnes::where('id',$request->witness_id)->first();
			$witnes->client_id=Session::get('client_id');
			$witnes->witness_name=$request->witness_name;
			$witnes->job_id=Session::get('job_id');
			$witnes->updated_at=strtotime(Carbon::now());
			$witnes->update();
			$arr=array('status'=>'true','message'=>'Witnes Successfully modifyed','reload'=>asset('clients/examination_schedule_inner/'.Session::get('job_id')));
	
		echo json_encode($arr);
	}

	public function delete_witness(Request $request){
		if($request->id)
		{	
			$ids=$request->id;
			for($i=0;$i<sizeof($ids);$i++)
			{
				$Witnes=Witnes::where('id',$ids[$i])->first();
				echo $Witnes->delete();
				
				$is_exist = Witness_file::where("witness_id",$ids[$i])->delete();
				
				
				
			}
		}
	}

	public function change_order(Request $request){
		 if($request->id)
		 {
			for($i=0;$i<=sizeof($request->id);$i++)
			{
				$witnes = Witnes::where('id',$request->id[$i])->get()->first();
				$witnes->list_order=$i;
				$witnes->update();
			}
		 }
	}

	public function manage_docs(Request $request,$witness_id,$whchjobs=false)
	{
		$my_notifications = $this->getNotifications();
		if($whchjobs){
			$request->session()->put('job_id',$whchjobs);
		}
		$whchjobs = Session::get('job_id');
		$active_job = Job::find(Session::get('job_id'));
		$all_nods = [];
		$all_nods = [];
		$public_path = url('public/images/Folder_32.png');
		$publicfile_path = url('public/images/file-pdf-icon_32.png');
		$url = URL::to('/clients/file/render/');
		$move_icon = url('public/images/move-icon.png');
		
		$arr_nods_move = [];
        $all_nods_move = [];
		$job_id = Session::get('jobs');
		$alljobs = explode(',', $job_id); 
		$jobs = Job::whereIn('job_id',$alljobs)->get();
		$arr_bread[] = 'Examination Schedule';
		$arr_bread_bk[0]['file_id'] = ''; 
        $arr_bread_bk[0]['filename'] = 'Examination Schedule';
		
		$clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
		 }
		 
		$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
         $my_clouds=[];
         $i=0;
		 if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
		}
		if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
					$checked = "name='file_id'";
					$classes_folder = "class='check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
					$classes_file = "class='check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_move["id"] = $my_cloud->file_id;
                    $arr_nods_move["pId"] = $my_cloud->file_parent_id;
					$active_image='';
					if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$active_image = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	
                    	$active_image = url('public/images/image.png');
                    }else{
                    	
                    	$active_image = url('public/images/play.png');
                    }
                    
					if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a id='manage_doc_".$my_cloud->file_id."' onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_move["name"] = "<a id='manage_doc1_".$my_cloud->file_id."' onclick='moveHere(".$my_cloud->file_id.")' class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none;color:lightgreen;'></i></a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                    }else{
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='javascript:;' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
							$arr_nods["name"] = "<a href='javascript:;'  class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$active_image."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";                        
                        }
                        $arr_nods_move["name"] = "<a class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$active_image."'>".ucfirst($my_cloud->file_name)."</a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
    
                    $arr_nods_move["open"] = false;
   
   }
                    $all_nods[] = $arr_nods;
                    $all_nods_move[] = $arr_nods_move;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_move = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
		$all_witness_file=Witness_file::select(['witness_file.*','files.file_name','files.file_upload_name'])->where('witness_id',$witness_id)->join('files','witness_file.doc_id','=','files.file_id')->orderBy('list_order','ASC')->get()->toArray();
		return view('clients.manage_docs',['active_job'=>$active_job,'all_nods'=>$all_nods,'all_nods_move'=>$all_nods_move,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'all_witness_file'=>$all_witness_file]);
	}
	
	public function manage_docs_copy(Request $request,$witness_id,$whchjobs=false)
	{
		$my_notifications = $this->getNotifications();
		if($whchjobs){
			$request->session()->put('job_id',$whchjobs);
		}
		$whchjobs = Session::get('job_id');
		$active_job = Job::find(Session::get('job_id'));
		$all_nods = [];
		$all_nods = [];
		$public_path = url('public/images/Folder_32.png');
		$publicfile_path = url('public/images/file-pdf-icon_32.png');
		$url = URL::to('/clients/file/render/');
		$move_icon = url('public/images/move-icon.png');
		
		$arr_nods_move = [];
        $all_nods_move = [];
		$job_id = Session::get('jobs');
		$alljobs = explode(',', $job_id); 
		$jobs = Job::whereIn('job_id',$alljobs)->get();
		$arr_bread[] = 'Examination Schedule';
		$arr_bread_bk[0]['file_id'] = ''; 
        $arr_bread_bk[0]['filename'] = 'Examination Schedule';
		
		$clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
		 }
		 
		$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
         $my_clouds=[];
         $i=0;
		 if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
		}
		if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
					$checked = "name='file_id'";
					$classes_folder = "class='check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
					$classes_file = "class='check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_move["id"] = $my_cloud->file_id;
                    $arr_nods_move["pId"] = $my_cloud->file_parent_id;
					$active_image='';
					if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$active_image = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	
                    	$active_image = url('public/images/image.png');
                    }else{
                    	
                    	$active_image = url('public/images/play.png');
                    }
                    
					if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a id='manage_doc_".$my_cloud->file_id."' onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_move["name"] = "<a id='manage_doc1_".$my_cloud->file_id."' onclick='moveHere(".$my_cloud->file_id.")' class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none;color:lightgreen;'></i></a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                    }else{
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='javascript:;' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
							$arr_nods["name"] = "<a href='javascript:;'  class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$active_image."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkfile(this)' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";                        
                        }
                        $arr_nods_move["name"] = "<a class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$active_image."'>".ucfirst($my_cloud->file_name)."</a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
    
                    $arr_nods_move["open"] = false;
   
   }
                    $all_nods[] = $arr_nods;
                    $all_nods_move[] = $arr_nods_move;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_move = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
		$all_witness_file=Witness_file::select(['witness_file.*','files.file_name','files.file_upload_name'])->where('witness_id',$witness_id)->join('files','witness_file.doc_id','=','files.file_id')->orderBy('list_order','ASC')->get()->toArray();
		return view('clients.manage_docs_copy',['active_job'=>$active_job,'all_nods'=>$all_nods,'all_nods_move'=>$all_nods_move,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk,'whchjobs'=>$whchjobs,'notifications'=>$my_notifications,'all_witness_file'=>$all_witness_file]);
	}
	public function examination_schedule_render($id,$witness,Request $request)
	{
		
		 $page=1;
		 if($request->session()->has('client_id')){
        
        //$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$id)->get()->toArray()[0]['download_id'];
		$download_id=Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$id)->get()->toArray();
		if(isset($download_id[0]['download_id']))
		{
			$layer_toke=$download_id[0]['layer'];
		$download_id=$download_id[0]['download_id'];
		
        $myjobs = Session::get('jobs');
        $arr_myjobs = explode(',', $myjobs);

        $jobs = Job::where('job_id',$myjobs)->get();
      /*  print_r($jobs);
        die();*/
        $arr_group_ids = [];
        if(count($jobs) > 0){
            foreach ($jobs as $jobkey => $job) {
                $grp_ids = explode(',', $job->group_id);
                if(count($grp_ids) > 0){
                    foreach ($grp_ids as $grpkey => $grp) {
                        if(!in_array($grp, $arr_group_ids)){
                            $arr_group_ids[] = $grp;
                        }
                    }
                }
            }
        }

        $arr_client_ids = [];
        if(count($arr_group_ids) > 0){
            /*print_r($arr_group_ids);
            die();*/
            $groups = Group::whereIn('group_id',$arr_group_ids)->get()->toArray();

            //$my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.Session::get('job_id').',`job_id`) order by `file_type` ASC');
          /*  foreach($groups as $gp)
            {
                $c1=$gp['client_id']
            }*/
            $grp=array();
            foreach($groups as $gp)
            {
                $go1 = DB::select('select * from `groups` where `group_id` = '.$gp['group_id'].' and FIND_IN_SET('.Session::get('client_id').',`client_id`)');
                if(isset($go1[0]))
                {
                    $grp[]=$go1[0];
                }
            }
           /* echo "<pre>";
            print_r($grp);
            die();*/
            foreach ($grp as $groupkey => $group) {
                $client_ids = explode(',', $group->client_id);
                if(count($client_ids) > 0){
                    foreach ($client_ids as $clkey => $clnt) {
                        if(!in_array($clnt, $arr_client_ids) && Session::get('client_id') != $clnt){
                            $arr_client_ids[] = $clnt;
                        }
                    }
                }
            }
        }
        $clients = [];
        if(count($arr_client_ids) > 0){
            $clients = Client::whereIn('client_id',$arr_client_ids)->get();
        }
        
        
        $my_notifications = $this->getNotifications();
        $file = File::where('file_id',$id)->first();
        if($file){
            $annot = Annotation::where('annotation_client_id',Session::get('client_id'))->where('annotation_file_id',$id)->first();

            if($annot){
                $annotJson = $annot->annotation_data;
            }else{
                $annotJson = [];
            }

            $book = Bookmark::where('bookmarked_client_id',Session::get('client_id'))->where('bookmarked_file_id',$id)->first();

            if($book){
                $bookJson = $book->bookmarked_data;
            }else{
                $bookJson = [];
            } 
            
            $my_DFile = Download::where('download_client_id',Session::get('client_id'))->orderBy('download_date','desc')->get();

            $arr_Dfiles = [];
            $myFiles = '';
            if(count($my_DFile) > 0){
                foreach ($my_DFile as $key => $Dfile) {
                    $arr_Dfiles[] = $Dfile->download_file_id;
                }
            }
            $myFiles = File::whereIn('file_id',$arr_Dfiles)->orderBy('file_date_modified','desc')->get();
        }


        /** MyFIles For Ztree **/
        // $my_notifications = $this->getNotifications();
        //     $job_id = Session::get('jobs');
        //     $alljobs = explode(',', $job_id); 
            
        //     $jobs = Job::whereIn('job_id',$alljobs)->get();
        //     if($alljobs[0] && $whchjobs==false){
        //         $whchjobs = $alljobs[0];
        //     }

            /*get downloaded files here*/
            $arr_my_dfiles=[];
           $clientid = Session::has('client_id') ? Session::get('client_id') : '';
           $AllMyFiles = Download::where('download_client_id',$clientid)->get();
           $arr_my_dfiles[]=array();
           if($AllMyFiles){
               foreach ($AllMyFiles as $myfile){
                   $arr_my_dfiles[] = $myfile->download_file_id;
               }
           }

            /**for breadcrumb**/
            $arr_bread[] = 'Home';

            $arr_bread_bk[0]['file_id'] = ''; 
            $arr_bread_bk[0]['filename'] = 'Home';

       $clientId=$request->session()->get('client_id');
         $downloadedFiles=Download::where('download_client_id',$clientId)->get();
         $downloadedFilesId=[];
         if(count($downloadedFiles) > 0){
         foreach($downloadedFiles as $key=>$downloadedFile)
          {
            $downloadedFilesId[$key]=$downloadedFile->download_file_id;
          }
         }
		 
		 
		 $w_files=Witness_file::where('witness_id',$witness)->get()->toArray();
		 $w_count=0;
		 $w_con='';
		 foreach($w_files as $wf)
		 {
			 if($w_count==0)
				 $w_con=' file_id='.$wf['doc_id'];
			 else 
				 $w_con.=' OR file_id='.$wf['doc_id'];
		 $w_count++;
		 }
         $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and '.$w_con.' order by `file_type` ASC');
		
         $my_clouds=[];
         $i=0;
         if(count($my_files) > 0){
         foreach($my_files as $key=>$my_file)
          {
            $this->arr_merge=[];

            if($my_file->file_type==1)
             {
                 $this->getFilesId($my_file->file_id);
          

                 foreach($this->arr_merge as $fileId)
                  {
                    if(in_array($fileId,$downloadedFilesId))
                     {
                        $my_clouds[$i]=$my_file;
                        $i++;
                        break;
                     }
                  }
                  
             }
            else
              {
                if(in_array($my_file->file_id,$downloadedFilesId))
                   {
                    $my_clouds[$i]=$my_file;
                    $i++;
                   } 
              }
          }
        }

        // set downloads recursive data to session for using filter in my files
        if(count($my_clouds) > 0){
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files',$my_clouds);
        }else{
            $request->session()->forget('downloaded_recursive_files');
            $request->session()->put('downloaded_recursive_files','');
        }

        $final_parents = [];
        $final_clouds = [];
        if(count($my_clouds) > 0){
            foreach ($my_clouds as $mkey => $check) {
                $final_parents[] = $check->file_parent_id;
            }
        }

        if(count($final_parents) > 0){
            foreach ($my_clouds as $mkey => $mycloud) {
                if($mycloud->file_type == 1){
                    if(in_array($mycloud->file_id,$final_parents)){
                        $final_clouds[] = $mycloud->file_id;
                    }
                }else{
                        $final_clouds[] = $mycloud->file_id;
                }
            }
        }


        $my_clouds = File::whereIn('file_id',$final_clouds)->get();        

            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            $arr_nods_dd = [];
            $all_nods_dd = [];
            $all_add_to_links = [];
            if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);
                	if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'){
                    	$targetclick = 'popupwindow("'.$target.'","doc")';
                    	$publicfile_path = url('public/images/doc.png');
                    }elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'){
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/image.png');
                    }else{
                    	$targetclick = 'popupwindow("'.$target.'","img")';
                    	$publicfile_path = url('public/images/play.png');
                    }
                	
					$ly_info=Download::select('layer')->where('download_client_id',Session::get('client_id'))->where('download_file_id',$my_cloud->file_id)->get()->first();  
                	$contactclick = 'addContact('.$my_cloud->file_id.',"'.$my_cloud->file_name.'","'.$ly_info->layer.'")'; 

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_dd["id"] = $my_cloud->file_id;
                    $arr_nods_dd["pId"] = $my_cloud->file_parent_id;
                    
                    $add_to_link["id"] = $my_cloud->file_id;
                    $add_to_link["pId"] = $my_cloud->file_parent_id;
                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a  onclick='nodefiless(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_dd["name"] = "<a class='add-contact' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $add_to_link["name"] = "<a class='add-contact nodefile' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."</a><p style='top:5px; margin-left: 75px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }else{
                    		
                        	
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck' data-file_id='".$my_cloud->file_id."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        $add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='nodefile add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        
                        	$arr_nods_dd["name"] = "<a onclick='".$contactclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".url('public/images/file-pdf-icon_32.png')."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                            
                        }else{
                        	$arr_nods["name"] = "<a onclick='".$targetclick."' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."' onchange='checkmyfile()' class='nodefile filecheck' data-file_id='".$my_cloud->file_id."' style='float:right'><p style='margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
							$add_to_link["name"] = "<a onclick='add_to_link(".$my_cloud->file_id.")' class='nodefile add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick checklink checklink_".$my_cloud->file_id." tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p style='top:5px; margin-left: 56px;color: #ccc;position: relative;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        	
                        	$arr_nods_dd["name"] = "<a onclick='".$targetclick."' class='add-contact-".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none'></i></a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        }	
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_dd["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_dd[] = $arr_nods_dd;
                    $all_add_to_links[] = $add_to_link;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_dd = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
        $this->arr_merge=[];
        $all_issue=$this->get_all_issue();
      /*  if($file->pspdf_file_id)
        {
          $all_annotation= $this->get_annotation($file->pspdf_file_id);
          if(isset($all_annotation['data']['annotations']))
          {
       
       			foreach($all_annotation['data']['annotations'] as $an)
                {
                	 $this->delete_annotation($file->pspdf_file_id,$an['id']);
                }
          }
       
        }*/
        $pdf_overlay_info = Pdf_file_overlay::where('user_id',Session::get('client_id'))->where('file_id',$id)->where('status','0')->get()->toArray();
          if($pdf_overlay_info)
          {
                foreach($pdf_overlay_info as $po)
                {
                    $pdf_resp = Pdf_file_overlay::where('id',$po['id'])->get()->first();    
                    if($pdf_resp)
                    {
                        $pdf_resp->delete();
                    }
                }
                
           } 
            $all_witness=Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->orderBy('list_order','ASC')->get()->toArray();
        	return view('clients.examination_schedule_render',['download_id'=>$download_id,'client_id'=>Session::get('client_id'),'clients'=>$clients,'myFiles'=>$myFiles,'file'=>$file,'annotJson'=>$annotJson,'bookJson'=>$bookJson,'id'=>$id,'notifications'=>$my_notifications,'all_nods'=>$all_nods,'all_nods_dd' => $all_nods_dd,'page'=>$page,'all_issue'=>json_decode(json_encode(json_decode($all_issue)),true),'all_add_to_links'=>$all_add_to_links,'layer_token'=>$layer_toke,'all_witness'=>$all_witness,'page_status'=>'1']);
		  }
		  else 
		  {
			  $my_notifications = $this->getNotifications();
			  return view('not_found',['notifications'=>$my_notifications,'page_status'=>'0']);
		  }
        }else{
            return redirect('/clients/login');
        }
	}
	public function add_to_witness(Request $request,$wid){
		if($request->arr_fileid){
            foreach ($request->arr_fileid as $fkey => $fileidd) {
            	
				$is_exist = Witness_file::where("witness_id",$wid)->where("doc_id",$fileidd)->first();
                $is_exist1 = Witness_file::where("witness_id",$wid)->where("doc_id",$fileidd)->get()->toArray();
				if(!$is_exist){
					$wfile = new Witness_file(); 
					$wfile->witness_id = $wid;
					$wfile->doc_id = $fileidd;
                    $wfile->list_order = sizeof($is_exist1)+1;
					$wfile->created_at = strtotime(Carbon::now());
					$wfile->updated_at=strtotime(Carbon::now());
					$wfile->save();
				}
            }

            $activitylogObj = new Activitylog();
            $action = 'New File Add On Witness';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type);

            $arr = array('message' => 'Files Successfully Added', 'title' => 'Added');
        }else{
            $arr = array('message' => 'Somthing went wrong', 'title' => 'error..');
        }
        echo json_encode($arr);
	}
	
	
	
	public function get_witness_file($request,$witness_id,$whchjobs){
			
			/*get downloaded files here*/
			$arr_my_dfiles=[];
		   if($whchjobs){
				$request->session()->put('job_id',$whchjobs);
			}
			$whchjobs = Session::get('job_id');
			
		   $AllMyFiles = Witness_file::where('witness_id',$witness_id)->get();
		   $arr_my_dfiles[]=array();
		   if($AllMyFiles){
			   foreach ($AllMyFiles as $myfile){
				   $arr_my_dfiles[] = $myfile->doc_id;
			   }
		   }

			/**for breadcrumb**/
	  
		 $downloadedFiles=Witness_file::where('witness_id',$witness_id)->get();
		 $downloadedFilesId=[];
		 if(count($downloadedFiles) > 0){
		 foreach($downloadedFiles as $key=>$downloadedFile)
		  {
			$downloadedFilesId[$key]=$downloadedFile->doc_id;
		  } 
		 }
		 $my_files = DB::select('select * from `files` where `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
	 //    $my_files = File::where('file_parent_id',0)->where('file_shared',1)->where('file_status',1)->where('job_id',$whchjobs)->orderBy('file_type','asc')->orderBy('file_name','asc')->get();
		 $my_clouds=[];
		 $i=0;
		 if(count($my_files) > 0){
		 foreach($my_files as $key=>$my_file)
		  {
			$this->arr_merge=[];

			if($my_file->file_type==1)
			 {
				 $this->getFilesId($my_file->file_id);
		  

				 foreach($this->arr_merge as $fileId)
				  {
					if(in_array($fileId,$downloadedFilesId))
					 {
						$my_clouds[$i]=$my_file;
						$i++;
						break;
					 }
				  }
				  
			 }
			else
			  {
				if(in_array($my_file->file_id,$downloadedFilesId))
				   {
					$my_clouds[$i]=$my_file;
					$i++;
				   } 
			  }
		  }
		}

		// set downloads recursive data to session for using filter in my files
		if(count($my_clouds) > 0){
			$request->session()->forget('downloaded_recursive_files');
			$request->session()->put('downloaded_recursive_files',$my_clouds);
		}else{
			$request->session()->forget('downloaded_recursive_files');
			$request->session()->put('downloaded_recursive_files','');
		}

		$final_parents = [];
		$final_clouds = [];
		if(count($my_clouds) > 0){
			foreach ($my_clouds as $mkey => $check) {
				$final_parents[] = $check->file_parent_id;
			}
		}

		if(count($final_parents) > 0){
			foreach ($my_clouds as $mkey => $mycloud) {
				if($mycloud->file_type == 1){
					if(in_array($mycloud->file_id,$final_parents)){
						$final_clouds[] = $mycloud->file_id;
					}
				}else{
						$final_clouds[] = $mycloud->file_id;
				}
			}
		}


		$my_clouds = File::whereIn('file_id',$final_clouds)->orderBy('file_type', 'asc')->get();

		$arr_nods = [];
			$all_nods = [];
			$public_path = url('public/images/Folder_32.png');
			$publicfile_path = url('public/images/file-pdf-icon_32.png');
			$url = URL::to('/clients/file/render/');
			$move_icon = url('public/images/move-icon.png');

			$arr_nods_move = [];
			$all_nods_move = [];

			if(count($my_clouds) > 0){
                foreach ($my_clouds as $mkey => $my_cloud) {
					$checked = "name='file_id'";
					$classes_folder = "class='witness_file check_file_cls nodefile filecheck main-checkbox-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."'";
					$classes_file = "class='witness_file check_file_cls nodefile filecheck sub-checkbox-".$my_cloud->file_parent_id." sub-checkbox-".$my_cloud->file_id."'";
                	$file_extension = strtolower(substr(strrchr($my_cloud->file_upload_name, "."), 1));
                	$target = url('public/storage/files/'.$my_cloud->file_upload_name);

                    $arr_nods["id"] = $my_cloud->file_id;
                    $arr_nods["pId"] = $my_cloud->file_parent_id;

                    $arr_nods_move["id"] = $my_cloud->file_id;
                    $arr_nods_move["pId"] = $my_cloud->file_parent_id;

                    if($my_cloud->file_type == 1){
                        $arr_nods["name"] = "<a onclick='nodefile(".$my_cloud->file_id.")' class='nodefile' data-file_id='".$my_cloud->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                        $arr_nods_move["name"] = "<a onclick='moveHere(".$my_cloud->file_id.")' class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img style='width:25px; margin:5px' src='".$public_path."'>".ucfirst($my_cloud->file_name)."<i class='fa fa-check tick tickmark_".$my_cloud->file_id."' style='display:none;color:lightgreen;'></i></a><p class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";

                    }else{
                    	if($file_extension == 'pdf'){
                        	$arr_nods["name"] = "<a href='javascript:;' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input type='checkbox' id='checkmyfile-".$my_cloud->file_id."' value='".$my_cloud->file_id."'  class='check_file_cls nodefile filecheck  checkmyfile-".$my_cloud->file_id." sub-checkbox-".$my_cloud->file_parent_id."' data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."'><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                        }else{
							$arr_nods["name"] = "<a href='javascript:;'  class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)." <i class='fa fa-check facheck facheck-".$my_cloud->file_id."' style='color:lightgreen;font-size:larger;display:none;'></i></a><input  type='checkbox'  id='check-".$my_cloud->file_id."' value='".$my_cloud->file_id."' ".$classes_file." data-file_id='".$my_cloud->file_id."' data-file_type='".$my_cloud->file_type."' ".$checked."><p style='color: #ccc;position: relative;margin-left: 26px;'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";                        
                        }
                        $arr_nods_move["name"] = "<a class='from_file from_file_".$my_cloud->file_id."' data-fileid='".$my_cloud->file_id."' data-filename='".$my_cloud->file_name."'><img width='25' src='".$publicfile_path."'>".ucfirst($my_cloud->file_name)."</a><p  class='dir_date_dd'>".$this->formatSizeUnits($my_cloud->file_size)." - ".date('M d, Y H:i, A', $my_cloud->file_date_modified)."</p>";
                    }
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = false;
                        $arr_nods_move["open"] = false;
                    }
                    $all_nods[] = $arr_nods;
                    $all_nods_move[] = $arr_nods_move;
                }
            }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
                $all_nods_move = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No Folder & File downloaded yet</strong>');
            }
		  $return_arr=array('all_nods'=>$all_nods,'all_nods_move'=>$all_nods_move);
		  return $return_arr;
	}


	
function delete_witness_file(Request $request,$wid)
	{
		$ids=$request->ids;	
		for($i=0;$i<sizeof($ids);$i++)
		{
			$file=Witness_file::where(["id"=>$ids[$i]])->first();
			$file->delete();
		}
	}


	function copy_witness(Request $request)
	{
		$validator=Validator::make($request->all(),['witness_name'=>'required']);
		if($validator->passes())
		{  
			$all_witness=Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->orderBy('list_order','ASC')->get()->toArray();
			$witnes= new Witnes();
			$witnes->client_id=Session::get('client_id');
			$witnes->witness_name=$request->witness_name;
			$witnes->job_id=Session::get('job_id');
			$witnes->list_order=sizeof($all_witness)+1;
			$witnes->created_at=strtotime(Carbon::now());
			$witnes->updated_at=strtotime(Carbon::now());
			$witnes->save();
			 $request->witness_old_id;
			$all_files=Witness_file::where('witness_id',$request->witness_old_id)->get()->toArray();
			
			if($all_files)
			{
				foreach($all_files as $file)
				{
					$wfile = new Witness_file(); 
					$wfile->witness_id = $witnes->id;
					$wfile->doc_id = $file['doc_id'];
					$wfile->created_at = strtotime(Carbon::now());
					$wfile->updated_at=strtotime(Carbon::now());
					$wfile->save();
				}
			}
			$arr=array('status'=>'true','message'=>'Witnes Successfullay Copy','reload'=>asset('clients/examination_schedule_inner/'.Session::get('job_id')));
		}
		else 
		{
			$arr=array('status'=>'false','message'=>$validator->errors()->all());
		}
		echo json_encode($arr);
	}

	function Modify_files(Request $request)
	{
		$is_exist = Witness_file::where("witness_id",$request->wid)->where("doc_id",$request->new_file)->get()->toArray();
			if(!$is_exist)
			{
				$wfile=Witness_file::where(['id'=>$request->old_file])->first();
				$wfile->doc_id = $request->new_file;
				$wfile->update();
				$arr=array('status'=>'true','message'=>'File Successfully Modify');
			}
			else 
			{
				$arr=array('status'=>'false','message'=>'File Already Exists');
			}
			echo json_encode($arr);
	}
	
	function change_order_docs(Request $request)
	{
		if($request->id)
		{
			for($i=0;$i<sizeof($request->id);$i++)
			{
            	$i1=$i;
				$witnes = Witness_file::where('id',$request->id[$i])->get()->first();
				$witnes->list_order=$i1+1;
				echo $witnes->update();
			}
		}
	}

public function search_witness_and_file(Request $request)
	{
		if($request->value!='')
		{
			$files=DB::select("SELECT witness_file.*,files.file_upload_name,files.file_name,witness.client_id,witness.job_id,witness.witness_name FROM witness_file INNER JOIN files ON witness_file.doc_id = files.file_id INNER JOIN witness ON witness_file.witness_id = witness.id WHERE (witness.client_id =".Session::get('client_id')." AND  witness.job_id = ".Session::get('job_id').") AND  (files.file_name LIKE '%$request->value%' OR  witness.witness_name LIKE '%$request->value%')");
    			// echo $files = DB::select('witness_file.*,files.file_upload_name,files.file_name,witness.client_id,witness.job_id,witness.witness_name')
    			// ->join('files', 'files.file_id', '=', 'witness_file.doc_id')
    			// ->join('witness', 'witness.id', '=', 'witness_file.witness_id')
    			// ->where('witness.client_id', '=', Session::get('client_id'))
    			// ->where('witness.job_id', '=', Session::get('job_id'))
    			// ->where('files.file_name', 'LIKE', '%$request->value%')
    			// ->orWhere('witness.witness_name', 'LIKE', '%$request->value%')
    			// ->toSql();
        	
		}
		else 
		{
			$files=DB::select("SELECT witness_file.*,files.file_upload_name,files.file_name,witness.client_id,witness.job_id,witness.witness_name,witness_file.witness_id FROM witness_file JOIN files ON witness_file.doc_id = files.file_id JOIN witness ON witness_file.witness_id =witness.id WHERE (witness.client_id =".Session::get('client_id')." AND  witness.job_id = ".Session::get('job_id').")");
		}
	
		$new_arr=array();
		foreach($files as $f1)
		{
			$file=(array) $f1;
			$new_arr[$file['witness_name']][]=$file;
		}
		//print_r($new_arr);

$all_witness=$new_arr;
if($all_witness) {

foreach($all_witness as $key => $files) { ?>
<h3><?php echo $key ?></h3> 

<div class="<?php if(!$files) { ?> custom_class <?php } ?>">
<?php 
	if($files) { ?>
	  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>SNo.</th>
                <th>File Name</th>
            	<th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=0;  foreach($files as $f1) { 
		 $color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$f1['doc_id']);  
         $file_extension = strtolower(substr(strrchr($f1['file_upload_name'], "."), 1));
        ?>
        <tr>
			<td><?php echo $i=$i+1 ?></td>
        	<?php if($file_extension == 'pdf') { ?>
         <td><a href="<?php echo asset('clients/examination_schedule_render/'.$f1['doc_id'].'/'.$f1['witness_id']) ?>"><div style="width:100%;color:cornflowerblue"><span style="background:<?php echo $color ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo asset('public/images/file-pdf-icon_32.png') ?>"> <?php echo $f1['file_name'] ?></div></a></td>
         <td><a href="#" data-id="<?php echo $f1['doc_id'] ?>" onclick="getTags1(<?php echo $f1['doc_id'] ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo asset('public/frontend/img/ColorPicker1.png') ?>" height="23" width="23"></a></td> 
        <?php } else if($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg') { ?>
        <td onclick="popupwindow('<?php echo   $url ?>','doc')"><a href="javascript:;"><div style="width:100%;color:cornflowerblue"><span style="background:<?php echo $color ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo url('public/images/image.png') ?>"> <?php echo $f1['file_name'] ?></div></a></td>
         <td><a href="#" data-id="<?php echo $f1['doc_id'] ?>" onclick="getTags1(<?php echo $f1['doc_id'] ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo asset('public/frontend/img/ColorPicker1.png') ?>" height="23" width="23"></a></td>
        <?php } else if($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx') { ?>
        <td onclick="popupwindow('<?php echo   $url ?>','doc')"><a href="javascript:;"><div style="width:100%;color:cornflowerblue"><span style="background:<?php echo $color ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo url('public/images/image.png') ?>"> <?php echo $f1['file_name'] ?></div></a></td>
         <td><a href="#" data-id="<?php echo $f1['doc_id'] ?>" onclick="getTags1(<?php echo $f1['doc_id'] ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo asset('public/frontend/img/ColorPicker1.png') ?>" height="23" width="23"></a></td
        <?php } else { ?>
        <td onclick="popupwindow('<?php echo   $url ?>','doc')"><a href="javascript:;"><div style="width:100%;color:cornflowerblue"><span style="background:<?php echo $color ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo url('public/images/image.png') ?>"> <?php echo $f1['file_name'] ?></div></a></td>
         <td><a href="#" data-id="<?php echo $f1['doc_id'] ?>" onclick="getTags1(<?php echo $f1['doc_id'] ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo asset('public/frontend/img/ColorPicker1.png') ?>" height="23" width="23"></a></td
        <?php  } ?>
         
        </tr>
        <?php } ?>
      </tbody>
	</table>
   <?php } else { ?> 
	<h3 align="center">Witness And Files Are Not found</h3>
  <?php } ?>
</div>
<?php } } else { ?>  
	<h3 align="center">Witness And Files Are Not found</h3>
<?php }                               



/*if($files)
			$arr=array('status'=>'true','message'=>'success','data'=>$new_arr);
		else 
			$arr=array('status'=>'false','message'=>'success','data'=>array());
		echo json_encode($arr);*/

	}

	public function search_witness(Request $request)
	{
		if($request->value=='')
			$mode='ALL';
		else 
			$mode='';
		
		if($request->value!='')
		{
			$witnes = Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->Where("witness_name","like","%".$request->value."%")->get()->toArray();
		}
		else 
		{
			$witnes = Witnes::where('client_id',Session::get('client_id'))->where('job_id',Session::get('job_id'))->get()->toArray();
		}
		if($witnes)
			$arr=array('status'=>'true','message'=>'success','data'=>$witnes,'mode'=>$mode);
		else 
			$arr=array('status'=>'false','message'=>'Witnes Not Found');
		echo json_encode($arr);
	}

	public function search_witness_files(Request $request)
	{
		if($request->value=='')
			$mode='ALL';
		else 
			$mode='';
		if($request->value!='')
		{
			$witnes = Witness_file::select(['witness_file.*','files.file_name','files.file_upload_name'])->where('witness_file.witness_id',$request->w_id)->join('files','witness_file.doc_id','=','files.file_id')->Where("files.file_name","like","%".$request->value."%")->orderBy('list_order','ASC')->get()->toArray();
		}
		else 
		{
			$witnes = Witness_file::select(['witness_file.*','files.file_name','files.file_upload_name'])->where('witness_file.witness_id',$request->w_id)->join('files','witness_file.doc_id','=','files.file_id')->orderBy('list_order','ASC')->get()->toArray();
		}
		if($witnes)
			$arr=array('status'=>'true','message'=>'success','data'=>$witnes,'mode'=>$mode);
		else 
			$arr=array('status'=>'false','message'=>'Witnes Not Found');
		echo json_encode($arr);
	}
	public function move_to_witness_file(Request $request)
	{
		$all_witness=Witness_file::where('witness_id',$request->witness)->get()->toArray();
		if($request->new_index > sizeof($all_witness))
		{
			$arr=array('Status'=>'false','message'=>'Please Enter Index Between 1 to '.sizeof($all_witness));
		}
		else if($request->current_index_field==$request->new_index)
		{
			$arr=array('Status'=>'false','message'=>'Please Enter Diffrent Index');
		}
		else 
		{
			$w2=Witness_file::where(['witness_id'=>$request->witness,'list_order'=>$request->new_index])->get()->first();
			if($w2)
            {
        		$w2->list_order=$request->current_index_field;
				$w2->update();
            }
			$w1=Witness_file::where('id',$request->current_id)->get()->first();
        	if($w1)
            {
				$w1->list_order=$request->new_index;
				$w1->update();	
            }
			$arr=array('status'=>'true','message'=>'File Successfullay Moved','reload'=>asset('clients/manage_docs/'.$request->witness.'/'.Session::get('job_id')));			
		}
		echo json_encode($arr);
		
	}
	public function files_goto(Request $request)
	{
		$all_witness=Witness_file::where('witness_id',$request->witness)->orderBy('list_order','desc')->get()->toArray();
		$i=1;
		foreach($all_witness as $w1)
		{
			$w2=Witness_file::where('id',$w1['id'])->get()->first();
			$w2->list_order=$i;
			$w2->update();
			$i++;
		}
		$arr=array('status'=>'true','message'=>'Success','reload'=>asset('clients/manage_docs/'.$request->witness.'/'.Session::get('job_id')));
		echo json_encode($arr);
	}
	function get_doc_by_tagid($tagid,$whchjobs=false)
	{
        /*For apply tag colour*/
        $tagdata = Tag::findOrfail($tagid);
    
    	$whchjobs = Session::get('job_id');

        /** For get files **/
        $tags = Tagstatus::where('client_id',Session::get('client_id'))->where('tag_id',$tagid)->get();
        $arrfiles = [];
        if(count($tags)>0){
            foreach ($tags as $tkey => $tag) {
                $arrfiles[] = $tag->file_id;
            } 
        }

       if(count($arrfiles) > 0){ 
        $my_clouds_str = implode(',', $arrfiles);
        /*echo "<pre>";
        print_r($arrfiles[0]); */  
        //$my_clouds = DB::select('select * from `files` WHERE file_id IN ('.$my_clouds_str.') and `file_shared` = 1 and `file_status` = 1 and FIND_IN_SET('.$whchjobs.',`job_id`) order by `file_type` ASC');
		
		/*$files=DB::select("SELECT witness_file.*,files.file_upload_name,files.file_name,witness.witness_name,witness_file.witness_id FROM witness_file JOIN files ON witness_file.doc_id = files.file_id JOIN witness ON witness_file.witness_id =witness.id WHERE file_id IN ('$my_clouds_str') and `file_shared` = 1 and `file_status` = 1 and witness.job_id = $whchjobs order by `file_type` ASC");*/
        $files=array();
        $files1=DB::select("SELECT witness_file.*,files.file_upload_name,files.file_name,witness.witness_name,witness_file.witness_id FROM witness_file JOIN files ON witness_file.doc_id = files.file_id JOIN witness ON witness_file.witness_id =witness.id WHERE  `file_shared` = 1 and witness.client_id=".Session::get('client_id')." and `file_status` = 1 and witness.job_id = $whchjobs order by `file_type` ASC");  
        //$arrfiles=json_decode(json_encode($arrfiles),true);
        foreach($files1 as $f1)
        {
            for($i=0;$i<sizeof($arrfiles);$i++)
            {
                if($arrfiles[$i]==$f1->doc_id)
                {
                    $files[]=$f1;
                }
            }
            
        }
        /*echo "<pre>";
        print_r($files);*/
		$new_arr=array();
		foreach($files as $f1)
		{
			$file=(array) $f1;
			$new_arr[$file['witness_name']][]=$file;
		}
		if($files)
			$arr=array('status'=>'true','message'=>'success','data'=>$new_arr);
		else 
			$arr=array('status'=>'false','message'=>'success','data'=>array());
		
        }
		else 
		{
			$arr=array('status'=>'false','message'=>'success','data'=>array());
		}
		echo json_encode($arr);
	}

	public function checkFilename($folderid,$fileid){
    	$isexist = 0;
    	$copied_doc = File::where('file_id',$fileid)->first();
    	
    	if($copied_doc->file_type == 2){
    		$children = File::where('file_parent_id',$folderid)->where('file_type',$copied_doc->file_type)->get();
    		if(count($children) > 0){
        	$arr_dfiles = [];
        		foreach($children as $ckey => $child){
            		$downloads = Download::where('download_file_id',$child->file_id)->where('download_client_id',Session::get('client_id'))->exists();
            		if($downloads) { 
            			$arr_dfiles[] = $child->file_id;
    				}
            	}
        	}
        }else{
        	$children = File::where('file_parent_id',$folderid)->where('file_type',$copied_doc->file_type)->get();
        	if(count($children) > 0){
            	$arr_dfiles = [];
            	foreach($children as $ckey => $child){
                	$sub_children_files = File::where('file_parent_id',$child->file_id)->where('file_type',2)->get();
                	foreach($sub_children_files as $sckey => $sub_child){
                    	$downloads = Download::where('download_file_id',$sub_child->file_id)->where('download_client_id',Session::get('client_id'))->exists();
            			if($downloads) { 
            				$arr_dfiles[] = $child->file_id;
    					}
                    }
                }
            }
        }
    	if(count($arr_dfiles) > 0){
        	$files_d = File::whereIn('file_id',$arr_dfiles)->get();
            
        	foreach($files_d as $fkey => $f_d){
            	if (strcmp($copied_doc->file_name, $f_d->file_name) == 0) { 
    				$isexist = $isexist + 1; 
               	}
            }
        }
    	echo $isexist;
    }
   	public function add_activity($text)
	{
		$activitylogObj = new Activitylog();
		$action = 'Add '.$text; 
		$user_type = 'client';
		$activitylogObj->saveActivityLog($action,$user_type);
	}
	public function get_file_token($file_id)
	{
		$isDownloaded = Download::where('download_client_id',Session::get('client_id'))->where('download_file_id',$file_id)->first();
		$file_info = File::where('file_id',$file_id)->first();
		$arr=array('psppdf_file_id'=>$file_info->pspdf_file_id,'layer'=>$isDownloaded->layer,'file_id'=>$file_id);
		echo json_encode($arr);
	}
   public function check_file()
   {
   		/*$file_arr=array('21');
        $this->uploadodfonserver($file_arr);*/
		$this->create_layer('7KPS4GAHK4GGQR4RRRCJBR6KG9',"DOC_101");
   }

   public function uploadodfonserver($files_arr)
   {
   
   		foreach($files_arr as $key => $file)
   		{
     		 $file_info=File::where('file_id',$file)->get()->toArray();
      		 $url=url("public/storage/files/".$file_info[0]['file_upload_name']);
      		 $ch = curl_init();
       		 curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents');
      		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      		 curl_setopt($ch, CURLOPT_POST, 1);
      	     curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"url\": \"".$url."\"}");
             $headers = array();
             $headers[] = 'Authorization: Token token=secret';
             $headers[] = 'Content-Type: application/json';
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $result = curl_exec($ch);
             $file_info=json_decode(json_encode(json_decode($result)),true);
             if(isset($file_info['data']['document_id']))	
             {
             		$down = File::where('file_id',$file)->get()->first();
                    $down->pspdf_file_id=str_replace('"',"",$file_info['data']['document_id']);
                    $down->update();
            }
            if (curl_errno($ch)) {
        		echo 'Error:' . curl_error($ch);
           }
           curl_close($ch);
      }
      return true;
  }
   
public function get_annotation($file_id) {
   		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$file_id.'/annotations');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Token token=secret';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        return json_decode(json_encode(json_decode($result)),true);
        if (curl_errno($ch)) {
    		echo 'Error:' . curl_error($ch);
        }
		curl_close($ch);
}

public function delete_annotation(Request $request) {
	$file = File::find($request->fileid);
	
	$annotation_ids = json_decode($request->annotation_ids); 
	echo "<pre>";
	print_r($annotation_ids);
	die;
	if(count($annotation_ids) > 0){
	foreach($annotation_ids as $key => $annotation_id){
  	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$file->pspdf_file_id.'/annotations/'.$annotation_id);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	 $headers = array();
	 $headers[] = 'Authorization: Token token=secret';
	 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	 $result = curl_exec($ch);
	if (curl_errno($ch)) {
    	echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
    }
    echo true;
    }else{
    echo false;
    }
}

function create_layer($file_pspdf_id,$layer) {

    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$file_pspdf_id.'/layers');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1); 
		
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"name\": \"".$layer."\"}");
		$headers = array();
		$headers[] = 'Authorization: Token token=secret';
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		 $result = curl_exec($ch);
		if (curl_errno($ch)) {
    		 'Error:' . curl_error($ch);
		}
		curl_close($ch);
}
public function copy_layer($file_id,$old_layer,$new_layer)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$file_id.'/layers');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"name\": \"$new_layer\", \"source_layer_name\": \"$old_layer\"}");
	$headers = array();
	$headers[] = 'Authorization: Token token=secret';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
   		 echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}


public function get_layer_annotation($file_id,$layer)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$file_id.'/layers/'.$layer.'/annotations');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	$headers = array();
	$headers[] = 'Authorization: Token token=secret';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
    return $result;
	if (curl_errno($ch)) {
   		 echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}
public function delete_layer($document_id,$layer)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$document_id.'/layers/'.$layer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

	$headers = array();
	$headers[] = 'Authorization: Token token=secret';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
    	echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}
/*public function delete_annotation($file_id,$id) {
  	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, 'http://web.etabella.com:5000/api/documents/'.$file_id.'/annotations/'.$id);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	 $headers = array();
	 $headers[] = 'Authorization: Token token=secret';
	 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	 $result = curl_exec($ch);
	if (curl_errno($ch)) {
    	echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}*/
public function get_tag_color($id)
{
	echo $color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$id); 
}
public function update_timezone(Request $request)
{ 
    setcookie("time_zone", $this->ipaddress_testing(), time()+2*24*60*60);
    $client = Client::where('client_id',Session::get('client_id'))->first();
    if($client)
    {
        $client->timezone = $request->timezone;
        echo $client->update();
    }
}
public function delete_overlay(Request $request)
{

    $reportData =Report::where('annotation_id',$request->id)->get()->toArray();
    foreach($reportData as $rd)
    {
        $r1 = Report::where('id',$rd['id'])->get()->first();
        if($r1)
        {
            $r1->delete();
        }
    }
    $overlay = Pdf_file_overlay::where('id',$request->id)->get()->first();
    echo $overlay->delete();
}
public function send_message()
{
    if(Session::get('client_id'))
    {
        $data['files'] = Download::select('downloads.*','files.file_name')->join('files','downloads.download_file_id','=','files.file_id')->where('downloads.download_client_id',Session::get('client_id'))->get()->toArray();
        return view('setMessage',$data);
    }
    else
    {
        return redirect('clients');
    }
}
public function open_presentation($id)
{
    $data['files'] = Download::select('downloads.*','files.file_name','files.pspdf_file_id as pfid')->join('files','downloads.download_file_id','=','files.file_id')->where('downloads.download_id',$id)->get()->toArray();
    $data['token']=$data['files'][0]['download_id'].'_DOC_'.$data['files'][0]['download_client_id'];
    $data['fid']=$data['files'][0]['pfid'];
    $data['sender']=$data['files'][0]['download_client_id'];
    $data['file_id']=$data['files'][0]['download_file_id'];
    return view('notificationView',$data);  
}

public function open_presentation_admin($id)
{
    $data['files'] = Download::select('downloads.*','files.file_name','files.pspdf_file_id as pfid')->join('files','downloads.download_file_id','=','files.file_id')->where('downloads.download_id',$id)->get()->toArray();
    $data['token']=$data['files'][0]['download_id'].'_DOC_'.$data['files'][0]['download_client_id'];
    $data['fid']=$data['files'][0]['pfid'];
    $data['sender']=$data['files'][0]['download_client_id'];
    $data['file_id']=$data['files'][0]['download_file_id'];
    return view('open_presentation_admin',$data);  
}
public function ipaddress_testing()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    } 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ipapi.co/'.$ip.'/timezone/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    return $result;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}
public function removeFileTag($file_id,$tag_id)
{
	$tag = Tagstatus::where('tag_id',$tag_id)->where('file_id',$file_id)->where('client_id',Session::get('client_id'))->get()->first();
	$tag->delete();
}
}

