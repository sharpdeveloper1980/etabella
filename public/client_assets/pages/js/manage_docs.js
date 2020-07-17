function nodefile(id){
	var id=$('#manage_doc_'+id).parent('li').children('span').attr('id');
	$('#'+id).trigger('click');
}
function moveHere(id){
	var id=$('#manage_doc1_'+id).parent('li').children('span').attr('id');
	$('#'+id).trigger('click');
}
$( function() {
    $( "#sortable" ).sortable({
		stop: function(event, ui) {
	    
			//console.log("New position: " + ui.item.index());
			//console.log();
			ids=[];
			for(i=0;i<$('#sortable').children().length;i++)
			{
				ids.push($($('#sortable').children()[i]).attr('id'))
			}
			for(sno=0;sno<$($('#sortable').children()).length;sno++)
			{
				node =$($('#sortable').children())[sno];
				new_sno=sno;
				$(node).find('span').text(new_sno+1);
			}
			
			//console.log(ids);
			$.post(baseurl+"/clients/change_order_docs",{'id':ids,_token:$("input[name='_token']").val()},function(fb){
				console.log(fb);
			}) 
		}
	});
    $( "#sortable" ).disableSelection();
  } );
var w_file_arr=[];
$(document).on('change','.witness_files',function(){
	var data=$(this).val();
	if($(this). is(":checked"))
	{
	  w_file_arr.push(data);
	}
	else 
	{
	  var temp_arr=w_file_arr;
	  w_file_arr=[];
	  y = jQuery.grep(temp_arr, function(value) {
		if(value != data)
			w_file_arr.push(value);
	  });
	}
});
$('#example').DataTable({
	dom: 'Bfrtip',
	buttons: [
	]
});


var setting = {
		data: {
		  simpleData: {
			enable: true
		  },
		},
		  view: {
			addDiyDom: null,
			autoCancelSelected: true,
			dblClickExpand: true,
			expandSpeed: "fast",
			fontCss: {},
			nameIsHTML: true,
			selectedMulti: true,
			showIcon: false,
			showLine: true,
			showTitle: true,
			txtSelectedEnable: true,
		  },
		check: {
		  enable: false
		},
		callback: {
			// onCheck: zTreeOnCheck
		}
	  };
 setTimeout(function(){
    expandNode();
  },500);
function expandNode() {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandAll(true);
        zTree.expandAll(false);
  }

$( document ).ready(function() {
  load(setting,zNodes);
  load_modi(setting,zNodes);
  load_move(setting,zNodes_move);
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);
}
 function load_modi(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo_Modify"), setting, zNodes);
}
  
function load_move(setting,zNodes_move){
	return $.fn.zTree.init($("#treeDemo_move"), setting, zNodes_move);
}
var array_checked = []; 
function checkfile(type)
{
	var data=$(type).val();
	if($(type). is(":checked"))
	{
	  array_checked.push(data);
	}
	else 
	{
	  var temp_arr=array_checked;
	  array_checked=[];
	  y = jQuery.grep(temp_arr, function(value) {
		if(value != data)
			array_checked.push(value);
	  });
	}
 }

  $("#add_files").click(function(){
    var whchjobs = $(this).val();
	var wid=$(this).attr('data-witness');
    if(array_checked.length > 0){
		/**Loader Show**/
		/*$("#treeDemo").hide();
		$(".hr_new3").hide();
		$(".loader").show();*/
	  $.ajax({
          type: "POST",
          url: baseurl+"/clients/add_to_witness/"+wid,
          data: {_token: $("input[name='_token']").val(),arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
             
              array_checked = [];
			       $(".filecheck").prop('checked', false);
			 /**Loader Hide**/
				$("#treeDemo1").show();
				$(".hr_new3").show();
				$(".loader").hide();
			  toastr.success(data.message, data.title);
			  setTimeout(function(){
				  location.reload();
			  },1000)
            }
          }
      });
    }else{
	  toastr.error('Please select atleast single folder/file','error','Warning');
    }
  });
   function refreshPage(whchjobs){
         $(".page-101").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            window.location.reload();
            $('.loader').hide();
            $(".hr_new3").show();
            $("#treeDemo").show();  
         }, 1000);
      }
	  
	 
	$(document).on('click','#Delete',function(){
		data_witness=$(this).attr('data-witness');
		var val = w_file_arr;
		
		console.log(val);
		if(val.length>0) {
		$.post(baseurl+"/clients/delete_witness_file/"+data_witness,{'ids':val,_token:$("input[name='_token']").val()},function(fb){
			 toastr.success('Files Successfully Deleted','Success');
			  setTimeout(function(){
				  location.reload();
			  },1000);
		})
		} 
		else 
		{
			 toastr.error('Please Select Any Doc','Warning');
		}
	});
	$(document).on('click','#Modify',function(){
		var val = w_file_arr;
		
		if(val.length>1)
		{
			toastr.error("you can't select multipal files",'Warning');
		}
		else if(val.length>0)
		{
			$('#selected_doc').val(val[0]);
			$('#doc_Modify').modal('show');
		}
		else 
		{
			toastr.error("Please Select One File",'Warning');
		}
	});
	$(document).on('click','#Modify_files',function(){
		 var whchjobs = $(this).val();
		 var main_file_id=$('#selected_doc').val();
		 var wid=$(this).attr('data-witness');
		 if(array_checked.length > 1){
			 toastr.error('Please Select only One File','Warning');
		 }
		 else if(array_checked.length > 0)
		 {
			 var data={'new_file':array_checked[0],'old_file':main_file_id,'job':whchjobs,'wid':wid,_token:$("input[name='_token']").val()};
			 $.post(baseurl+"/clients/Modify_files",data,function(fb){
				 var resp=$.parseJSON(fb);
				 if(resp.status=='true')
				 {
					 toastr.success(resp.message,'Success');
					 setTimeout(function(){
						location.reload();
					 },1000);
					 
				 }
				 else 
				 {
					toastr.error(resp.message,'Warning');
				 }
			 });
		 }
		 else 
		 {
			 toastr.error('Please Select One File','Warning');
		 }
	});
	$(document).on('keyup','.search_witness_files',function(){
		var value=$(this).val();
		$.post(baseurl+"/clients/search_witness_files",{'value':value,_token:$("input[name='_token']").val(),'w_id':segment3},function(fb){
			var resp=$.parseJSON(fb);
			
			if(resp.status=='true')
			{
				$('.file_container').html('<ul class="list-group" id="sortable" ></ul>');
				console.log(resp.data);
				var url=baseurl+"/public/images/pdf.ico";
            	var doc_url=baseurl+"/public/images/doc.png";
            	var img_url=baseurl+"/public/images/image.png";
                var other_url=baseurl+"/public/images/play.png";
				for(i=0;i<resp.data.length;i++)
				{
				//	alert(resp.data[i].file_name)
                  //  console.log('EXT');
					console.log(resp.data[i].file_name.split('.').reverse());
					var file_extension = resp.data[i].file_name.split('.').reverse()[0];
					var doc_file=baseurl+"/public/storage/files/"+resp.data[i].file_upload_name;
				//	console.log(file_extension);
				//	alert(file_extension)
					if(file_extension =='pdf' || file_extension =='PDF')
					{
						var pdf_file=baseurl+"/clients/file/render/"+resp.data[i].doc_id;
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="'+pdf_file+'"><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
					else if(file_extension == 'xlsx' || file_extension == 'wpd' || file_extension == 'tex' || file_extension == 'xls' || file_extension == 'xlsx' || file_extension == 'docb' || file_extension == 'dotm' || file_extension == 'dotx' || file_extension == 'docm' || file_extension == 'csv' || file_extension == 'pptx' || file_extension == 'ppt' || file_extension == 'txt' || file_extension == 'doc' || file_extension == 'docx')
					{
						
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'doc\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+doc_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
                	else if(file_extension == 'jpg' || file_extension == 'png' || file_extension == 'jpeg')
					{
						
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'doc\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+img_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
					else 
					{
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><a href="javascript:;" onclick="popupwindow(\''+doc_file+'\',\'img\')" ><div style="width:95%;float:left"><span >'+(i+1)+'</span> &nbsp; <img style="width:20px" class="file_iocn" src="'+other_url+'">'+resp.data[i].file_name+'</div></a><div><input type="checkbox" value="'+resp.data[i].id+'" class="witness_files"/></div></li>');
					}
				}
				if(resp.mode=='ALL')
				{				
					$('#sortable').sortable({
						connectWith: '#mycontainer ul',
						placeholder: 'myplaceholder'
					});
				}
			}
			/*else 
			{
				$('.file_container').html('<h3 align="center">File Not Found</h3>');
			}*/
		
			
		})
	});
	$(document).on('click','#move_to',function(){
		
		var data=[];
		var index=[];
		$(':checkbox:checked').each(function(i){
           data.push($(this).val());
		   index.push($(this).closest('li').find('span').text());
        });
		if(data.length>1)
		{
			 toastr.error('Please Select Only One File','Warning');
		}
		else if(data.length>0)
		{
			$('#current_index').text(index[0]);
			$('#current_index_field').val(index[0]);
			$('#current_id').val(data[0]);
			$('#move_to_popup').modal('show');
			
		}
		else
		{
			toastr.error('Please Select One File','Warning');
		}
	});
	$(document).on('click','#go_to',function(){
		var witness=$(this).attr('data-witness');
		var data={'witness':witness,_token:$("input[name='_token']").val()};
		$.post(baseurl+"/clients/files_goto",data,function(fb){
			 var resp=$.parseJSON(fb);
			 if(resp.status=='true')
			 {
				 window.location.href=resp.reload;
				 
			 }
			 else 
			 {
				toastr.error(resp.message,'Warning');
			 }
		 });
	});
	function goBack() {
	  window.location.href=baseurl+"/clients/examination_schedule_inner/"+segment4;
	}