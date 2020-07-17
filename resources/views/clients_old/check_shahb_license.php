@extends('layouts.client.app')
@section('title','Client Dashboard')
@section('content')
<style>
  .nodefile.filecheck {
    display: none !important;
  }
  
  i.fa.fa-check {
    color: green;
    font-size: 20px;
    margin-left: 16px;
  }

  .jconfirm-box.jconfirm-hilight-shake.jconfirm-type-default.jconfirm-type-animated {
      width: 500px !important;
   }

  ul {
    list-style: none;
  }
  
  .PSPDFKit-DocumentEditor > div:first-child {
    display: none !important;
  }
</style>
<?php 
      // echo "<pre>";
      // print_r(json_decode($bookJson));
      $arr_book_pages = [];
      $bookmrks = json_decode($bookJson);
      if($bookmrks){
        foreach ($bookmrks as $key => $mrk) {
          $arr_book_pages[] = $mrk->action->pageIndex;
        }
      }
    ?>

  <div class="row custom-toolbar-parent">
    <input type="hidden" name="active_file_id" class="active_file_id" value="{{$id}}">
    <ul class="list-inline custom-toolbar">
      <li><a href="#" id="close" class="closebtn">Close</a></li>
      <li><a href="#" id="rotate" class="rotatebtn"><img src="{{asset('public/frontend/img/rotate.png')}}" height="23" width="23"></a></li>
      <li><a href="#" onclick="getTags()"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></li>

      @if(count($clients) > 0)
       <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="share_user"><i class="fa fa-users" aria-hidden="true"></i></a>
          <ul class="dropdown-menu clients-dropdown-menu">
            @foreach($clients as $clnkey => $clnt)
              <li>
                <a href="#" onclick="shareAnnotation(<?=$clnt->client_id?>)" data-clientid="{{$clnt->client_id}}" data-clientname="{{$clnt->client_display_name}}">
                <i class="fa fa-user" style="margin-right: 5px;"></i> 
                  {{ucfirst($clnt->client_display_name)}} 
                </a>
              </li>
            @endforeach
          </ul>
      </li>
      @endif

      <li style="width: 841px; text-align: center; color: #E54E09;"><b> {{$file->file_name}} </b></li>
      
      <li><a href="#" id="compare_btn"><i class="fa fa-files-o" aria-hidden="true"></i></a></li>
      
      <li><a href="#" id="page1" data-toggle="modal" data-toggle="modal" data-target="#pageModal"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
      
      <li><a href="#" class="createbookmark"><i id="i-bookmark" class="fa @if(in_array(1, $arr_book_pages)) fa-bookmark @else fa-bookmark-o @endif i-bookmark" aria-hidden="true"></i></a></li>
      <li><a href="#" id="search" class="searchbtn"><i class="fa fa-search" aria-hidden="true"></i></a></li>
      
      <li class="annotation-li"><a href="#" id="annotation" class="annotationbtn"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls{{$id}}" name="annotation-{{$id}}" value="true"></a></li>
      <li><a href="#" id="grid" class="gridbtn"><i class="fa fa-th-large"></i></a></li> 
      @if(count($myFiles) > 0)
      <li class="dropdown pull-right">
        <a href="#" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">My File</a>
        <ul id="treeDemo_dd" class="dropdown-menu treeDemo_dd ztree">
          
        </ul>
      </li>
      @endif
    </ul>
  </div>

  <div class="row tag-line tag-title-con" style="display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
    <small id="tag-title"></small>
  </div>

  <div class="container">
    <ul class="nav nav-tabs" role="tablist" style="width: 100%;">
        <li class="active">
          <a href="#pspdfkit_{{$id}}" data-file_id="{{$id}}" data-toggle="tab"><!-- <span style="padding-right: 9px;"> x </span> --> {{ $file->file_name }}</a>
        </li>
        
        <!-- <li><a href="#" class="add-contact">+ Add Contact</a>
        </li> -->
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="pspdfkit_{{$id}}" style="width: 100%; height: 480px;"></div>
    </div>
  </div>

  <div class="modal fade docs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-groupsearch_sorting" id="search_files">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
        <form method="POST" action="{{ route('compareFiles') }}">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="{{ $id }}">
            <input type="hidden" name="compare_second_file" class="compare_2" value="{{ $id }}">
            <ul id="treeDemo" class="treeDemo ztree">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Compare</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade modal-color-picker" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Colour picker</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="hdn_color_picker" class="hdn_color_picker" value="#ccc">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="pageModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Go to Page #</h4>
        </div>
        <div class="modal-body">
          <input type="number" id="pageNo" min="0"> 
        </div>
        <div class="modal-footer">
          <button type="button" id="" class="btn btn-default pagebutton" data-dismiss="modal">Go</button>
        </div>
      </div>
    </div>
  </div>
@section('js')
<script type="text/javascript">
  var markers = [];
  var id = "{{$id}}";
  var mi = 0;
  var arr_pages = [];
  var zNodes = {!! json_encode($all_nods) !!};
  var zNodes_dd = {!! json_encode($all_nods_dd) !!};
  var setting = {
        data: {
          simpleData: {
          enable: true
        },
      },
        view: {
          addDiyDom: null,
          autoCancelSelected: true,
          dblClickExpand: true,
          expandSpeed: "fast",
          fontCss: {},
          nameIsHTML: true,
          selectedMulti: true,
          showIcon: false,
          showLine: true,
          showTitle: true,
          txtSelectedEnable: true,
        },
        check: {
          enable: false
        },
        callback: {
        // onCheck: zTreeOnCheck
        }
      };


  
      $("#color-picker").click(function(){
        $(".modal-color-picker").modal('show');
      });

      $(".nav-tabs").on("click", "a", function (e) {
          e.preventDefault();

          var idd = $(this).data('file_id');
          
          $('.active_file_id').val(idd);

          $(".activefile").val(idd);
          
          $('.pagebutton').attr('onclick','gotoPage('+idd+')');
          $('.closebtn').attr('onclick','closeKit('+idd+')');
          $('.rotatebtn').attr('onclick','rotateKit('+idd+')');
          $('.annotationbtn').attr('onclick','annotationKit('+idd+')');

          $('.searchbtn').attr('onclick','searchKit('+idd+')');
          $('.gridbtn').attr('onclick','gridKit('+idd+')');
          /** For Bookmark **/
          getBookmarkedPages(idd);
          
          $('.createbookmark').attr('onclick','createBookmark('+idd+')');

          setTimeout(function(){
            currentPage(idd);  
            getCheckedTag(idd);

          },1000);
          /** For Bookmark End **/


          if (!$(this).hasClass('add-contact')) {
              $(this).tab('show');
          }
          console.log(markers);
      })
      .on("click", "span", function () {
          var anchor = $(this).siblings('a');
          $(anchor.attr('href')).remove();
          $(this).parent().remove();
          $(".nav-tabs li").children('a').first().click();
      });

  $('.add-contact').click(function (e) {
      e.preventDefault();
      var id = $(this).data('fileid');
      var Fname = $(this).data('filename'); //think about it ;)
      var tabId = 'pspdfkit_' + id;
      $('.nav-tabs li:last-child').after('<li><a href="#pspdfkit_' + id + '" data-file_id="'+id+'"> <span> x </span> '
        +Fname+'</a></li>');
      $('.annotation-li').after('<input type="hidden" class="annotation_cls'+id+'" name="annotation-'+id+'" value="true">');
      $('.tab-content').append('<div class="tab-pane" id="' + tabId + '" style="width: 100%; height: 480px;"></div>');
     $('.nav-tabs li:nth-child(' + id + ') a').click();
     getFileData(id);
  });

  function addContact(id) {
      // var id = $(this).data('fileid');
      var Fname = $(".add-contact-"+id).data('filename'); //think about it ;)
      var tabId = 'pspdfkit_' + id;
      $('.nav-tabs li:last-child').after('<li><a href="#pspdfkit_' + id + '" data-file_id="'+id+'"> <span> x </span> '
        +Fname+'</a></li>');
      $('.annotation-li').after('<input type="hidden" class="annotation_cls'+id+'" name="annotation-'+id+'" value="true">');
      $('.tab-content').append('<div class="tab-pane" id="' + tabId + '" style="width: 100%; height: 480px;"></div>');
     $('.nav-tabs li:nth-child(' + id + ') a').click();
     getFileData(id);
  }

  getFileData(id);
   
  $('.pagebutton').attr('onclick','gotoPage('+id+')');
  $('.createbookmark').attr('onclick','createBookmark('+id+')');
  $('.closebtn').attr('onclick','closeKit('+id+')');
  $('.rotatebtn').attr('onclick','rotateKit('+id+')');
  $('.annotationbtn').attr('onclick','annotationKit('+id+')');
  $('.searchbtn').attr('onclick','searchKit('+id+')');
  $('.gridbtn').attr('onclick','gridKit('+id+')');

  function gridKit(id){
    let state = markers[id].viewState;
    markers[id].setViewState(state.set("interactionMode",
                PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
  }

  function searchKit(id){
    let state = markers[id].viewState;
    markers[id].setViewState(state.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
  }

  function gotoPage(id){
      var name = $('#pageNo').val();
                                
    if(!name){
      alert('provide a valid page number');
      return false;
    }
    // $.alert('Your name is ' + name);
    //markers[fid].setViewState(viewState.set("currentPageIndex", name - 1));
    let state = markers[id].viewState;
    let newState = state.set("currentPageIndex", 2);
      markers[id].setViewState(newState);
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

  function currentPage(id){
    console.log(id);
    console.log(arr_pages);
    const viewState = markers[id].viewState;
    const curr_page = viewState.currentPageIndex+1;
    if ($.inArray(Number(curr_page), arr_pages) !== -1) {
            $("#i-bookmark").removeClass("fa-bookmark-o");
            $("#i-bookmark").addClass("fa-bookmark");
          }else {
            console.log('Not in array');
            $("#i-bookmark").addClass("fa-bookmark-o");
          }
    return curr_page; 
  }

  function createBookmark(id){
    alert('bookmark');
    const viewState = markers[id].viewState;
    const curr_page = viewState.currentPageIndex+1;
                     
    const bookmark = new PSPDFKit.Bookmark({
            name: "Bookmark-"+curr_page,
            action: new PSPDFKit.Actions.GoToAction({
            pageIndex: curr_page 
            })
          });
          markers[id].createBookmark(bookmark).then(function(createdBookmark) {
            $("#i-bookmark").removeClass("fa-bookmark-o");
            $("#i-bookmark").addClass("fa-bookmark");
          });
  }

  function annotationKit(id){
    const annot_val = $(".annotation_cls"+id).val();
    console.log('dfdfdf');
    console.log(id);

    let state = markers[id].viewState;
    let newstate = state.set("showToolbar", annot_val);
    markers[id].setViewState(newstate);

    if(annot_val == 'true'){
      $(".annotation_cls"+id).val('false');
    }else{
      $(".annotation_cls"+id).val('true');
    }
  }


  function closeKit(id){
              markers[id].exportInstantJSON().then(function(instantJSON) {
                
                const viewState = markers[id].viewState;
                const page_no = viewState.currentPageIndex + 1; // => 0
                // // console.log(instantJSON); 

                swal({
                  title: 'Are you sure to save this file?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Save it!',
                  cancelButtonText: 'No cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    console.log(JSON.stringify(instantJSON));
                    $.ajax({
                      type: "POST",
                      url: baseurl+"/clients/instant-json",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('Save','File Updated Successfully','success');
                          // arr_pages.push(page_no);
                          // console.log(arr_pages);
                        }else{
                          swal('Something went wrong','error');
                        }
                      }
                    });
                  }
                });
              });
  }

  function rotateKit(id){
    markers[id].setViewState(viewState => viewState.rotateRight());
  }

  getBookmarkedPages(id);
  function getBookmarkedPages(id){
    arr_pages = [];
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          
            
            arr_pages = data.arr_book_pages;
          console.log(arr_pages);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }

  function getFileData(id){
    // $("#loader").show();
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          loadFile(data);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }  

  function loadFile(data){  
    
    if(data.annotJson){          
      PSPDFKit.load({
        container: "#pspdfkit_"+data.file.file_id,
        disableWebAssemblyStreaming: true,
        baseUrl: 'http://66.206.3.18/etabellaweb/public/dist/',
        pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
        licenseKey: "SdwYw58HCbIyStwlGWSsFB5B602pJWcNypZ_61OqodrXkrfceDOeOj1OatamVy40pjAFNGIVrgjF0MkWAiXtGpeM4Gl60BpYoBKnJVw9Jn9mj1G-gRroWTZYfLbO7916z8R3b_YwpOQNw4bZHwg9i4tpWMjgKwplS0pC2kh8Gcu1xt2h5bWNxOO0P7bZJOzjd_hIfFRKOv2ekouv_MoIGpDfxjr5x3bqD2kTZUNchhacLemzBkiY1VoKpRbliW_OOCU2vNlYz3OqkgNuXXfz8vko_aZ_Zmc5EMPaPvbp2B5nyZY3JA2KzuuakK5icKrKjxZKQORpq28uQDx82gAjmf9cy1s1mg4TI9mBqhDkDJqkHOE5R5y5IwN-bb6cXlCzSNIgSN64tIXKYQr_HOepVEgz4mxP9Q79yhD3YgY4YG4MYSFuzVdt-hc1fFsbcdID",
        instantJSON: {
          format: "https://pspdfkit.com/instant-json/v1",
          annotations: JSON.parse(data.annotJson),
          bookmarks: JSON.parse(data.bookJson),
          },
      })
        .then(function(instance) {
            // $("#loader").hide();
            var fid = data.file.file_id;
            markers[fid] =instance;

         
          instance.addEventListener("viewState.currentPageIndex.change", (pageIndex) => {
            console.log(pageIndex);
            if ($.inArray(Number(pageIndex+1), arr_pages) !== -1) {

                                console.log('in array');
                                $("#i-bookmark").removeClass("fa-bookmark-o");
                                $("#i-bookmark").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark").addClass("fa-bookmark-o");
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
          // var pid = '#gotoPage'+data.file.file_id;
          // $(document.body).on('click',pid,function(){
          //   alert(fid);
          //       var name = $('#pageNo').val();
                              
          //                     if(!name){
          //                         alert('provide a valid page number');
          //                         return false;
          //                     }
          //                     // $.alert('Your name is ' + name);
          //                     markers[fid].setViewState(viewState.set("currentPageIndex", name - 1));
                              
          //                       console.log(arr_pages);
          //                       console.log(name);
          //                       console.log(arr_pages.indexOf(21));
                              
          //                     if ($.inArray(Number(name), arr_pages) !== -1) {

          //                       console.log('in array');
          //                       $("#i-bookmark").removeClass("fa-bookmark-o");
          //                       $("#i-bookmark").addClass("fa-bookmark");
          //                     }else {
          //                       console.log('Not in array');
          //                       $("#i-bookmark").addClass("fa-bookmark-o");
          //                     }
          // });
          // $('#page').click(function(){
          //   const viewState = instance.viewState;
          //   const curr_page = viewState.currentPageIndex+1;
          //     $.confirm({
          //         title: 'Go To Page #!',
          //         content: '' +
          //         '<form action="" class="formName">' +
          //         '<div class="form-group">' +
          //         '<label>Current Page : '+curr_page+'</label>' +
          //         '<input type="text" placeholder="Page Number" class="name form-control" required />' +
          //         '</div>' +
          //         '</form>',
          //         buttons: {
          //             formSubmit: {
          //                 text: 'Ok',
          //                 btnClass: 'btn-blue',
          //                 action: function () {
                              
          //                     var name = this.$content.find('.name').val();
                              
          //                     if(!name){
          //                         $.alert('provide a valid page number');
          //                         return false;
          //                     }
          //                     // $.alert('Your name is ' + name);
          //                     instance.setViewState(viewState.set("currentPageIndex", name - 1));
                              
          //                       console.log(arr_pages);
          //                       console.log(name);
          //                       console.log(arr_pages.indexOf(21));
                              
          //                     if ($.inArray(Number(name), arr_pages) !== -1) {

          //                       console.log('in array');
          //                       $("#i-bookmark").removeClass("fa-bookmark-o");
          //                       $("#i-bookmark").addClass("fa-bookmark");
          //                     }else {
          //                       console.log('Not in array');
          //                       $("#i-bookmark").addClass("fa-bookmark-o");
          //                     }

          //                 }
          //             },
          //             cancel: function () {
          //                 //close
          //             },
          //         },
          //     });

          // });

          // $('.createbookmark').click(function(){
          //   const viewState = instance.viewState;
          //   const curr_page = viewState.currentPageIndex+1;
            
             
          //     const bookmark = new PSPDFKit.Bookmark({
          //         name: "Bookmark-"+curr_page,
          //         action: new PSPDFKit.Actions.GoToAction({
          //          pageIndex: curr_page 
          //          })
          //       });
          //       instance.createBookmark(bookmark).then(function(createdBookmark) {
          //         $("#i-bookmark").removeClass("fa-bookmark-o");
          //         $("#i-bookmark").addClass("fa-bookmark");
          //       });
          // });

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

          // $('#search').click(function(){
          //   // instance.startUISearch("..");
          //   // $(".PSPDFKit-Search-Form-Input").val('');
          //   instance.setViewState(viewState.set("interactionMode",
          //       PSPDFKit.InteractionMode.SEARCH));
          // });

          // $("#annotation").click(function(){
          //   const annot_val = $(".annotation_cls").val();
          //   instance.setViewState(viewState.set("showToolbar", annot_val));
          //   if(annot_val == 'true'){
          //     $(".annotation_cls").val('false');
          //   }else{
          //     $(".annotation_cls").val('true');
          //   }
          //   // console.log(instance);
          // });

          // $("#rotate").click(function(){
          //   instance.setViewState(viewState => viewState.rotateRight());
          // });

          // $("#close").click(function(){
          //     instance.exportInstantJSON().then(function(instantJSON) {
                
          //       const page_no = viewState.currentPageIndex + 1; // => 0
          //       // // console.log(instantJSON); 

          //       swal({
          //         title: 'Are you sure to save this file?',
          //         text: '',
          //         type: 'warning',
          //         showCancelButton: true,
          //         confirmButtonColor: '#3085d6',
          //         cancelButtonColor: '#d33',
          //         confirmButtonText: 'Save it!',
          //         cancelButtonText: 'No cancel!',
          //         confirmButtonClass: 'confirm-class',
          //         cancelButtonClass: 'cancel-class',
          //         closeOnConfirm: false,
          //         closeOnCancel: false
          //       },
          //       function(isConfirm) {
          //         if (isConfirm) {
          //           console.log(JSON.stringify(instantJSON));
          //           $.ajax({
          //             type: "POST",
          //             url: baseurl+"/clients/instant-json",
          //             data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
          //             success: function(data)
          //             {  
          //               if(data == true){
          //                 swal('Save','File Updated Successfully','success');
          //                 // arr_pages.push(page_no);
          //                 // console.log(arr_pages);
          //               }else{
          //                 swal('Something went wrong','error');
          //               }
          //             }
          //           });
          //         } else {
          //           swal(
          //             'Cancelled',
          //             'Your imaginary file is safe :)',
          //             'error'
          //           );
          //         }
          //       });
          //     });
          //   });

          // $("#grid").click(function(){
          //   setTimeout(function(){
          //     $('.PSPDFKit-DocumentEditor').hide();
          //   },2000)
            
          //     instance.setViewState(viewState.set("interactionMode",
          //       PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
          // });



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

        })
        .catch(function(error) {
          console.error(error.message);
        });
      }else{
        PSPDFKit.load({
        container: "#pspdfkit_"+data.file.file_id,
        disableWebAssemblyStreaming: true,
        baseUrl: 'http://66.206.3.18/etabellaweb/public/dist/',
        pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
        licenseKey: "SdwYw58HCbIyStwlGWSsFB5B602pJWcNypZ_61OqodrXkrfceDOeOj1OatamVy40pjAFNGIVrgjF0MkWAiXtGpeM4Gl60BpYoBKnJVw9Jn9mj1G-gRroWTZYfLbO7916z8R3b_YwpOQNw4bZHwg9i4tpWMjgKwplS0pC2kh8Gcu1xt2h5bWNxOO0P7bZJOzjd_hIfFRKOv2ekouv_MoIGpDfxjr5x3bqD2kTZUNchhacLemzBkiY1VoKpRbliW_OOCU2vNlYz3OqkgNuXXfz8vko_aZ_Zmc5EMPaPvbp2B5nyZY3JA2KzuuakK5icKrKjxZKQORpq28uQDx82gAjmf9cy1s1mg4TI9mBqhDkDJqkHOE5R5y5IwN-bb6cXlCzSNIgSN64tIXKYQr_HOepVEgz4mxP9Q79yhD3YgY4YG4MYSFuzVdt-hc1fFsbcdID"
      })
        .then(function(instance) {
          // $("#loader").hide();
          var fid = data.file.file_id;
          markers[fid] =instance;
          instance.addEventListener("viewState.currentPageIndex.change", (pageIndex) => {
            console.log(pageIndex);
                if ($.inArray(Number(pageIndex), arr_pages) !== -1) {

                                console.log('in array');
                                $("#i-bookmark").removeClass("fa-bookmark-o");
                                $("#i-bookmark").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark").addClass("fa-bookmark-o");
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
          // var pid = '#gotoPage'+data.file.file_id;
          // $(document.body).on('click',pid,function(){

          //       var name = $('#pageNo').val();
                              
          //                     if(!name){
          //                         alert('provide a valid page number');
          //                         return false;
          //                     }
          //                     // $.alert('Your name is ' + name);
          //                     markers[fid].setViewState(viewState.set("currentPageIndex", name - 1));
                              
          //                       console.log(arr_pages);
          //                       console.log(name);
          //                       console.log(arr_pages.indexOf(21));
                              
          //                     if ($.inArray(Number(name), arr_pages) !== -1) {

          //                       console.log('in array');
          //                       $("#i-bookmark").removeClass("fa-bookmark-o");
          //                       $("#i-bookmark").addClass("fa-bookmark");
          //                     }else {
          //                       console.log('Not in array');
          //                       $("#i-bookmark").addClass("fa-bookmark-o");
          //                     }
          // });
          // $('#page').click(function(){
          //   const viewState = instance.viewState;
          //   const curr_page = viewState.currentPageIndex+1;
          //     $.confirm({
          //         title: 'Go To Page #!',
          //         content: '' +
          //         '<form action="" class="formName">' +
          //         '<div class="form-group">' +
          //         '<label>Current Page : '+curr_page+'</label>' +
          //         '<input type="text" placeholder="Page Number" class="name form-control" required />' +
          //         '</div>' +
          //         '</form>',
          //         buttons: {
          //             formSubmit: {
          //                 text: 'Ok',
          //                 btnClass: 'btn-blue',
          //                 action: function () {
                              
          //                     var name = this.$content.find('.name').val();
                              
          //                     if(!name){
          //                         $.alert('provide a valid page number');
          //                         return false;
          //                     }
          //                     // $.alert('Your name is ' + name);
          //                     instance.setViewState(viewState.set("currentPageIndex", name - 1));
                              
          //                       console.log(arr_pages);
          //                       console.log(name);
          //                       console.log(arr_pages.indexOf(21));
                              
          //                     if ($.inArray(Number(name), arr_pages) !== -1) {

          //                       console.log('in array');
          //                       $("#i-bookmark").removeClass("fa-bookmark-o");
          //                       $("#i-bookmark").addClass("fa-bookmark");
          //                     }else {
          //                       console.log('Not in array');
          //                       $("#i-bookmark").addClass("fa-bookmark-o");
          //                     }

          //                 }
          //             },
          //             cancel: function () {
          //                 //close
          //             },
          //         },
          //     });

          // });

          // $('.createbookmark').click(function(){
          //   const viewState = instance.viewState;
          //   const curr_page = viewState.currentPageIndex+1;
            
             
          //     const bookmark = new PSPDFKit.Bookmark({
          //         name: "Bookmark-"+curr_page,
          //         action: new PSPDFKit.Actions.GoToAction({
          //          pageIndex: curr_page 
          //          })
          //       });
          //       instance.createBookmark(bookmark).then(function(createdBookmark) {
          //         $("#i-bookmark").removeClass("fa-bookmark-o");
          //         $("#i-bookmark").addClass("fa-bookmark");
          //       });
          // });

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

          // $('#search').click(function(){
          //   // instance.startUISearch("..");
          //   // $(".PSPDFKit-Search-Form-Input").val('');
          //   instance.setViewState(viewState.set("interactionMode",
          //       PSPDFKit.InteractionMode.SEARCH));
          // });

          // $("#annotation").click(function(){
          //   const annot_val = $(".annotation_cls").val();
          //   instance.setViewState(viewState.set("showToolbar", annot_val));
          //   if(annot_val == 'true'){
          //     $(".annotation_cls").val('false');
          //   }else{
          //     $(".annotation_cls").val('true');
          //   }
          //   // console.log(instance);
          // });

          // $("#rotate").click(function(){
          //   instance.setViewState(viewState => viewState.rotateRight());
          // });

          // $("#close").click(function(){
          //     instance.exportInstantJSON().then(function(instantJSON) {
                
          //       const page_no = viewState.currentPageIndex + 1; // => 0
          //       // // console.log(instantJSON); 

          //       swal({
          //         title: 'Are you sure to save this file?',
          //         text: '',
          //         type: 'warning',
          //         showCancelButton: true,
          //         confirmButtonColor: '#3085d6',
          //         cancelButtonColor: '#d33',
          //         confirmButtonText: 'Save it!',
          //         cancelButtonText: 'No cancel!',
          //         confirmButtonClass: 'confirm-class',
          //         cancelButtonClass: 'cancel-class',
          //         closeOnConfirm: false,
          //         closeOnCancel: false
          //       },
          //       function(isConfirm) {
          //         if (isConfirm) {
          //           console.log(JSON.stringify(instantJSON));
          //           $.ajax({
          //             type: "POST",
          //             url: baseurl+"/clients/instant-json",
          //             data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
          //             success: function(data)
          //             {  
          //               if(data == true){
          //                 swal('Save','File Updated Successfully','success');
          //                 // arr_pages.push(page_no);
          //                 // console.log(arr_pages);
          //               }else{
          //                 swal('Something went wrong','error');
          //               }
          //             }
          //           });
          //         } else {
          //           swal(
          //             'Cancelled',
          //             'Your imaginary file is safe :)',
          //             'error'
          //           );
          //         }
          //       });
          //     });
          //   });

          // $("#grid").click(function(){
          //   setTimeout(function(){
          //     $('.PSPDFKit-DocumentEditor').hide();
          //   },2000)
            
          //     instance.setViewState(viewState.set("interactionMode",
          //       PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
          // });

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

        })
        .catch(function(error) {
          console.error(error.message);
        });
      }
  }

    $("#compare_btn").click(function(){
      load(setting,zNodes);
      $(".docs-example-modal-lg").modal('show');
    });

    $("#tag").click(function(){
      var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              console.log(data);
              if(data != ''){
                $.confirm({
                    title: 'Tags  <a onclick="addTag('+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
                    content: data,
                });
              }else{
                $.confirm({
                    title: 'Tags',
                    content: '',   
                });
              }
            }
        });
    });

    var a = '';
    function getTags(){ 
      var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              console.log(data);
              if(data != ''){
                a = $.confirm({
                      title: 'Tags  <a onclick="addTag('+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Tags',
                    content: '',
                    
                });
              }
            }
        });
    }

    function addTag(fileid){
      a.close();
      
      $.confirm({
        title: 'Add Tag',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Title</label>'+
        '<input type="text" placeholder="Your title" class="name form-control" required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Color</label><br>'+
        '<input type="color" id="bgcolor" value="#ffffff" onchange="pickColor(this)" onkeyup="pickColor(this)" />'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid title');
                        return false;
                    }
                    var colr_tag = $(".hdn_color_picker").val();
                    
                    $.ajax({
                        type: "POST",
                        url: baseurl+"/clients/add_tag",
                        data: {_token: "{{ csrf_token() }}",title:name,fileid:fileid,color_tag:colr_tag},
                        success: function(data)
                        {
                          console.log(data);
                          getTags();
                        }
                    });
                }
            },
            cancel: function () {
                
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
    }

  function pickColor(t) {
    var pick_color = $("#bgcolor").val();
    $(".hdn_color_picker").val(pick_color);
  }

  function deleteTag(fileid){
    a.close();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/delete_tag/"+fileid,
            success: function(data)
            {
              getTags();
            }
        });
  }

  function tagRow(tagid){
    a.close();
    var fileid = $(".activefile").val();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/change_tag/"+tagid+"/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
                $("#tag-title").text(datares.tag.title);
                $('.tag-title-con').css('background-color', datares.tag.color_tag);
                $(".tag-title-con").show();
              }
            }
        });
  }

    getCheckedTag(id);

   function getCheckedTag(fileid){
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_active_tag/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
                $("#tag-title").text(datares.tag.title);
                $('.tag-title-con').css('background-color', datares.tag.color_tag);
                $(".tag-title-con").show();
              }
            }
        });
  }

  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      var keywords = $(this).val();
      var job = $('.selected_job').val();
      if(keywords){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/searchmyfiles/"+keywords,
            success: function(data)
            {
              if(data != ''){
                  // console.log(zNodes);
                  zNodes = JSON.parse(data);
                  load(setting,zNodes);
              }else{
                swal(
                    'Searching..',
                    'No result found for this keywords',
                    'error'
                  );
              }
            }
        });
      }else{
        var zNodes = {!! json_encode($all_nods) !!};
        load(setting,zNodes);
      }
    }
  });

  load_dd(setting,zNodes_dd);

  function load_dd(setting,zNodes_dd){
    return $.fn.zTree.init($("#treeDemo_dd"), setting, zNodes_dd);
  }

  function load(setting,zNodes){
    return $.fn.zTree.init($(".treeDemo"), setting, zNodes);
  }

  function nodefile(id){
    $(".tick").hide();
    $(".tickmark_"+id).show();
    $(".compare_2").val(id);
  }

  function shareAnnotation(rec_id){
    var id = $(".active_file_id").val();
    
    markers[id].exportInstantJSON().then(function(instantJSON) {
                
                const viewState = markers[id].viewState;
                const page_no = viewState.currentPageIndex + 1; // => 0
                // // console.log(instantJSON); 

                swal({
                  title: 'Are you sure to share this file?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Share',
                  cancelButtonText: 'Cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    console.log(JSON.stringify(instantJSON));
                    $.ajax({
                      type: "POST",
                      url: baseurl+"/clients/share-annotation",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,client_id:rec_id},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('shared','File Shared','success');
                          // arr_pages.push(page_no);
                          // console.log(arr_pages);
                        }else{
                          swal('Something went wrong','error');
                        }
                      }
                    });
                  }
                });
              });
  }



</script>
@stop

@endsection