@if($from == '1')
<!-- <li class="ks-separator">Today</li> -->
@endif

@if(count($messages) > 0)
@foreach($messages as $mkey => $message)

@if($mkey == count($messages)-1)
  <input type="hidden" class="countmsg_cls" name="last_msgs" value="{{ $message->id }}">
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

<!-- <li class="ks-item ks-self">
   <span class="ks-group-amount two-char-name">CA</span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name">Brian Diaz</span>
         <span class="ks-datetime">6:46 PM</span>
      </div>
      <div class="ks-message">The weird future of movie theater food</div>
   </div>
</li>
<li class="ks-item ks-from">
   <span class="ks-avatar ks-offline">AB</span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name">Brian Diaz</span>
         <span class="ks-datetime">6:46 PM</span>
      </div>
      <div class="ks-message">
         The weird future of movie theater food
         <div class="ks-link">
            <div class="ks-name">Google</div>
            <a href="http://www.google.com" target="_blank">www.google.com</a>
         </div>
      </div>
   </div>
</li> -->
<!-- <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">The weird future of movie theater food</div>
   </div>
   </li>
   <li class="ks-item ks-from ks-unread">
   <span class="ks-avatar ks-online">
       <img src="https://bootdey.com/img/Content/avatar/avatar5.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">1 minute ago</span>
       </div>
       <div class="ks-message">
           The weird future of movie theater food
   
           <ul class="ks-files">
               <li class="ks-file">
                   <a href="#">
                       <span class="ks-thumb">
                           <span class="ks-icon la la-file-word-o text-info"></span>
                       </span>
                       <span class="ks-info">
                           <span class="ks-name">Project...</span>
                       <span class="ks-size">15 kb</span>
                       </span>
                   </a>
               </li>
               <li class="ks-file">
                   <a href="#">
                       <span class="ks-thumb">
                           <img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="36" height="36">
                       </span>
                       <span class="ks-info">
                           <span class="ks-name">photo.jpg</span>
                       <span class="ks-size">312 kb</span>
                       </span>
                   </a>
               </li>
           </ul>
       </div>
   </div>
   </li>
   
   <li class="ks-separator">Today</li>
   
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li>
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li>
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li> -->