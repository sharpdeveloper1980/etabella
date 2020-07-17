
if(counts>0)
  var lst=1;
else 
  var lst=0;
if(counts > 0){
  init_datatable();
}

  function init_datatable(){
    $('#sample_1').DataTable({
    	 "order": [[ 4, "desc" ]],
      //dom: 'lBfrtip',
     // buttons: [
        // 'copyHtml5',
        // 'excelHtml5',
     //   'csvHtml5',
        // 'pdfHtml5'
    //  ]
    });
  }

  function destroy_datatable(){
    $("#sample_1").DataTable().destroy();
  }

  function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Make sure that the link is not displayed
    downloadLink.style.display = "none";

    // Add the link to your DOM
    document.body.appendChild(downloadLink);

    // Lanzamos
    downloadLink.click();
  }

  function export_table_to_csv(html, filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
      for (var i = 0; i < rows.length; i++) {
      var row = [], cols = rows[i].querySelectorAll("td, th");
      
          for (var j = 0; j < cols.length; j++) 
              row.push(cols[j].innerText);
          
      csv.push(row.join(","));    
    }

      // Download CSV
      download_csv(csv.join("\n"), filename);
  }

 /*



 document.querySelector(".export").addEventListener("click", function () {
      var html = document.querySelector("table").outerHTML;
    export_table_to_csv(html, "Log List.csv");
  });*/


    $('input[name="daterange"]').daterangepicker({
       opens: 'right',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD')
       
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-logs",
             data: {_token: $("input[name='_token']").val(),startDate:startDate,endDate:endDate},
             success: function(data)
             {
              var resp = $.parseJSON(data);
              console.log(resp);
               if(data){
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
             }
       });
   });

   function deleteAdmin(id){
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to delete this Admin!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      },
      function() {
         $("#delete-admin-"+id).submit();
        swal(
          'Deleted!',
          'Admin has been deleted.',
          'success'
        );
      });
   };