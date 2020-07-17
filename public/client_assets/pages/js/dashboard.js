function nodefile(id){
	var id=$('#check_node_'+id).parent('li').children('span').attr('id');
	$('#'+id).trigger('click');
}
 $(document).on('click','.sort_dd_outer',function(){
		$('.sort_dd_inner').css({'display':'block'});
	});
	$('body').on('click',function(){
		$('.sort_dd_inner').css({'display':'none'});
	});
	
	$(document).on('click','#select_job_btn',function(){
    		localStorage.setItem("job_popup", 1);
    		var val=$('#select_job_dash').val();
    		window.location.href=baseurl+'/clients/dashboard/'+val;
    });
   if(!localStorage.getItem("job_popup") || localStorage.getItem("job_popup")==0)
   {
	   
     $('#page_overlay').addClass('page_overlay');
  	 $('#select_job').show();
   }
   $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
    $('body').css("opacity","0.1");
   
  setTimeout(function(){
    $('body').css("background-color","#fff !important");
    $('body').css("opacity","1");
  },2000)

   $('[data-toggle="tooltip"]').tooltip(); 

    // var zNodes = '';
    var setting = {
                    edit: {
                      enable: true,
                      showRemoveBtn: false,
                      showRenameBtn: false,
                    },
                    data: {
                      keep: {
                        parent: true,
                        leaf: true
                      },
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
                        txtSelectedEnable: false,
                      },
                    check: {
                      enable: false
                    },
                    callback: {
                        onDragMove: myOnDragMove
                        // onExpand: expandNode
                        // onCheck: zTreeOnCheck
                    },
                  };


      setTimeout(function(){
        expandNode();
      },500);

      function myOnDragMove(event, treeId, treeNodes) {
        console.log(event.target);
      }

      function expandNode() {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
          zTree.expandAll(true);
          zTree.expandAll(false);
      }
      // function zTreeOnCheck(event, treeId, treeNode) {
        // var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
      //   var nodes = treeObj.getCheckedNodes(true);
      //   console.log(nodes); //Here are all of the selected nodes
      // };

      function refreshPage(whchjobs){
         $("#treeDemo").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            window.location.reload();
            $('.loader').hide();
            $(".hr_new3").show();
            $("#treeDemo").show();  
         }, 1000);
      }

/**
Open File Modal
**/
   function opnFileMdl(){
      $("#file_modal").modal('show');
   }
/**End**/

/**
Close File Modal
**/
   function clsFileMdl(){
      $("#file_modal").modal('hide');
   }
/**End**/

/**
Select All Function
**/
var array_checked = []; 
function checkfile(type)
  {
    console.log(type);

  array_checked = []; 
    
    if(type == 'all'){

      if($(".checkbox_selectall_chck").is(":checked")){
        
        $(".filecheck").prop('checked', true);
        
        // $('#download_btn').prop("disabled", false);
        // $('#exportzip_btn').prop("disabled", false);
        // $('#print_btn').prop("disabled", false);
      }else{
        
        $(".filecheck").prop('checked', false);
        
        // $('#download_btn').prop("disabled", true);
        // $('#exportzip_btn').prop("disabled", true);
        // $('#print_btn').prop("disabled", true);
      }

    }else{
      
      if($(type).is(":checked")){
        $(type).prop('checked', true);
      }else{
        $(type).prop('checked', false);
      }
    
    }

    $("input:checkbox[name=file_id]:checked").each(function() { 
      if(jQuery.inArray($(this).val(), array_checked) !== -1){
      }else{
        array_checked.push($(this).val()); 
      }

    }); 
    if(array_checked.length > 0){
      // $('#download_btn').prop("disabled", false); // Element(s) are now enabled.
      // $('#exportzip_btn').prop("disabled", false);
      // $('#print_btn').prop("disabled", false);
    }else{
      // $('#download_btn').prop("disabled", true);
      // $('#exportzip_btn').prop("disabled", true);
      // $('#print_btn').prop("disabled", true);
    }
  }
  
    function folderCheck(id) {
    // console.log(id);
    var main = document.querySelector(".main-checkbox-"+id);
    var children = document.querySelectorAll(".sub-checkbox-"+id);
    
    children.forEach(child => {
      	console.log(child.value);
      if(child.dataset.file_type == 1){
        folderCheck(child.value);
      }
      child.checked = child.checked == true ? false : true
      
      if (child.checked == true && child.dataset.file_type == 2) {
        array_checked.push(child.value);
      }else{
        if ($.inArray(child.value, array_checked) !== -1) {
          array_checked.splice($.inArray(child.value, array_checked),1);
        }
      }
    })

    if(array_checked.length > 0){
      // $('#download_btn').prop("disabled", false); // Element(s) are now enabled.
      // $('#exportzip_btn').prop("disabled", false);
    }else{
      // $('#download_btn').prop("disabled", true);
      // $('#exportzip_btn').prop("disabled", true);
    }
    console.log(array_checked)
    return array_checked;
  }

  $("#download_btn").click(function(){
    var whchjobs = $(this).val();
    if(array_checked.length > 0){
		/**Loader Show**/
		$("#treeDemo").hide();
		$(".hr_new3").hide();
		$(".loader").show();
	  $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/downloading",
          data: {_token: $("input[name='_token']").val(),arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
              /**jQuery.grep(array_checked, function(value) {
                $("#check-"+value).removeAttr('name');
                $("#check-"+value).prop("disabled", true);
              }); **/

              array_checked = [];
			       $(".filecheck").prop('checked', false);
			 /**Loader Hide**/
				$("#treeDemo").show();
				$(".hr_new3").show();
				$(".loader").hide();
			  toastr.success(data.message, data.title);
            }
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  });

  $("#exportzip_btn").click(function(){
    var whchjobs = $(this).val();
    if(array_checked.length > 0){

      /**Loader Show**/
      $("#treeDemo").hide();
      $(".hr_new3").hide();
      $(".loader").show();
      
      $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/exportzip",
          data: {_token: $("input[name='_token']").val(),arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
              toastr.success(data.message, data.title);
            }else{
              toastr.error(data.message, data.title);
            }
              array_checked = [];
              $(".filecheck").prop('checked', false);
              /**Loader Hide**/
              $("#treeDemo").show();
              $(".hr_new3").show();
              $(".loader").hide();
              $('#download_zip').get(0).click();
			  delete_export_file();
              
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  });

/**Print Button functionality**/
  function printFiles(){
    if(array_checked.length > 0){
      $("#treeDemo").hide();
      $(".hr_new3").hide();
      $(".loader").show();
      $("body").css("cursor", "progress");
      $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/printing",
          data: {_token:$("input[name='_token']").val(),arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            if(data){
              PrintMerge();              
              jQuery.grep(array_checked, function(value) {
                $("#check-"+value).removeAttr('name');
                $("#check-"+value).prop("disabled", true);
              }); 

              array_checked = [];
              $(".filecheck").prop('checked', false);
              toastr.success(data.message, data.title);
            }
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  }


/**
End
**/

/**
 Sorting Start 
**/
   function sorting(segment,parentid=0,job,orderName,type){

    if(segment == 'dashboard'){
      parentid = 0;
    }
    
    var spanClass = $('.'+orderName).find('i').attr('class');
    
    $.ajax({
          type: "GET",
          url: baseurl+"/clients/sorting/"+job+"/"+orderName,
          success: function(data)
          {
            if(data){
                if(spanClass == 'fa fa-chevron-down'){
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-chevron-up');
                }else{
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-chevron-down');
                }
                zNodes = JSON.parse(data);
                load(setting,zNodes);
                setTimeout(function(){
                    expandNode();
                },500);
            }
          }
      });
   }
/**
Sorting End
**/

/**
Search Files 
**/
  function toggleSearchBox(){
    $("#search_files").toggle('fast');
    $("#name_date").toggle('fast');
  }

  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      swal({
            title: "Click options where you want to apply search ?",
            buttons: {
              close: "Search files",
              catch: {
                text: "Search inside document",
                value: "catch",
              },
            },
          })
          .then((value) => {
            var keywords = $(this).val();
            var job = $('.selected_job').val();
            if(keywords){
              switch (value) {
                case "catch":
				 $('.loader').css({'display':'block'});
				 $('body').css({'pointer-events':'none'});
				 
                  $.ajax({
                      type: "GET",
                      url: baseurl+"/clients/search_inside/"+keywords+"/"+job,
                      success: function(data)
                      {
						$('.loader').css({'display':'none'});
						$('body').css({'pointer-events':'all'});
                        if(data){
                          console.log(data);
                            $("#treeDemo").hide();
                            $(".hr_new3").hide();
                            $("#for-search-con").html(data);
                            $("#for-search-con").show();
                        }else{
                          swal(
                              'Searching..',
                              'No result found for this keywords',
                              'error'
                            );
                        }
                      }
                  });
                  break;
                
                case "close":
                  $.ajax({
                      type: "GET",
                      url: baseurl+"/clients/search/"+keywords+"/"+job,
                      success: function(data)
                      {
                        if(data != ''){
                          console.log(zNodes);
                            zNodes = JSON.parse(data);
                            load(setting,zNodes);
                             setTimeout(function(){
                                  expandNode();
                              },500);
                        }else{
                          swal(
                              'Searching..',
                              'No result found for this keywords',
                              'error'
                            );
                        }
                      }
                  });
                  break;

                default:   
              }
            }else{
              window.location.reload();
            }
          });
    }
  });
/**stop**/


$( document ).ready(function() {
  load(setting,zNodes);
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);
}

// function renameFile(id){
//   var fileid = $(this).data('file_id');
//   alert(id);
// }

/** File Uploading **/
var index = 0;

    $(document).on('change', '.btn-warning :file', function () {
        $('#uploads_table').html('');

        for (var i = 0; i < this.files.length; i++)
            sendFiledata(this.files[i], index++);
    });
    function sendFiledata(file, index) {
        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + index + '"></span></td></tr>');
    }

    var bar = $('.bar-custom');
    var percent = $('.percent-custom');
    $('#add_file').ajaxForm({
        beforeSend: function () {
            $('.progress-custom').css('display', 'block');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            document.getElementById("file_field").disabled = true;
            document.getElementById("save_btn").disabled = true;
            var percentVal = percentComplete + '%';
            console.log(percentVal);
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function () {
            document.getElementById("file_field").disabled = false;
            document.getElementById("save_btn").disabled = false;
            //$('#add_file :input[type=submit]').attr('disabled', false);
        },
        clearForm: true, // clear all form fields after successful submit 
        resetForm: true,
        url: baseurl+"/clients/files/upload_files",
        success: function (res) {
            $('#uploads_table').html('');
                $('#file_modal').modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
        },
    });

    // function printFiles(){
//   printJS({
//     printable: ['http://66.206.3.18/etabella/public/images/file-pdf-icon_64.png', 'http://66.206.3.18/etabella/public/images/Folder-blue-icon_64.png', 'http://66.206.3.18/etabella/public/images/folder2.png'],
//     type: 'image',
//     header: 'Multiple Images',
//     imageStyle: 'width:50%;margin-bottom:20px;'
//    });
// }

function PrintMerge(){
  printJS({
    printable: ['http://web.etabella.com/etabellaweb/public/storage/mergeall/merge.pdf'],
    onLoadingEnd: function(){
        $('.loader').hide();
        $(".hr_new3").show();
        $("#treeDemo").show();  
        $("body").css("cursor", "default");
    }
   });
}

/** 
Start ajax method for get rename filename 
**/
  function renameFile(id){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/get_file/"+id,
           data: {"id":id}, 
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              swal({
                    title: "Rename "+'"'+data.file_name+'"'+"!",
                    text: "You can change your filename here",
                    content: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Enter new Filename"
                  })
                  .then((inputValue) => { 
                    if (inputValue === false) return false;
                    if ($.trim(inputValue) === "") {
                      swal("Warning!", "You need to write something!", "warning");
                      return false
                    }else{
                      updateRenameFile(inputValue,id);
                    }

                  });
           }
         });
  }
/** 
End
**/

/**
Method for change filename
**/
   function updateRenameFile(inputValue,id){
      $.ajax({
           type: "POST",
           url: baseurl+"/clients/rename/"+id,
           data: {file_name:inputValue,_token: $("input[name='_token']").val()}, 
           success: function(data)
           {
            if(data){
					window.location.reload();
              /**$("#file"+id).text(inputValue);**/
              /**swal("Nice!", "You wrote: " + inputValue, "success");**/
            }
           }
        });
   }
/**End**/

/** Get Tags **/
var a = '';
    function getTags(){ 
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags-for-filter/",
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

    function getTaggedFiles(tagid){
      $.ajax({
           type: "GET",
           url: baseurl+"/clients/get-by-tagid/"+tagid+"/"+whchjobs,
           success: function(data)
           {
              if(data != ''){
                console.log(zNodes);
                zNodes = JSON.parse(data);
                load(setting,zNodes);
              }else{
                  swal(
                        'Searching..',
                        'No result found for this keywords',
                        'error'
                      );            
              }
              a.close();
           }
        });
    }

    var arr_ids = [];
    function moveFile(fileId){
      if ($.inArray(fileId, arr_ids) !== -1) {
          arr_ids.splice($.inArray(fileId, arr_ids),1);
          $(".facheck-"+fileId).hide();
        }else{
        arr_ids.push(fileId); 
        $(".facheck-"+fileId).show();
      }
      console.log(arr_ids);
    }
  
  	

/** End **/