if(counts>0)
  var lst=1;
else 
  var lst=0;
  if(counts > 0){
  $('#Notification-table').DataTable( {
        "order": [[ 2, "desc" ]],
		dom: 'Bfrtip',
        buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
        ]
    } );
  }

  $(".mark_read_list").click(function(){
      var id = $(this).data('notif_list_id');
      $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_read/"+id,
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
               window.location.reload();
              }
           }
      });
   });
  $('.daterange_1').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD');
      var aceess = $('.daterange_1').attr('data-access');
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-notification",
             data: {_token: $("input[name='_token']").val(),startDate:startDate,endDate:endDate,access:aceess},
             success: function(data)
             {
              console.log(data);

               resp=$.parseJSON(data);
                console.log(resp);
                if(resp.status==1)
                {
                if(lst==1)
                  destroy_datatable();
                }
                lst=resp.status; 
                        $("#table_container").html(resp.data);
                
                if(resp.status==1)
                {
                  init_datatable();
                }
          
             }
       });
    });