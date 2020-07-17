@extends('layouts.client.app')
@section('title','Client Dashboard')
@section('content')
<div class="row">
  <div class="col-md-6">
      <?php 
        $arr_book_pages_1 = [];
        if($bookJson_1){
          $bookmrks_1 = json_decode($bookJson_1);
          if($bookmrks_1){
            foreach ($bookmrks_1 as $key_1 => $mrk_1) {
              $arr_book_pages_1[] = $mrk_1->action->pageIndex;
            }
          }
        }
      ?>
    <div class="row custom-toolbar-parent">
      <ul class="list-inline custom-toolbar">
        <li><a href="#" onclick="CloseBoth()">Close</a></li>

        <!-- <li><a href="#" onclick="getTags(1)"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></li> -->

        <input type="hidden" name="activefile_1" class="activefile_1" value="{{$first_id}}">

        <li class="test-0" style="width: 72%; text-align: center; color: #E54E09;"><b> @if(strlen($file_1->file_name) > 44) {{ substr($file_1->file_name, 0, 40) . '...' }} @else {{ $file_1->file_name }} @endif </b></li>

        <li class="test_4"><a href="#" id="page_1"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>

        <li class="test_3"><a href="#" class="createbookmark_1"><i id="i-bookmark_1" class="fa fa-bookmark-o i-bookmark_1" aria-hidden="true"></i></a></li>

        <li class="test_2"><a href="#" id="search_1"><i class="fa fa-search" aria-hidden="true"></i></a></li>
        
        <li class="test_1"><a href="#" id="annotation_1"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls_1" name="annotation" value="true"></a></li>
    	
      	<!-- Compare File -->
		<li style=" position: absolute; right: 132px; "><a href="#" id="compare_btn_for_first" data-toggle="tooltip" data-placement="top" title="Compare files"><i class="fa fa-files-o" aria-hidden="true"></i></a></li>
		<!-- Compare File -->
    </ul>
    </div>

    <div class="row tag-line-1 tag-title-con-1" style="display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
      <small id="tag-title-1"></small>
    </div>

    <div id="pspdfkit_1{{$first_id}}" style="width: 100%; height: 100vh;"></div> 
  </div>
  <div class="col-md-6">
    <?php 
        $arr_book_pages_2 = [];
        if($bookJson_2 ){  
          $bookmrks_2 = json_decode($bookJson_2);
          if($bookmrks_2){
            foreach ($bookmrks_2 as $key_2 => $mrk_2) {
              $arr_book_pages_2[] = $mrk_2->action->pageIndex;
            }
          }
        }
      ?>
    <div class="row custom-toolbar-parent">
      <ul class="list-inline custom-toolbar">
        <!-- <li><a href="#" onclick="getTags(2)"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></li> -->

        <input type="hidden" name="activefile_2" class="activefile_2" value="{{$second_id}}">

        <li class="test-0" style="width: 85%; text-align: center; color: #E54E09;"><b style="margin-left: 100px;"> @if(strlen($file_2->file_name) > 44) {{ substr($file_2->file_name, 0, 40) . '...' }} @else {{ $file_2->file_name }} @endif </b></li>

        <li class="test_4"><a href="#" id="page_2"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>

        <li class="test_3"><a href="#" class="createbookmark_2"><i id="i-bookmark_2" class="fa fa-bookmark-o i-bookmark_2" aria-hidden="true"></i></a></li>

        <li class="test_2"><a href="#" id="search_2"><i class="fa fa-search" aria-hidden="true"></i></a></li>
        
        <li class="test_1"><a href="#" id="annotation_2"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls_2" name="annotation" value="true"></a></li>
		
		<!-- Compare File -->
		<li style=" position: absolute; right: 132px; "><a href="#" id="compare_btn" data-toggle="tooltip" data-placement="top" title="Compare files"><i class="fa fa-files-o" aria-hidden="true"></i></a></li>
		<!-- Compare File -->
      </ul>
    </div>

    <div class="row tag-line-2 tag-title-con-2" style="display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
      <small id="tag-title-2"></small>
    </div>

    <div id="pspdfkit_2{{$second_id}}" style="width: 100%; height: 100vh;"></div>
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
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="{{ $first_id }}">
            <input type="hidden" name="compare_second_file" class="compare_2" value="{{ $second_id }}">
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

 <div class="modal fade docs-example-modal-lg-first" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-groupsearch_sorting" id="search_files">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
        <form method="POST" action="{{ route('compareFilesFirst') }}">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="{{ $first_id }}">
            <input type="hidden" name="compare_second_file" class="compare_2" value="{{ $second_id }}">
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
@section('js')
<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  var markers = [];
  var instantJSON = [];
  const arr_pages_1 = <?=json_encode($arr_book_pages_1)?>;
  const arr_pages_2 = <?=json_encode($arr_book_pages_2)?>;
  
  var first_id = "{{$first_id}}";
  var second_id = "{{$second_id}}"; 

	var report_all_1 = [];
	var report_all_2 = [];

	var report_annotation_1 = 'Annotation';
	var report_annotation_2 = 'Annotation';

   	var report_bookmark_1 = '';
   	var report_bookmark_2 = '';
	
	var delete_id_1 = '';
	var delete_id_2 = '';

console.log(instantJSON);
  function CloseBoth(){
    swal("Are you sure to save this file?", {
      buttons: {
        cancel: "Cancel",
        close: "Close",
        catch: {
          text: "Save and Close",
          value: "catch",
        },
      },
    })
    .then((value) => {
      switch (value) {
     
        case "catch":
          let state1 = markers[first_id].viewState;
                  markers[first_id].exportInstantJSON().then(function(instantJSON) {
                
                  const page_no = state1.currentPageIndex + 1; // => 0
                // // console.log(instantJSON); 
                    console.log(JSON.stringify(instantJSON));
                      $.ajax({
                        type: "POST",
                        url: baseurl+"/clients/instant-json",
                        data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:first_id,page_no:page_no,report_annotation:report_annotation_1,report_bookmark:report_bookmark_1,report_all:JSON.stringify(report_all_1),delete_id:delete_id_1},
                        success: function(data)
                        {  
                          recentAnnoted(first_id);
                        }
                      });
                    });

                  let state2 = markers[second_id].viewState;
                  markers[second_id].exportInstantJSON().then(function(instantJSON) {
                
                  const page_no2 = state2.currentPageIndex + 1; // => 0
                // // console.log(instantJSON); 
                    console.log(JSON.stringify(instantJSON));
                      $.ajax({
                        type: "POST",
                        url: baseurl+"/clients/instant-json",
                        data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:second_id,page_no:page_no2,report_annotation:report_annotation_2,report_bookmark:report_bookmark_2,report_all:JSON.stringify(report_all_2),delete_id:delete_id_2},
                        success: function(data)
                        {  
                          console.log(data);
                          if(data){
                            recentAnnoted(second_id);
                          }
                        }
                      });
                    });
                  swal('Save','File Updated Successfully','success');
                  setTimeout(function(){ 
                    window.location.href=baseurl+"/clients/file/render/"+first_id;
                  }, 500);
          break;
        
        case "close":
          window.location.href=baseurl+"/clients/file/render/"+first_id;
          break;

        default:

          
      }
    });


                // swal({
                //   title: 'Are you sure to save this file?',
                //   text: '',
                //   type: 'warning',
                //   showCancelButton: true,
                //   confirmButtonColor: '#3085d6',
                //   cancelButtonColor: '#d33',
                //   confirmButtonText: 'Save & Close!',
                //   cancelButtonText: 'Cancel',
                //   confirmButtonClass: 'confirm-class',
                //   cancelButtonClass: 'cancel-class',
                //   closeOnConfirm: true,
                //   closeOnCancel: true
                // },
                // function(isConfirm) {
                //   if (isConfirm) {

                //   let state1 = markers[first_id].viewState;
                //   markers[first_id].exportInstantJSON().then(function(instantJSON) {
                
                //   const page_no = state1.currentPageIndex + 1; // => 0
                // // // console.log(instantJSON); 
                //     console.log(JSON.stringify(instantJSON));
                //       $.ajax({
                //         type: "POST",
                //         url: baseurl+"/clients/instant-json",
                //         data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:first_id,page_no:page_no},
                //         success: function(data)
                //         {  
                          
                //         }
                //       });
                //     });

                //   let state2 = markers[second_id].viewState;
                //   markers[second_id].exportInstantJSON().then(function(instantJSON) {
                
                //   const page_no2 = state2.currentPageIndex + 1; // => 0
                // // // console.log(instantJSON); 
                //     console.log(JSON.stringify(instantJSON));
                //       $.ajax({
                //         type: "POST",
                //         url: baseurl+"/clients/instant-json",
                //         data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:second_id,page_no:page_no2},
                //         success: function(data)
                //         {  
                //           if(data == true){
                //             swal('Save','File Updated Successfully','success');
                //             // arr_pages_1.push(page_no);
                //             // console.log(arr_pages_1);
                //           }else{
                //             swal('Something went wrong','error');
                //           }
                //         }
                //       });
                //     });

                //   }
                // });
    }
    
    // console.log(markers[id]);
    // console.log(markers[id]);
  


  getFirstFileData(first_id);


  function getFirstFileData(id){
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          loadFirstFile(data);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }  

  setTimeout(function(){
    getSecondFileData(second_id);
    getCheckedTag(2,second_id);
    recentOpened(second_id);
  },1000);

  function getSecondFileData(id){
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          loadSecondFile(data);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }  

	function deleteKit_1(id){
    	 markers[id].exportInstantJSON().then(function(instantJSON) {
      	const viewState = markers[id].viewState;
      	const page_no = viewState.currentPageIndex + 1; // => 0
         $.ajax({
            type: "POST",
            url: baseurl+"/clients/instant-json",
            data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation_1,report_bookmark:report_bookmark_1,report_all:JSON.stringify(report_all_1),delete_id:delete_id_1},
            success: function(data)
            { 
             // if(data == true){
             	delete_id_1 = '';
               recentAnnoted(id);
               //window.location.href=document.referrer;
               toastr.success('Deleted Successfully','Success',{"debug": false,});
             // }
            }
          });
      });
    }

function deleteKit_2(id){
    	 markers[id].exportInstantJSON().then(function(instantJSON) {
      	const viewState = markers[id].viewState;
      	const page_no = viewState.currentPageIndex + 1; // => 0
         $.ajax({
            type: "POST",
            url: baseurl+"/clients/instant-json",
            data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation_2,report_bookmark:report_bookmark_2,report_all:JSON.stringify(report_all_2),delete_id:delete_id_2},
            success: function(data)
            { 
             // if(data == true){
             	delete_id_2 = '';
               recentAnnoted(id);
               //window.location.href=document.referrer;
               toastr.success('Deleted Successfully','Success',{"debug": false,});
             // }
            }
          });
      });
    }

  function loadFirstFile(data){  
    
    if(data.annotJson){   
     $.ajax({
           //url:api_url+data.file.pspdf_file_id+'/doc_'+data.file.file_id+'{{ $client_id }}',
		   url:api_url+data.file.pspdf_file_id+'/{{ $layer1 }}',
		   method:'GET',
		   contentType:"application/json",
		   success : function(resp){
				console.log(resp);
      PSPDFKit.load({
        container: "#pspdfkit_1"+data.file.file_id,
        disableWebAssemblyStreaming: false,
       // baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
      //  pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
        documentId: data.file.pspdf_file_id,
         authPayload: { jwt: resp },
         instant: true,
        licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J",
        instantJSON: {
          format: "https://pspdfkit.com/instant-json/v1",
          annotations: data.annotJson.length > 0 ? JSON.parse(data.annotJson) : data.annotJson,
          bookmarks: data.bookJson.length > 0 ? JSON.parse(data.bookJson) : data.bookJson,
          },
      })
        .then(function(instance) {
          // deleteBookmarks
          var fid = data.file.file_id;
          markers[fid] =instance;

          instance.exportInstantJSON().then(function(instantJSON) {
            instantJSON[fid] = instantJSON;
          });

          const viewState = instance.viewState;

          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", false));
          // => 0

          // if ($.inArray(curr_page, arr_pages)) {
          //   console.log('current page is '+curr_page);
          //   $(".i-bookmark_1").removeClass("fa-bookmark-o");
          //   $(".i-bookmark_1").addClass("fa-bookmark");
          // }else {
          //   $(".i-bookmark_1").removeClass("fa-bookmark");
          //   $(".i-bookmark_1").addClass("fa-bookmark-o");
          // }
          
          $('#page_1').click(function(){
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
                              
                                // console.log(arr_pages_1);
                                // console.log(name);
                                // console.log(arr_pages_1.indexOf(21));
                              
//                               if ($.inArray(Number(name), arr_pages_1) !== -1) {

//                                 console.log('in array');
//                                 $("#i-bookmark_1").removeClass("fa-bookmark-o");
//                                 $("#i-bookmark_1").addClass("fa-bookmark");
//                               }else {
//                                 console.log('Not in array');
//                                 $("#i-bookmark_1").addClass("fa-bookmark-o");
//                               }

                          }
                      },
                      cancel: function () {
                          //close
                      },
                  },
              });

          });

          $('.createbookmark_1').click(function(){
          	instance.setViewState(function(viewState) {
  			return viewState.set("sidebarMode", PSPDFKit.SidebarMode.BOOKMARKS);
		  });
          	
//             const viewState = instance.viewState;
//             const curr_page = viewState.currentPageIndex+1;
            
             
//               const bookmark = new PSPDFKit.Bookmark({
//                   name: "Bookmark-"+curr_page,
//                   action: new PSPDFKit.Actions.GoToAction({
//                    pageIndex: curr_page 
//                    })
//                 });
//                 instance.createBookmark(bookmark).then(function(createdBookmark) {
//                   $("#i-bookmark_1").removeClass("fa-bookmark-o");
//                   $("#i-bookmark_1").addClass("fa-bookmark");
//                 });
          });
      
      	 instance.addEventListener("bookmarks.create", (createdBookmarks) => {
        		report_bookmark_1 = 1;
        	
        		report_all_1.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
       	 });
    
    	 instance.addEventListener("bookmarks.delete", (deletedBookmarks) => {
        		report_bookmark_1 = 1;
        		console.log(deletedBookmarks._tail.array[0].id);
            	delete_id_1 = deletedBookmarks._tail.array[0].id;
				deleteKit_1(fid);
        	// report_all.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
        });

          /**$('.deletebookmark_1').click(function(){
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
          });**/

          $('#search_1').click(function(){
            // instance.startUISearch("..");
            // $(".PSPDFKit-Search-Form-Input").val('');
            instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
          });

          $("#annotation_1").click(function(){
            const annot_val = $(".annotation_cls_1").val();
            instance.setViewState(viewState.set("showToolbar", annot_val));
            if(annot_val == 'true'){
              $(".annotation_cls_1").val('false');
            }else{
              $(".annotation_cls_1").val('true');
            }
            // console.log(instance);
          });

          $("#rotate_1").click(function(){
            instance.setViewState(viewState => viewState.rotateRight());
          });
      

          $("#close_1").click(function(){
              instance.exportInstantJSON().then(function(instantJSON) {
                
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
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('Save','File Updated Successfully','success');
                          // arr_pages_1.push(page_no);
                          // console.log(arr_pages_1);
                        }
                      }
                    });
                  } else {
                    swal(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    );
                  }
                });
              });
            });

          $("#grid_1").click(function(){
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

        })
        .catch(function(error) {
          console.error(error.message);
        });
      }
     });
      }else{
      $.ajax({
          // url:api_url+data.file.pspdf_file_id+'/doc_'+data.file.file_id+'{{ $client_id }}',
		   url:api_url+data.file.pspdf_file_id+'/{{ $layer1 }}',
   		   method:'GET',
		   contentType:"application/json",
		   success : function(resp){
				console.log(resp);
        PSPDFKit.load({
        container: "#pspdfkit_1"+data.file.file_id,
        disableWebAssemblyStreaming: false,
        //baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
        //pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
         documentId: data.file.pspdf_file_id,
         authPayload: { jwt: resp },
         instant: true,
        licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J"
      })
        .then(function(instance) {
          // deleteBookmarks
          var fid = data.file.file_id;
          markers[fid] =instance;

          instance.exportInstantJSON().then(function(instantJSON) {
            instantJSON[fid] = instantJSON;
          });

          const viewState = instance.viewState;

          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", false));
          // => 0

          // if ($.inArray(curr_page, arr_pages_1)) {
          //   console.log('current page is '+curr_page);
          //   $(".i-bookmark_1").removeClass("fa-bookmark-o");
          //   $(".i-bookmark_1").addClass("fa-bookmark");
          // }else {
          //   $(".i-bookmark_1").removeClass("fa-bookmark");
          //   $(".i-bookmark_1").addClass("fa-bookmark-o");
          // }
          
          $('#page_1').click(function(){
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
                              
                                console.log(arr_pages_1);
                                console.log(name);
                                console.log(arr_pages_1.indexOf(21));
                              
                              if ($.inArray(Number(name), arr_pages_1) !== -1) {

                                console.log('in array');
                                $("#i-bookmark_1").removeClass("fa-bookmark-o");
                                $("#i-bookmark_1").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark_1").addClass("fa-bookmark-o");
                              }

                          }
                      },
                      cancel: function () {
                          //close
                      },
                  },
              });

          });

          $('.createbookmark_1').click(function(){
          	instance.setViewState(function(viewState) {
  			return viewState.set("sidebarMode", PSPDFKit.SidebarMode.BOOKMARKS);
		  });
          	
//             const viewState = instance.viewState;
//             const curr_page = viewState.currentPageIndex+1;
            
             
//               const bookmark = new PSPDFKit.Bookmark({
//                   name: "Bookmark-"+curr_page,
//                   action: new PSPDFKit.Actions.GoToAction({
//                    pageIndex: curr_page 
//                    })
//                 });
//                 instance.createBookmark(bookmark).then(function(createdBookmark) {
//                   $("#i-bookmark_1").removeClass("fa-bookmark-o");
//                   $("#i-bookmark_1").addClass("fa-bookmark");
//                 });
          });
      
      	 instance.addEventListener("bookmarks.create", (createdBookmarks) => {
        		report_bookmark_1 = 1;
        	
        		report_all_1.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
       	 });
    
    	 instance.addEventListener("bookmarks.delete", (deletedBookmarks) => {
        		report_bookmark_1 = 1;
        		console.log(deletedBookmarks._tail.array[0].id);
            	delete_id_1 = deletedBookmarks._tail.array[0].id;
				deleteKit_1(fid);
        	// report_all.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
        });

          $('#search_1').click(function(){
            // instance.startUISearch("..");
            // $(".PSPDFKit-Search-Form-Input").val('');
            instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
          });

          $("#annotation_1").click(function(){
            const annot_val = $(".annotation_cls_1").val();
            instance.setViewState(viewState.set("showToolbar", annot_val));
            if(annot_val == 'true'){
              $(".annotation_cls_1").val('false');
            }else{
              $(".annotation_cls_1").val('true');
            }
            // console.log(instance);
          });

          $("#rotate_1").click(function(){
            instance.setViewState(viewState => viewState.rotateRight());
          });

          $("#close_1").click(function(){
              instance.exportInstantJSON().then(function(instantJSON) {
                
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
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('Save','File Updated Successfully','success');
                          // arr_pages_1.push(page_no);
                          // console.log(arr_pages_1);
                        }
                      }
                    });
                  } else {
                    swal(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    );
                  }
                });
              });
            });

          $("#grid_1").click(function(){
            setTimeout(function(){
              $('.PSPDFKit-DocumentEditor').hide();
            },2000)
            
              instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
          });

          $("#compare_1").click(function(){
            load(setting,zNodes);
            $(".docs-example-modal-lg").modal('show');
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

        })
        .catch(function(error) {
          console.error(error.message);
        });
     }
    });  
      }
  }

  function loadSecondFile(data){ 

    if(data.annotJson){    
    $.ajax({
           //url:api_url+data.file.pspdf_file_id+'/doc_'+data.file.file_id+'{{ $client_id }}',
		   url:api_url+data.file.pspdf_file_id+'/{{ $layer2 }}',
		   method:'GET',
		   contentType:"application/json",
		   success : function(resp){
				console.log(resp);
      PSPDFKit.load({
        container: "#pspdfkit_2"+data.file.file_id,
        disableWebAssemblyStreaming: false,
       // baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
      //  pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
         documentId: data.file.pspdf_file_id,
         authPayload: { jwt: resp },
         instant: true,
        licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J",
        instantJSON: {
          format: "https://pspdfkit.com/instant-json/v1",
          annotations: data.annotJson.length > 0 ? JSON.parse(data.annotJson) : data.annotJson,
          bookmarks: data.bookJson.length > 0 ? JSON.parse(data.bookJson) : data.bookJson,
          },
      })
        .then(function(instance) {
          // deleteBookmarks
          var fid = data.file.file_id;
          markers[fid] =instance;

          instance.exportInstantJSON().then(function(instantJSON) {
            instantJSON[fid] = instantJSON;
          });

          const viewState = instance.viewState;

          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", false));
          // => 0

          // if ($.inArray(curr_page, arr_pages_2)) {
          //   console.log('current page is '+curr_page);
          //   $(".i-bookmark_1").removeClass("fa-bookmark-o");
          //   $(".i-bookmark_1").addClass("fa-bookmark");
          // }else {
          //   $(".i-bookmark_1").removeClass("fa-bookmark");
          //   $(".i-bookmark_1").addClass("fa-bookmark-o");
          // }
          
          $('#page_2').click(function(){
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
                              
                                console.log(arr_pages_2);
                                console.log(name);
                                console.log(arr_pages_2.indexOf(21));
                              
                              if ($.inArray(Number(name), arr_pages_2) !== -1) {

                                console.log('in array');
                                $("#i-bookmark_2").removeClass("fa-bookmark-o");
                                $("#i-bookmark_2").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark_2").addClass("fa-bookmark-o");
                              }

                          }
                      },
                      cancel: function () {
                          //close
                      },
                  },
              });

          });

          /**$('.createbookmark_2').click(function(){
            const viewState = instance.viewState;
            const curr_page = viewState.currentPageIndex+1;
            
             
              const bookmark = new PSPDFKit.Bookmark({
                  name: "Bookmark-"+curr_page,
                  action: new PSPDFKit.Actions.GoToAction({
                   pageIndex: curr_page 
                   })
                });
                instance.createBookmark(bookmark).then(function(createdBookmark) {
                  $("#i-bookmark_2").removeClass("fa-bookmark-o");
                  $("#i-bookmark_2").addClass("fa-bookmark");
                });
          });

          $('.deletebookmark_2').click(function(){
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
          });**/
      
      	  	$('.createbookmark_2').click(function(){
          		instance.setViewState(function(viewState) {
  				return viewState.set("sidebarMode", PSPDFKit.SidebarMode.BOOKMARKS);
		  		});
            });
      
      	 	instance.addEventListener("bookmarks.create", (createdBookmarks) => {
        		report_bookmark_2 = 1;
        	
        		report_all_2.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
       	 	});
    
    	 	instance.addEventListener("bookmarks.delete", (deletedBookmarks) => {
        		report_bookmark_2 = 1;
        		console.log(deletedBookmarks._tail.array[0].id);
            	delete_id_2 = deletedBookmarks._tail.array[0].id;
				deleteKit_2(fid);
        	// report_all.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
        	});

          $('#search_2').click(function(){
            // instance.startUISearch("..");
            // $(".PSPDFKit-Search-Form-Input").val('');
            instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
          });

          $("#annotation_2").click(function(){
            const annot_val = $(".annotation_cls_2").val();
            instance.setViewState(viewState.set("showToolbar", annot_val));
            if(annot_val == 'true'){
              $(".annotation_cls_2").val('false');
            }else{
              $(".annotation_cls_2").val('true');
            }
            // console.log(instance);
          });

          $("#rotate_2").click(function(){
            instance.setViewState(viewState => viewState.rotateRight());
          });

          $("#close_2").click(function(){
              instance.exportInstantJSON().then(function(instantJSON) {
                
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
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('Save','File Updated Successfully','success');
                          // arr_pages_2.push(page_no);
                          // console.log(arr_pages_2);
                        }else{
                          swal('Something went wrong','error');
                        }
                      }
                    });
                  } else {
                    swal(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    );
                  }
                });
              });
            });

          $("#grid_2").click(function(){
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

        })
        .catch(function(error) {
          console.error(error.message);
        });
      }
    });
      }else{
      $.ajax({
           //url:api_url+data.file.pspdf_file_id+'/doc_'+data.file.file_id+'{{ $client_id }}',
		   url:api_url+data.file.pspdf_file_id+'/{{ $layer2 }}',
		   method:'GET',
		   contentType:"application/json",
		   success : function(resp){
				console.log(resp);
        PSPDFKit.load({
        container: "#pspdfkit_2"+data.file.file_id,
        disableWebAssemblyStreaming: false,
       // baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
       // pdf: "{{ url('/public/storage/files/') }}"+"/"+data.file.file_upload_name,
        documentId: data.file.pspdf_file_id,
         authPayload: { jwt: resp },
         instant: true,
        licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J"
      })
        .then(function(instance) {


          // deleteBookmarks
          var fid = data.file.file_id;
          markers[fid] = instance;

          instance.exportInstantJSON().then(function(instantJSON) {
            instantJSON[fid] = instantJSON;
          });

          const viewState = instance.viewState;

          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", false));
          // => 0

          // if ($.inArray(curr_page, arr_pages_2)) {
          //   console.log('current page is '+curr_page);
          //   $(".i-bookmark_2").removeClass("fa-bookmark-o");
          //   $(".i-bookmark_2").addClass("fa-bookmark");
          // }else {
          //   $(".i-bookmark_2").removeClass("fa-bookmark");
          //   $(".i-bookmark_2").addClass("fa-bookmark-o");
          // }
          
          $('#page_2').click(function(){
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
                              
                                console.log(arr_pages_2);
                                console.log(name);
                                console.log(arr_pages_2.indexOf(21));
                              
                              if ($.inArray(Number(name), arr_pages_2) !== -1) {

                                console.log('in array');
                                $("#i-bookmark_2").removeClass("fa-bookmark-o");
                                $("#i-bookmark_2").addClass("fa-bookmark");
                              }else {
                                console.log('Not in array');
                                $("#i-bookmark_2").addClass("fa-bookmark-o");
                              }

                          }
                      },
                      cancel: function () {
                          //close
                      },
                  },
              });

          });

          /**$('.createbookmark_2').click(function(){
            const viewState = instance.viewState;
            const curr_page = viewState.currentPageIndex+1;
            
             
              const bookmark = new PSPDFKit.Bookmark({
                  name: "Bookmark-"+curr_page,
                  action: new PSPDFKit.Actions.GoToAction({
                   pageIndex: curr_page 
                   })
                });
                instance.createBookmark(bookmark).then(function(createdBookmark) {
                  $("#i-bookmark_2").removeClass("fa-bookmark-o");
                  $("#i-bookmark_2").addClass("fa-bookmark");
                });
          });

          $('.deletebookmark_2').click(function(){
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
          });**/
        
        $('.createbookmark_2').click(function(){
          		instance.setViewState(function(viewState) {
  				return viewState.set("sidebarMode", PSPDFKit.SidebarMode.BOOKMARKS);
		  		});
            });
      
      	 	instance.addEventListener("bookmarks.create", (createdBookmarks) => {
        		report_bookmark_2 = 1;
        	
        		report_all_2.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
       	 	});
    
    	 	instance.addEventListener("bookmarks.delete", (deletedBookmarks) => {
        		report_bookmark_2 = 1;
        		console.log(deletedBookmarks._tail.array[0].id);
            	delete_id_2 = deletedBookmarks._tail.array[0].id;
				deleteKit_2(fid);
        	// report_all.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmark"});
        	});

          $('#search_2').click(function(){
            // instance.startUISearch("..");
            // $(".PSPDFKit-Search-Form-Input").val('');
            instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
          });

          $("#annotation_2").click(function(){
            const annot_val = $(".annotation_cls_2").val();
            instance.setViewState(viewState.set("showToolbar", annot_val));
            if(annot_val == 'true'){
              $(".annotation_cls_2").val('false');
            }else{
              $(".annotation_cls_2").val('true');
            }
            // console.log(instance);
          });

          $("#rotate_2").click(function(){
            instance.setViewState(viewState => viewState.rotateRight());
          });

          $("#close_2").click(function(){
              instance.exportInstantJSON().then(function(instantJSON) {
                
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
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:data.file.file_id,page_no:page_no},
                      success: function(data)
                      {  
                        if(data == true){
                          swal('Save','File Updated Successfully','success');
                          // arr_pages_2.push(page_no);
                          // console.log(arr_pages_2);
                        }else{
                          swal('Something went wrong','error');
                        }
                      }
                    });
                  } else {
                    swal(
                      'Cancelled',
                      'Your imaginary file is safe :)',
                      'error'
                    );
                  }
                });

              });
            });

          $("#grid_2").click(function(){
            setTimeout(function(){
              $('.PSPDFKit-DocumentEditor').hide();
            },2000)
            
              instance.setViewState(viewState.set("interactionMode",
                PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
          });

          $("#compare_2").click(function(){
            load(setting,zNodes);
            $(".docs-example-modal-lg").modal('show');
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

        })
        .catch(function(error) {
          console.error(error.message);
        });
      }
      });
      }
  }


  function recentOpened(id){
        $.ajax({
          type: "GET",
          url: baseurl+"/clients/recent-opened/"+id,
          success: function(data)
            {  
              console.log(data)
            }
        });
  }

  function recentAnnoted(id){
    if(id){
        $.ajax({
          type: "GET",
          url: baseurl+"/clients/recent-annoted/"+id,
          success: function(data)
            {  
              return true;
            }
        });
      }
      return true;
  }

  var a = '';
    function getTags(type){ 
      var active_file = $(".activefile_"+type).val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              // console.log(data);
              if(data != ''){
                a = $.confirm({
                      title: 'Tags  <a onclick="addTag('+type+','+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
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

    function addTag(type,fileid){
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
                          // console.log(data);
                          getTags(type);
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

  function deleteTag(type,fileid){
    a.close();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/delete_tag/"+fileid,
            success: function(data)
            {
              getTags(type);
            }
        });
  }

  function tagRow(type,tagid){
    a.close();
    var fileid = $(".activefile").val();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/change_tag/"+tagid+"/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
                $("#tag-title-"+type).text(datares.tag.title);
                $('.tag-title-con-'+type).css('background-color', datares.tag.color_tag);
                $(".tag-title-con-"+type).show();
              }
            }
        });
  }

    getCheckedTag(1,first_id);

   function getCheckedTag(type,fileid){
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_active_tag/"+fileid,
            success: function(data)
            {
              console.log(data);
              var datares = JSON.parse(data);
              if(datares.success == 1){
                $("#tag-title-"+type).text(datares.tag.title);
                $('.tag-title-con-'+type).css('background-color', datares.tag.color_tag);
                $(".tag-title-con-"+type).show();
              }else{
                $(".tag-title-con-"+type).hide();
              }
            }
        });
  }

/*deependra*/
var zNodes = {!! json_encode($all_nods) !!};
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
	  
function load(setting,zNodes){
    return $.fn.zTree.init($(".treeDemo"), setting, zNodes);
  }
$("#compare_btn").click(function(){
      load(setting,zNodes);
      $(".docs-example-modal-lg").modal('show');
    });

$("#compare_btn_for_first").click(function(){
      load(setting,zNodes);
      $(".docs-example-modal-lg-first").modal('show');
    });
	
function nodefile(id){
    $(".tick").hide();
    $(".tickmark_"+id).show();
    $(".compare_2").val(id);
  }
/*deependra*/
</script>
@stop

@endsection