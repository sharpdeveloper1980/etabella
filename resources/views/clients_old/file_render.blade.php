@extends('layouts.client.app')
@section('title','File Render')
@section('content')
 <style type="text/css">
  .incomming_comment {
    width: 80%;
    height: 50px;
  }
  .outgoing_comment {
    width: 80%;
    height: 50px;
    margin-left: 20%;
    background: #ebeef5;;
    color: #333;
    padding: 10px;
    border-radius: 8px;
     margin-bottom: 10px;
}
.incomming_comment {
    width: 80%;
    height: 50px;
    background: #f9f1ca;
    border-radius: 6px;
    margin-bottom: 10px;
	color:#333;
	padding: 10px;
}

</style>
  <div class="row custom-toolbar-parent">
    <ul class="list-inline custom-toolbar">
      <li><a href="#" id="close">Close</a></li>
      <!-- <li><a href="#" id="rotate"><img src="{{asset('public/frontend/img/rotate.png')}}" height="25" width="25"></a></li> -->
      <li style="width: 1140px; text-align: center; color: #E54E09;"><b> {{$file->file_name}} </b></li>
      <!-- <li><a href="#" id="page"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li> -->
      
      <!-- <li><a href="#" id="search"><i class="fa fa-search" aria-hidden="true"></i></a></li> -->
      
      <!-- <li><a href="#" id="annotation"><i class="fa fa-external-link" aria-hidden="true"></i><input type="hidden" class="annotation_cls" name="annotation" value="true"></a></li> -->
      <!-- <li><a href="#" id="grid"><i class="fa fa-th-large"></i></a></li>  -->
    </ul>
  </div>
    
    <!-- 2. Element where PSPDFKit will be mounted. -->
    <div id="pspdfkit" style="width: 100%;"></div>
  
  <div class="modal fade" id="add_txt_mark" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add To Mark</h4>
        </div>
        <div class="modal-body">
          <h4 id="mark_text" style=" width: 100%;  word-break: break-word; "></h4>
          <hr>
          <div class="all_comment">
           
          </div>
           <div class="new_comment"></div>
          <div class="form-group">
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field" placeholder="Enter Comment..."></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data">Save</button> <a id="share_comment" class="btn pull-right" href="javascript:;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="add_txt_mark_2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add To Mark</h4>
        </div>
        <div class="modal-body">
          <h4 style=" width: 100%;  word-break: break-word; " id="mark_text_2"></h4>
          <hr>
          <div class="all_comment_2">
           
          </div>
          <div class="new_comment_2"></div>
         
          <div class="form-group">
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field_2" placeholder="Enter Comment..."></textarea>
            <input type="hidden" name="document_id1" id="document_id1" value="{!! Request::segment(3) !!}">
            <input type="hidden" name="client_id" id="client_id" value="{!! $notofocation_main->sender; !!}">
            <input type="hidden" name="d1" id="d1" value="{!! $notofocation_main->file_id; !!}">
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data_2">Save</button> <a id="share_comment" class="btn pull-right" href="javascript:;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- 3. Initialize PSPDFKit. -->
    <script>
	resizeDiv();
	  function resizeDiv() {
		vpw = $(window).width();
		vph = $(window).height()-107;
		$("#pspdfkit").css({'height': vph + 'px'});
	  }
      // PSPDFKit.preloadWorker({
      //   disableWebAssemblyStreaming: true,
      //   baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
      //   licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J"
      // });
   function pdf_overlay(fid){
    console.log(markers)
   
      // var f_id=$('#file_id').val();
     
    }
 //   console.log("{{ $annotJson }}");
      const items2 = PSPDFKit.defaultToolbarItems;
      var counter=0;
	
      $.ajax({ 
           url:api_url+"{{ $file->pspdf_file_id }}/{{ $layer_token }}",
           method:'GET',
           contentType:"application/json",
           success : function(resp){
      PSPDFKit.load({
        container: "#pspdfkit",
        //disableWebAssemblyStreaming: false,
       //  baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
       // pdf: "{{ url('/public/storage/files/'.$file->file_upload_name) }}",
        documentId: "{{ $file->pspdf_file_id }}",
         authPayload: { jwt: resp },
     /*  renderPageCallback: function(ctx, pageIndex, pageSize) {
    ctx.beginPath();
    ctx.moveTo(pageSize.width, 0);
    ctx.lineTo(pageSize.width, pageSize.height);
    ctx.stroke();
       
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(0, pageSize.height);
    ctx.stroke();

    ctx.font = "30px Comic Sans MS";
    ctx.fillStyle = "red";
    ctx.textAlign = "center";
    ctx.fillText(
      `This is page ${pageIndex + 1}`,
      pageSize.width / 2,
      pageSize.height / 2
    );
  }, */
 
      
         instant: true,
        /*licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J",*/
       /* instantJSON: {
          format: "https://pspdfkit.com/instant-json/v1",
          <?php if($annotJson){ ?>
          annotations: <?=$annotJson?>,
          <?php } 
          ?>
          },*/
      })
        .then(function(instance) {
    
			
         var fid={{ $file->file_id }};
        // alert(<?php echo $sender ?>)
        $.post(baseurl+'/clients/get_document_file',{_token:"{{ csrf_token() }}",'file_id':fid,'sender':<?php echo $sender ?>},function(fb){
        var file_resp=$.parseJSON(fb);
        console.log(file_resp);
        
        if(file_resp.status=='true')
        {
        var size=Object.keys(file_resp.data).length 
        const videoWidget=[];
        for(i=0;i<size;i++)
        {
        	//console.log(file_resp.data[i]);
        	videoWidget[i] = document.createElement('div');
        	if(file_resp.data[i].file_type=='jpg' || file_resp.data[i].file_type=='png' || file_resp.data[i].file_type=='svg')
          {          
          	 videoWidget[i].innerHTML ='<img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[i].file_name+'">';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+i,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp4' || file_resp.data[i].file_type=='avi' || file_resp.data[i].file_type=='webm' || file_resp.data[i].file_type=='avi')
          {
            videoWidget[i].innerHTML =
              '\
              <video width="200" controls>\
              <source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="video/'+file_resp.data[i].file_type+'"> \
              Your browser does not support HTML5 video. \
              </video> \
            ';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+i,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp3' || file_resp.data[i].file_type=='mpeg' || file_resp.data[i].file_type=='m4r' || file_resp.data[i].file_type=='ogg')
          {
            videoWidget[i].innerHTML =
              '<audio style="width:200px" controls><source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="audio/'+file_resp.data[i].file_type+'"></audio>';
               var item = new PSPDFKit.CustomOverlayItem({
                id: "video-instructions_"+i,
                node: videoWidget[i],
                pageIndex:parseInt(file_resp.data[i].page_no),
                position: new PSPDFKit.Geometry.Point({ x: 360, y: 730 })
              });
              instance.setCustomOverlayItem(item);
          }
          else 
          {
            videoWidget[i].innerHTML ='<a href="'+baseurl+'/'+file_resp.data[i].file_name+'" target="_blank"><img width="50px" height="50px" src="https://image.flaticon.com/icons/png/512/2323/premium/2323513.png"></a>';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+i,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 530, y: 720 })
            });
            instance.setCustomOverlayItem(item);
          }
        	
        }
        return false;
           videoWidget = document.createElement('div');
          const videoWidget1 = document.createElement('div');
          //const videoWidget = document.createElement('div');
          if(file_resp.data[0].file_type=='jpg' || file_resp.data[0].file_type=='png' || file_resp.data[0].file_type=='svg')
          {          videoWidget.innerHTML ='<img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[0].file_name+'">';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions",
              node: videoWidget,
              pageIndex:parseInt(file_resp.data[0].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
           
           videoWidget1.innerHTML ='<img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[0].file_name+'">';
           var item1 = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions1",
              node: videoWidget1,
              pageIndex:1,
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
           instance.setCustomOverlayItem(item1);
          }
          else if(file_resp.data[0].file_type=='mp4' || file_resp.data[0].file_type=='avi' || file_resp.data[0].file_type=='webm' || file_resp.data[0].file_type=='avi')
          {
            videoWidget.innerHTML =
              '\
              <video width="200" controls>\
              <source src="'+baseurl+'/'+file_resp.data[0].file_name+'" type="video/'+file_resp.data[0].file_type+'"> \
              Your browser does not support HTML5 video. \
              </video> \
            ';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions",
              node: videoWidget,
              pageIndex:parseInt(file_resp.data[0].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
          }
          else if(file_resp.data[0].file_type=='mp3' || file_resp.data[0].file_type=='mpeg' || file_resp.data[0].file_type=='m4r' || file_resp.data[0].file_type=='ogg')
          {
            videoWidget.innerHTML =
              '<audio style="width:200px" controls><source src="'+baseurl+'/'+file_resp.data[0].file_name+'" type="audio/'+file_resp.data[0].file_type+'"></audio>';
               var item = new PSPDFKit.CustomOverlayItem({
                id: "video-instructions",
                node: videoWidget,
                pageIndex:parseInt(file_resp.data[0].page_no),
                position: new PSPDFKit.Geometry.Point({ x: 360, y: 730 })
              });
              instance.setCustomOverlayItem(item);
          }
          else 
          {
            videoWidget.innerHTML ='<a href="'+baseurl+'/'+file_resp.data[0].file_name+'" target="_blank"><img width="50px" height="50px" src="https://image.flaticon.com/icons/png/512/2323/premium/2323513.png"></a>';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions",
              node: videoWidget,
              pageIndex:parseInt(file_resp.data[0].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 530, y: 720 })
            });
            instance.setCustomOverlayItem(item);
          }

        }
      });
      
      
      
      
          // deleteBookmarks
          const viewState = instance.viewState;

          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", false));
          // => 0

          // if ($.inArray(curr_page, arr_pages)) {
          //   console.log('current page is '+curr_page);
          //   $(".i-bookmark").removeClass("fa-bookmark-o");
          //   $(".i-bookmark").addClass("fa-bookmark");
          // }else {
          //   $(".i-bookmark").removeClass("fa-bookmark");
          //   $(".i-bookmark").addClass("fa-bookmark-o");
          // }
          instance.setViewState(viewState.set("showToolbar", false));
      
      const state = instance.viewState;
            const newState = state.set("scrollMode", "PER_SPREAD");
            instance.setViewState(newState);
      const textSelection = instance.getTextSelection();
    json='';
      instance.addEventListener("textSelection.change", function(textSelection) {
        if (textSelection) {
          textSelection.getText().then(function(text) {

           
          counter++;
           instance.addEventListener("textSelection.change", function(textSelection) {
               if(counter>0)
               { 
              $('#add_txt_mark_2').modal('show');
              $('#mark_text_2').text(text);
              $('.all_comment_2').html('');
              $('.new_comment').html('');
              $('.new_comment_2').html('');
               }
               var annotations = instance.getAnnotations(0).then(function(annotations) {
                console.log(annotations);
                annotations.forEach(function(annotation) {
                var serializedObject = PSPDFKit.Annotations.toSerializableObject(annotation);
                              var json = JSON.stringify(serializedObject);
                              localStorage.setItem("last_ins_1",json);
                
                });
                setTimeout(function(){
                console.log(localStorage.getItem("last_ins_1"));  
                },5000)
                
              });
            });
          });
        } else {
          console.log("no text is selected");
        }
        });

    instance.addEventListener("annotations.press", event => {
      var serializedObject = PSPDFKit.Annotations.toSerializableObject(event.annotation);
      var json = JSON.stringify(serializedObject);
      var resp=$.parseJSON(json);

      if(resp.type == "pspdfkit/markup/underline"){
        var id=resp.id;
         $.post(baseurl+'/clients/check_hyperlink',{_token:"{{ csrf_token() }}","id":id},function(fb){
           var ajax_resp=$.parseJSON(fb);
           if(ajax_resp.status=='true')
           {
            if(ajax_resp.data[0].is_external == 1){
              window.open(ajax_resp.data[0].url, '_blank');
            }else{
              window.location.href=baseurl+'/'+ajax_resp.data[0].url;
            }
           }
         })
      }else if(resp.type=='pspdfkit/markup/squiggly'){
        var serializedObject = PSPDFKit.Annotations.toSerializableObject(event.annotation);
         var json = JSON.stringify(serializedObject);
         localStorage.setItem("last_ins",json);
         $.post(baseurl+'/clients/read_all_text_comment',{_token:"{{ csrf_token() }}",'json':json},function(fb){
          var resp=$.parseJSON(fb);
          if(resp.status=='true')
          {
            var message=resp.data;
            console.log(message)
            $('#add_txt_mark').modal('show');
            $('#mark_text').text(resp.message);
            $('.all_comment').html('');
            $('.new_comment').html('');
            $('.new_comment_2').html('');
            $('#comment_id').val(resp.comment_id);
            for(i=0;i<Object.keys(message).length;i++)
            {
            if(resp.user_id==message[i].user_id)
              $('.all_comment').append('<div class="outgoing_comment">'+message[i].comment+'</div>');
            else 
              $('.all_comment').append('<div class="incomming_comment">'+message[i].comment+'</div>');
            }

          }
         });
      //   $.post(baseurl+'/clients/read_all_text_comment',{_token:"{{ csrf_token() }}","json":json},function(fb){
      //     let resp=$.parseJSON(fb);
      //     if(resp.status=='true'){
      //       var message=resp.data;
      //       console.log(message)
      //       $('#add_txt_mark').modal('show');
      //       $('#mark_text').text(resp.message);
      //       $('.all_comment').html('');
      //       $('.new_comment').html('');
      //       $('#comment_id').val(resp.comment_id);
      //       $('#share_comment').css({'display':'block'});
      //       for(i=0;i<Object.keys(message).length;i++)
      //       {
      //       if(resp.user_id==message[i].user_id)
      //       $('.all_comment').append('<div class="outgoing_comment">'+message[i].comment+'</div>');
      //       else 
      //       $('.all_comment').append('<div class="incomming_comment">'+message[i].comment+'</div>');
      //     }
      //   }
      // });
    }else{}
     return false;
     
        var id=resp.id;
        $.post(baseurl+'/clients/check_hyperlink',{_token:"{{ csrf_token() }}","id":id},function(fb){
           var ajax_resp=$.parseJSON(fb);
           if(ajax_resp.status=='true'){
             window.location.href=baseurl+'/'+ajax_resp.data[0].url;
           }else{
            load(setting,zNodes_links);
            $('#annotation_id').val(id);
            $('#create_hyperlink_popup').modal('show');
           }
        })
    });

    // instance.addEventListener("annotations.press", event => {
    //   if (event.annotation instanceof PSPDFKit.Annotations.HighlightAnnotation || event.annotation instanceof PSPDFKit.Annotations.SquiggleAnnotation || event.annotation instanceof PSPDFKit.Annotations.UnderlineAnnotation || event.annotation instanceof PSPDFKit.Annotations.StrikeOutAnnotation) {
        
    //     event.preventDefault();                                                                                    
    //     console.log(event.annotation);
    //      var serializedObject = PSPDFKit.Annotations.toSerializableObject(event.annotation);
    //      var json = JSON.stringify(serializedObject);
    //      localStorage.setItem("last_ins",json);
    //      $.post(baseurl+'/clients/read_all_text_comment',{_token:"{{ csrf_token() }}",'json':json},function(fb){
    //       var resp=$.parseJSON(fb);
    //       if(resp.status=='true')
    //       {
    //         var message=resp.data;
    //         console.log(message)
    //         $('#add_txt_mark').modal('show');
    //         $('#mark_text').text(resp.message);
    //         $('.all_comment').html('');
    //         $('.new_comment').html('');
    //         $('.new_comment_2').html('');
    //         $('#comment_id').val(resp.comment_id);
    //         for(i=0;i<Object.keys(message).length;i++)
    //         {
    //         if(resp.user_id==message[i].user_id)
    //           $('.all_comment').append('<div class="outgoing_comment">'+message[i].comment+'</div>');
    //         else 
    //           $('.all_comment').append('<div class="incomming_comment">'+message[i].comment+'</div>');
    //         }

    //       }
    //      })
    //     }
    //   });
          
          $('#page').click(function(){
            const viewState = instance.viewState;
            const curr_page = viewState.currentPageIndex+1;
              $.confirm({
                  title: 'Go To Page #!',
                  content: '' +
                  '<form action="" class="formName">' +
                  '<div class="form-group">' +
                  '<label>Current Page : '+curr_page+'</label>' +
                  '<input type="text" placeholder="Page Number" class="name form-control" required />' +
                  '</div>' +
                  '</form>',
                  buttons: {
                      formSubmit: {
                          text: 'Ok',
                          btnClass: 'btn-blue',
                          action: function () {
                              
                              var name = this.$content.find('.name').val();
                              
                              if(!name){
                                  $.alert('provide a valid page number');
                                  return false;
                              }
                              // $.alert('Your name is ' + name);
                              instance.setViewState(viewState.set("currentPageIndex", name - 1));
                              
                                console.log(arr_pages);
                                console.log(name);
                                console.log(arr_pages.indexOf(21));
                              
                              if ($.inArray(Number(name), arr_pages) !== -1) {

                                console.log('in array');
                                $("#i-bookmark").removeClass("fa-bookmark-o");
                                $("#i-bookmark").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark").addClass("fa-bookmark-o");
                              }

                          }
                      },
                      cancel: function () {
                          //close
                      },
                  },
              });

          });

          $('.createbookmark').click(function(){
            const viewState = instance.viewState;
            const curr_page = viewState.currentPageIndex+1;
            
             
              const bookmark = new PSPDFKit.Bookmark({
                  name: "Bookmark-"+curr_page,
                  action: new PSPDFKit.Actions.GoToAction({
                   pageIndex: curr_page 
                   })
                });
                instance.createBookmark(bookmark).then(function(createdBookmark) {
                  $("#i-bookmark").removeClass("fa-bookmark-o");
                  $("#i-bookmark").addClass("fa-bookmark");
                });
          });

          $('.deletebookmark').click(function(){
            const viewState = instance.viewState;
            const curr_page = viewState.currentPageIndex+1;
            
             
              const bookmark = new PSPDFKit.Bookmark({
                  name: "Bookmark-"+curr_page,
                  action: new PSPDFKit.Actions.GoToAction({
                   pageIndex: curr_page 
                   })
                });
                instance.createBookmark(bookmark).then(function(createdBookmark) {
                   console.log(instance);
                });
          });

          $('#search').click(function(){
            // instance.startUISearch("..");
            // $(".PSPDFKit-Search-Form-Input").val('');
            instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
          });

          $("#annotation").click(function(){
            const annot_val = $(".annotation_cls").val();
            instance.setViewState(viewState.set("showToolbar", annot_val));
            if(annot_val == 'true'){
              $(".annotation_cls").val('false');
            }else{
              $(".annotation_cls").val('true');
            }
            // console.log(instance);
          });

          $("#rotate").click(function(){
            instance.setViewState(viewState => viewState.rotateRight());
          });

          $("#close").click(function(){
              window.location.href=baseurl+"/clients/dashboard";
              // instance.exportInstantJSON().then(function(instantJSON) {
                
              //   const page_no = viewState.currentPageIndex + 1; // => 0
              //   // // console.log(instantJSON); 

              //   swal({
              //     title: 'Are you sure to save this file?',
              //     text: '',
              //     type: 'warning',
              //     showCancelButton: true,
              //     confirmButtonColor: '#3085d6',
              //     cancelButtonColor: '#d33',
              //     confirmButtonText: 'Save it!',
              //     cancelButtonText: 'No cancel!',
              //     confirmButtonClass: 'confirm-class',
              //     cancelButtonClass: 'cancel-class',
              //     closeOnConfirm: false,
              //     closeOnCancel: false
              //   },
              //   function(isConfirm) {
              //     if (isConfirm) {
              //       console.log(JSON.stringify(instantJSON));
              //       $.ajax({
              //         type: "POST",
              //         url: baseurl+"/clients/instant-json",
              //         data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:"{{$file->file_id}}",page_no:page_no},
              //         success: function(data)
              //         {  
              //           if(data == true){
              //             swal('Save','File Updated Successfully','success');
              //             // arr_pages.push(page_no);
              //             // console.log(arr_pages);
              //           }
              //         }
              //       });
              //     } else {
              //       swal(
              //         'Cancelled',
              //         'Your imaginary file is safe :)',
              //         'error'
              //       );
              //     }
              //   });
              // });
            });

          $("#grid").click(function(){
            setTimeout(function(){
              $('.PSPDFKit-DocumentEditor').hide();
            },2000)
            
              instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
          });



          instance.setToolbarItems(function(items) {
            // console.log('here');
            // console.log(items);
            items.splice(0, 30);
            items.push({"type":"spacer"});
            items.push({"type":"highlighter"});
            items.push({"type":"ink"});
            items.push({"type":"text-highlighter"});
            items.push({"type":"ink-eraser"});
            items.push({"type":"line"});
            items.push({"type":"arrow"});
            items.push({"type":"rectangle"});
            items.push({"type":"ellipse"});
            items.push({"type":"polygon"});
            items.push({"type":"polyline"});
            items.push({"type":"text"});
            items.push({"type":"note"});
            return items;
          });
      
      $(document).on('click','#save_selected_data_2',function(){
        var comment=$('#comment_field_2').val();
        var text=$('#mark_text_2').text(); 
        var document_id=$('#document_id1').val();
        var client_id=$('#client_id').val();
        var d1=$('#d1').val();
        $('#save_selected_data_2').html('Save <i  class="fa fa-spinner" aria-hidden="true"></i>');
         $('#save_selected_data_2').attr("disabled", true);
        if(comment!='')
        {
         setTimeout(function(){
         var lst_id=localStorage.getItem("last_annotation_id");
         var current_instanceJSON=localStorage.getItem("last_ins_1");
         console.log(current_instanceJSON);
        
         

          instance.exportInstantJSON().then(function(instantJSON) {
            
            const viewState = instance.viewState;
            const page_no = viewState.currentPageIndex + 1; // => 0
            $.post(baseurl+'/clients/shared_file_update',{_token:"{{ csrf_token() }}",json:JSON.stringify(instantJSON.annotations),'document_id':document_id,'comment':comment,'text':text,'current_instanceJSON':current_instanceJSON,'client_id':client_id,'d1':d1,'page_no':page_no},function(fb){
             $('#save_selected_data_2').html('Save');
             $('#save_selected_data_2').removeAttr("disabled");
              counter=0;
              if(fb.match('1'))
              {

              swal('Text Successfully share')
              //setTimeout(function(){ location.reload(); },2000);
              $('.new_comment_2').append('<div class="outgoing_comment">'+comment+'</div>');
              $('#comment_field_2').val('');

              }
            }) 

             
            });

         /*  $.post(baseurl+'/clients/selected_text_information_save',{_token:"{{ csrf_token() }}",'comment':comment,'last_id':lst_id,'text':text,'current_instanceJSON':current_instanceJSON},function(fb){
          swal('Save','Comment Successfully Added','success');
         setTimeout(function(){
          location.reload();
          },2000)
         });*/
        },4000);
       } 
       else 
       {
        swal('Please Enter Comment');
       }
        
      });

    $(document).on('click','#save_selected_data',function(){
      var comment=$('#comment_field').val();
      var text=$('#mark_text').text(); 
      var client_id=$('#client_id').val();
        var document_id=$('#document_id1').val();
        var d1=$('#d1').val();
      $('#save_selected_data').html('Save <i  class="fa fa-spinner" aria-hidden="true"></i>');
      $('#save_selected_data').attr("disabled", true);
      if(comment!='')
      {
        
         var lst_id=localStorage.getItem("last_annotation_id");
         var current_instanceJSON=localStorage.getItem("last_ins");
         console.log(current_instanceJSON);
        
        
      instance.exportInstantJSON().then(function(instantJSON) {
        const viewState = instance.viewState;
            const page_no = viewState.currentPageIndex + 1; // => 0
               $.post(baseurl+'/clients/shared_file_update',{_token:"{{ csrf_token() }}",'comment':comment,'last_id':lst_id,'text':text,'current_instanceJSON':current_instanceJSON,'client_id':client_id,'d1':d1,'document_id':document_id,'json':JSON.stringify(instantJSON.annotations),'page_no':page_no,'unique_token':'second'},function(fb){
              $('#save_selected_data').html('Save');
              $('#save_selected_data').removeAttr("disabled");
                swal('Save','Comment Successfully Added','success');
                $('#add_txt_mark').modal('hide');
              $('.new_comment').append('<div class="outgoing_comment">'+comment+'</div>');
              $('#comment_field').val('');
              counter=0;
             /*  setTimeout(function(){
                  location.reload();
                },2000)*/
               });

               });



              
           } 
           else 
           {
              swal('Please Enter Comment');
           }
            
        });
      
    
        })
        .catch(function(error) {
          console.error(error.message);
        });
      }
      });



  $(document).on('click',function(){
    count=0;
  });
    </script>
@endsection