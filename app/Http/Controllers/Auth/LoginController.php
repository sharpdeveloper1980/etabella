<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Activitylog;
use Carbon\Carbon;
use App\Client;
use App\User;
use App\Job;
use Cookie;
use Config;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }

    // function getUserIpAddr(){
    //   if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    //       //ip from share internet
    //       $ip = $_SERVER['HTTP_CLIENT_IP'];
    //   }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    //       //ip pass from proxy
    //       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //   }else{
    //       $ip = $_SERVER['REMOTE_ADDR'];
    //   }
    //   return $ip;
    // }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        $username = Cookie::get('username') ? Cookie::get('username') : '';
        $password = Cookie::get('password') ? Cookie::get('password') : '';
        return view('auth.login',['username'=>$username,'password'=>$password]);
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['user_password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'user_name'=>$request->{$this->username()},
            'user_password'=>$request->user_password,
        ];
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'user_password' => 'required|string',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $rememberMe=$request->remember;
        if($rememberMe)
          {
            $userName=$request->user_name;
            $userPwd=$request->user_password;
            Cookie::queue('username',$userName,10080);
            Cookie::queue('password',$userPwd,10080);

          }
        else
         {
          Cookie::queue(Cookie::forget('username'));
          Cookie::queue(Cookie::forget('password'));
         }
        $key = Config::get('constraints.key');
        $auth = User::where('user_name', '=', $request->user_name)->where('user_password', '=', md5($key.$request->user_password))->first();
        if ($auth) {
            // Authentication passed...
            Auth::login($auth);

            $activitylogObj = new Activitylog();
            $action = 'Logged In';
            $user_type = 'admin';
            $activitylogObj->saveActivityLog($action,$user_type);

            Toastr::success('You have logged in successfully', 'Success', ['"debug": false']);
            return redirect()->intended('admin/dashboard');
        }else{
            Toastr::error('Credentials does not match !!', 'Error', ['"debug": false']);
            return redirect()->back();
        }
      
  }
    /**
        Show Client Login 
    **/
        public function showClientLogin(Request $request)
        {
          $username = Cookie::get('client_username') ? Cookie::get('client_username') : '';
          $password = Cookie::get('client_password') ? Cookie::get('client_password') : '';
            if($request->session()->has('type')){
                if($request->session()->get('type') == "admin"){
                    return redirect('admin/dashboard');
                }
                if($request->session()->has('client_id')){
                   return  redirect('/clients/dashboard');
                  }   
            }
            return view('auth.client_login',['client_username'=>$username,'client_password'=>$password]);
        }
    /**End**/

    /**
    Post CLient Login
    **/
    public function postClientLogin(Request $request){
        $rememberMe=$request->remember;
        if($rememberMe)
          {
            $userName=$request->user_name;
            $userPwd=$request->user_password;
            Cookie::queue('client_username',$userName,10080);
            Cookie::queue('client_password',$userPwd,10080);

          }
        else
          {
          Cookie::queue(Cookie::forget('client_username'));
          Cookie::queue(Cookie::forget('client_password'));
          }
        $key = Config::get('constraints.key');
        $username=$request->input('user_name');
        $password=md5($key.$request->input('user_password'));
        $auth = Client::where('username', '=', $username)->where('user_password', '=', $password)->first();
        if($auth){
            $request->session()->put('type','client');
            $request->session()->put('client_id',$auth->client_id);
            $request->session()->put('client_unique_id',$auth->client_unique_id);
            $request->session()->put('username',$auth->username);
            $request->session()->put('jobs',$auth->jobs);
            $request->session()->put('client_display_name',$auth->client_display_name);
            $request->session()->put('client_date_created',$auth->client_date_created);
            $request->session()->put('client_date_last_update',$auth->client_date_last_update);
            $request->session()->put('client_share_files_to_all',$auth->client_share_files_to_all);
            $request->session()->put('client_status',$auth->client_status);

            /**start Sorting Purpose**/
            $request->session()->put('file_name','asc');
            $request->session()->put('file_date_modified','asc');
            $request->session()->put('file_size','asc');
            $request->session()->put('file_type','asc');
            /**end Sorting Purpose**/
        
        	$alljobs = Job::all();
            if(count($alljobs) > 0){
              $request->session()->put('job_id',$alljobs[0]->job_id);
            }
        	
            $activitylogObj = new Activitylog();
            $action = 'Logged In';
            $user_type = 'client';
            $activitylogObj->saveActivityLog($action,$user_type);

            Toastr::success('You have logged in successfully', 'Success', ['"debug": false']);
            return redirect('/clients/dashboard/'.$alljobs[0]->job_id);
        }else{
            Toastr::error('Credentials does not match !!', 'Error', ['"debug": false']);
            return redirect()->back();
        }
    }
    /**End**/

    /**
    Method Client Logout
    **/
    public function clientlogout(Request $request){
        
        $activitylogObj = new Activitylog();
        $action = 'Logged Out';
        $user_type = 'client';
        $activitylogObj->saveActivityLog($action,$user_type);

        $request->session()->forget('client_id');
        $request->session()->forget('client_unique_id');
        $request->session()->forget('username');
        $request->session()->forget('jobs');
        $request->session()->forget('client_display_name');
        $request->session()->forget('client_date_created');
        $request->session()->forget('client_date_last_update');
        $request->session()->forget('client_share_files_to_all');
        $request->session()->forget('client_status');
        /**start Sorting Purpose**/
            $request->session()->forget('file_name');
            $request->session()->forget('file_date_modified');
            $request->session()->forget('file_size');
            $request->session()->forget('file_type');
            /**end Sorting Purpose**/
        if($request->session()->get("type")=="client"){
            $request->session()->forget('type');
        }


        Toastr::success('Successfully logged out !!', 'Success', ['"debug": false']);
        return redirect('/clients/login');
      }
    /**End**/
  /**
    Method Admin Logout
  **/
    public function logout(Request $request)
    {
      $activitylogObj = new Activitylog();
      $action = 'Logged Out';
      $user_type = 'admin';
      $activitylogObj->saveActivityLog($action,$user_type);

      $this->guard()->logout();
      $request->session()->invalidate();

      Toastr::success('Successfully logged out !!', 'Success', ['"debug": false']);
      return $this->loggedOut($request) ?: redirect('/admin/login');
    }
  /**
    End
  **/
}
