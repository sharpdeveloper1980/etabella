@extends('layouts.client.app')
@section('title','Reports')
@section('content')
   <div class="row">
      <div class="col-md-1"><img src="{{asset('public/frontend/img/Untitled.png')}}" class="case_icon"></div>
      <div class="col-md-11 dropdown">
         <button class="btn  dropdown-toggle case_drop" type="button" data-toggle="dropdown">My Cases({{Session::get('client_display_name')}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></button>
         <ul class="dropdown-menu menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/dashboard/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
               @endforeach
            @endif
         </ul>
      </div>
   </div>
   <!-- <div class="row">
      <div class="col-md-6">
         <div style="float: left;">
            <button type="button" onclick="toggleSearchBox()" class="search_button"><i class="fa fa-search"></i>Search</button>
            <button type="button" class="refresh_button" onclick="refreshPage({{$whchjobs}})"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
         </div>
      </div>
      <div class="col-md-6">
         <div class="row" style="float: right;">
            <div class="col-md-2">
               <button type="button" class="select_button" onclick="selectAll()"><i class="fa fa-check" aria-hidden="true"></i> Select All</button>
            </div>
            <div class="col-md-2">
               <button type="button" class="plus_button" onclick="opnFileMdl()"><i class="fa fa-plus fa_ps" aria-hidden="true" ></i></button>
            </div>
            <div class="col-md-2">
               <form action="{{ route('downloadFile') }}" method="post">
               @csrf
                  <input type="hidden" id="file_id" name="file_id" />
                  <button type="submit" id="download_btn" class="download_button" disabled><i class="fa fa-download" aria-hidden="true"></i> Download</button>
               </form>
            </div>   
         </div>
      </div>
   </div> -->
   <hr class="hr_new1">
   <!-- second buttons start -->
   <div>
      <center>
        
      </center>
   </div>
   <!-- end second button -->
   <hr class="hr_new2">
   <!-- Table start -->
   <div class="row">
     <!--  <div class="col-md-6 client_bread">
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
      </div> -->
   </div>
   <hr class="hr_new3">
   <!-- <div class="loader" style="display: none;"></div> -->
 <!--  <div id="files_container">
   @if(count($my_clouds) > 0)
   @foreach($my_clouds as $clkey => $cloud)
      @if($cloud->file_type == 1)
          <div class="row FILE_CONT">
            <a href="{{ url('/clients/files/'.$cloud->file_id.'/'.$whchjobs) }}">
               <div class="col-md-3"><i class="fa fa-folder fa_fold" aria-hidden="true"></i> </div>
               <div class="col-md-6 col_heading">
                  <h>{{ucfirst($cloud->file_name)}}</h>
                  <p>{!! Helper::humanFileSize($cloud->file_size) !!}, - {{ date('M d, Y H:i:s', $cloud->file_date_modified) }}</p>
               </div>
            <div class="col-md-3 fa_rgt"><i class="fa fa-chevron-right fa_right" aria-hidden="true"></i></div>
            </a>
          </div>
         <hr class="hr_new3">
      @else
         <div class="row FILE_CONT">
          <a href="{{ url('/clients/file/render/'.$cloud->file_id) }}">
            <div class="col-md-3"><i class="fa fa-file-pdf-o fa_pdo" aria-hidden="true"></i> </div>
            <div class="col-md-6 col_heading">
               <h>{{ucfirst($cloud->file_name)}}</h>
               <p>{!! Helper::humanFileSize($cloud->file_size) !!}, - {{ date('M d, Y H:i:s', $cloud->file_date_modified) }}</p>
            </div>
          </a>
            <div class="col-md-3 check">
               <input type="checkbox" class="scales" id="scales[]" name="scales[]" onclick="myFunction(this,{{$cloud->file_id}})" @if(in_array($cloud->file_id, $arr_my_dfiles)) checked @endif value="{{ $cloud->file_id }}">
            </div> 
         </div>
         <hr class="hr_new3">
      @endif
   @endforeach
   @else
   <center>
     <label class="alert alert-warning"> You do not have any folders or files added yet</label>
   </center> 
   @endif
  </div> -->
<!-- upload files modal -->
@section('js')
   <script type="text/javascript">
    
@stop

@endsection