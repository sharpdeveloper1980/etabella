<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="Notification-table" role="grid" aria-describedby="sample_1_info">
            <thead>
              <tr role="row">
                  <th>Title</th>  
                  <th>Message</th>
                  <th>Date</th>
                  <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @if(count($allnotifications) > 0)
                     @foreach($allnotifications as $nkey => $allnotification)
                     <?php  $message = str_replace('#','',str_replace('@','', substr(strip_tags($allnotification->message), 0, 20))); ?>
					 <?php 
									 $url="javascript:;";
									  if($allnotification->type==1)
									  {
										  if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/groups-single/'.$allnotification->job_id.'/'.$allnotification->file_id); 
											}
											else 
											{
												$url = url('clients/groups/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									  }
								     else if($allnotification->type==2)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/topics-single/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											else 
											{
												$url = url('clients/topics/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									 }
								     else if($allnotification->type==3)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/user-single/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											else 
											{
												$url = url('clients/user/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									 }
								    ?>
                     <tr>
                        <td>
                           @if($allnotification->is_annotation == 1)
                            <a href="{{ url('clients/shared/'.$allnotification->id) }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 1)
                            <a href="{{ $url }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 2)
                            <a href="{{ $url }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 3)
                            <a href="{{ $url }}">
                            {{ $allnotification->title }}
                            </a>
                            @else
                            {{ $allnotification->title }}
                            @endif
                        </td>
                        <td>
                          @if($allnotification->is_annotation == 1)
                            <a href="{{ url('clients/shared/'.$allnotification->id) }}">
                             <?php echo  strlen($message) > 15  ? $message . '...' :  $message; ?>
                            </a>
                            @else
                             <?php echo  strlen($message) > 15  ? $message . '...' :  $message; ?> 
                            @endif
                        </td>
                        <td>{{ date('M d, Y H:i:s', $allnotification->created_at) }}</td>
                        <td>
                          @if($allnotification->mark_read == 1)
                           <a href="javascript:void(0)" data-notif_list_id="{{$allnotification->id}}" type="button" class="btn btn-xs btn-success mark_read_list">Mark read</a>      
                           @else
                           <a href="javascript:void(0)" data-notif_list_id="{{$allnotification->id}}" type="button" class="btn btn-xs btn-info" disabled>Read</a>      
                           @endif
                        </td>
                     </tr>
                     @endforeach
                     @else
                     <tr>
                       <td colspan="5">
                        <center>
						@if(Request::segment(2)=='message_notification')
                          <a  href="{{ url('clients/groups/'.Session::get('job_id')) }}"><label style="cursor: pointer;" class="alert alert-warning">Go To Messenger</label></a>
					    @else 
						  <label class="alert alert-warning"> No new message found yet</label>
					    @endif
                        </center> 
                       </td>
                     </tr>
                     @endif
            </tbody>
        </table>