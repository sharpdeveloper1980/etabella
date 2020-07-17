@extends('layouts.client.app')
@section('title','My Files')
@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
	border: 1px solid #b8b8ba;
	background: #f6f6f6;
	font-weight: normal;
	color: #656565;
}
.custom_class {
    height: 100px !important;
}
.sort_dd .action-button {
	border: 2px solid #e54e09 !important;
	width: auto;
	height: 28px;
	float: right;
}
img.file_iocn {
    width: 19px;
}
a{
	text-decoration:none;	
}
a:hover{
	text-decoration:none;	
}

</style>
   <div class="row second_header">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd" data-toggle="tooltip" title="Jobs">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{$active_job->job_name}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu menu_case" >
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/examination_schedule/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>

               @if($job->job_id == $whchjobs)
               <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
               @endif
               
               @endforeach
            @endif
         </ul>
      </div>
      <div class="action_parent">
         <button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i data-toggle="tooltip" title="Refresh" class="fa fa-refresh" aria-hidden="true"></i>
         </button>
         <div class="dropdown sort_dd" >
            <button data-toggle="tooltip" title="Create/Modify"  onclick="window.location.href='{{ asset('clients/examination_schedule_inner/'.Session::get('job_id')) }}'" type="button" class="dropdown-toggle action-button" data-toggle="dropdown">
				Create/Modify
            </button>  
			<a  href="#" data-toggle="tooltip" title="Tag Filter" class="tag-box" onclick="getTags()" style="float: right"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" style=" margin-top: 3px; margin-right: 1px; " height="26" width="26"></a>			
            <div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
               <input type="text" name="search" class="form-control search_witness_and_file" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>

               <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
            </div>
         </div>
		 
      </div>
   </div>
   
<hr class="hr_new2">
<div class="loader" style="display: none;"></div>
<div class="container">
<div class="page-101">
@if($all_witness)
<div id="accordion">
  @foreach($all_witness as $wit)
  <h3>{{ $wit['witness_name'] }}</h3>
  <?php $files = (new \App\Helpers\Helper)->get_witness_files($wit['id']);  
  ?>
  <div class="@if(!$files) custom_class @endif">
	
	@if($files)
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>SNo.</th>
                <th>File Name</th>
            	<th>Action</th>
            </tr>
        </thead>
        <tbody>
		
		<?php $i=1; foreach($files as $f1) { 
		 $color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$f1['doc_id']);  
        $file_extension = strtolower(substr(strrchr($f1['file_upload_name'], "."), 1));
        ?>
            <tr>
				<td>{{ $i }}</td>
				@if($file_extension == 'pdf')
				<td><a href="{{ asset('clients/examination_schedule_render/'.$f1['doc_id'].'/'.$f1['witness_id']) }}"><div style="width:100%;color:cornflowerblue"><span style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="{{ asset('public/images/file-pdf-icon_32.png') }}">  {{ $f1['file_name'] }}</div></a></td>
                <td><a href="#" data-id="{{ $f1['doc_id'] }}" onclick="getTags1({{ $f1['doc_id'] }})" data-toggle="tooltip" data-placement="top" title="Tags"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></td>
            	@elseif($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx')
				<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
				<td style=" cursor: pointer; " onclick="popupwindow('{{  $url }}','doc')"><span style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="{{ url('public/images/doc.png') }}"> {{ $f1['file_name'] }}</td>	
            	 <td><a data-id="{{ $f1['doc_id'] }}" href="#" onclick="getTags1({{ $f1['doc_id'] }})" data-toggle="tooltip" data-placement="top" title="Tags"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></td>
            	@elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg')
				<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
				<td style=" cursor: pointer; " onclick="popupwindow('{{  $url }}','doc')"><span style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn1" src="{{ url('public/images/image.png') }}">{{ $color }}  {{ $f1['file_name'] }} </td>	
            	 <td><a data-id="{{ $f1['doc_id'] }}" href="#" onclick="getTags1({{ $f1['doc_id'] }})" data-toggle="tooltip" data-placement="top" title="Tags"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></td>
            	@else
				<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
				<td style=" cursor: pointer; " onclick="popupwindow('{{  $url }}','img')"><span style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="{{ url('public/images/play.png') }}"> {{ $color }} {{ $f1['file_name'] }}</td>
				 <td><a data-id="{{ $f1['doc_id'] }}" href="#" onclick="getTags1({{ $f1['doc_id'] }})" data-toggle="tooltip" data-placement="top" title="Tags"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></td>
            	@endif
			</tr>
		<?php $i++; } ?>
		</tbody>
	</table>
	@else 
		<h3 align="center">File Not Found</h3>
	@endif
  </div> 
  @endforeach
</div>
@else 
<div id="accordion">
 <h3 align="center">Witness And Files Are Not found</h3>
</div>
@endif
</div>
</div>
<input type="hidden" class="activefile" />
<input type="hidden" class="hdn_color_picker" value="#ffff" />
@section('js')
<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
function getTags(){ 
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags-for-filter-exe/",
            success: function(data)
            {
              console.log(data);
              if(data != ''){
                a = $.confirm({
                      title: 'Filter by Tags',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Filter by Tags',
                    content: 'No tags added yet',
                    
                });
              }

            }
        });
    }
function getTaggedFiles(tagid,color){
      $.ajax({
           type: "GET",
           url: baseurl+"/clients/get_doc_by_tagid/"+tagid+"/"+"{{ $whchjobs }}",
           success: function(data)
           {
              resp=$.parseJSON(data);
			  if(resp.status=='true')
			  {
				//  console.log(resp.data.length.);
				var j=1;
				$('#accordion').html('');
				  $.each(resp.data, function( index, value ) {
				  /*console.log( index );
				  console.log(value.length);*/
				   var file_path="{{ asset('public/images/file-pdf-icon_32.png') }}";
                   var doc_path="{{ asset('public/images/doc.png') }}";
                   var img_path="{{ asset('public/images/image.png') }}";
                   var other_path="{{ asset('public/images/play.png') }}";
				  $('#accordion').append('<h3>'+index+'</h3><div><table id="example" class="table table-striped table-bordered" style="width:100%"><thead><tr><th>SNo.</th><th>File Name</th></tr></thead><tbody id="table_'+j+'"></tbody></div>');
				  console.log(value.length);
				  console.log(value);
				  for(i=0;i<value.length;i++)
				  {
					  count=i; 
					  /*$('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><img class="file_iocn" src="'+file_path+'"> '+value[i].file_name+'</td></tr>');*/
					  //var file_extension = value[i].file_name.split('.')[1];
            var file_extension = value[i].file_name.split('.').reverse()[0];
					  count=i; 
					  var file_url="{{ asset('public/storage/files') }}/"+value[i].file_upload_name;
					  if(file_extension =='pdf' || file_extension =='PDF')
					  {
						  var pdf_url="{{ asset('clients/file/render') }}/"+value[i].doc_id;
						  $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="'+pdf_url+'"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+file_path+'"> '+value[i].file_name+'</div></a></td></tr>');
					  } 
					   else if(file_extension == 'xlsx' || file_extension == 'wpd' || file_extension == 'tex' || file_extension == 'xls' || file_extension == 'xlsx' || file_extension == 'docb' || file_extension == 'dotm' || file_extension == 'dotx' || file_extension == 'docm' || file_extension == 'csv' || file_extension == 'pptx' || file_extension == 'ppt' || file_extension == 'txt' || file_extension == 'doc' || file_extension == 'docx')
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'doc\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+doc_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
                  else if(file_extension == 'jpg' || file_extension == 'png' || file_extension == 'jpeg')
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'doc\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+img_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
                  else
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'img\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+other_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
				  }		  
				j++;
				});
				$( "#accordion" ).accordion('destroy').accordion();
			  }
			  else 
			  {
				 $('#accordion').html('<h3 align="center">Witness And Files Are Not found</h3>');
				 $( "#accordion" ).accordion('destroy').accordion();
			  }
			  a.close();
           }
        });
    }
 $( function() {
    active_a();
  });
  function active_a()
  {
	  $( "#accordion" ).accordion();
  }
  $(document).on('ready',function(){
	  
  });
 function refreshPage(whchjobs){
	 $("#con").hide();
	 $(".page-101").hide();
	 $(".loader").show();
	 setTimeout(function () {
		window.location.reload();
		$('.loader').hide();
		$(".hr_new3").show();
		$("#treeDemo").show();  
	 }, 1000);
  }
  $(document).on('keyup','.search_witness_and_file',function(){
	  var value=$(this).val();
	  $.post("{{ asset('clients/search_witness_and_file/') }}",{'value':value,_token:'{{ csrf_token() }}'},function(fb){
      		$('#accordion').html(fb);
            $( "#accordion" ).accordion('destroy').accordion();
           $( "#accordion" ).accordion();
      });
  });
   var a = '';
    function getTags1(active_file){ 
    $('.activefile').val(active_file);
      //var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
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
               location.reload();
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
              getCheckedTag(fileid);
            }
        });
  }

</script>
@stop

@endsection