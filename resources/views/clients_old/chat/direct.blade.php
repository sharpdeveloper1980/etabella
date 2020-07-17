@extends('layouts.client.app')
@section('title','Chat')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/chat.css')}}" />
<style type="text/css">

  i.fa.fa-link {
      color: #000 !important;
      padding-bottom: 4px !important;
      font-size: 17px !important;
      padding-top: 4px !important;
  }
  .fileinput-button {
      background: none repeat scroll 0 0 #eeeeee;
      border: 1px solid #e6e6e6;
      float: left;
      margin-right: 4px;
      overflow: hidden;
      position: relative;
  }
  .fileinput-button input {
      cursor: pointer;
      direction: ltr;
      font-size: 23px;
      margin: 0;
      opacity: 0;
      position: absolute;
      right: 0;
      top: 0;
      -webkit-transform: translate(-300px, 0px) scale(4);
      transform: translate(-300px, 0px) scale(4);
  }
  .msgs-image {
    width: 70px !important;
    height: 70px !important;
  }
</style>
@stop
@section('content')
   <div class="row">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{$active_job->job_name}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu job-dropdown menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/user/'.$job->job_id.'/'.$selected_user->client_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>

               @if($job->job_id == $whchjobs)
                  <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
                @endif

               @endforeach
            @endif
         </ul>
      </div>
      
      
   </div>
   <hr class="hr_new1">
   <!-- second buttons start -->
<div class="ks-page-content">
    <div class="ks-page-content-body">
        <div class="ks-messenger">
            <div class="ks-discussions">
                <div class="ks-search">
                    <div class="dropdown chat_head">
                       <button class="btn btn-primary-outline ks-light ks-no-text ks-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <span class="fa fa-home"> 
                        <span class="fa fa-chevron-down" style="color: #7a7575"></span>
                        </span>
                       </button>
                       <div class="dropdown-menu ks-simple" aria-labelledby="dropdownMenuButton">
                          <p><a class="dropdown-item" href="{{ url('clients/groups'.'/'.Session::get('job_id')) }}">
                             <span class="la la-user-plus ks-icon"></span>
                             <span class="ks-text">Groups</span>
                             </a>
                          </p>
                          <p><a class="dropdown-item" href="{{ url('clients/topics'.'/'.Session::get('job_id')) }}">
                             <span class="la la-eye-slash ks-icon"></span>
                             <span class="ks-text">Topics</span>
                             </a>
                          </p>
                          <p>
                            <a class="dropdown-item sub-heading" href="javascript:void(0)">
                             <span class="ks-text">One to One</span>
                             
                            @if($all_users)
                             <span class="fa fa-chevron-down" style="color: #7a7575"></span>
                             </a>
                             <div id="sub-one-to-one" class="dropdown-submenu dropdown-menu sub-ks-simple" aria-labelledby="dropdownMenuButton" style="display: none">
                               @foreach($all_users as $ukey =>$user) 
                 @if($sess_client_id != $user->client_id)
                              <p><a class="dropdown-item" href="{{ url('clients/user/'.Session::get('job_id').'/'.$user->client_id) }}">
                                 <span class="la la-user-plus ks-icon"></span>
                                 <i class="fa fa-comments-o" aria-hidden="true"></i>
                                 <span class="ks-text">{{ ucfirst($user->client_display_name) }}</span>
                                 </a>
                              </p>
                @endif
                              @endforeach
                              <!-- <p><a class="dropdown-item" href="#">
                                 <span class="la la-eye-slash ks-icon"></span>
                                 <span class="ks-text">User 2</span>
                                 </a>
                              </p> -->

                            </div>
                            @endif

                          </p>
                       </div>
                       <span class="chat-type">One to One</span>
                    </div>
                </div>
                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="400" style="overflow-y: hidden; padding: 0px;" tabindex="0">

                    <div class="jspContainer" style="height: 450px;">
                        <div class="jspPane" style="padding: 0px; top: 0px;">
                            <ul class="ks-items">
                              @if($all_users)
                              @foreach($all_users as $ukey => $user)
                              @if($sess_client_id != $user->client_id)
                                <?php 
                                 $words = $user->client_display_name;
                                 $firstTwoCharacters = substr($words, 0, 2);
                                ?>
                                <li class="{{ $ukey % 2 ? 'ks-item ks-active': 'ks-item ks-unread' }}">
                                    <a href="{{ url('clients/user/'.$whchjobs.'/'.$user->client_id) }}">
                                        <span class="ks-group-amount">{{strtoupper($firstTwoCharacters)}}</span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                {{ucfirst($user->client_display_name)}}
                                                <span class="ks-group-amount msg-count" id="user-{{$user->client_id}}" style="display: none;">
                                                  
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                              @endif
                              @endforeach
                              @else
                              <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <!-- <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36"> -->
                                        </span>
                                        <div class="ks-body">
                                            <!-- <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div> -->
                                            <div class="ks-message">No Group Found</div>
                                        </div>
                                    </a>
                                </li>
                              @endif
                              <!-- <li class="ks-item ks-active">
                                    <a href="#">
                                        <span class="ks-group-amount">3</span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Group Chat
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="18" height="18" class="rounded-circle"> The weird future of movie theater food
                                            </div>
                                        </div>
                                    </a>
                                </li> -->
                                <!--<li class="ks-item ks-unread">
                                    <a href="#">
                                        <span class="ks-group-amount">5</span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="18" height="18" class="rounded-circle"> Why didn't he come and talk to me...
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36">
                                            <span class="badge badge-pill badge-danger ks-badge ks-notify">7</span>
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar ks-online">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Brian Diaz
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">The weird future of movie theater food</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-group-amount">3 <span class="badge badge-pill badge-danger ks-badge ks-notify">7</span></span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar ks-offline">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>

                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Eric George
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">Why didn't he come and talk to me himse...</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Lauren Sandoval
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">The weird future of movie theater food</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="ks-item ks-closed">
                                    <a href="#">
                                        <span class="ks-avatar">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="36" height="36">
                                        </span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                Brian Diaz
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">The weird future of movie theater food</div>
                                        </div>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ks-messages ks-messenger__messages">
                <div class="ks-header">
                    <div class="ks-description">
                        <div class="ks-name"><strong>{{ $selected_user ? ucfirst($selected_user->client_display_name) : 'No Name' }}</strong></div>
                        <div class="ks-amount">{{date('M d , g:ia')}}</div>
                    </div>
                  <div class="ks-controls">
                      <!--  Deependra -->
                    @if(isset($messages[0]))
                        <a href="{{ asset('clients/export_direct_chat/'.$messages[0]->recipient_id) }}" class="btn btn-info">Export Chat</a>
                    @endif
                  </div>
        </div>
                
                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="" data-reduce-height=".ks-footer" data-fix-height="32" style="height: 390px; overflow: hidden; padding: 0px;" tabindex="0">
                    <div class="jspContainer" style=" height: 380px;">
                        <div class="jspPane" style="padding: 0px; top: 0px;">
                            <ul class="ks-items" id="message-container">
                                @if(count($messages) > 0)
                                  @foreach($messages as $mkey => $message)

                                  @if($mkey == count($messages)-1)
                                    <input type="hidden" class="countmsg_cls" name="last_msgs" value="{{ $message->id }}">
                                  @endif

                                  @if($mkey == 0)
                                    <input type="hidden" class="last_start_date" name="last_start_date" value="{{ $message->created_at }}">
                                  @endif

                                  <?php 
                                    $words = $message->sender_name;
                                    $firstTwoCharacters = substr($words, 0, 2);
                                    // $url = URL::to("/storage/app/")."/".$message->message;
                                    $url=url('public/storage/app/'.$message->message);

                                  ?>

                                  @if($message->sender_id == Session::get('client_id'))

              <?php 
              if($message->msg_type == "file"){
                if($message->file_type=='image'){
    ?>

     <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif><span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message->sender_name) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message->message }}"><img id = "msg-image" class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">{{ $message->message }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{{ date('M d , H:i A', $message->created_at) }}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php
    
   }else{

?>
              <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif><span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message->sender_name) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message->message }}"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">{{ $message->message }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{{ date('M d , H:i A', $message->created_at) }}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
              <?php
            } 
              }else{
                ?>
                                  <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif>
                                     <span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message->sender_name) }}</span>
                                           <span class="ks-datetime">{{ date('M d , H:i A', $message->created_at) }}</span>
                                        </div>
                                        <div class="ks-message">{{ $message->message }}</div>
                                     </div>
                                  </li>
                                  <?php
}
?>
                                  @else
    <?php if($message->msg_type == "file"){

               if($message->file_type=='image'){
    ?>

     <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif><span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message->sender_name) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message->message }}"><img id = "msg-image " class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">{{ $message->message }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{{ date('M d , H:i A', $message->created_at) }}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php
    
   }else{

?>
              <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif><span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message->sender_name) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message->message }}"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small  class="file_name" _ngcontent-c4="">{{ $message->message }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{{ date('M d , H:i A', $message->created_at) }}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
              <?php
            }
              }else{
                ?>

                                  <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif>
                                     <span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message->sender_name) }}</span>
                                           <span class="ks-datetime">{{ date('M d , H:i A', $message->created_at) }}</span>
                                        </div>
                                        <div class="ks-message">{{ $message->message }}</div>
                                     </div>
                                  </li>
    <?php
}
?>
                                  @endif

                                  @endforeach
                                  @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ks-footer">
                  <div class="btn-group dropup">
                    <span _ngcontent-c4="" class="btn green fileinput-button">
                      <i _ngcontent-c4="" class="fa fa-link"></i>
                      <form id="file_upload_form">
                         {{ csrf_field() }}
                         <input type="hidden" class="user_id_cls" name="user_id" value="{{ $selected_user ? $selected_user->client_id : '' }}">
                        <input type="hidden" class="sender_cls" name="sender_id" value="{{ $sess_client_id ? $sess_client_id : '' }}">
                        <input _ngcontent-c4="" data-form="#file_upload_form" id="file" name="image" type="file">
                        <input type="hidden"  name="job" value="{{ $whchjobs }}">
                      </form>
                    </span>
                  </div>
                    <textarea class="form-control message" onkeyup="typeMessage(event)" name="message" placeholder="Type something..."></textarea>
                    <input type="hidden" class="user_id_cls" name="user_id" value="{{ $selected_user ? $selected_user->client_id : '' }}">
                    <input type="hidden" class="sender_cls" name="sender_id" value="{{ $sess_client_id ? $sess_client_id : '' }}">

                    <div class="ks-controls">
                        <button class="btn btn-primary" onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  
<!-- upload files modal -->
@section('js')
<script type="text/javascript">
  var my_name = '{{ucfirst(Session::get("client_display_name"))}}';
  var sel_user_id = "{{ $selected_user ? $selected_user->client_id : '' }}";
  var whchjobs = '<?php echo $whchjobs ?>';
  var authfirstTwoCharacters = '<?php echo $authfirstTwoCharacters ?>'; 

  $(document).ready(function(){
    var percentage = '';
      $(".jspContainer").mCustomScrollbar({
            theme:"dark-3",
            onTotalScrollBackOffset: '10px',
            scrollInertia:100,
            callbacks:{
              onTotalScrollBack:function(){
                var last_id = $(".countmsg_cls").val();
                $.ajax({
                    type: "GET",
                    url: baseurl+"/clients/get_previous_direct_messages/{{ $selected_user->client_id }}/"+last_id,
                    dataType: 'json',
                    success: function(data)
                    {
                      console.log(data);
                      if(data.success == 1){
                        $(".countmsg_cls").val(data.last_id);
                        $("#message-container").prepend(data.html);
                        var height = $('.mCustomScrollBox').height();
                        $('.jspContainer').mCustomScrollbar('scrollTo',height);

                      }else{
                        $(".no-msg").remove();
                        $("#message-container").prepend(data.html);
                      }
                    }
                });
              },
              onScroll:function(){
                percentage = this.mcs.topPct;
              }
            },
          });
        
        setTimeout(function(){
          $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
        },1000);

      $('.sub-heading').on("click", function(e){
        $('#sub-one-to-one').toggle();
        e.stopPropagation();
        e.preventDefault();
      });

      setInterval(function(){ get_messages(percentage); }, 5000);

      /* file uploader section */

    var msg_count = '<?php echo $msg_count ?>';
  $('#file').on("change",function(evt){ 
    var content;
    var input = evt.target;
    var htmljq;
    msg_count++;
 var form_id=$(this).attr('data-form');
   var file_info = new FormData($(form_id)[0]);
    var msg = $("#file").val();
    var trim_msg = msg.replace(/^.*[\\\/]/, ''); 
    var usr_id = $(".user_id_cls").val();
    var sender_id = $(".sender_cls").val();
    if(msg.length > 0 && usr_id){
    var curr_date = '{{ date('M d , H:i A') }}';

    var file = document.getElementById("file").files[0];
    var fileType = file['type'].split('/')[0];
  if (file) {
    var reader = new FileReader();
  if(fileType == "image"){
    reader.onload = function () {
    content = reader.result;

    htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="'+baseurl+'/public/storage/app/'+trim_msg+'" download="'+trim_msg+'"><img id="msg-image'+msg_count+'" height="150" width="150" class="msgs-image"  _ngcontent-c4="" src=""></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">'+trim_msg+'</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">'+curr_date+'</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>'; 

      $("#message-container").append(htmljq);
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
      $(".message").val('');
      $('#msg-image'+msg_count).attr('src', content);

        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_direct_file",
           // data: {_token: "{{ csrf_token() }}",'file':file_info,message:trim_msg,content:content,fileType:fileType,user_id:usr_id,sender_id:sender_id,msg_type:"file"},
            data:file_info,
             dataType: 'json',
            contentType:false,
            processData:false,
            success: function(data)
            {
                // console.log(data);
                if(data){
                    $(".message").val('');
                }
            }
           });
}
  reader.onerror = function () {
          content = "";
          },
 reader.readAsDataURL(input.files[0])
}
else{
  fileType = "other";
          reader.readAsText(file, "UTF-8");
          reader.onload = function () {
          content = reader.result;

       htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="'+baseurl+'/public/storage/app/'+trim_msg+'" download="'+trim_msg+'"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">'+trim_msg+'</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">'+curr_date+'</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>'; 

      $("#message-container").append(htmljq);
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
      $(".message").val('');

        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_direct_file",
            //data: {_token: "{{ csrf_token() }}",'file':file_info,message:trim_msg,content:content,fileType:fileType,user_id:usr_id,sender_id:sender_id,msg_type:"file"},
            data:file_info,
             dataType: 'json',
            contentType:false,
            processData:false,
            success: function(data)
            {
                // console.log(data);
                if(data){
                    $(".message").val('');
                }
            }
           });
    }
      reader.onerror = function () {
          content = "";
          }
      }    
    }
        
  }
});

      function get_messages(percentage){ 
        last_msgs = $(".countmsg_cls").val();
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_direct_messages/{{ $selected_user->client_id }}/"+last_msgs,
            dataType: 'json',
            success: function(data)
            {
              // console.log(data);
              // console.log(JSON.parse(data.msg_counter));
              if(data.msg_counter){
                $.each(data.msg_counter, function (key, val) {
                  $("#user-"+key).html(val);
                  $("#user-"+key).show();
                });
              }

              if(data.success == 1){
                console.log(data.ids);
                // console.log(data.last_msg_id);
                $(".countmsg_cls").val(data.last_msg_id);
                $("#message-container").append(data.html);
                if(percentage > 80){
                  $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
                }
                changeMsgStatus(data.ids);
              }
                changeNotifDirectstatus();
            }
        });
    }

    function changeMsgStatus(ids){  
        last_msgs = $(".countmsg_cls").val();
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/change_direct_msg_status",
            data: {_token: "{{ csrf_token() }}",ids:ids},
            dataType: 'json',
            success: function(data)
            {
              console.log(data);
            }
        });
    }

    function changeNotifDirectstatus(){  
        last_msgs = $(".countmsg_cls").val();
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/change_direct_notif_status",
            data: {_token: "{{ csrf_token() }}",sel_user_id:sel_user_id},
            dataType: 'json',
            success: function(data)
            {
              console.log(data);
            }
        });
    }
  
  $('.message').keypress(function(event){
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
          sendMessage();          
      }
  });
      function formatAMPM(date) {
  var month = new Array();
  month[0] = "Jan";
  month[1] = "Feb";
  month[2] = "Mar";
  month[3] = "Apr";
  month[4] = "May";
  month[5] = "June";
  month[6] = "July";
  month[7] = "Aug";
  month[8] = "Sep";
  month[9] = "Oct";
  month[10] = "Nov";
  month[11] = "Dec";
  var date=new Date();
    var val=date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();

  var month_new = month[date.getMonth()];
  var day = date.getDay();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  
  var strTime = month_new+' '+date.getDate()+','+hours + ':' + minutes + ' ' + ampm;
  return strTime;
}
    function sendMessage(){
    var msg = $(".message").val();
    var usr_id = $(".user_id_cls").val();
    var sender_id = $(".sender_cls").val();
    var trim_msg = $.trim(msg);
    if(trim_msg.length > 0 && usr_id){
      var curr_date = formatAMPM(new Date);
      var htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><span class="ks-datetime">'+curr_date+'</span></div><div class="ks-message">'+msg+'</div></div></li>'; 
    

        $("#message-container").append(htmljq);
        $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
         $(".message").val('');
          $.ajax({
              type: "POST",
              url: baseurl+"/clients/send_msg_direct",
              data: {_token: "{{ csrf_token() }}",message:msg,user_id:usr_id,sender_id:sender_id,msg_type:"msg",job:whchjobs},
              dataType: 'text',
              success: function(data)
              {
                  console.log(data);
                  if(data){
                      // get_messages();
                      $(".message").val('');
                  }
              }
         });
      }
    };

    /**$(".send_message").click(function(){
    var msg = $(".message").val();
    var usr_id = $(".user_id_cls").val();
    var sender_id = $(".sender_cls").val();
    var trim_msg = $.trim(msg);
    if(trim_msg.length > 0 && usr_id){
      var curr_date = '{{ date('M d , H:i A') }}';
      var htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">CL</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><span class="ks-datetime">'+curr_date+'</span></div><div class="ks-message">'+msg+'</div></div></li>'; 
    

      $("#message-container").append(htmljq);
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
       $(".message").val('');
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_direct",
            data: {_token: "{{ csrf_token() }}",message:msg,user_id:usr_id,sender_id:sender_id,msg_type:"msg"},
            dataType: 'text',
            success: function(data)
            {
                console.log(data);
                if(data){
                    // get_messages();
                    $(".message").val('');
                }
            }
       });
    }
  });**/
  });
  (function($){
    $.fn.setCursorToTextEnd = function() {
        var $initialVal = this.val();
        this.val($initialVal);
    };
  })(jQuery);

  function setColor(color) {
      document.execCommand('styleWithCSS', false, true);
      document.execCommand('foreColor', false, color);
  }
  
    var keystatus = '';
  function typeMessage(event) {
    // var x = event.which || event.keyCode;
    console.log(event.keyCode);
  console.log(mem_str);
  //alert('a')
  if(event.keyCode == 50)
  {
    //alert('f')
     $('.client-id-all').css({'display':'block'});
     $('.message').atwho({
          at: "@",
          data: mem_str
      });
  }
  
  if(event.keyCode == 51)
  {
        setColor("#1c94e0");
    }
    if(event.keyCode == 32)
  {
        setColor("black");
    
  }
    if(event.keyCode == 32 && keystatus == 1){
        keystatus = '';
        var msg = $('.message').html();
        var hashStr = msg.substr(msg.lastIndexOf(" "));
        
        var hashtag = hashStr.fontcolor("#3A3F51");
        var newmsg = msg.replace(hashStr,hashtag);
      
        setTimeout(function(){
          $('.message').html(newmsg);
          $('.message').setCursorToTextEnd();
        },2000);
    }

    if(keystatus == 1){
      var msg = $('.message').html();
      var hashStr = msg.substr(msg.lastIndexOf("#"));
      var hashtag = '<b style="color:blue">'+hashStr+'</b>';
      var newmsg = msg.replace(hashStr,hashtag);
      
      setTimeout(function(){
        $('.message').html(newmsg);
        $('.message').setCursorToTextEnd();
      },2000);
      
    }

    if(event.keyCode == 64){
        keystatus = '';
        // $(".client-id-all").show();
        $('.message').atwho({
          at: "@",
          data:['Hans', 'Peter', 'Tom', 'Anne']
      });
    }
    
    if(event.keyCode == 35){
        keystatus = 1;
        // $(this).css("background-color", "red");
        setTimeout(function(){
          $('.message').setCursorToTextEnd();
        },2000);
      }
  } 

 /* setInterval(function(){
    if({{ Request::segment(4) }})
    {
    $.get(baseurl+'/clients/read_message/{{ Request::segment(4) }}',function(fb){
      console.log(fb)
    })
    }
  },1000);*/
</script>
@stop

@endsection