$(document).on('submit','.database_operation_form',function(){
    var url=$(this).attr('action');
    var data=new FormData($(this)[0]);
    var popup=$(this).attr('data-pop');
    $.ajax({
        type:'POST',
        url:url,
        data:data,
        contentType:false,
        processData:false,
        success:function(fb)
        {
            var resp=$.parseJSON(fb);
            if(resp.status=='true')
            {
                $('.database_operation_form').trigger('reset');
                //swal('Success',resp.message,'success');
				 toastr.success(resp.message,'Success');
                $(popup).modal('hide');
                if(resp.reload==0)
                {
                    $('.dataTable').DataTable().ajax.reload();
                }
                else
                {
                    window.location.href=resp.reload;
                }
            }
            else
            {
               toastr.error(resp.message,'Warning');
            }
        }


    });
    return false;
});
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});