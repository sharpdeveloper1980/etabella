@extends('layouts.client.app')
@section('title','File Render')
@section('content')
 <style type="text/css">
  .incomming_comment {
    width: 80%;
    height: 50px;
  }
  .outgoing_comment {
    width: 80%;
    height: 50px;
    margin-left: 20%;
    background: skyblue;
    color: white;
    padding: 5px;
    border-radius: 8px;
     margin-bottom: 10px;
  }
  .incomming_comment {
    width: 80%;
    height: 50px;
    background: #e44c064a;
    border-radius: 6px;
    margin-bottom: 10px;
  }
</style>
  <div class="row custom-toolbar-parent">
    <ul class="list-inline custom-toolbar">
      <li style="width:4%"><a href="{{ url('clients/dashboard') }}" id="">Back</a></li>
      <li style="width: 95%; text-align: center; color: #E54E09;"><b><center>{{$file->file_name}}</center></b></li>
    </ul>
  </div>
    
    <!-- 2. Element where PSPDFKit will be mounted. -->
	
    <div id="pspdfkit" style="width: 100%;" class="pdf_container"></div>
   
  <div class="modal fade" id="add_txt_mark" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add To Mark</h4>
        </div>
        <div class="modal-body">
          <p id="mark_text"></p>
          <hr>
          <div class="all_comment">
           
          </div>
           <div class="new_comment"></div>
          <div class="form-group">
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field" placeholder="Enter Comment..."></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data">Save</button> <a id="share_comment" class="btn pull-right" href="javascript:;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <!-- 3. Initialize PSPDFKit. -->
    <script>
	resizeDiv();
	  function resizeDiv() {
		vpw = $(window).width();
		vph = $(window).height()-107;
		$(".pdf_container").css({'height': vph + 'px'});
	  }
     /* PSPDFKit.preloadWorker({
       // disableWebAssemblyStreaming: true,
        baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
        licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J"
      });*/
   $.ajax({
           url:"http://66.206.3.50:6062/get_token_for_dashbord/{{ $file->pspdf_file_id }}",
           method:'GET',
           contentType:"application/json",
           success : function(resp){
      PSPDFKit.load({
        container: "#pspdfkit",
        //disableWebAssemblyStreaming: true,
       //  baseUrl: 'http://web.etabella.com/etabellaweb/public/dist/',
       // pdf: "{{ url('/public/storage/files/'.$file->file_upload_name) }}",
         documentId: "{{ $file->pspdf_file_id }}",
         authPayload: { jwt: resp },
         instant: true,
       /* licenseKey: "SbWkKq6YZNSluvvY475kx7Qb7qN-_e2mdPd06NA7Kzh57UZW0g2gaRd7scqa-i-2T-DyC6Jh-u6y6t7e4HogHVRfFbK5cUZc-e1P7UqwIAqKyKSzHO-xlX-sfbAOqXzIifaHjL0fTdUbYZGUEKLcZr5kOQW5tKswef3Gi40Kmp4zriP5KI2mC20xXc-Ppe7Y48pDElXqyV4pqok26L6Rg0p21qtmjKEPPhdD8R1D9uAR1CRVkRpqAj-AXgHMJT19F7Co_9k5bykDFXUNaZbiUlwv0Tu8mwziwrBTuKAvKB-TFFA000RSLnASjKpGZMeMYvx6-9wk0zA0e826jXd_f9zBH3_WUkWHqEkuAmP1LbrlPlNPIPoTfYUOgFgx-yZfVPloMMwey1-YQq1ed_zUQSXnNBlR9Hv9unxYuF6DGSICS5bZf-_oieyUwXeaw04J"*/
      })
        .then(function(instance) {
          /**Hide toolbar section**/
          const viewState = instance.viewState;
          const curr_page = viewState.currentPageIndex+1;
          instance.setViewState(viewState.set("showToolbar", false));
			const state = instance.viewState;
           	const newState = state.set("scrollMode", "PER_SPREAD");
            instance.setViewState(newState);
		  })
        .catch(function(error) {
          console.error(error.message);
        });
     }
   });
    </script>
@endsection