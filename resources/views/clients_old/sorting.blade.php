@if($my_clouds)
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
               <input type="checkbox" class="scales" id="scales" name="scales" onclick="myFunction(this,{{$cloud->file_id}})" @if(in_array($cloud->file_id, $arr_my_dfiles)) checked @endif>
            </div> 
         </div>
         <hr class="hr_new3">
      @endif
  @endforeach
@endif
