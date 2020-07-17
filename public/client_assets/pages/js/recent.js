
if(counts>0)
	var lst=1;
else 
	var lst=0;

$('input[name="daterange"]').daterangepicker({
       opens: 'right',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD')
       
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-quick/"+segment3+"/"+type,
             data: {_token: $("input[name='_token']").val(),startDate:startDate,endDate:endDate},
             success: function(data)
             {
				resp=$.parseJSON(data);
              
                  console.log(resp);
				 
				  if(resp.status==1)
				  {
					if(lst==1)
						destroy_datatable();
				  }
				  lst=resp.status;
                  $("#dvData").html(resp.data);
				  
				  if(resp.status==1)
				  {
					init_datatable();
				  }
          
             }
       });
   });
   
 
 if(counts>0)
 {
	if(segment2=='get-recent-shared' || segment2=='get-recent-commented')
	{
		$('#sample_1').DataTable({
			"order": [[ 2, "desc" ]],
		});
	}
	else 
	{
		$('#sample_1').DataTable({
			"order": [[ 1, "desc" ]],
		});
	}
 }
 function init_datatable(){
	if(segment2=='get-recent-shared' || segment2=='get-recent-commented')
	{
		 $('#sample_1').DataTable({
			"order": [[ 2, "desc" ]],
		 });
	}
	else 
	{
		 $('#sample_1').DataTable({
			"order": [[ 1, "desc" ]],
		});
	}
   
  }
  function destroy_datatable(){
    $("#sample_1").DataTable().destroy();
  }