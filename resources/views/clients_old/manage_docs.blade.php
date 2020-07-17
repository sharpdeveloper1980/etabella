@extends('layouts.client.app')
@section('title','My Files')
@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.sort_dd .action-button {
    width: auto;
}
a{
	text-decoration:none;
	color:black;
}
a:hover{
	text-decoration:none;
	color:black;
}
.file_container{
 padding: 0px 70px;
}
.list-group-item{
	border:none;
	border-bottom: 2px solid #e4eaec!important;
}
.level0 p {
    width: 39%;
}

.level0 p{
	width:100%;
	padding-right: 19px;
}
.hide_element
{
	display:none;
}
img.file_iocn {
    margin-right: 7px;
}
</style>
   <div class="row second_header">
      <div class="action_parent">
	  <button style="border: 2px solid #e54e09 !important;width: 88px;height: 28px;background: white;border-radius: 5px;color:#e54e09;margin-left: 20px;" onclick="goBack()" data-toggle="tooltip" title="Go Back">Go Back 1</button>
         <button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i class="fa fa-refresh" data-toggle="tooltip" title="Refresh" aria-hidden="true"></i>
         </button>
         <div class="dropdown sort_dd">
            <button  type="button" id="Delete" data-witness="{{ Request::segment(3) }}" data-toggle="tooltip" title="Delete" class="dropdown-toggle action-button" >
				Delete
            </button> 
			 <button  type="button" id="move_to" data-toggle="tooltip" title="Move To" class="dropdown-toggle action-button" >
				Move To
            </button> 
			<button  type="button" id="Modify" data-toggle="tooltip" title="Modify"  class="dropdown-toggle action-button" >
				Modify
            </button> 
			<button  type="button" id="go_to" data-toggle="tooltip" title="Go To" data-witness="{{ Request::segment(3) }}" class="dropdown-toggle action-button" >
				Go To
            </button>
			<button data-toggle="modal" data-target="#add_doc" data-toggle="tooltip" title="Add Doc" type="button" class="dropdown-toggle action-button" >
				Add Doc
            </button> 			
            <div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
               <input type="text" name="search" class="form-control search_witness_files" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
               <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
            </div>
         </div>
		 
      </div>
   </div>
<hr class="hr_new2">
<div class="loader" style="display: none;"></div>
<div class="container-fluid">  
<div class="page-101">
<div class="row">
	<div  class="col-sm-12">
		 <div class="file_container">
		        @if($all_witness_file)
				<ul class="list-group" id="sortable" >
					<?php
                		$i=1; 
                	?>
					@foreach($all_witness_file as $file)
						<?php  
						$color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$file['doc_id']);  
                			$file_extension = strtolower(substr(strrchr($file['file_name'], "."), 1));
                			$url = asset('public/storage/files/'.$file['file_upload_name']); 
                		?>
						@if($file_extension=='pdf')
						<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
							<a href="{{ asset('clients/file/render/'.$file['doc_id']) }}"><div style="width:95%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ asset('public/images/pdf.ico') }}"> {{ $file['file_name'] }}</div></a>
							<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
						</li>
						@elseif($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx')
						<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
							<a href="javascript:;" onclick="popupwindow('{{  $url }}','doc')"><div style="width:95%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ url('public/images/doc.png') }}"> {{ $file['file_name'] }}</div></a>
							<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
						</li>
                		@elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg')
						<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
							<a href="javascript:;" onclick="popupwindow('{{  $url }}','doc')"><div style="width:95%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ url('public/images/image.png') }}"> {{ $file['file_name'] }}</div></a>
							<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
						</li>
            			@else
						<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
							<a href="javascript:;" onclick="popupwindow('{{  $url }}','img')"><div style="width:95%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp;<img style="width:20px" class="file_iocn" src="{{ url('public/images/play.png')}}"> {{ $file['file_name'] }}</div></a>
							<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
						</li>	
						@endif
					<?php $i++; ?>
					@endforeach
				</ul>
				@else 
				<h2 align="center">File Not Found</h2>
				@endif
		 </div>
	</div>
</div>
</div>
</div>
<div id="add_doc" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Doc</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="container" style="width:auto;min-height: 200px !important;">
					<ul id="treeDemo" class="ztree">
					</ul>
				</div>
			</div>
		</div>
      </div>
	  <div class="modal-footer">
       <div class="col-sm-6">
		<button class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
	   </div>
	   <div class="col-sm-6">
		<button id="add_files" data-witness="{{ Request::segment(3) }}" value="{{ $whchjobs }}" class="btn btn-default btn-block">Add</button>
	   </div>
      </div>
    </div>
  </div>
</div>



<div id="doc_Modify" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Doc</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="container" style="width:auto;min-height: 200px !important;">
					<input type="hidden" name="selected_doc" id="selected_doc" value="" />
					<ul id="treeDemo_Modify" class="ztree">
					</ul>
				</div>
			</div>
		</div>
      </div>
	  <div class="modal-footer">
       <div class="col-sm-6">
		<button class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
	   </div>
	   <div class="col-sm-6">
		<button id="Modify_files" data-witness="{{ Request::segment(3) }}" value="{{ $whchjobs }}" class="btn btn-default btn-block">Modify</button>
	   </div>
      </div>
    </div>
  </div>
</div>
<div id="move_to_popup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Move At Index</h4>
      </div>
      <div class="modal-body">
        <p align="center">(Current Index : <span id="current_index">0</span>)</p>
				<form action="{{ asset('clients/move_to_witness_file') }}" class="database_operation_form">
				<div class="form-group ">
					<label>Enter New Index No</label>
					<input type="hidden" name="current_index_field" id="current_index_field" class="form-control" />
					<input type="hidden" name="current_id" id="current_id" class="form-control" />
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="hidden" name="witness" value="{{ Request::segment(3) }}">					
					<input type="number" required="required" name="new_index" class="form-control" id="new_index" placeholder="Enter New Index" />
				</div>
				<div class="form-group">
					<button class="btn btn-info">Change Index</button>
				</div>
				</form>
	  </div>
    </div>
    </div>

  </div>
</div>
@section('js')
<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('public/js/custom.js') }}"></script>
<script type="text/javascript">
$( function() {
    $( "#sortable" ).sortable({
		stop: function(event, ui) {
	    
			//console.log("New position: " + ui.item.index());
			//console.log();
			ids=[];
			for(i=0;i<$('#sortable').children().length;i++)
			{
				ids.push($($('#sortable').children()[i]).attr('id'))
			}
			for(sno=0;sno<$($('#sortable').children()).length;sno++)
			{
				node =$($('#sortable').children())[sno];
				new_sno=sno;
				$(node).find('span').text(new_sno+1);
			}
			
			//console.log(ids);
			$.post("{{ asset('clients/change_order_docs') }}",{'id':ids,_token:'{{ csrf_token() }}'},function(fb){
				console.log(fb);
			}) 
		}
	});
    $( "#sortable" ).disableSelection();
  } );
var w_file_arr=[];
$(document).on('change','.witness_files',function(){
	var data=$(this).val();
	if($(this). is(":checked"))
	{
	  w_file_arr.push(data);
	}
	else 
	{
	  var temp_arr=w_file_arr;
	  w_file_arr=[];
	  y = jQuery.grep(temp_arr, function(value) {
		if(value != data)
			w_file_arr.push(value);
	  });
	}
});
$('#example').DataTable({
	dom: 'Bfrtip',
	buttons: [
		// 'copyHtml5',
		// 'excelHtml5',
		// 'csvHtml5',
		// 'pdfHtml5'
	]
});
var zNodes = {!! json_encode($all_nods) !!};
var zNodes_move = {!! json_encode($all_nods_move) !!};

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
 setTimeout(function(){
    expandNode();
  },500);
function expandNode() {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandAll(true);
        zTree.expandAll(false);
  }

$( document ).ready(function() {
  load(setting,zNodes);
  load_modi(setting,zNodes);
  load_move(setting,zNodes_move);
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);
}
 function load_modi(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo_Modify"), setting, zNodes);
}
  
function load_move(setting,zNodes_move){
	return $.fn.zTree.init($("#treeDemo_move"), setting, zNodes_move);
}
var array_checked = []; 
function checkfile(type)
{
	var data=$(type).val();
	if($(type). is(":checked"))
	{
	  array_checked.push(data);
	}
	else 
	{
	  var temp_arr=array_checked;
	  array_checked=[];
	  y = jQuery.grep(temp_arr, function(value) {
		if(value != data)
			array_checked.push(value);
	  });
	}
 }

  $("#add_files").click(function(){
    var whchjobs = $(this).val();
	var wid=$(this).attr('data-witness');
    if(array_checked.length > 0){
		/**Loader Show**/
		/*$("#treeDemo").hide();
		$(".hr_new3").hide();
		$(".loader").show();*/
	  $.ajax({
          type: "POST",
          url: baseurl+"/clients/add_to_witness/"+wid,
          data: {_token: "{{ csrf_token() }}",arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
             
              array_checked = [];
			       $(".filecheck").prop('checked', false);
			 /**Loader Hide**/
				$("#treeDemo1").show();
				$(".hr_new3").show();
				$(".loader").hide();
			  toastr.success(data.message, data.title);
			  setTimeout(function(){
				  location.reload();
			  },1000)
            }
          }
      });
    }else{
	  toastr.error('Please select atleast single folder/file','error','Warning');
    }
  });
   function refreshPage(whchjobs){
         $(".page-101").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            window.location.reload();
            $('.loader').hide();
            $(".hr_new3").show();
            $("#treeDemo").show();  
         }, 1000);
      }
	  
	 
	$(document).on('click','#Delete',function(){
		data_witness=$(this).attr('data-witness');
		var val = w_file_arr;
		
		console.log(val);
		if(val.length>0) {
		$.post("{{  asset('clients/delete_witness_file') }}/"+data_witness,{'ids':val,_token:'{{ csrf_token() }}'},function(fb){
			 toastr.success('Files Successfully Deleted','Success');
			  setTimeout(function(){
				  location.reload();
			  },1000);
		})
		} 
		else 
		{
			 toastr.error('Please Select Any Doc','Warning');
		}
	});
	$(document).on('click','#Modify',function(){
		var val = w_file_arr;
		
		if(val.length>1)
		{
			toastr.error("you can't select multipal files",'Warning');
		}
		else if(val.length>0)
		{
			$('#selected_doc').val(val[0]);
			$('#doc_Modify').modal('show');
		}
		else 
		{
			toastr.error("Please Select One File",'Warning');
		}
	});
	$(document).on('click','#Modify_files',function(){
		 var whchjobs = $(this).val();
		 var main_file_id=$('#selected_doc').val();
		 var wid=$(this).attr('data-witness');
		 if(array_checked.length > 1){
			 toastr.error('Please Select only One File','Warning');
		 }
		 else if(array_checked.length > 0)
		 {
			 var data={'new_file':array_checked[0],'old_file':main_file_id,'job':whchjobs,'wid':wid,_token:'{{ csrf_token() }}'};
			 $.post("{{ asset('clients/Modify_files') }}",data,function(fb){
				 var resp=$.parseJSON(fb);
				 if(resp.status=='true')
				 {
					 toastr.success(resp.message,'Success');
					 setTimeout(function(){
						location.reload();
					 },1000);
					 
				 }
				 else 
				 {
					toastr.error(resp.message,'Warning');
				 }
			 });
		 }
		 else 
		 {
			 toastr.error('Please Select One File','Warning');
		 }
	});
	$(document).on('keyup','.search_witness_files',function(){
		var value=$(this).val();
		$.post("{{ asset('clients/search_witness_files') }}",{'value':value,_token:'{{ csrf_token() }}','w_id':{{ Request::segment(3) }}},function(fb){
			var resp=$.parseJSON(fb);
			
			if(resp.status=='true')
			{
				$('.file_container').html('<ul class="list-group" id="sortable" ></ul>');
				console.log(resp.data);
				var url="{{asset('public/images/pdf.ico')}}";
            	var doc_url="{{asset('public/images/doc.png')}}";
            	var img_url="{{asset('public/images/image.png')}}";
                var other_url="{{asset('public/images/play.png')}}";
				for(i=0;i<resp.data.length;i++)
				{
				//	alert(resp.data[i].file_name)
                  //  console.log('EXT');
					console.log(resp.data[i].file_name.split('.').reverse());
					var file_extension = resp.data[i].file_name.split('.').reverse()[0];
					var doc_file="{{ asset('public/storage/files') }}/"+resp.data[i].file_upload_name;
				//	console.log(file_extension);
				//	alert(file_extension)
					if(file_extension =='pdf' || file_extension =='PDF')
					{
						var pdf_file="{{ asset('clients/file/render') }}/"+resp.data[i].doc_id;
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="'+pdf_file+'"><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
					else if(file_extension == 'xlsx' || file_extension == 'wpd' || file_extension == 'tex' || file_extension == 'xls' || file_extension == 'xlsx' || file_extension == 'docb' || file_extension == 'dotm' || file_extension == 'dotx' || file_extension == 'docm' || file_extension == 'csv' || file_extension == 'pptx' || file_extension == 'ppt' || file_extension == 'txt' || file_extension == 'doc' || file_extension == 'docx')
					{
						
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'doc\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+doc_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
                	else if(file_extension == 'jpg' || file_extension == 'png' || file_extension == 'jpeg')
					{
						
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'doc\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+img_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
					else 
					{
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'img\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+other_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
				}
				if(resp.mode=='ALL')
				{				
					$('#sortable').sortable({
						connectWith: '#mycontainer ul',
						placeholder: 'myplaceholder'
					});
				}
			}
			else 
			{
				$('.file_container').html('<h3 align="center">File Not Found</h3>');
			}
		})
	});
	$(document).on('click','#move_to',function(){
		
		var data=[];
		var index=[];
		$(':checkbox:checked').each(function(i){
           data.push($(this).val());
		   index.push($(this).closest('li').find('span').text());
        });
		if(data.length>1)
		{
			 toastr.error('Please Select Only One File','Warning');
		}
		else if(data.length>0)
		{
			$('#current_index').text(index[0]);
			$('#current_index_field').val(index[0]);
			$('#current_id').val(data[0]);
			$('#move_to_popup').modal('show');
			
		}
		else
		{
			toastr.error('Please Select One File','Warning');
		}
	});
	$(document).on('click','#go_to',function(){
		var witness=$(this).attr('data-witness');
		var data={'witness':witness,_token:'{{ csrf_token() }}'};
		$.post("{{ asset('clients/files_goto') }}",data,function(fb){
			 var resp=$.parseJSON(fb);
			 if(resp.status=='true')
			 {
				 window.location.href=resp.reload;
				 
			 }
			 else 
			 {
				toastr.error(resp.message,'Warning');
			 }
		 });
	});
	function goBack() {
	  window.location.href="{{ url('clients/examination_schedule_inner/'.Request::segment(3)) }}";
	}
</script>
@stop
@endsection
<!-- Modal -->
