$(document).on('click','#notification_menu_new',function(){
		$('.message_drop_down').css({'display':'none'});
		$('.notification_dropdown').css({'display':'block'});
	});
	$('body').on('click',function(){
		$('.notification_dropdown').css({'display':'none'});
		$('.message_drop_down').css({'display':'none'});
	});
	
	

	$(document).on('click','#message_menu',function(){
		$('.notification_dropdown').css({'display':'none'});
		$('.message_drop_down').css({'display':'block'});
	});
      $(document).ready(function(){
         var timezone =  show_timezone_info();
          $.post(baseurl+'/clients/update_timezone',{_token:$("input[name='_token']").val(),"timezone":timezone},function(fb){ 
          });
      });
      $('[data-tooltip="tooltip"]').tooltip();
        /*@if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    "debug": false,
                });
            @endforeach
        @endif*/

        var active_job = $('.active_jobname').val();

        setTimeout(function(){
          $('.case_jobname').text(' '+active_job+' ');  
        },2000);

        setTimeout(function(){
          $("a.level0").removeAttr("title");
          $("a.level1").removeAttr("title");	
        },2000)
  

   function mark_read(id){
      $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_read/"+id,
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
               $("#row-"+id).remove();
               $(".count_notif").text(data.count);
              }
           }
      });
   };

  $(".allRead").click(function(){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_all_read",
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
                $(".drop-content").remove();
                $("#noti-hr").after('<div class="drop-content"><li><div class="col-md-12">No new message found</div></li></div>');
                $(".count_notif").text(0);
              }
           }
      });
  });
  if(localStorage.getItem("job_popup") || localStorage.getItem("job_popup")!=0)
   {
	   
     $('#page_overlay').removeClass('page_overlay');
   }
/** start get realtime notifications **/
  function get_notifications(){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/get_notifications",
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.success == true){
                console.log(data);
                $(".count_notif").text(data.notif_count);
				$(".count_mnotif").text(data.notif_count1);
              console.log('a');
              console.log(data.notif_html1);
               $("#notifications-container").html(data.notif_html);
                $("#notifications-container1").html(data.notif_html1);
              }
           }
      });
  }
/** end get realtime notifications **/

    function popupwindow(url,type) {
    	if(type == 'doc'){
        	var src_val = "https://docs.google.com/gview?url="+url+"&embedded=true";
        	$(".ifram_src").attr("src",src_val);
    		$(".doc-display-mdl").modal('show');    
        	return false;
        }
    
    	var w = 500;
        var h =400;
        var left = Number((screen.width/2)-(w/2));
        var tops = Number((screen.height/2)-(h/2));
		// var screenwidth = $(window).width();
		// var screenheight = $(window).height();
		
		// var y = window.outerHeight / 2 + window.screenY - ( screenwidth / 2)
		// var x = window.outerWidth / 2 + window.screenX - ( screenheight / 2)
    	return window.open(url,'new',"width=500,height=400,top="+tops+",left="+left+"");
	} 
    
    $("#cancel-doc-display-mdl").click(function(){
    	$(".doc-display-mdl").modal('hide');  
    });
    
   setInterval(function(){ get_notifications(); }, 5000);
/*  $(document).ready(function(){ */
    $('[data-toggle="tooltip"]').tooltip();
/*  }); */
//$('#time_zone_display').html(Intl.DateTimeFormat().resolvedOptions().timeZone);
console.log(Intl.DateTimeFormat().resolvedOptions().timeZone)