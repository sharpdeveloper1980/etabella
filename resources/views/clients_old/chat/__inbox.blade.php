@extends('layouts.client.app')
@section('title','Chat')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/chat.css')}}" />
@stop
@section('content')
   <div class="row">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{Session::get('client_display_name')}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu job-dropdown menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/groups/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
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
                          <p><a class="dropdown-item" href="{{ url('clients/groups') }}">
                             <span class="la la-user-plus ks-icon"></span>
                             <span class="ks-text">Groups</span>
                             </a>
                          </p>
                          <p><a class="dropdown-item" href="#">
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
                              <p><a class="dropdown-item" href="{{ url('clients/user/'.$whchjobs.'/'.$user->client_id) }}">
                                 <span class="la la-user-plus ks-icon"></span>
                                 <i class="fa fa-comments-o" aria-hidden="true"></i>
                                 <span class="ks-text">{{ ucfirst($user->client_display_name) }}</span>
                                 </a>
                              </p>
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
                       <span class="chat-type">Groups</span>
                    </div>
                </div>
                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="400" style="overflow-y: hidden; padding: 0px;" tabindex="0">

                    <div class="jspContainer" style="height: 450px;">
                        <div class="jspPane" style="padding: 0px; top: 0px;">
                            <ul class="ks-items">
                              @if($groups)
                              @foreach($groups as $gkey => $group)
                                <?php 
                                  $client = explode(',',$group->client_id); 
                                ?>
                                <li class="{{ $gkey % 2 ? 'ks-item ks-active': 'ks-item ks-unread' }}">
                                    <a href="{{ url('clients/groups/'.$whchjobs.'/'.$group->group_id) }}">
                                        <span class="ks-group-amount">{{count($client)}}</span>
                                        <div class="ks-body">
                                            <div class="ks-name">
                                                {{$group->group_name}}
                                                <span class="ks-datetime">just now</span>
                                            </div>
                                            <div class="ks-message">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="18" height="18" class="rounded-circle"> Why didn't he come and talk to me...
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
                    <div class="ks-description">
                        <div class="ks-name"><strong style="font-weight: 10px">{{ $selected_grp ? ucfirst($selected_grp->group_name) : 'Group Name' }}</strong></div>
                        <div class="ks-name">{{ implode(', ',$member_names) }}</div>
                        <div class="ks-amount">{{count($members) > 0 ? count($members) : 0}} {{ count($members) == 1 ? 'member' : 'members' }}</div>
                    </div>
                    <div class="ks-controls">
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
                <div class="ks-body ks-scrollable jspScrollable" data-auto-height="" data-reduce-height=".ks-footer" data-fix-height="32" style="overflow: hidden; padding: 0px;" tabindex="0">
                    <div class="jspContainer" style="height: 375px;">
                        <div class="mCustomScrollbar jspPane" data-mcs-theme="dark" id="message-container-parent" style="padding: 0px; top: 0px; width: 691px;">
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
                                  ?>

                                  @if($message->sender_id == Session::get('client_id'))
                                  <li class="ks-item ks-from" @if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif>
                                     <span class="ks-avatar ks-offline">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message->sender_name) }}</span>
                                           <span class="ks-datetime">{{ date('M d , g:ia', $message->created_at) }}</span>
                                        </div>
                                        <div class="ks-message">{{ $message->message }}</div>
                                     </div>
                                  </li>
                                  @else
                                  <li class="ks-item ks-self"@if($mkey == 0)  id="msg-start-{{ $message->id }}" @endif @if($mkey == count($messages) - 1)  id="msg-end-{{ $message->id }}" @endif>
                                     <span class="ks-group-amount two-char-name">{{strtoupper($firstTwoCharacters)}}</span>
                                     <div class="ks-body">
                                        <div class="ks-header">
                                           <span class="ks-name">{{ ucfirst($message->sender_name) }}</span>
                                           <span class="ks-datetime">{{ date('M d , g:ia', $message->created_at) }}</span>
                                        </div>
                                        <div class="ks-message">{{ $message->message }}</div>
                                     </div>
                                  </li>
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
                <div class="ks-footer">
                  <div class="btn-group dropup">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@</button>
                    <div class="dropdown-menu">
                      @if($all_users)
                       @foreach($all_users as $ukey =>$user) 
                              <p>
                                <a class="dropdown-item name_paperclient" data-rcname="{{ ucfirst($user->client_display_name) }}">
                                 <span class="la la-user-plus ks-icon"></span>
                                 <i class="fa fa-comments-o" aria-hidden="true"></i>
                                 <span class="ks-text">{{ ucfirst($user->client_display_name) }}</span>
                                 </a>
                              </p>
                              @endforeach
                              @endif
                    </div>
                  </div>
                    <textarea class="form-control message" name="message" placeholder="Type something..."></textarea>
                    <input type="hidden" class="group_id_cls" name="group_id" value="{{ $selected_grp ? $selected_grp->group_id : '' }}">
                    <input type="hidden" class="sender_cls" name="sender_id" value="{{ $sess_client_id ? $sess_client_id : '' }}">

                    <div class="ks-controls">
                        <button class="btn btn-primary send_message">Send</button>
                    </div>
                </div>
            </div>
            <div class="ks-info ks-messenger__info">
                <div class="ks-header">
                    User Info
                </div>
                <div class="ks-body">
                    <div class="ks-item ks-user">
                        <span class="ks-avatar ks-online">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="36" height="36" class="rounded-circle">
                        </span>
                        <span class="ks-name">
                            {{ ucfirst($selected_grp->group_name) }}
                        </span>
                    </div>

                    <div class="ks-item">
                        <div class="ks-name">Username</div>
                        <div class="ks-text">
                            @lauren.sandoval
                        </div>
                    </div>
                    <div class="ks-item">
                        <div class="ks-name">Email</div>
                        <div class="ks-text">
                            lauren.sandoval@example.com
                        </div>
                    </div>
                    <div class="ks-item">
                        <div class="ks-name">Phone Number</div>
                        <div class="ks-text">
                            +1(555) 555-555
                        </div>
                    </div>
                </div>
                <div class="ks-footer">
                    <div class="ks-item">
                        <div class="ks-name">Created</div>
                        <div class="ks-text">
                            Febriary 17, 2016 at 11:38 PM
                        </div>
                    </div>
                    <div class="ks-item">
                        <div class="ks-name">Last Activity</div>
                        <div class="ks-text">
                            1 minute ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  
<!-- upload files modal -->
@section('js')
<script type="text/javascript">
  // count_msgs = $(".countmsg_cls").val();
  // count_msgs = "{{ count($messages) }}";
  var my_name = '{{ucfirst(Session::get("client_display_name"))}}';
  

  $(document).ready(function(){
        var percentage = '';
        var end_date = $(".last_start_date").val();
          $(".jspContainer").mCustomScrollbar({
            scrollInertia:100,
            callbacks:{
              onTotalScrollBack:function(){
                $.ajax({
                    type: "GET",
                    url: baseurl+"/clients/get_previous_messages/{{ $selected_grp->group_id }}/"+end_date,
                    dataType: 'json',
                    success: function(data)
                    {
                      console.log(data.success);
                      if(data.success == 1){
                        $(".last_start_date").val(data.last_start_date);
                        $("#message-container").prepend(data.html);
                      }else{
                        alert('here');
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
        },1000)

      // $('.sub-heading').on("click", function(e){
      //   $('#sub-one-to-one').toggle();
      //   e.stopPropagation();
      //   e.preventDefault();
      // });
       setInterval(function(){ get_messages(percentage); }, 1500);
  });

    
                

    function get_messages(percentage){  
        last_msgs = $(".countmsg_cls").val();
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_group_messages/{{ $selected_grp->group_id }}/"+last_msgs,
            dataType: 'json',
            success: function(data)
            {
              // console.log(data);
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
            }
        });
    }

    function changeMsgStatus(ids){  
        last_msgs = $(".countmsg_cls").val();
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/change_msg_status",
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

  $(".send_message").click(function(){
    var msg = $(".message").val();
    var grp_id = $(".group_id_cls").val();
    var sender_id = $(".sender_cls").val();
    var trim_msg = $.trim(msg);
    if(trim_msg.length > 0 && grp_id){
      var curr_date = '{{ date('M d , g:ia') }}';
      var htmljq = '<li class="ks-item ks-from"><span class="ks-avatar ks-offline">CL</span><div class="ks-body"><div class="ks-header"><span class="ks-name">'+ my_name +'</span><span class="ks-datetime">'+curr_date+'</span></div><div class="ks-message">'+msg+'</div></div></li>' 
      
      $("#message-container").append(htmljq);
      $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
       $(".message").val('');
        $.ajax({
            type: "POST",
            url: baseurl+"/clients/send_msg_group",
            data: {_token: "{{ csrf_token() }}",message:msg,group_id:grp_id,sender_id:sender_id},
            dataType: 'json',
            success: function(data)
            {
                console.log(data);
                if(data){
                    // get_messages();
                    $(".message").val('');

                    // setTimeout(function(){
                    //   $('.jspContainer').mCustomScrollbar('scrollTo','bottom');
                    // },1000);
                    
                    // $("div,#message-container").animate({ 
                    //   scrollTop:($('#message-container').prop("scrollHeight")
                    //   )}, "slow");

                    // $("html,#messages").animate({ 
                    //   scrollTop:$('#messages').prop("scrollHeight")
                    //   )}, "slow");

                    // var offset = $('#msg-start').first().position().top;
                    
                    // $('#msg-start').scrollTop($('#msg-end').parent().position().top - offset);
                }
            }
       });
    }
  });

  $(".name_paperclient").click(function(){
    var name_rec = $(this).data('rcname');
    $(".message").val('@'+name_rec);
  })

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