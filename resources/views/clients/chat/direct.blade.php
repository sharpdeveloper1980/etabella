@extends('layouts.client.app') 
@section('title','Chat') 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-body" >
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
                                    
									
						@if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
							|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
							, $_SERVER["HTTP_USER_AGENT"]))
							<a href="{{ url('clients/user/'.$whchjobs.'/'.$user->client_id) }}">
						@else 
							<a href="{{ url('clients/user-single/'.$whchjobs.'/'.$user->client_id) }}">
						@endif
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
			</div>
			</div>
		</div>
	</div>
</section>
@endsection