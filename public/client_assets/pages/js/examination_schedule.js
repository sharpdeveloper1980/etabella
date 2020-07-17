function getTags(){ 
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags-for-filter-exe/",
            success: function(data)
            {
              console.log(data);
              if(data != ''){
                a = $.confirm({
                      title: 'Filter by Tags',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Filter by Tags',
                    content: 'No tags added yet',
                    
                });
              }

            }
        });
    }
function getTaggedFiles(tagid,color){
      $.ajax({
           type: "GET",
           url: baseurl+"/clients/get_doc_by_tagid/"+tagid+"/"+"{{ $whchjobs }}",
           success: function(data)
           {
              resp=$.parseJSON(data);
			  if(resp.status=='true')
			  {
				//  console.log(resp.data.length.);
				var j=1;
				$('#accordion').html('');
				  $.each(resp.data, function( index, value ) {
				  /*console.log( index );
				  console.log(value.length);*/
				   var file_path=baseurl+"/public/images/file-pdf-icon_32.png";
                   var doc_path=baseurl+"/public/images/doc.png";
                   var img_path=baseurl+"/public/images/image.png";
                   var other_path=baseurl+"/public/images/play.png";
				  $('#accordion').append('<h3>'+index+'</h3><div><table id="example" class="table table-striped table-bordered" style="width:100%"><thead><tr><th>SNo.</th><th>File Name</th></tr></thead><tbody id="table_'+j+'"></tbody></div>');
				  console.log('value.length');
				  console.log(value);
				  for(i=0;i<value.length;i++)
				  {
					  count=i; 
					  var file_extension = value[i].file_name.split('.').reverse()[0];
					  count=i; 
					  var file_url=baseurl+"/public/storage/files/"+value[i].file_upload_name;
					  if(file_extension =='pdf' || file_extension =='PDF')
					  {
						  var pdf_url=baseurl+"/clients/examination_schedule_render/"+value[i].doc_id+'/'+value[i].witness_id;
						  $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="'+pdf_url+'"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+file_path+'"> '+value[i].file_name+'</div></a></td></tr>');
					  } 
					   else if(file_extension == 'xlsx' || file_extension == 'wpd' || file_extension == 'tex' || file_extension == 'xls' || file_extension == 'xlsx' || file_extension == 'docb' || file_extension == 'dotm' || file_extension == 'dotx' || file_extension == 'docm' || file_extension == 'csv' || file_extension == 'pptx' || file_extension == 'ppt' || file_extension == 'txt' || file_extension == 'doc' || file_extension == 'docx')
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'doc\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+doc_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
                  else if(file_extension == 'jpg' || file_extension == 'png' || file_extension == 'jpeg')
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'doc\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+img_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
                  else
                  {
                        $('#table_'+j).append('<tr><td>'+(count+1)+'</td><td><a href="javascript:;"  onclick="popupwindow(\''+file_url+'\',\'img\')"><div style="width:100%"><span style="background:'+color+';width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="'+other_path+'"> '+value[i].file_name+'</div></a></td></tr>');
                  }
				  }		  
				j++;
				});
				$( "#accordion" ).accordion('destroy').accordion();
			  }
			  else 
			  {
				 $('#accordion').html('<h3 align="center">Witness And Files Are Not found</h3>');
				 $( "#accordion" ).accordion('destroy').accordion();
			  }
			  a.close();
           }
        });
    }
 $( function() {
    active_a();
  });
  function active_a()
  {
	  $( "#accordion" ).accordion({ header: "h3", collapsible: true, active: false });
  }
  $(document).on('ready',function(){
	  
  });
 function refreshPage(whchjobs){
	 $("#con").hide();
	 $(".page-101").hide();
	 $(".loader").show();
	 setTimeout(function () {
		window.location.reload();
		$('.loader').hide();
		$(".hr_new3").show();
		$("#treeDemo").show();  
	 }, 1000);
  }
  $(document).on('keyup','.search_witness_and_file',function(){
	  var value=$(this).val();
	  $.post(baseurl+"/clients/search_witness_and_file",{'value':value,_token:$("input[name='_token']").val()},function(fb){
      		$('#accordion').html(fb);
            $( "#accordion" ).accordion('destroy').accordion();
           $( "#accordion" ).accordion({ header: "h3", collapsible: true, active: false });
      });
  });
   var a = '';
    function getTags1(active_file){ 
    $('.activefile').val(active_file);
      //var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              if(data != ''){
                a = $.confirm({
                      title: 'Tags  <a onclick="addTag('+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Tags',
                    content: '',
                    
                });
              }

            }
        });
    }
  function tagRow(tagid){
    a.close();
    var fileid = $(".activefile").val();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/change_tag/"+tagid+"/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
               location.reload();
              }
            }
        });
  }
 function addTag(fileid){
      a.close();
      
      $.confirm({
        title: 'Add Tag',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Title</label>'+
        '<input type="text" placeholder="Your title" class="name form-control" required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Color</label><br>'+
        '<input type="color" id="bgcolor" value="#ffffff" onchange="pickColor(this)" onkeyup="pickColor(this)" />'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid title');
                        return false;
                    }
                    var colr_tag = $(".hdn_color_picker").val();
                    
                    $.ajax({
                        type: "POST",
                        url: baseurl+"/clients/add_tag",
                        data: {_token: "{{ csrf_token() }}",title:name,fileid:fileid,color_tag:colr_tag},
                        success: function(data)
                        {
                          getTags();
                        }
                    });
                }
            },
            cancel: function () {
                
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
    }
function pickColor(t) {
    var pick_color = $("#bgcolor").val();
    $(".hdn_color_picker").val(pick_color);
  }

  function deleteTag(fileid){
    a.close();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/delete_tag/"+fileid,
            success: function(data)
            {
              getTags();
              getCheckedTag(fileid);
            }
        });
  }
 