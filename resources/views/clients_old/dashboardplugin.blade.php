@extends('layouts.client.app')
@section('title','Client Dashboard')
@section('content')
   <div class="row">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class=" dropdown">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{Session::get('client_display_name')}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu job-dropdown menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/dashboard/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
               @endforeach
            @endif
         </ul>
      </div>
      
      
   </div>
   <div class="row" style="padding:20px;">
      
         <button type="button" onclick="toggleSearchBox()" class="action-button"><i class="fa fa-search"></i>Search</button>
            <button type="button" class="action-button" onclick="refreshPage({{$whchjobs}})"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
          
          
           <form action="{{ route('downloadFile') }}" method="post" style="float:right">
               @csrf
                  <input type="hidden" id="file_id" name="file_id" />
                  <button type="submit" id="download_btn" class="action-button" disabled><i class="fa fa-download" aria-hidden="true"></i> Download</button>
               </form>
               <button type="button" class="action-button" onclick="selectAll()" style="float:right"><i class="fa fa-check" aria-hidden="true"></i> Select All</button>
               <button type="button" class="action-button add-file" onclick="opnFileMdl()" style="float:right"><i style="padding:3px;" class="fa fa-plus fa_ps" aria-hidden="true" ></i></button>
     
   </div>
   <hr class="hr_new1">
   <!-- second buttons start -->
   <div>
      <center>
         <div class="col-md-6 col-md-offset-3" id="search_files" style="display: none;margin-top: -22px">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
            <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
         </div>
         <div class="name_date">
            <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_name','{{Session::get('file_name')}}')">
              @if(Session::get('file_name') == 'asc')
                <span class="file_name"><i class="fa fa-arrow-down"></i></span>
              @else
                <span class="file_name"><i class="fa fa-arrow-up"></i></span>
              @endif
              Name
            </a>
            <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_date_modified','{{Session::get('file_date_modified')}}')">

              @if(Session::get('file_date_modified') == 'asc')
                <span class="file_date_modified"><i class="fa fa-arrow-down"></i></span>
              @else
                <span class="file_date_modified"><i class="fa fa-arrow-up"></i></span>
              @endif
              Date
            </a>
            <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_size','{{Session::get('file_size')}}')">

              @if(Session::get('file_size') == 'asc')
                <span class="file_size"><i class="fa fa-arrow-down"></i></span>
              @else
                <span class="file_size"><i class="fa fa-arrow-up"></i></span>
              @endif
              Size
            </a>
            <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_type','{{Session::get('file_type')}}')">

              @if(Session::get('file_type') == 'asc')
                <span class="file_type"><i class="fa fa-arrow-down"></i></span>
              @else
                <span class="file_type"><i class="fa fa-arrow-up"></i></span>
              @endif
              Type
            </a>
         </div>
      </center>
   </div>
   <!-- end second button -->
   <hr class="hr_new2">
   <!-- Table start -->
   <div class="row">
      <div class="col-md-6 client_bread">
         @if($arr_bread_bk)
            @foreach($arr_bread_bk as $bkey => $bread)
               @if($bkey == 0)
                  <a href="{{ url('/clients/dashboard/'.$whchjobs) }}" class="client_bread"><i class="fa fa-home"></i> {{$bread['filename']}}</a>
               @elseif((count($arr_bread_bk)-1) == $bkey)
                  <a style="color: grey" class="client_bread"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
               @else
                  <a href="{{ url('/clients/files/'.$bread['file_id'].'/'.$whchjobs) }}" class="client_bread"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
               @endif
                  
               @if((count($arr_bread_bk)-1) == $bkey)
                  @else
                  <span class="separator client_bread">/</span>
               @endif
            @endforeach
         @endif                         
      </div>
   </div>
   <hr class="hr_new3">
   <div class="loader" style="display: none;"></div>
  <div class="container">
    <ul id="treeDemo" class="ztree">
    </ul>
  </div>
<!-- upload files modal -->
<div id="file_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{ url('clients/files/upload_files') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="file_parent_id" value="{{ Request::segment(2) == 'dashboard' ? 0 : Request::segment(3) }}">
        <input type="hidden" name="jobs[]" value="{{ $whchjobs }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Files</h4>
        </div>
        <div class="modal-body">
          <div style="margin-top:-10px;padding-bottom:10px">
            <span class="grey"><i class="fa fa-home"></i></span>
            {{ implode(' / ',$arr_bread) }}
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="file_name"></label>
                <label class="btn btn-warning form-control" style="display: block;">
                    Please choose a file to upload 
                    <input type="file" name="file_name[]" multiple style="display: none;">
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-default" onclick="clsFileMdl()">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('js')
   <script type="text/javascript">
    var setting = {
                    data: {
                      simpleData: {
                        enable: true
                      },
                      view: {
                        addDiyDom: null,
                        autoCancelSelected: true,
                        dblClickExpand: true,
                        expandSpeed: "fast",
                        fontCss: {},
                        nameIsHTML: false,
                        selectedMulti: true,
                        showIcon: true,
                        showLine: true,
                        showTitle: true,
                        txtSelectedEnable: false
                      },
                    }
                  };


var zNodes = {!! json_encode($all_nods) !!};

$(document).ready(function(){
$.fn.zTree.init($("#treeDemo"), setting, zNodes);
});



      var file_id=[];
      var i=0;
      function myFunction(chk,fileid)
      {
         var find = chk.checked?"checked":"unchecked" ;
         if(find=="checked")
         {
            file_id[i]=fileid;
            i++;
            document.getElementById("file_id").value=file_id;
         }
         else
            {
               e=0;
               while(e<file_id.length)
               {
                  if(file_id[e]==fileid)
                  {
                     // file_id[e]=0;
                     file_id.splice(e,1);
                     break;
                  }
                  e++;
               }
           //  alert(file_id.length);

              document.getElementById("file_id").value=file_id;
            }
    /*      for(c=0;c<file_id.length;c++)
          {
            if(file_id[c]!=0)
            {
               document.getElementById("download_btn").disabled=false;
               document.getElementById("download_btn").style.color = "#f36523";
               break;
            }
            else
            {
               document.getElementById("download_btn").disabled=true;
               document.getElementById("download_btn").style.color = "#c1bfbe";
            }
          }
    */
          if(file_id.length==0)
           {
               document.getElementById("download_btn").disabled=true;
               document.getElementById("download_btn").style.color = "#c1bfbe";
               i=0;
           }
          else
           {
               document.getElementById("download_btn").disabled=false;
               document.getElementById("download_btn").style.color = "#f36523";
           }

      }

      function refreshPage(whchjobs){
         $(".FILE_CONT").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            $('.loader').hide();
            $(".hr_new3").show();
            $(".FILE_CONT").show();
            window.location.href=baseurl+'/clients/dashboard/'+whchjobs
         }, 1000);
      }

/**
Open File Modal
**/
   function opnFileMdl(){
      $("#file_modal").modal('show');
   }
/**End**/

/**
Close File Modal
**/
   function clsFileMdl(){
      $("#file_modal").modal('hide');
   }
/**End**/

/**
Select All Function
**/

function selectAll()
  {
    var i=0;
    $(".scales").prop('checked', true);
   $("input[name='scales[]']").each( function () {
  //       alert( $(this).val() );
       file_id[i]=$(this).val();
        i++;  
   });
//   alert(file_id);
    document.getElementById("file_id").value=file_id;
    document.getElementById("download_btn").disabled=false;
    document.getElementById("download_btn").style.color = "#f36523";

    $(".scales").prop('checked', true);
    }

/**
End
**/

/**
 Sorting Start 
**/
   function sorting(segment,parentid=0,job,orderName,type){
    if(segment == 'dashboard'){
      parentid = 0;
    }
    var spanClass = $('.'+orderName).find('i').attr('class');
    $.ajax({
          type: "GET",
          url: baseurl+"/clients/sorting/"+parentid+"/"+job+"/"+orderName,
          success: function(data)
          {
            if(data){
                if(spanClass == 'fa fa-arrow-down'){
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-arrow-up');
                }else{
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-arrow-down');
                }
                $("#files_container").html(data);
            }
          }
      });
   }
/**
Sorting End
**/

/**
Search Files 
**/
  function toggleSearchBox(){
    $("#search_files").fadeToggle();
    $(".name_date").fadeToggle();
  }

  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      var keywords = $(this).val();
      var job = $('.selected_job').val();
      if(keywords){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/search/"+keywords+"/"+job,
            success: function(data)
            {
              if(data != ''){
                  $("#files_container").html(data);
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
        window.location.reload();
      }
    }
  });
/**stop**/


</script>
@stop

@endsection