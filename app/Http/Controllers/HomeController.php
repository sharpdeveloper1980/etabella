<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Activitylog;
use Carbon\Carbon;
use App\Adminrole;
use App\Notification;
use App\Download;
use App\Client;
use App\Group;
use App\User;
use App\File;
use App\Job;
use App\Ftp;
use Config;
use Excel;
use Auth;

class HomeController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    public function __construct()
    {
        $this->middleware('auth');
		$this->curl_url='http://'.request()->getHttpHost().":5000/";
    }

/**
method Fetching all parent files
**/    
    public function index()
    {
        $jobs = Job::all();
        $files = File::where('file_parent_id',0)->where('file_status',1)->where('is_copied_moved',0)->orderBy('file_type','asc')->get();
        /**for breadcrumb**/
        $arr_bread[] = 'Home';

        $arr_bread_bk[0]['file_id'] = ''; 
        $arr_bread_bk[0]['filename'] = 'Home';

        return view('admin.files.list',['files'=>$files,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk]);
    }
/**end**/

/**
method Fetching all Sub files
**/    
    public function subFiles($id)
    {
        $jobs = Job::all();
        $files = File::where('file_parent_id',$id)->where('file_status',1)->where('is_copied_moved',0)->orderBy('file_type','asc')->get();
        
        /*for Breadcrumb*/
        $arr_bread = [];
        $arr_bread_bk = []; 
        
        $file = File::where('file_id',$id)->first(); 
        if($file){

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
            // echo "<pre>";
            // print_r($arr_bread_bk);
            // die;
        }
        return view('admin.files.list',['files'=>$files,'jobs'=>$jobs,'arr_bread'=>$arr_bread,'arr_bread_bk'=>$arr_bread_bk]);
    }
/**end**/

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
/**end**/

/**
method Rename Files and Folders
**/
    public function renameFiles(Request $request,$id){
        $file = File::where('file_id',$id)->first();
        $file->file_name = $request->file_name;
        $res = $file->update();
        if($res){

            $activitylogObj = new Activitylog();
            $action = 'Rename File';
            $user_type = 'admin';
            $activitylogObj->saveActivityLog($action,$user_type);

            echo true;
        }else{
            echo false;
        }
    }
/**end**/

/**
Method Upload Multiple Files
**/
    public function uploadFiles(Request $request){
        // dd($request->all());
        //             'file_name' => 'required|unique:files',

       $v= $this->validate($request, [
            'file_name' => 'required|unique:files',
			'jobs' => 'required'
            // mimes:jpeg,png,jpg,gif,svg,tif,bmp,pdf,sql,mp4,mov,mpg,mpeg,avi,3gp,pdf,ppt,odp,doc,docx,xls,xlsx,ods,xml,csv,rtf,txt,zip|
        ]);
       $files_arr=array();
    // print_r($validator->fails());
    // die;
        // Validate the input and return correct response
//         if ($v->fails())
//         {
// //             return Response::json(array(
// //                 'success' => false,
// //                 'errors' => $validator->getMessageBag()->toArray()

// //             ), 400); // 400 being the HTTP code for an invalid request.
//              // Toastr::error('Please upload file and select jobs first', 'Error', ['"debug": false']);
//               echo 'Please upload file and select jobs first';
//         }
    
        if(!Storage::disk('public')->exists('files')){
            Storage::disk('public')->makeDirectory('files');
        }

        $totalFileSize = 0;

        if($files=$request->file('file_name')){
            // dd($files[0]['size']);
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
                    $savefile = $file->save();
                    if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $files_arr[]=$file->file_id;
                        }
                    }
                    if($savefile && pathinfo($imagename, PATHINFO_EXTENSION) != "zip"){
                        $this->updateParentFolderSize($parent_id,$file_size,'add');
                    }
                    if (pathinfo($imagename, PATHINFO_EXTENSION) == "zip") {
                        $this->updateParentFolderSize($parent_id,$file_size,'add');
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
                	
                  // Toastr::error('This '.$fileOriginalName.' is already Exist', 'Error', ['"debug": false']);
                  // 
                echo json_encode(array('status'=>false, 'title'=>'error', 'msg'=>'This '.$fileOriginalName.' is already Exist'));
                }
            }
        }
    
        if($savefile){
       // echo 'in last if';
         //  echo "success";
         //  print_r($files_arr);
           	$this->uploadodfonserver($files_arr);
        	$activitylogObj = new Activitylog();
       		$action = 'File Uploading';
        	$user_type = 'admin';
        	$activitylogObj->saveActivityLog($action,$user_type);
       
       // die();
            //Toastr::success('File Successfully Uploaded !!', 'Success', ['"debug": false']);
         echo json_encode(array('status'=>true, 'title'=>'success', 'msg'=>'File Successfully Uploaded !!'));
        }
    

        // Activity Log save
        
        
        // return redirect()->back();
    }


/**End**/

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

/**
Method Create New Folder 
**/
    public function createFolder(Request $request){
        $this->validate($request,[
            'folder_name' => 'required',
            'jobs' => 'required',
        ]);

        $file = new File();
        $file->job_id = implode(',',$request->jobs);
        $file->file_name = $request->folder_name;
        $file->file_type = 1;
        $file->file_parent_id = $request->file_parent_id;
        $file->file_date_modified = strtotime(Carbon::now());
        $file->file_status = 1;
        $savefile = $file->save();
        if($savefile){

            $activitylogObj = new Activitylog();
            $action = 'Create Folder';
            $user_type = 'admin';
            $activitylogObj->saveActivityLog($action,$user_type);

            Toastr::success('Folder Successfully Creates !!', 'Success', ['"debug": false']);
        }else{
            Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
        }
        return redirect()->back();
    }
/**End**/

/**
method Fetching cLients
**/
    public function clients(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $all_nods = [];
            /**assign page label**/
            $head_label = 'All Clients';

            $users = Client::get();

            $all_nods = array('name'=>'<strong style="color:#A8A2A2;margin:170%">No File downloaded yet</strong>');

            return view('admin.clients.list',['users'=>$users,'head_label'=>$head_label,'all_nods'=>$all_nods]);
        }    
    }
/**end**/

/**
method Fetching all active cLients
**/
    public function activeClients(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $all_nods = [];
            /**assign page label**/
            $head_label = 'Active Clients';

            $users = Client::where('client_status',1)->get();

            return view('admin.clients.list',['users'=>$users,'head_label'=>$head_label,'all_nods'=>$all_nods]);
        }
    }
/**end**/

/**
method Fetching all inactive cLients
**/
    public function inactiveClients(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
             $all_nods = [];
            /**assign page label**/
            $head_label = 'Inactive Clients';

            $users = Client::where('client_status',0)->get();

            return view('admin.clients.list',['users'=>$users,'head_label'=>$head_label,'all_nods'=>$all_nods]);
        }
    }
/**end**/

/**
method Fetching all groups cLients
**/
    public function groups(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $groups = Group::all();
            return view('admin.groups.list',['groups'=>$groups]);
        }
    }
/**end**/

/**
method Show add group page
**/
    public function addGroup(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            /**all clients pass to add group page**/
            $clients = Client::all();
            return view('admin.groups.add',['clients'=>$clients]);
        }
    }
/*end*/

/**
method Save group with validations &
using Toastr for display success & error messages
**/
    public function saveGroup(Request $request){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            
            $this->validate($request,[
                'group_name' => 'required',
                'client_id' => 'required',
            ]);


            $group = new Group();

                $group->client_id = implode(',',$request->client_id);
               
                $group->group_name = $request->group_name;
                $group->save();
            
            if($group){
                
                $activitylogObj = new Activitylog();
                $action = 'Create Group';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Group Successfully Saved !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            /** return to groups listing page **/
            return redirect()->route('groups');
        }
    }
/**end**/

/**
method Show edit group page
**/
    public function editGroup($id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            /**all clients pass to edit group page**/
            $clients = Client::all();
            $group = Group::find($id);
            
            /** store selected client for highlighting in dropdown**/
            $arr_client_ids = [];
            if($group->client_id){
                $arr_client_ids = explode(',', $group->client_id);
            }

            return view('admin.groups.edit',['clients'=>$clients,'group'=>$group,'arr_client_ids'=>$arr_client_ids]);
        }
    }
/**end**/

/**
method Update group with validations &
using Toastr for display success & error messages
**/
    public function updateGroup(Request $request,$id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $this->validate($request,[
                'group_name' => 'required',
                'client_id' => 'required',
            ]);

            $group = Group::find($id);

            $group->group_name = $request->group_name;
            $group->client_id = implode(',',$request->client_id);
               
            $group->save();
            
            if($group){
                
                $activitylogObj = new Activitylog();
                $action = 'Update Group';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Group Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('groups');
        }
    }
/**end**/

/**
method Delete group & using Toastr for
display success & error messages
**/
    public function deleteGroup($id){
        if(Auth::user()->user_level == 1){
            $group = Group::find($id);
            if($group){
                $group->delete();
                
                $activitylogObj = new Activitylog();
                $action = 'Delete Group';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Group Successfully Deleted !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
        }else{
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }
        return redirect()->back();
    }
/**end**/

/**
Method fetch all jobs
**/
    public function jobs(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $jobs = Job::all();
            return view('admin.jobs.list',['jobs'=>$jobs]);
        }
    }
/**end**/

/**
method Show add-job page
**/
    public function addJob(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $groups = Group::all();
            return view('admin.jobs.add',['groups'=>$groups]);
        }
    }
/**end**/

/**
method Save Job with validations &
using Toastr for display success & error messages
**/
    public function saveJob(Request $request){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $this->validate($request,[
                'job_name' => 'required',
                'group_id' => 'required',
            ]);


            $job = new Job();

                $job->group_id = implode(',',$request->group_id);
               
                $job->job_name = $request->job_name;
                $job->save();
            
            if($job){
                
                $activitylogObj = new Activitylog();
                $action = 'Create Job';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Job Successfully Saved !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('jobs');
        }
    }
/**end**/

/**
method Show edit job page
**/
    public function editJob($id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $groups = Group::all();
            $job = Job::find($id);
            
            $arr_group_ids = [];
            if($job->group_id){
                $arr_group_ids = explode(',', $job->group_id);
            }

            return view('admin.jobs.edit',['groups'=>$groups,'job'=>$job,'arr_group_ids'=>$arr_group_ids]);
        }
    }
/**end**/

/**
method Update JOB with validations &
using Toastr for display success & error messages
**/
    public function updateJob(Request $request,$id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $this->validate($request,[
                'job_name' => 'required',
                'group_id' => 'required',
            ]);

            $Job = Job::find($id);

            $Job->job_name = $request->job_name;
            $Job->group_id = implode(',',$request->group_id);
               
            $Job->save();
            
            if($Job){
                
                $activitylogObj = new Activitylog();
                $action = 'Update Job';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Job Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('jobs');
        }
    }
/**end**/

/**
method delete GROUP with validations &
using Toastr for display success & error messages
**/
    public function deleteJob($id){
        if(Auth::user()->user_level == 1){    
            $job = Job::find($id);
            if($job){
                $job->delete();
                
                $activitylogObj = new Activitylog();
                $action = 'Delete Job';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Job Successfully Deleted !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
        }else{
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }
        return redirect()->back();
    }
/**end**/
    
/**
method Show add-client page
**/
    public function addClient(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $jobs = Job::all();
            return view('admin.clients.add',['jobs'=>$jobs]);
        }
    }
/**end**/

/**
method Save CLIENT with validations &
using Toastr for display success & error messages
**/
    public function saveClient(Request $request){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $this->validate($request,[
                'username' => 'required|unique:clients,username',
                'client_display_name' => 'required',
                'user_password' => 'required',
                'jobs' => 'required',
            ]);

            $client = new Client();
                $key = Config::get('constraints.key');
                $client->client_unique_id = Str::random(5);
                $client->username = $request->username;
                $client->user_password = md5($key.$request->user_password);
                $client->jobs = implode(',',$request->jobs);
                $client->access_token = $request->_token;
                $client->client_display_name = $request->client_display_name;
                $client->client_date_created = strtotime(Carbon::now());
                $client->client_date_last_update = strtotime(Carbon::now());
               
                $client->save();
            
            if($client){

                $activitylogObj = new Activitylog();
                $action = 'Create Client';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Client Successfully Saved !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('adminClients');
        }
    }
/**end**/

/**
method Show edit CLIENT page
**/
    public function editClient($id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $jobs = Job::all();
            
            $client = Client::find($id);
            
            $arr_job_ids = [];
            if($client->jobs){
                $arr_job_ids = explode(',', $client->jobs);
            }

            return view('admin.clients.edit',['jobs'=>$jobs,'client'=>$client,'arr_job_ids'=>$arr_job_ids]);
        }
    }
/**end**/

/**
method update CLIENT with validations &
using Toastr for display success & error messages
**/
    public function updateClient(Request $request,$id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $this->validate($request,[
                'username' => 'required',
                'client_display_name' => 'required',
                'jobs' => 'required',
                // 'user_password' => 'required',
            ]);

            $client = Client::find($id);

                $key = Config::get('constraints.key');
                $client->client_unique_id = $client->client_unique_id;
                $client->username = $request->username;
                if($request->user_password){
                    $client->user_password = md5($key.$request->user_password);
                }
                $client->jobs = implode(',',$request->jobs);
                $client->access_token = $client->access_token;
                $client->client_display_name = $request->client_display_name;
                $client->client_date_created = $client->client_date_created;
                $client->client_date_last_update = strtotime(Carbon::now());
               
                $client->save();
            
            if($client){

                $activitylogObj = new Activitylog();
                $action = 'Update Client';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Client Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('adminClients');
        }
    }
/**end**/

/**
method delete CLIENT with validations &
using Toastr for display success & error messages
**/
    public function deleteClient($id){
        if(Auth::user()->user_level == 1){
            $client = Client::find($id);
            if($client){
                $client->delete();

                $activitylogObj = new Activitylog();
                $action = 'Delete Client';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Client Successfully Deleted !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
        }else{
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }
        return redirect()->back();
    }

/**
method Show change-password page
**/
    public function changePassword(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            return view('admin.settings.change_password');
        }
    }
/**end**/

/**
method Update Password with validations &
using Toastr for display success & error messages
**/
    public function updatePassword(Request $request){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }else{

            $this->validate($request,[
                'current_password' => 'required',
                'user_password' => 'required',
                'confirm_password' => 'required|same:user_password'
            ]);

            $auth = Auth::user();
            $key = Config::get('constraints.key');
            
            if(md5($key.$request->current_password) == $auth->user_password){
                $auth->user_password = md5($key.$request->user_password);
                $auth->user_name = $auth->user_name;
                $auth->user_level = $auth->user_level;
                $auth->user_date_created = $auth->user_date_created;
                $auth->user_date_last_update = $auth->user_date_last_update;
                $auth->update();

                
                $activitylogObj = new Activitylog();
                $action = 'Update Password';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Password changed successfully !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Current password does not match !!', 'Error', ['"debug": false']);
            }
        }    
        return redirect()->back();
    }
/**end**/

/**
method Show FTP page
**/
    public function ftp(){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{

            $ftp = Ftp::first();
            return view('admin.settings.ftp',['ftp'=>$ftp]);
        }
    }
/**end**/

/**
method Save FTP with validations &
using Toastr for display success & error messages
**/
    public function saveFtp(Request $request){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }else{

            $this->validate($request,[
                'ftp_host' => 'required',
                'ftp_user' => 'required',
                'ftp_pass' => 'required'
            ]);

            $ftp = new Ftp();
            $ftp->ftp_host = $request->ftp_host;
            $ftp->ftp_user = $request->ftp_user;
            $ftp->ftp_pass = $request->ftp_pass;
            $ftp->save();   

            if($ftp){
                
                $activitylogObj = new Activitylog();
                $action = 'Create FTP';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Ftp Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
        }
        return redirect()->back();
    }
/**end**/

/**
method Update FTP with validations &
using Toastr for display success & error messages
**/
    public function updateFtp(Request $request,$id){
        if(Auth::user()->user_level == 3){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
        }else{

            $this->validate($request,[
                'ftp_host' => 'required',
                'ftp_user' => 'required',
                'ftp_pass' => 'required'
            ]);

            $ftp = Ftp::find($id);
            
            $ftp->ftp_host = $request->ftp_host;
            $ftp->ftp_user = $request->ftp_user;
            $ftp->ftp_pass = $request->ftp_pass;
            $update = $ftp->update();   

            if($update){
                
                $activitylogObj = new Activitylog();
                $action = 'Update FTP';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Ftp Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
        }
        return redirect()->back();
    }
/**end**/

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
        
        // echo $createFolder = Storage::directories('files/zipupload/'.time());
        // die;
        // if (is_dir($createFolder)){
        //     $this->rmdir_recursive($createFolder);
        // }

        $oldmask = umask(0);

        //$createFolder = Storage::disk('public')->makeDirectory('files/zipupload/'.time());
		$createFolder = public_path('storage/files/zipupload/');
        // Storage::makeDirectory($createFolder,0777,true);
        // Storage::disk('public')->makeDirectory($createFolder,0777,true);
        mkdir($createFolder,0777);
        // chmod($createFolder, 0777);
        //chown($createFolder,0777);
        umask($oldmask);
        $cCommand = '"'.Config::get('constraints.zip_path').'" x "'.public_path('storage/files/').$file_name.'" -o'.$createFolder.' -r';
        exec($cCommand);
            
            $dir = $createFolder;
            
            $this->scanDirectory($dir, $parent_id, $file_job_id);
            $this->rmdir_recursive($createFolder);
            // unlink(public_path('storage/files/'). $file_name);
            
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
        @rmdir($dir);
        
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
         // $cCommand = 'dir /s "'.$sub_dir.'"';
/*
   $bytestotal = 0;
    $path = realpath($sub_dir);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    } 
*/

     // exec($cCommand,$output, $return_var);
     // //echo (string)$output;
     // $data = implode($output);
     // $list = explode('Total Files Listed:',$data);
     // $eploaded = explode('File(s)',$list[1]);
     // $eploaded = explode('Dir(s)',$eploaded[1]);
     // $size = explode('bytes',$eploaded[0]);
     // $bytes = str_replace(",","",$size[0]);


//$output = $output[21];
//echo $output;
//$str_arr = explode (" ",$output);  
//$bytes = str_replace(",","",$str_arr[25]);

        /* Create New directory - start */
        if (!$folderCount) {
                $file = new File();
                $file->file_name = $folder_name;
                $file->file_type = 1;
                $file->file_parent_id = $parent_id;
                $file->job_id = $file_job_id;
                $file->file_date_modified = strtotime(Carbon::now());
                $file->file_size = $folder_size;
                $file->save();
            $response = $file->file_id;
           // $this->updateParentFolderSize($file->file_parent_id,$file->file_size,'add');
        }else{
                $file = File::where('file_id', $folderCount->file_id)->first();
                $file->job_id = $file_job_id;
                $file->files_updated_at = time();   
                $file->update();         
            $response = $folderCount->file_id;
            // $this->updateParentFolderSize($file->file_parent_id,$file->file_size,'add');
        }

        return $response;
        /* Create New directory - end */
    }

 //    public function rename_win($oldfile,$newfile) {
	//     if (!rename($oldfile,$newfile)) {
	//         if (copy ($oldfile,$newfile)) {
	//             unlink($oldfile);
	//             return TRUE;
	//         }
	//         return FALSE;
	//     }
	//     return TRUE;
	// }

    public function createNewFile($file_name, $parent_id, $from_directory, $file_job_id) {
    $files_arr=array();   
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
                'file_size' => filesize(public_path('storage/files/'). $new_name),
            );
            $file = new File();
                $file->file_name = $file_name;
                $file->file_upload_name = $new_name;
                $file->file_type = 2;
                $file->file_parent_id = $parent_id;
                $file->job_id = $file_job_id;
                $file->file_date_modified = time();
                $file->file_size = filesize(public_path('storage/files/'). $new_name);
                $file->save();
        
             $finfo=explode('.',$new_name);
             if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $files_arr[]=$file->file_id;
                        }
                    }
        
            // $this->updateParentFolderSize($file->file_parent_id,$file->file_size,'add');
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
                $file->file_size = filesize(public_path('storage/files/'). $new_name);
                $file->files_updated_at = time();   
                $file->update();
                $finfo=explode('.',$new_name);
                  if(isset($finfo[1])) {
                        if($finfo[1]=='pdf') {
                           $files_arr[]=$file->file_id;
                        }
                    }
            // $this->updateParentFolderSize($file->file_parent_id,$file->file_size,'add');
        }
        $this->uploadodfonserver($files_arr);

        /* Modify existing file - end */
    }

     public function updateFolderSize($parent_id) {
        // echo $parent_id . "</br>";
        if ($parent_id != '') {
            $foldesize = $this->getsumbyproductId($parent_id);
            if ($foldesize && $foldesize != '') {
                $this->updateFoldersizeParentId($parent_id, $foldesize[0]->file_size);
            }
        }
    }

    public function getsumbyproductId($parent_id) {
        $query = File::where('file_parent_id', $parent_id)->sum('file_size');


        // $this->db->select_sum('file_size');
        // $this->db->from('files');
        // $this->db->where('file_parent_id', $parent_id);
        // $query = $this->db->get();
       
        if (count($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function updateFoldersizeParentId($parent_id, $foldesize) {
        if ($parent_id != '' && $foldesize != '') {
            $file = File::where('file_id', $parent_id)->first();

            $file->file_size = $foldesize;
            $res = $file->update();

            // $data = array(
            //     'file_size' => $foldesize,
            // );
            // $this->db->where('file_id', $parent_id);
            // $this->db->update('files ', $data);
            
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return FALSE;
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

    public function fileShared($file_id,$parent_id,$status){
    	$file = File::where('file_id',$file_id)->where('file_parent_id',$parent_id)->where('file_shared',$status)->first();
    	
    	if($status == 1){
    		$status = 0;
    	}else{
    		$status = 1;
    	}
    	$file->file_shared = $status;

        if($status == 0 && $file->file_added == 1){
            $file->file_added = $status;            

            $downloads = Download::where('download_file_id',$file_id)->get();
            if(count($downloads) > 0){
                foreach ($downloads as $dkey => $download) {
                    $download->delete();
                }
            }
        }

        $file->update();

    	$this->toggleShared($file->file_id,$status);

        $activitylogObj = new Activitylog();
        // $ip = $request->getClientIp();
        $user_type = 'admin';
    	
        if($file->file_shared == 1){

            $action = 'File Shared';
            $activitylogObj->saveActivityLog($action,$user_type);

            $take_clients = [];
            $my_notifications = [];
            $jobs = explode(',', $file->job_id);
            
            $clients = Client::where('client_status',1)->get();
            if(count($clients) > 0){
                $arr_id = [];
                /*foreach($clients as $nkey => $client){
                    $client_job_arr = explode(',',$client->jobs);
                    if(array_intersect($client_job_arr, $jobs)){
                         // $arr_id[] = $client->id;
                        $notif = new Notification();

                        $notif->title = Auth::user()->user_display_name.' '.'shared'.' '.$file->file_name;
                        $notif->message = Auth::user()->user_display_name.' '.'shared'.' '.$file->file_name;

                        $notif->client_id = $client->client_id;
                        $notif->job_id = implode(',', $jobs);
                        $notif->sender = Auth::user()->user_id;
                        $notif->created_at = strtotime(Carbon::now());
                        $notif->updated_at = strtotime(Carbon::now());
                        $notif->save();
                    }
                }*/
            }
    		Toastr::success('File Shared !!', 'Success', ['debug": false']);
    	}else{

            $action = 'File Unshared';
            $activitylogObj->saveActivityLog($action,$user_type);

    		Toastr::success('File Unshared !!', 'Success', ['debug": false']);
    	}
    	return redirect()->back();
    }

    public function toggleShared($parent_id=0,$status){
    	if ($parent_id < 1) {
            return;
        }

        $q = File::where('file_parent_id',$parent_id)->get();
        if ($q){
	        foreach ($q as $r) {
	            if ($r->file_type == 1) {
	                $this->toggleShared($r->file_id,$status);
	            }
	            $file = File::where('file_id',$r->file_id)->first();
	            $file->file_shared = $status;
                $file->update();
	        }
	    }else{
	    	return;
	    }
	    return;
    }

    public function fileAdded($file_id,$parent_id,$status){
        $file = File::where('file_id',$file_id)->where('file_parent_id',$parent_id)->where('file_added',$status)->first();
        
        if($status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $file->file_added = $status;

        if($file->file_shared == 0){
            if($status == 1){
                $file->file_shared = 1;
            }
        }
        
        $file->file_added_time = strtotime(Carbon::now());
        $res = $file->update();
        if($res){
            $activitylogObj = new Activitylog();
            $user_type = 'admin';

            if($status == 1){
                $action = 'File Added';

            $jobs = explode(',', $file->job_id);
            
            $clients = Client::where('client_status',1)->get();
            if(count($clients) > 0){
                $arr_id = [];
                foreach($clients as $nkey => $client){
                    $client_job_arr = explode(',',$client->jobs);
                    if(array_intersect($client_job_arr, $jobs)){
                         // $arr_id[] = $client->id;
                        $downObj = new Download();

                        $downObj->download_client_id = $client->client_id;
                        $downObj->download_file_id = $file_id;
                        $downObj->download_date = strtotime(Carbon::now());
                        $downObj->save();
                    }
                }
            }

            Toastr::success('File added !!', 'Success', ['debug": false']);
            }else{
                $action = 'File remove from added';

                $jobs = explode(',', $file->job_id);
            
            $clients = Client::where('client_status',1)->get();
            if(count($clients) > 0){
                $arr_id = [];
                foreach($clients as $nkey => $client){
                    $client_job_arr = explode(',',$client->jobs);
                    if(array_intersect($client_job_arr, $jobs)){
                         // $arr_id[] = $client->id;
                        $down_data = Download::where('download_client_id',$client->client_id)->where('download_file_id',$file_id)->first();
                        if($down_data){
                            $down_data->delete();
                        }

                    }
                }
            }
            Toastr::success('File removed !!', 'Success', ['debug": false']);
            }

             $activitylogObj->saveActivityLog($action,$user_type);
        }else{

            Toastr::error('Something went wrong !!', 'Error', ['debug": false']);
        }
        return redirect()->back();

    }

/**
Method Delete File
**/

    public function deleteFile($fileId){
        if(Auth::user()->user_level == 1){
            $file = File::find($fileId);
           
            if($file){
                $parentId = $file->file_parent_id;
                $fileSize = $file->file_size;
                if($file->file_type=='1')
                 { 
                    $subFiles=File::where('file_parent_id',$fileId)->get();
                    foreach($subFiles as $subFile)
                     {
                        if($subFile->file_type=='1')
                         {
                            $id=$subFile->file_id;

                            $this->deleteFile($id);
                            File::where('file_id',$id)->delete();
                            $this->delete_document($subFile->pspdf_file_id);
                         }
                         else
                          {
        					if(file_exists(public_path('storage/files/'.$subFile->file_upload_name)))
                            {
                               unlink(public_path('storage/files/'.$subFile->file_upload_name));
                            }
        					Download::where('download_file_id',$subFile->file_id)->delete();
                            $subFile->delete();
                         	 $this->delete_document($subFile->pspdf_file_id);
                          }
                     }
                    $filedl = File::where('file_id',$fileId)->delete();

                    $activitylogObj = new Activitylog();
                    $action = 'Delete Files';
                    $user_type = 'admin';
                    $activitylogObj->saveActivityLog($action,$user_type);
                    
                    $this->updateParentFolderSize($parentId,$fileSize,'delete');
                    return redirect()->route('dashboard');
                 }
                 else
                 {
        			if(file_exists(public_path('storage/files/'.$file->file_upload_name)))
                    {
                       unlink(public_path('storage/files/'.$file->file_upload_name));
                    }
                    Download::where('download_file_id',$file->file_id)->delete();
                     $file->delete();

                    $activitylogObj = new Activitylog();
                    $action = 'Delete File';
                    $user_type = 'admin';
                    $activitylogObj->saveActivityLog($action,$user_type);
					$this->delete_document($file->pspdf_file_id);
                    $this->updateParentFolderSize($parentId,$fileSize,'delete');
                     return redirect('admin/files/'.$parentId);
                 }
            }     

        }else{
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }
    }

/**
End
**/


/**
Method update Folder 
**/

    public function updateFolder(Request $request,$id){
        $this->validate($request,[
            'jobs' => 'required',
        ]);

        $file = File::where('file_id',$id)->first();
        $file->job_id = implode(',',$request->jobs);
        $file->file_date_modified = strtotime(Carbon::now());

        $parentId=$this->getParentId($id);
        $this->updateFileJobId($parentId,$file->job_id,$file->file_date_modified);
        
        // $file->file_name = $request->folder_name;
//        $file->file_type = 1;
//        $file->file_parent_id = $request->file_parent_id;
  //      $file->file_date_modified = strtotime(Carbon::now());
//        $file->file_status = 1;
//        $savefile = $file->update();
/*        if($savefile){
            Toastr::success('Folder successfully updated !!', 'Success', ['"debug": false']);
        }else{
            Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
        }
*/
        $activitylogObj = new Activitylog();
            $action = 'Update Folder';
            $user_type = 'admin';
            $activitylogObj->saveActivityLog($action,$user_type);

        return redirect()->back();
    }

/**End**/


/**
Method Get Parent Id
**/

    public function getParentId($fileId)
    {
        $file=File::find($fileId);
        if($file->file_parent_id==0)
         {
            return $file->file_id;
         }
        else
         {
            $parent_id=$this->getParentId($file->file_parent_id);
            return $parent_id;
         }
    }

/**
End
**/

/**
Method Update File Job Id
**/

public function updateFileJobId($pid,$jid,$fdm)
    {
        $files=File::where('file_parent_id',$pid)->get();
        
        foreach($files as $file)
        {

         if($file->file_type=='1')
          { 
            $id=$file->file_id;
            $this->updateFileJobId($file->file_id,$jid,$fdm);
            $f = File::where('file_id',$id)->first();
            $f->job_id = $jid;
            $f->file_date_modified = $fdm;
            $savefile = $f->update();

          }
          else
           {
            $f = File::where('file_id',$file->file_id)->first();
            $f->job_id = $jid;
            $f->file_date_modified = $fdm;
            $savefile = $f->update();

           }
        }
            $f = File::where('file_id',$pid)->first();
            $f->job_id = $jid;
            $f->file_date_modified = $fdm;
            $savefile = $f->update();

    }

/**
End
**/

/**
method Fetching cLients
**/
    public function admins(){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
        /**assign page label**/
        $head_label = 'All Admins';

        $users = User::where('user_role',null)->get();


        return view('admin.admins.list',['users'=>$users,'head_label'=>$head_label]);
        }
    }
/**end**/

/**
method Fetching all active cLients
**/
    public function activeAdmins(){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            /**assign page label**/
            $head_label = 'Active Admins';

            $users = User::where('user_role',null)->where('user_status',1)->get();

            return view('admin.admins.list',['users'=>$users,'head_label'=>$head_label]);
        }
    }
/**end**/

/**
method Fetching all inactive cLients
**/
    public function inactiveAdmins(){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            /** assign page label **/
            $head_label = 'Inactive Admins';

            $users = User::where('user_role',null)->where('user_status',0)->get();

            return view('admin.admins.list',['users'=>$users,'head_label'=>$head_label]);
        }
    }
/**end**/

/**
method Show add-client page
**/
    public function addAdmins(){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $roles = Adminrole::all();
            return view('admin.admins.add',['roles' => $roles]);
        }
    }
/**end**/

/**
method Save CLIENT with validations &
using Toastr for display success & error messages
**/
    public function saveAdmins(Request $request){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $this->validate($request,[
                'user_name' => 'required|unique:users,user_name',
                'user_display_name' => 'required',
                'user_password' => 'required',
                'user_level' => 'required',
            ]);

            $user = new User();
                $key = Config::get('constraints.key');
                $user->user_name = $request->user_name;
                $user->user_password = md5($key.$request->user_password);
                $user->user_display_name = $request->user_display_name;
                $user->user_level = $request->user_level;
                $user->user_date_created = strtotime(Carbon::now());
                $user->user_date_last_update = strtotime(Carbon::now());
               
                $user->save();
            
            if($user){

                $activitylogObj = new Activitylog();
                $action = 'Create Admin';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Admin Successfully Saved !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('adminAdmins');
        }
    }
/**end**/

/**
method Show edit ADMIN page
**/
    public function editAdmins($id){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $admin = User::find($id);
            $roles = Adminrole::all();
            return view('admin.admins.edit',['admin'=>$admin,'roles'=>$roles]);
        }
    }
/**end**/

/**
method update ADMIN with validations &
using Toastr for display success & error messages
**/
    public function updateAdmins(Request $request,$id){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $this->validate($request,[
                'user_name' => 'required',
                'user_display_name' => 'required',
                'user_password' => 'required',
                'user_level' => 'required',
            ]);

            $user = User::find($id);

                $key = Config::get('constraints.key');
                $user->user_name = $request->user_name;
                $user->user_password = md5($key.$request->user_password);
                $user->user_display_name = $request->user_display_name;
                $user->user_level = $request->user_level;
                $user->user_date_created = $user->user_date_created;
                $user->user_date_last_update = strtotime(Carbon::now());
               
                $user->save();
            
            if($user){

                $activitylogObj = new Activitylog();
                $action = 'Update Admin';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('User Successfully Updated !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->route('adminAdmins');
        }
    }
/**end**/

/**
method delete Admin with validations &
using Toastr for display success & error messages
**/
    public function deleteAdmins($id){
        if(Auth::user()->user_role == null){
            Toastr::error('You have not access', 'Error', ['"debug": false']);
            return redirect()->back();
        }else{
            $user = User::find($id);
            if($user){
                $user->delete();
                
                $activitylogObj = new Activitylog();
                $action = 'Delete Admin';
                $user_type = 'admin';
                $activitylogObj->saveActivityLog($action,$user_type);

                Toastr::success('Admins Successfully Deleted !!', 'Success', ['"debug": false']);
            }else{
                Toastr::error('Something went wrong !!', 'Error', ['"debug": false']);
            }
            return redirect()->back();
        }
    }

    public function clientActivityLog(){
         /**assign page label**/
        $head_label = 'Clients Logs';

        $startDate = strtotime(date('Y-m-d')." 00:00:00");
        $endDate = strtotime(date('Y-m-d')." 23:59:59");
        
        $usertype = 'client';
        $clients = Client::all();
        $users = Activitylog::where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('action_type',0)->get();
        $users=$users->reverse();	
        return view('admin.admins.loglist',['clients' => $clients,'users'=>$users,'head_label'=>$head_label,'usertype'=>$usertype]);
    }

    public function adminActivityLog(){
        /**assign page label**/
        $head_label = 'Admin Logs';

            $startDate = strtotime(date('Y-m-d')." 00:00:00");
        $endDate = strtotime(date('Y-m-d')." 23:59:59");
        $usertype = 'admin';
		$clients = Client::all();
        $users = Activitylog::where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('action_type',0)->get();
		$users=$users->reverse();
        return view('admin.admins.loglist',['clients' => $clients,'users'=>$users,'head_label'=>$head_label,'usertype'=>$usertype]);
    }

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function exportFile($ttype){

        $data = Activitylog::paginate(10);
        $data_array[] = array('Username', 'Ip Address', 'Action', 'Description', 'Date','User Type');

        foreach ($data as $key => $value) {
            
            // if($value->type == 1){
            //     $type = 'Admin';
            // }elseif($value->type == 2){
            //     $type = 'Manager';
            // }elseif($value->type == 3){
            //     $type = 'Developer';
            // }else{
            //     $type = 'Client';
            // }  

            $data_array[] = array(
                'Username' => $value->username,
                'Ip Address' => $value->ip_address,
                'Action' => $value->action,
                'Description' => $value->description,
                'Date' => date('M d, Y H:i:s', $value->created_at),
                // 'User Type' => $type
            );
        }

        Excel::download('Log Data', function($excel) use ($data_array) {
            $excel->setTitle('Log Data list');
            $excel->sheet('Log Data', function($sheet) use ($data_array)
            {
                $sheet->fromArray($data_array, null, 'A1', false, false);
            });
        })->download($ttype);

    }   

    public function getClientDownloaded($id){
        $downloads = Client::find($id)->mydownloads;
        $arr_fileid = [];
        if(count($downloads) > 0){
            foreach ($downloads as $dkey => $download) {
                $arr_fileid[] = $download->download_file_id;
            }
        }
        if(count($arr_fileid) > 0){
            $my_clouds = File::whereIn('file_id',$arr_fileid)->where('is_copied_moved',0)->get(); 
            $arr_nods = [];
            $all_nods = [];
            $public_path = url('public/images/Folder_32.png');
            $publicfile_path = url('public/images/file-pdf-icon_32.png');
            if(count($my_clouds) > 0){
                $parid = '';
                foreach ($my_clouds as $mkey => $my_cloud) {

                    $download_S = Download::where('download_file_id',$my_cloud->file_id)->first();
                    
                    if($my_cloud->file_parent_id != $parid){
                        $parent = File::where('file_id',$my_cloud->file_parent_id)->where('file_type',1)->first();
                        if($parent){
                            
                            $arr_nods["id"] = $parent->file_id;
                            $arr_nods["pId"] = $parent->file_parent_id;
                            $arr_nods["name"] = "<tr><td style='float:left'><a class='nodefile' data-file_id='".$parent->file_id."'><img style='width:40px; margin:5px' src='".$public_path."'>".$parent->file_name."</a></td></tr>";
                                $arr_nods["open"] = true;
                                $all_nods[] = $arr_nods;

                        }
                    }
                        $arr_nods["id"] = $my_cloud->file_id;
                        $arr_nods["pId"] = $my_cloud->file_parent_id;
                        $arr_nods["name"] = "<tr><td style='float:left;color:#777777'><a style='color:#777777' href='javascript:void(0)' class='nodefile' data-file_id='".$my_cloud->file_id."'><img src='".$publicfile_path."'>".$my_cloud->file_name."</a></td><td><span style='float:right;'>".date('M d, Y H:i A', $download_S->download_date)."</span></td></tr>";
                    if($my_cloud->file_parent_id == 0){
                        $arr_nods["open"] = true;
                    }
                    $all_nods[] = $arr_nods;
                $parid =  $my_cloud->file_parent_id;
                }
            }
        }else{
                $all_nods = array('name'=>'<strong style="color:#A8A2A2;">No File downloaded yet</strong>');
            }
        echo json_encode($all_nods);
    }   

    public function renderLogs(Request $request){ 
        $startDate = strtotime($request->startDate." 00:00:00");
        $endDate = strtotime($request->endDate." 23:59:59");
    	$client_id = $request->client_id;
    
        if($request->segment == 'admin_log'){
            $usertype = 'admin';
        }else{
            $usertype = 'client';
        }
        // $users = Activitylog::where('user_type',$usertype)->whereBetween('created_at', [$startDate,$endDate])->get();
		if($startDate && $endDate && $client_id){
        	$users = Activitylog::where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('userid',$client_id)->where('action_type',0)->get();
        }elseif($startDate && $endDate && empty($client_id)){
        	$users = Activitylog::where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->where('action_type',0)->get();
        }elseif(empty($startDate) && empty($endDate) && $client_id){
        	$users = Activitylog::where('user_type',$usertype)->where('userid',$client_id)->where('action_type',0)->get();
        }
		$users=$users->reverse();
        $result = view('admin.renders.loglist',['users'=>$users])->render();
        if(sizeof($users)>0)
        {
            $arr=array('status'=>'1','data'=>$result);
        }
        else 
        {
            $arr=array('status'=>'0','data'=>$result);
        }
        echo json_encode($arr);


       // echo $result;
        
    }

// public function myRenderLogs(Request $request){ 
//         $startDate = strtotime($request->startDate);
//         $endDate = strtotime($request->endDate);
//         $usertype = 'client';
//         // $users = Activitylog::where('user_type',$usertype)->whereBetween('created_at', [$startDate,$endDate])->get();

//         $users = Activitylog::where('userid',Session::get('client_id'))->where('user_type',$usertype)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        
//         $result = view('clients.render.loglist',['users'=>$users])->render();
        
//         echo $result;
        
//     }
public function uploadodfonserver($files_arr) {
   		// print_r($files_arr);
   foreach($files_arr as $key => $file)
   {

      $file_info=File::where('file_id',$file)->get()->toArray();
      
     $url=url("/public/storage/files/".$file_info[0]['file_upload_name']);
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
		// echo    str_replace('"',"",$file_info['data']['document_id']);
     	$down = File::where('file_id',$file)->get()->first();
     	$down->pspdf_file_id=str_replace('"',"",$file_info['data']['document_id']);
        $down->update();
	 }
	 if (curl_errno($ch)) {
		//echo 'Error:' . curl_error($ch);
	 }
     curl_close($ch);
   }
}
public function delete_document($document_id)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->curl_url.'api/documents/'.$document_id);
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

}
