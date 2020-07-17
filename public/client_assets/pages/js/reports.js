if(all_counts>0)
  var all_lst=1;
else 
  var all_lst=0;

if(annot_counts>0)
  var annot_lst=1;
else 
  var annot_lst=0;

if(hyper_counts>0)
  var hyper_lst=1;
else 
  var hyper_lst=0;

if(book_counts>0)
  var book_lst=1;
else 
  var book_lst=0;

if(issue_counts>0)
  var issue_lst=1;
else 
  var issue_lst=0;


  if(all_counts > 0){
    $('#sample_1').DataTable({
                  //  dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                  //  buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }
  if(annot_counts > 0){
    $('#sample_2').DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                    //buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                  //  ]
                  });
  }if(hyper_counts > 0){
    $('#sample_3').DataTable({
                   // dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                  //  'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }if(book_counts > 0){
    $('#sample_4').DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }if(issue_counts > 0){
    $('#sample_5').DataTable({
                   // dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                    //]
                  });
  }

function ajaxForFilter(datecls,tablecont,tableid,reporttype,startDate,endDate){
  $.ajax({
    type: "POST",
    url: baseurl+"/clients/report-files",
    data: {_token: $("input[name='_token']").val(),startDate:startDate,endDate:endDate,reporttype:reporttype,tableid:tableid,whchjobs:"{{$whchjobs}}"},
    success: function(data)
      {

           var resp = $.parseJSON(data);
           console.log(resp);
            if(resp.status==1)
            {
              if(datecls=='daterange_1')
              {
                if(all_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_2')
              {
                if(annot_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_3')
              {
                if(hyper_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_4')
              {
                if(book_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_5')
              {
                if(issue_lst==1)
                 destroy_datatable(tableid);  
              }              
            }




            if(datecls=='daterange_1')
            {
               all_lst=resp.status; 
            }
            if(datecls=='daterange_2')
            {
               annot_lst=resp.status; 
            }
            if(datecls=='daterange_3')
            {
               hyper_lst=resp.status; 
            }
            if(datecls=='daterange_4')
            {
               book_lst=resp.status; 
            }
            if(datecls=='daterange_5')
            {
               issue_lst=resp.status; 
            }
            

            $("#"+tablecont).html(resp.data);
            if(resp.status==1)
            {
                init_datatable(tableid);
            }
             /*if ( ! $.fn.DataTable.isDataTable( '#'+tableid ) ) {
                  $("#"+tablecont).html(data);
                  init_datatable(tableid);
             }
             else 
             {
	             destroy_datatable(tableid);
                 $("#"+tablecont).html(data);
                 init_datatable(tableid);
            }*/
       
      }
  });
}

  
   $('.daterange_1').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate1 = start.format('YYYY-MM-DD');
      var endDate1 = end.format('YYYY-MM-DD')

      var tablecont1 = $('.daterange_1').data('tablecont');
      var tableid1 = $('.daterange_1').data('tableid');
      var reporttype1 = $('.daterange_1').data('reporttype');

      ajaxForFilter('daterange_1',tablecont1,tableid1,reporttype1,startDate1,endDate1);
    });

   $('.daterange_2').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate2 = start.format('YYYY-MM-DD');
      var endDate2 = end.format('YYYY-MM-DD')

      var tablecont2 = $('.daterange_2').data('tablecont');
      var tableid2 = $('.daterange_2').data('tableid');
      var reporttype2 = $('.daterange_2').data('reporttype');

      ajaxForFilter('daterange_2',tablecont2,tableid2,reporttype2,startDate2,endDate2);
    });

   $('.daterange_3').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate3 = start.format('YYYY-MM-DD');
      var endDate3 = end.format('YYYY-MM-DD')

      var tablecont3 = $('.daterange_3').data('tablecont');
      var tableid3 = $('.daterange_3').data('tableid');
      var reporttype3 = $('.daterange_3').data('reporttype');

      ajaxForFilter('daterange_3',tablecont3,tableid3,reporttype3,startDate3,endDate3);
    });

   $('.daterange_4').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate4 = start.format('YYYY-MM-DD');
      var endDate4 = end.format('YYYY-MM-DD')

      var tablecont4 = $('.daterange_4').data('tablecont');
      var tableid4 = $('.daterange_4').data('tableid');
      var reporttype4 = $('.daterange_4').data('reporttype');
      ajaxForFilter('daterange_4',tablecont4,tableid4,reporttype4,startDate4,endDate4);
    });

   $('.daterange_5').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate5 = start.format('YYYY-MM-DD');
      var endDate5 = end.format('YYYY-MM-DD')

      var tablecont5 = $('.daterange_5').data('tablecont');
      var tableid5 = $('.daterange_5').data('tableid');
      var reporttype5 = $('.daterange_5').data('reporttype');

      ajaxForFilter('daterange_5',tablecont5,tableid5,reporttype5,startDate5,endDate5);
    });
 

   function init_datatable(tableid){
    $('#'+tableid).DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
					"response":true,
                   //buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                    //'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }

  function destroy_datatable(tableid){
    $("#"+tableid).DataTable().destroy();
  }
