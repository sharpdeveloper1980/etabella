<!-- notify content -->
@if(count($notifications) > 0)
	@foreach($notifications as $nkey => $notification)
    	<div class="drop-content" id="row-{{$notification->id}}">
        	<li>
            	@if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
									 <?php 
									 $url="javascript:;";
									  if($notification->type==1)
							    	   $url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==2)
							    	   $url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==3)
							    	   $url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
								    ?> 
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ $url }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{ $notification->title }}
                                      </label>  
                                    </div>
                                    @endif 
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <!-- <div class="notify-img"> -->
                    <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                    <!-- </div> -->
                </div>

                <div class="col-md-12 pd-l0">
                	<p></p>
                </div>
            </li>
        </div>
    @endforeach
@else
    <div class="drop-content" id="row-else">
        <li>
            <div class="col-md-12">No message found</div>
        </li>
    </div>
@endif