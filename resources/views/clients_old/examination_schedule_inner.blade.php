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
#sortable{
 padding: 0px 70px;
}
.list-group-item{
	border:none;
	border-bottom: 2px solid #e4eaec!important;
}
a { text-decoration:none;color:black; }
a:hover { text-decoration:none;color:black; }
a:hover { text-decoration:none;color:black; }
a:active { text-decoration:none;color:black; }
a:link { text-decoration:none;color:black; }
a:visited  { text-decoration:none; }
</style>
   <div class="row second_header">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{$active_job->job_name}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
      
		<ul class="dropdown-menu menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li class="ui-state-default"><a href="{{ url('/clients/examination_schedule_inner/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>

               @if($job->job_id == $whchjobs)
               <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
               @endif
               
               @endforeach
            @endif
         </ul>
      </div>
      <div class="action_parent">
      	<button type="button" class="action-button" onclick="goBack(<?=Session::get('job_id')?>)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back"><i class="fa fa-backward" data-toggle="tooltip" title="Back" aria-hidden="true"></i>
         </button>
         <button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i data-toggle="tooltip" title="Refresh" class="fa fa-refresh" aria-hidden="true"></i>
         </button>
         <div class="dropdown sort_dd">
            <button  type="button" id="Delete" class="dropdown-toggle action-button" >
				<span data-toggle="tooltip" title="Delete">Delete</span>
            </button> 
			<button  type="button" id="Modify" class="dropdown-toggle action-button" >
				<span data-toggle="tooltip" title="Modify">Modify</span>
            </button> 
			<button  type="button" id="copy_witness" class="dropdown-toggle action-button" >
				<span data-toggle="tooltip" title="Copy Witness">Copy Witness</span>
            </button>
			<button data-toggle="modal"  data-target="#create_witness" type="button" class="dropdown-toggle action-button" >
				<span data-toggle="tooltip" title="Create Witness">Create Witness</span>
            </button> 
			
            <div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
               <input type="text" name="search" class="form-control search_witness" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>

               <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
            </div>
         </div>
		 
      </div>
   </div>
<hr class="hr_new2">
<div class="loader" style="display: none;"></div>
<div class="container-fluid">  
<div class="page-101" id="con"> 
<div class="row">
	<div  class="col-sm-12">
		<div id="witness_container">
			@if($all_witness)
				<ul class="list-group" id="sortable" >
					@foreach($all_witness as $witness)
					<li class="list-group-item"  id="{{ $witness['id'] }}" data-id="{{ $witness['id'] }}" >
					<div style=" float: left; width: 25px; padding-top: 3px; "><input class="witness" type="checkbox" value="{{ $witness['id']  }}" ></div> <a href="{{ asset('clients/manage_docs/'.$witness['id']) }}/{{ Session::get('job_id') }}"><div><span id="wit_name_{{ $witness['id'] }}">
					{{ $witness['witness_name'] }}<i style=" float: right; " class="fa fa-chevron-right float-right" aria-hidden="true"></i></div></a>
					</li>
					@endforeach
				</ul>
			@else 
				<h3 align="center">Witness Not Found</h3>
			@endif
		</div>
	</div>
</div>
</div>
</div>
<div id="create_witness" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Witness</h4>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/create_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter Witness Name</label>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="text" name="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Add</button>
				</div>
			</div>
		</div>
		</form>
      </div>
    </div>

  </div>
</div>
<div id="Modify_witness" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Witness</h4>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/modify_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter Witness Name</label>
					<input type="hidden" name="_token"  value="{{ csrf_token() }}">
					<input type="hidden" name="witness_id" id="witness_id" />
					<input type="text" name="witness_name" required="required" id="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Modify</button>
				</div>
			</div>
		</div>
		</form>
      </div>
    </div>

  </div>
</div>


<div id="copy_witness_popup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Copy Witness</h4>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/copy_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter New Witness Name</label>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="hidden" name="witness_old_id" id="witness_old_id" />
					<input type="text" name="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Add</button>
				</div>
			</div>
		</div>
		</form>
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
			$.post("{{ asset('clients/change_order') }}",{'id':ids,_token:'{{ csrf_token() }}'},function(fb){
				console.log(fb);
			})
		}
	});
    $( "#sortable" ).disableSelection();
  } );
  $(document).on('click','#Modify',function(){
		id=$("input[class='witness']:checked").val();
		var c1=0;
		$(':checkbox:checked').each(function(i){
          c1++;
        });
		if(id)
		{
			if(c1>1)
			{
				 toastr.error('Please select Only One Witness','Warning');
			}
			else 
			{
				var title=$('#wit_name_'+id).text();
				$('#witness_name').val(title);
				$('#witness_id').val(id);
				$('#Modify_witness').modal('show');
			}
		}
		else 
		{
			 toastr.error('Please select One Witness','Warning');
		}
		
  });
  $(document).on('click','#Delete',function(){
		id=$("input[class='witness']:checked").val();
		 var val = [];
		$(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
		if(id)
		{
			swal({
			  title: "Are you sure?",
			  text: "Do You Want To Delete This Witness",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				$.post("{{ asset('clients/delete_witness') }}",{'id':val,_token:'{{ csrf_token() }}'},function(fb){
					location.reload();
				})
				
			  }
			});
		}
		else 
		{
			 toastr.error('Please select Any Witness','Warning');
		}
		
  });
   function refreshPage(whchjobs){
         $("#con").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            window.location.reload();
            $('.loader').hide();
            $(".hr_new3").show();
            $("#treeDemo").show();  
         }, 1000);
      }
	$(document).on('click','#copy_witness',function(){
		id=$("input[class='witness']:checked").val();
		var c1=0;
		$(':checkbox:checked').each(function(i){
          c1++;
        });
		if(id)
		{
			if(c1>1)
			{
				toastr.error('Please select Only One Witness','Warning');
			}
			else 
			{
				$('#witness_old_id').val(id);
				$('#copy_witness_popup').modal('show');
			}
		}
		else 
		{
			toastr.error('Please select Any Witness','Warning');
		}
	});
	$(document).on('keyup','.search_witness',function(){
		var value=$(this).val();
		$.post("{{ asset('clients/search_witness') }}",{'value':value,_token:'{{ csrf_token() }}'},function(fb){
			var resp=$.parseJSON(fb);
			console.log(resp);
			if(resp.status=='true')
			{
				$('#witness_container').html('<ul class="list-group" id="sortable" ></ul>');
				console.log(resp.data);
				for(i=0;i<resp.data.length;i++)
				{
					var url="{{ asset('clients/manage_docs') }}/"+resp.data[i].id+"/{{ Session::get('job_id') }}";
					$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><div style=" float: left; width: 25px; padding-top: 3px; "><input class="witness" type="checkbox" value="'+resp.data[i].id+'" ></div><a href="'+url+'"><div><span id="wit_name_'+resp.data[i].id+'">'+resp.data[i].witness_name+'<i style=" float: right; " class="fa fa-chevron-right float-right" aria-hidden="true"></i></div></a></li>');
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
				$('#witness_container').html('<h3 align="center">Witness Not Found</h3>');
			}
		})
	});

	function goBack(job){
    	window.location.href=baseurl+"/clients/examination_schedule/"+job;
    }
</script>
@stop
@endsection