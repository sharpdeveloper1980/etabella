                <table class="table table-hover" id="sample_1">
                  <thead>
                     <th><a>No.</a>
                     </th>
                     <th><a>Description</a></th>
                     <th><a>Action</a></th>
                     <th><a>Type</a></th>
                     <th><a>Date</a></th>
                  </thead>
                  <tbody>
                     @if(count($users) > 0)
                     @foreach($users as $userkey => $user)
                     <tr>
                        <td id="user59">{{ $userkey + 1 }}</td>
                        <td>{{$user->description}}</td>
                        
                        <td>{{$user->action}}</td>
                        
                        <td>
                          @if($user->type == 1)
                            Admin
                          @elseif($user->type == 2)
                            Manager
                          @elseif($user->type == 3)
                            Developer
                          @else
                            Client
                          @endif  
                        </td>
                        
                        <td>{{ date('M d, Y H:i:s', $user->created_at) }}</td>
                     </tr>
                     @endforeach
                     @else
                     <tr>
                       <td colspan="7">
                        <center>
                          <label class="alert alert-warning">
                            No data found on this date range
                          </label>
                        </center> 
                       </td>
                     </tr>
                     @endif
                  </tbody>
                </table>
               