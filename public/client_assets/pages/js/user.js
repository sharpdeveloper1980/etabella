

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
                    url: baseurl+"/clients/get_previous_direct_messages/"+selected_job+"/"+last_id,
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
           // data: {_token: $("input[name='_token']").val(),'file':file_info,message:trim_msg,content:content,fileType:fileType,user_id:usr_id,sender_id:sender_id,msg_type:"file"},
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
            //data: {_token: $("input[name='_token']").val(),'file':file_info,message:trim_msg,content:content,fileType:fileType,user_id:usr_id,sender_id:sender_id,msg_type:"file"},
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
            url: baseurl+"/clients/get_direct_messages/"+selected_job+"/"+last_msgs,
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
            data: {_token: $("input[name='_token']").val(),ids:ids},
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
            data: {_token: $("input[name='_token']").val(),sel_user_id:sel_user_id},
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
              data: {_token: $("input[name='_token']").val(),message:msg,user_id:usr_id,sender_id:sender_id,msg_type:"msg",job:whchjobs},
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