@extends('layouts.client.app')
@section('title','topics')
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
  ul.client-id-all {
    position: relative;
    top: -360.5px;
    left: 413.797px;
    display: none;
    border: solid 1px;
    list-style: none;
    box-shadow: 5px 10px #888888;
    width: 25% !important;
  }
  li.ui-menu-item {
    margin-left: -25px;
    font-weight: 600 !important;
    cursor: pointer;
  }
  .ks-footer.clnt-footer {
    position: relative;
  }
  .ks-footer.clnt-footer ul {
    position: absolute;
    top: 65px;
    left: 74px;
  }
  li.ui-menu-item:hover {
    background-color: #d2cccc;
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

            @if($topics)
               @foreach($topics as $jkey => $job)
               <li><a href="{{ url('/clients/topics/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
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
                            </div>
                            @endif

                          </p>
                       </div>
                       <span class="chat-type">Topics</span>
                    </div>
                </div>
                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="400" style="overflow-y: hidden; padding: 0px;" tabindex="0">

                    <div class="jspContainer-sidebar" style="height: 450px;">
                        <div class="jspPane" style="padding: 0px; top: 0px;">

                            <ul class="ks-items">
                              @if($groups)
                              @foreach($groups as $gkey => $group)
                                <?php
                                  $client = explode(',',$group['client_id']);
                                ?>
                               <li class="{{ $gkey % 2 ? 'ks-item ks-active': 'ks-item ks-unread' }}">
                                    <a href="{{ url('clients/topics/'.$whchjobs.'/'.$group['topic_id']) }}">
                                        <span class="ks-group-amount">{{count($client)}}</span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                {{$group['topic_name']}}
                                            
                                            @if($group['created_by'] == Session::get('client_id'))
                                                <span class="ks-datetime topic_edit" data-topic_id="{{$group['topic_id']}}" data-client_ids="{{$group['client_id']}}" data-topic_name="{{$group['topic_name']}}">Edit</span>
                                            @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>

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
                        <!-- <div class="jspVerticalBar">
                            <div class="jspCap jspCapTop"></div>
                            <div class="jspTrack" style="height: 550px;">
                                <div class="jspDrag" style="height: 261px;">
                                    <div class="jspDragTop"></div>
                                    <div class="jspDragBottom"></div>
                                </div>
                            </div>
                            <div class="jspCap jspCapBottom"></div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="ks-messages ks-messenger__messages">
                <div class="ks-header">
                    @if($selected_grp)
                    <div class="ks-description">
                        <div class="ks-name"><strong style="font-weight: 10px">{{ $selected_grp ? ucfirst($selected_grp['topic_name']) : 'Group Name' }}</strong></div>
                        <div class="ks-name">{{ implode(', ',$member_names) }}</div>
                        <div class="ks-amount">{{ sizeof(explode(',',$selected_grp['client_id'])) > 0 ? sizeof(explode(',',$selected_grp['client_id'])) : 0}} {{ sizeof(explode(',',$selected_grp['client_id'])) == 1 ? 'member' : 'members' }}</div>
                    </div>
                    @endif
                    <div class="ks-controls">
					  @if(isset($messages[0]))
					  <a href="{{ asset('clients/export_topic_chat/'.$messages[0]['topic_id']) }}" class="btn btn-info">Export Chat</a>
                      @endif
					  <button type="button" class="btn btn-success add-topic-btn float-right">Add Topic</button>
                        <!-- <div class="dropdown chat_head">
                            <button class="btn btn-primary-outline ks-light ks-no-text ks-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="la la-ellipsis-h ks-icon"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right ks-simple" aria-labelledby="dropdownMenuButton">
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-user-plus ks-icon"></span>
                                    <span class="ks-text">Add members</span>
                                </a></p>
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-eye-slash ks-icon"></span>
                                    <span class="ks-text">Mark as unread</span>
                                </a></p>
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-bell-slash-o ks-icon"></span>
                                    <span class="ks-text">Mute notifications</span>
                                </a></p>
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-mail-forward ks-icon"></span>
                                    <span class="ks-text">Forward</span>
                                </a></p>
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-ban ks-icon"></span>
                                    <span class="ks-text">Spam</span>
                                </a></p>
                                <p><a class="dropdown-item" href="#">
                                    <span class="la la-trash-o ks-icon"></span>
                                    <span class="ks-text">Delete</span>
                                </a></p>
                            </div>
                        </div> -->
                    </div>

                </div>

                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="" data-reduce-height=".ks-footer" data-fix-height="32" style="height: 390px; overflow: hidden; padding: 0px;" tabindex="0">
                    <div class="jspContainer" style=" height: 380px;">
                        <div class="jspPane" style="padding: 0px; top: 0px;">

                            <ul class="ks-items" id="message-container">
                                @if(count($messages) > 0)
                                  @foreach($messages as $mkey => $message)

                                  @if($mkey == count($messages)-1)
                                    <input type="hidden" class="countmsg_cls" name="last_msgs" value="{{ $message['id'] }}">
                                  @endif

                                  @if($mkey == 0)
                                    <input type="hidden" class="last_start_date" name="last_start_date" value="{{ $message['created_at'] }}">
                                  @endif

                                  <?php
                                    $words = $message['sender_name'];
                                    $firstTwoCharacters = substr($words, 0, 2);
									 $url = URL::to("public/storage/app")."/".$message['message'];	
                                  ?>

                                  @if($message['sender_id'] == Session::get('client_id'))

              <?php
              if($message['msg_type'] == "file"){
                if($message['file_type']=='image'){
    ?>

     <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif><span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message['sender_name']) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message['message'] }}"><img id = "msg-image" class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">AA {{ $message['message'] }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{{ date('M d , g:ia', strtotime($message['created_at'])) }}   </small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php

   }else{

?>
              <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif><span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message['sender_name']) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message['message'] }}"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message['message'],0,20); ?> </small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{!!  date("M d , g:ia", strtotime($message['created_at'])) !!}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
              <?php
            }
              }else{
                ?>
                                  <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif>
                                     <span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message['sender_name']) }}</span>
                                           <span class="ks-datetime">{!!  date("M d , g:ia", strtotime($message['created_at'])) !!}</span>
                                        </div>
                                        <div class="ks-message">{!! $message['message'] !!}</div>
                                     </div>
                                  </li>
                                  <?php
}
?>
                                  @else
    <?php if($message['msg_type'] == "file"){

               if($message['file_type']=='image'){
    ?>

     <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif><span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message['sender_name']) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message['message'] }}"><img id = "msg-image " class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">AA{{ $message['message'] }}</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{!!  date("M d , g:ia", strtotime($message['created_at'])) !!}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php

   }else{

?>
              <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif><span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span><div class="ks-body"><div class="ks-header"><span class="ks-name">{{ ucfirst($message['sender_name']) }}</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="{{ $message['message'] }}"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small  class="file_name" _ngcontent-c4=""><?php echo substr($message['message'],0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4="">{!!  date("M d , g:ia", strtotime($message['created_at'])) !!}</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
              <?php
            }
              }else{
                ?>

                                  <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message['id'] }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message['id'] }}" @endif>
                                     <span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message['sender_name']) }}</span>
                                           <span class="ks-datetime">{{ date("M d, h:i A",strtotime($message['created_at'])) }}</span>
                                        </div>
                                        <div class="ks-message">{!! $message['message'] !!}</div>
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
                        <!-- <span id="msg-end"></span> -->
                        <!-- <div class="jspVerticalBar">
                            <div class="jspCap jspCapTop"></div>
                            <div class="jspTrack" style="height: 481px;">
                                <div class="jspDrag" style="height: 206px;">
                                    <div class="jspDragTop"></div>
                                    <div class="jspDragBottom"></div>
                                </div>
                            </div>
                            <div class="jspCap jspCapBottom"></div>
                        </div> -->
                    </div>
                </div>

                @if($selected_grp)
                <div class="ks-footer clnt-footer">
                  <div class="btn-group dropup">
                  <span _ngcontent-c4="" class="btn green fileinput-button">
                    <i _ngcontent-c4="" class="fa fa-link"></i>
                    <input _ngcontent-c4="" id="file" name="image" type="file">
                  </span>
                  </div>
                    <div contenteditable="true" class="form-control message" onkeyup="typeMessage(event)" name="message" placeholder="Type something..."></div>
                    <input type="hidden" class="group_id_cls" name="topic_id" value="{{ $selected_grp ? $selected_grp['topic_id'] : '' }}">
                    <input type="hidden" class="sender_cls" name="sender_id" value="{{ $sess_client_id ? $sess_client_id : '' }}">

                    <div class="ks-controls">
                        <button class="btn btn-primary" onclick="sendMessage()">Send</button>
                    </div>
                    <ul class="client-id-all">
                      @if(count($member_names) > 0)
                        @foreach ($member_names as $memkey => $name)
                          <li class="ui-menu-item" onclick="chooseClient('{{$name}}')">{{ $name }}</li>
                        @endforeach
                      @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="add-topic-mdl" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Topic</h4>
      </div>
      <div class="modal-body">
          <form class="database_operation_form" action="{!! asset('clients/topics/add_topics') !!}">

          <div class="form-group">
            <label for="usr">Topic name:</label>
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <input type="hidden" name="created_by" value="<?php echo Session::get('client_id'); ?>" />
              <input type="hidden" name="job_id" value="<?php echo Request::segment(3) ?>" />
              <input type="text" class="form-control" id="topic_name" name="topic_name" placeholder="Enter topic name..">
          </div>
          <div class="form-group">
            <label for="sel1">Add Topic Members</label>
            <select class="form-control" id="members" name="client_id[]" multiple>
              @if($all_users)
                @foreach($all_users as $mkey => $member)
            		@if($member->client_id != Session::get('client_id'))
                  		<option value="{{ $member->client_id }}">{{ $member->client_display_name }}</option>
            		@endif
                @endforeach
              @endif
            </select>
          </div>
              <div class="form-group">
                  <button type="submit"  class="btn btn-primary">Add</button>
              </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="update-topic-mdl" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Topic</h4>
      </div>
      <div class="modal-body">
          <form id="Update-topic-form" action="{{route('update_topics')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="usr">Topic name:</label>
              <input type="hidden" name="topic_id" id="topic_id_update">
          	  <input type="text" class="form-control" id="topic_name_update" name="topic_name" placeholder="Enter topic name..">
          </div>
          <div class="form-group">
            <label for="sel1">Add Topic Members</label>
            <select class="form-control" id="members" name="client_id[]" multiple>
              @if($all_users)
                @foreach($all_users as $mkey => $member)
            		@if($member->client_id != Session::get('client_id'))
                  		<option value="{{$member->client_id}}" class="client-{{$member->client_id}}">{{ $member->client_display_name }}</option>
            		@endif
                @endforeach
              @endif
            </select>
          </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary"> Update </button>
              </div>
        </form>
      </div>
    </div>

  </div>
</div>


<?php
    $tid='';
if(isset($selected_grp['topic_id']))
    $tid=$selected_grp['topic_id'];
?>
<!-- upload files modal -->
    <script src="{!! asset('public/js/custom.js') !!}"></script>
@section('js')
<script type="text/javascript">
  // count_msgs = $(".countmsg_cls").val();
   var mem_str = '<?php echo json_encode($member_names) ?>';
   mem_str = JSON.parse(mem_str);
  var my_name = '{{ucfirst(Session::get("client_display_name"))}}';

  var authfirstTwoCharacters = '<?=$authfirstTwoCharacters?>';

    $( ".message" ).autocomplete({
      source: mem_str
    });

  $(document).ready(function(){
        $(".jspContainer-sidebar").mCustomScrollbar();
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
                    url: baseurl+"/clients/tokenPrevMessages/{{ $tid }}/"+last_id,
                    dataType: 'json',
                    success: function(data)
                    {
                      // console.log(data);
                      if(data.success == 1){
                        $(".countmsg_cls").val(data.last_id);
                        $("#message-container").prepend(data.html);
                        var height = $('.mCustomScrollBox').height();
                        $('.jspContainer').mCustomScrollbar('scrollTo',height);

                      }else{
                          if(!$('label').hasClass('no_message_fount'))
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
       setInterval(function(){ get_messages(percentage); }, 2000);

  
  /* file uploader section */

    var msg_count = '<?php echo $msg_count ?>';
  
  $('#file').on("change",function(evt){ 
    var content;
    var input = evt.target;
    var htmljq;
    msg_count++;

    var msg = $("#file").val();
    var trim_msg = msg.replace(/^.*[\\\/]/, ''); 
    var grp_id = $(".group_id_cls").val();
    var sender_id = $(".sender_cls").val();
    if(msg.length > 0 && grp_id){
    var curr_date = '{{ date('M d , g:ia') }}';

    var file = document.getElementById("file").files[0];
    var fileType = file['type'].split('/')[0];
    
	var formData = new FormData();
	formData.append('_token', "{{ csrf_token() }}");
    formData.append('file', file);
    formData.append('message', trim_msg);
    formData.append('fileType', fileType);
    formData.append('group_id', grp_id);
    formData.append('sender_id', sender_id);
    formData.append('msg_type', "file");
    
    
  if (file) {
    var reader = new FileReader();
  
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
      $(".message").html('');
      $('#msg-image'+msg_count).attr('src', content);
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_topic",
            data: formData,
            dataType: 'json',
        	contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
            console.log(data);
              if(data){
              		if(fileType == "image"){
        			htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="'+baseurl+'/public/storage/app/'+trim_msg+'" download="'+trim_msg+'"><img id="msg-image'+msg_count+'" height="150" width="150" class="msgs-image"  _ngcontent-c4="" src="'+baseurl+'/public/storage/app/'+trim_msg+'"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">'+trim_msg+'</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">'+curr_date+'</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>'; 
    			}else{
        			htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="'+baseurl+'/public/storage/app/'+trim_msg+'" download="'+trim_msg+'"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4="">'+trim_msg+'</small></p><p _ngcontent-c4=""><small _ngcontent-c4="">'+curr_date+'</small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>'; 
    			}	
      			
              	$("#message-container").append(htmljq);
      			$('.jspContainer').mCustomScrollbar('scrollTo','bottom');
      			$('#msg-image'+msg_count).attr('src', content);
                $(".message").html('');
              }
            }
           });
    	}
  		}
	});
});

    function get_messages(percentage){
        last_msgs = $(".countmsg_cls").val();


        $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_topic_messages/{{ $tid }}/"+last_msgs,
            dataType: 'json',
            success: function(data)
            { console.log(data);
              // console.log(percentage);
              if(data.success == 1){
                // console.log(data.here_append);
                // console.log(data.last_msg_id);
                $(".countmsg_cls").val(data.last_msg_id);
                $("#message-container").append(data.html);
                if(percentage > 80){
                  $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
                }
				
                changeMsgStatus(data.ids);
              }
              else
              {
                  console.log('f');
              }
            }
        });
    }
  /*setTimeout(function(){
	  changeMsgStatus_topic(<?php if($selected_grp) { echo $selected_grp['topic_id']; } ?>);
  },5000);*/
  /*new start*/
  function changeMsgStatus(ids){   
        // last_msgs = $(".countmsg_cls").val();
    	  $.ajax({
            type: "POST",
            url: baseurl+"/clients/change_msg_status1",
            data: {_token: "{{ csrf_token() }}",ids:ids},
            dataType: 'json',
            success: function(data)
            {
              if(data.success == 1){
              
                console.log('in change status success');
                // $(".countmsg_cls").val(data.last_msg_id);;
                // $("#message-container").append(data.html);

              }
            }
        });
    }
setInterval(function(){
	changeNotifstatus("<?php  if($selected_grp) { echo $selected_grp['topic_id']; } ?>");
},1000)
	function changeNotifstatus(selected_grp){  
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/change_notif_status1",
            data: {_token: "{{ csrf_token() }}",group_id:selected_grp},
            dataType: 'json',
            success: function(data)
            {
              if(data.success == 1){
              
                console.log('in notif status success');

              }
            }
        });
    }
  
  /*new end*/
  
  function changeMsgStatus_topic(ids){
      last_msgs = $(".countmsg_cls").val();
      console.log('ids');
      console.log(ids);
      $.ajax({
          type: "POST",
          url: baseurl+"/clients/change_msg_status_topic",
          data: {_token: "{{ csrf_token() }}",ids:ids},
          dataType: 'json',
          success: function(data)
          {
              console.log(data);
              if(data.success == 1){
                  console.log(data.here_append);
                  console.log(data.last_msg_id);
                  $(".countmsg_cls").val(data.last_msg_id);;
                  $("#message-container").append(data.html);

              }
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
    var msg = $(".message").html();
    var grp_id = $(".group_id_cls").val();
    var sender_id = $(".sender_cls").val();
    var trim_msg = $.trim(msg);
  	
    if(trim_msg.length > 0 && grp_id){
      var curr_date = formatAMPM(new Date);;
      var htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">'+authfirstTwoCharacters+'</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><span class="ks-datetime">'+curr_date+'</span></div><div class="ks-message">'+msg+'</div></div></li>';

      $("#message-container").append(htmljq);
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
       $(".message").val('');
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_topic",
            data: {_token: "{{ csrf_token() }}",message:msg,group_id:grp_id,sender_id:sender_id,msg_type:"msg"},
            dataType: 'text',
            success: function(data)
            {
              console.log(data);
              if(data){
              	$(".message").html('');
              }
            }
       });
    }
  };

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
	if(event.keyCode == 50)
	{
		// $('.client-id-all').css({'display':'block'});
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

  function chooseClient(name){
    var msg = $('.message').val();
    // var namebold = name.bold();
    var aftr_msg = $('.message').val(msg+name);
    $(".client-id-all").hide();
    $('.message').focus();
  }

  $(".add-topic-btn").click(function(){
    $("#add-topic-mdl").modal("show");
  });

  $(".topic_edit").click(function(e){
  	e.preventDefault();
  	var topic_id = $(this).data('topic_id');
  	var client_ids = $(this).data('client_ids');
  	var topic_name = $(this).data('topic_name');
  
  	// var actionUrl = baseurl+'clients/topics/update_topics/'+topic_id;
  	// $("#Update-topic-form").attr('action',actionUrl)
  
  	$("#topic_id_update").val(topic_id);
  	$("#topic_name_update").val(topic_name);
  	
  	var items = client_ids.split(',');
  		$.each(items, function( index, value ) {
  			$('.client-'+value).attr('selected','selected');
		});
  
  	$("#update-topic-mdl").modal("show");
  });	

// $("#topic-submit").click(function(){
// 	$("#Update-topic-form").submit();
// });

  // $(".name_paperclient").click(function(){
  //   var name_rec = $(this).data('rcname');
  //   $(".message").val('@'+name_rec);
  // })

  // $("#message-container-parent").mCustomScrollbar({
  //   theme:"light-3",
  //   scrollButtons:{
  //     enable:true
  //   },
  //   callbacks:{
  //     whileScrolling:function(){
  //       console.log("Scrolling...");
  //     }
  //   }
  // });
</script>
@stop

@endsection
