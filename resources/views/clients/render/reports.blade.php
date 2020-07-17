<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="{{$tableid}}" role="grid" aria-describedby="{{$tableid}}_info">
              <thead>
                <tr role="row">
                    <th>Filename</th>
                    <th>Date</th>
                    <th>Page</th>
                    <th>Type</th>
                </tr>
              </thead>
              <tbody id="reportList">
                @if(count($reports) > 0)
                @foreach($reports as $cldkey => $my_cloud)
                  <tr>
                    <td>
                      <a href="{{url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)}}">{{ $my_cloud->file_name }}</a>
                    </td>
                    <td>
                      {{ date('M d, Y H:i:s', $my_cloud->created_at) }}
                    </td>
                    <td>
                      <a class="btn btn-default" href="{{url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)}}">Page {{ $my_cloud->page }}</a>
                    </td>
                    <td>
                      {{ $my_cloud->type }}
                    </td>
                  </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="3" style="text-align: center;">No data found yet</td>
                </tr>
                @endif
              </tbody>
            </table>