function resetForm() {
    //$("#add_file").reset();
    document.getElementById("add_file").reset();
    window.location.reload();
}

$(document).ready(function () {

    $('.delete').on('click', function (e) {
        var id = $(this).attr('file-id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This will delete \"" + $('#name' + id).text() + "\"",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f05050",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function () {
                    $.getJSON(APP_LINK + 'delete_file/' + id, function (data) {
                        if (data.error) {
                            swal("Oops!", data.msg, "error");
                            return;
                        }
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $('#row' + id).fadeOut();
                    });
                });

    });
    $('.editfile').on('click', function (e) {

        var id = $(this).attr('file-id');
        var name = $('#name' + id).text();
        $.post(APP_LINK + 'getclientdata', {id: id}, function (data) {

            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            } else {
                $('#selecteddata').html(data);

            }
        });
        $('#hdn_fileid').val(id);
        $('#filename').val(name);
        $('#Edit_modal').modal();
    });

    $('#editsubmitfile').on('click', function (e) {
        var id = $('#hdn_fileid').val();
        var editfileDtata = $('#editfile_id').val(); 
        if (editfileDtata == null || editfileDtata == '') {
            swal("Oops!", "Please select Job");
            return;
        }
        $.post(APP_LINK + 'rename_file_data', {file_id: id, editfileDtata: String(editfileDtata)}, function (data) {
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            } else {
                swal("Success!", "Your file/folder has been successfully edited!", "success");
                $('#Edit_modal').modal('hide');
            }
        }, 'json');
    });

    $('.rename').on('click', function (e) {
        var id = $(this).attr('file-id');
        setTimeout(function () {
            ($('.sweet-alert h2').css('word-wrap', 'break-word'))
        }, 10);
        e.preventDefault();
        swal({
            title: "Rename \"" + $('#name' + id).text() + "\"",
            type: "input",
            inputType: "text",
            inputPlaceholder: "New File Name",
            showCancelButton: true,
            confirmButtonColor: "#7266ba",
            confirmButtonText: "Rename it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function (inputValue) {
                    if (inputValue === false)
                        return false;

                    if (inputValue === "") {
                        swal.showInputError("Please enter new name!");
                        return false
                    }

                    $.post(APP_LINK + 'rename_file', {file_id: id, new_name: inputValue}, function (data) {
                        if (data.error) {
                            swal("Oops!", data.msg, "error");
                            return;
                        } else {
                            $('#name' + id).text(inputValue);
                            swal("Success!", "Your file/folder has been successfully renamed!", "success");
                        }
                    }, 'json');
                });
    });

    $('.share').click(function () {
        var id = $(this).attr('file-id');
        $.getJSON(APP_LINK + 'toggleSharingOfFile/' + id, function (data) {
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            }
            if (data.status) {
                $('#share' + id).addClass('btn-success').removeClass('btn-default');
            } else {
                $('#share' + id).removeClass('btn-success').addClass('btn-default');
            }
        });
    });
    
     $('.added').click(function () {
        var id = $(this).attr('file-id');
        $.getJSON(APP_LINK + 'toggleAddingOfFile/' + id, function (data) {
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            }
            if (data.status) {
                $('#added' + id).addClass('btn-success').removeClass('btn-default');
            } else {
                $('#added' + id).removeClass('btn-success').addClass('btn-default');
            }
        });
    });

    $("#savefiletype").click(function(){
        var id = '';
       var selectfiletype = $("#selectfiletype").val();
       alert(selectfiletype);
        $.each($("input[name='checkfile']:checked"), function(){            
            id = $(this).val();
            $.getJSON(APP_LINK + 'toggleAddingOfFile/' + id, function (data) {
                if (data.error) {
                    swal("Oops!", data.msg, "error");
                    return;
                }
                if (data.status) {
                    $('#added' + id).addClass('btn-success').removeClass('btn-default');
                } else {
                    $('#added' + id).removeClass('btn-success').addClass('btn-default');
                }
            });
        });
        console.log(id);
  
       // alert("My favourite sports are: " + favorite.join(", "));
    });
  

// Start Folder with job upload
    $('#new_folder').on('click', function (e) {
        $('#new_folderlist').modal();
    });

    $('#addfolder').on('click', function (e) {
        var id = $('#parent_id').val();
        var inputValue = $('#foldername').val();
        var addjobid = $('#addjobid').val();
        $.post(APP_LINK + 'createNewFolder', {parent_id: id, job_id: String(addjobid), folder_name: inputValue}, function (data) {
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            } else {
                $('#name' + id).text(inputValue);
                swal({
                    title: "Success!",
                    text: "Your new folder has been successfully created!",
                    type: "success"
                }, function () {
                    window.location.reload();
                });
            }
        }, 'json');
    });

// End Folder with job upload

//    $('#new_folder').on('click', function (e) {
//        var id = $('#parent_id').val();
//        if (id == '') {
//            return;
//        }
//        e.preventDefault();
//        swal({
//            title: "Create a new folder",
//            type: "input",
//            inputType: "text",
//            inputPlaceholder: "New Folder Name",
//            showCancelButton: true,
//            confirmButtonColor: "#ff902b",
//            confirmButtonText: "Create Now",
//            closeOnConfirm: false,
//            showLoaderOnConfirm: true
//        },
//                function (inputValue) {
//                    if (inputValue === false)
//                        return false;
//
//                    if (inputValue === "") {
//                        swal.showInputError("Please enter your new folder name!");
//                        return false
//                    }
//
//                    $.post(APP_LINK + 'createNewFolder', {parent_id: id, folder_name: inputValue}, function (data) {
//                        if (data.error) {
//                            swal("Oops!", data.msg, "error");
//                            return;
//                        } else {
//                            $('#name' + id).text(inputValue);
//                            swal({
//                                title: "Success!",
//                                text: "Your new folder has been successfully created!",
//                                type: "success"
//                            }, function () {
//                                window.location.reload();
//                            });
//                        }
//                    }, 'json');
//                });
//    });
    $('#upload').on('click', function (e) {
        $('#upload_modal').modal();
    });

//    $('#upload_done_button').on('click', function (e) {
//      
//    });

    /////upload

    var index = 0;

    $(document).on('change', '.btn-file :file', function () {
        $('#uploads_table').html('');
        for (var i = 0; i < this.files.length; i++)
            sendFiledata(this.files[i], index++);

    });
    function sendFiledata(file, index) {
        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + index + '"></span></td></tr>');
    }
//    $(document).on('change', '.btn-file :file', function () {
//        for (var i = 0; i < this.files.length; i++)
//            sendFile(this.files[i], index++);
//    });

    /*$("#save_btn").click(function () {
     UploadImages();
     });*/

    var bar = $('.bar-custom');
    var percent = $('.percent-custom');
    $('#add_file').ajaxForm({
        beforeSend: function () {
            $('.progress-custom').css('display', 'block');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            //$('#add_file :input[type=submit]').attr('disabled', true);
            //$('#_parent_id').val(parseInt($('#parent_id').val()));
            //console.log($('#parent_id').val());
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
        url: APP_LINK + 'upload-file',
        success: function (res) {
            $('#uploads_table').html('');
            console.log(JSON.parse(res));

            if (JSON.parse(res) == "upload_error") {
                $('.progress-custom').css('display', 'none');
                swal({
                    title: "Oops!",
                    text: "Maximum upload size is 200MB.",
                    type: "error"
                });
                return false;
            }
            if (JSON.parse(res).length <= 0) {
                $('.progress-custom').css('display', 'none');
                swal({
                    title: "Oops!",
                    text: "Please select a file!",
                    type: "error"
                });
                return false;
            }

            var is_error = false;

            $.each(JSON.parse(res), function (key, value) {
                if (value.type == "success") {
                    var percentVal = '100%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + key + '" class="fa fa-check" style="color:#27c24c"></span><span class="progress1"></span></td><td style="padding-left:20px">' + value.name + '</td><td style="padding-left:20px;color:green"><span class="msg" style="word-break: break-all;" id="msg' + key + '">' + value.message + '</span></td></tr>');

                } else if (value.type == "error") {
                    is_error = true;
                    $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + key + '" class="fa fa-close" style="color:red"></span><span class="progress1"></span></td><td style="padding-left:20px">' + value.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + key + '">' + value.message + '</span></td></tr>');
                }
            });


            if (!is_error) {
                swal({
                    title: "Success!",
                    text: "Your file/folder has been successfully added!",
                    type: "success"
                }, function () {
                    window.location.reload();
                });
                $('#upload_modal').modal('hide');
            }
        },
    });

    /*var upload_status = false;
     $("#save_btn324234").click(function () {
     var fi = document.getElementById('file_field');
     $('#uploads_table').html('');
     console.log(fi.files);
     
     for (var i = 0; i < fi.files.length; i++) {
     sendFile(fi.files[i], index++);
     var file = fi.files[i];
     var _index = i;
     $('#alert-upload').hide();
     var form_data = new FormData();
     form_data.append('file', file);
     form_data.append('parent_id', $('#parent_id').val());
     form_data.append('file_name', file.name);
     var job_id = $('#state_id').val();
     form_data.append('job_id', job_id);
     $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + _index + '" class="fa fa-check" style="display:none;color:#27c24c"></span><span id="progress' + _index + '">0%</span></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + _index + '"></span></td></tr>');
     console.log(form_data);*/
    //            
//            $.ajax({
//                type: 'post',
//                url: APP_LINK + 'upload-file',
//                data: form_data,
//                contentType: false,
//                cache: false,
//                processData: false,
//                success: function (data) {
//                    $('#done' + _index).show();
//                    $('#active' + _index).removeClass('active');
//                    $('#progress' + _index).hide();
//                    $('#msg' + _index).html(data);
//                    
//                    if (data == "" || data == " ") {
//                            
//                    } else {
//                        console.log(data);
//                        console.log(_index+'_index');
//                        console.log('#msg' + _index);
//                        
//                        upload_status =  true;
//                    }
//                    
//                    if(index == last_key) {
//                        console.log('#msg' + _index);
//                        console.log(last_key+'--');
//                        console.log(upload_status);
//                        
//                        if (upload_status == false) {
//                            swal("Success!", "Your file/folder has been successfully added!", "success");
//                            $('#upload_modal').modal('hide');
//                        }
//                    } 
//                },
//                error: function () {
//                    swal("Oops!", 'There was an error uploading the file!', "error");
//                    return;
//                    //alert("There was an error uploading the file!");
//                },
//                xhr: function () {
//                    var xhr = new window.XMLHttpRequest();
//                    xhr.upload.addEventListener("progress", function (evt) {
//                        if (evt.lengthComputable) {
//                            var percentage = Math.floor((evt.loaded / evt.total) * 100);
//                            $('#progress' + _index).text(percentage + '%');
//                        }
//                    }, false);
//
//                    xhr.addEventListener("progress", function (evt) {
//                        if (evt.lengthComputable) {
//                            var percentage = Math.floor((evt.loaded / evt.total) * 100);
//                            $('#progress' + _index).text(percentage + '%');
//                        }
//                    }, false);
//                    return xhr;
//                },
//            });
    // }

    //if (!upload_status) {
    //  swal("Success!", "Your file/folder has been successfully added!", "success");
    //  $('#upload_modal').modal('hide');
    //}
    //window.location.reload();
    /*});*/

    function sendFile(file, index) {
        $('#alert-upload').hide();
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('parent_id', $('#parent_id').val());
        form_data.append('file_name', file.name);
        var job_id = $('#state_id').val();
        form_data.append('job_id', job_id);
        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + index + '" class="fa fa-check" style="display:none;color:#27c24c"></span><span id="progress' + index + '">0%</span></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + index + '"></span></td></tr>');
        $.ajax({
            type: 'post',
            url: APP_LINK + 'upload-file',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#done' + index).show();
                $('#active' + index).removeClass('active');
                $('#progress' + index).hide();
                $('#msg' + index).html(data);
                if (data == "" || data == " ") {
                    swal("Success!", "Your file/folder has been successfully added!", "success");
                    $('#upload_modal').modal('hide');
                } else {
                    upload_status = true;
                }
            },
            error: function () {
                swal("Oops!", 'There was an error uploading the file!', "error");
                return;
                //alert("There was an error uploading the file!");
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentage = Math.floor((evt.loaded / evt.total) * 100);
                        $('#progress' + index).text(percentage + '%');
                    }
                }, false);

                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentage = Math.floor((evt.loaded / evt.total) * 100);
                        $('#progress' + index).text(percentage + '%');
                    }
                }, false);
                return xhr;
            },
        });
    }


    //end of upload

    $('.downloaded').click(function () {
        var id = $(this).attr('client-id');
        $('#downloaded_files_user').text($('#user' + id).text());
        $('#downloaded_files_modal').modal();
        $('#downloaded_files_div').load(APP_LINK + 'filesDownloaded/' + id);
    });

    function updateActiveUsers() {
        $.getJSON(APP_LINK + 'getNumberOfActiveUsers', function (data) {
            var total = parseInt(data.total);
            if (total > 0) {
                $('#online_users').text(total).removeClass('hide');
            } else {
                if (!$('#online_users').hasClass('hide')) {
                    $('#online_users').addClass('hide');
                }
            }
            setTimeout(function () {
                updateActiveUsers()
            }, 2000);
        });
    }

    setTimeout(function () {
        updateActiveUsers()
    }, 2000);


    // Start for job

    $('.jobdelete').on('click', function (e) {
        var id = $(this).attr('file-id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This will delete \"" + $('#name' + id).text() + "\"",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f05050",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function () {
                    $.getJSON(APP_LINK + 'delete_jobfile/' + id, function (data) {
                        if (data.error) {
                            swal("Oops!", data.msg, "error");
                            return;
                        }
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $('#row' + id).fadeOut();
                    });
                });

    });


    $('#job_folder').on('click', function (e) {
        var id = $('#parent_id').val();
        var job_id = $('#job_id').val();
        if (id == '') {
            return;
        }
        e.preventDefault();
        swal({
            title: "Create a new folder",
            type: "input",
            inputType: "text",
            inputPlaceholder: "New Folder Name",
            showCancelButton: true,
            confirmButtonColor: "#ff902b",
            confirmButtonText: "Create Now",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function (inputValue) {
                    if (inputValue === false)
                        return false;

                    if (inputValue === "") {
                        swal.showInputError("Please enter your new folder name!");
                        return false
                    }
                    $.post(APP_LINK + 'createJobFolder', {parent_id: id, job_id: job_id, folder_name: inputValue}, function (data) {

                        if (data.error) {
                            swal("Oops!", data.msg, "error");
                            return;
                        } else {

                            $('#name' + id).text(inputValue);
                            swal({
                                title: "Success!",
                                text: "Your new folder has been successfully created!",
                                type: "success"
                            }, function () {
                                window.location.reload();
                            });
                        }
                    }, 'json');
                });
    });

    $(document).on('change', '.btn-jobfile :file', function () {
        for (var i = 0; i < this.files.length; i++)
            sendjobFile(this.files[i], index++);
    });


    function sendjobFile(file, index) {
        $('#alert-upload').hide();
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('parent_id', $('#parent_id').val());
        form_data.append('job_id', $('#job_id').val());
        form_data.append('file_name', file.name);

        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + index + '" class="fa fa-check" style="display:none;color:#27c24c"></span><span id="progress' + index + '">0%</span></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" id="msg' + index + '"></span></td></tr>');
        $.ajax({
            type: 'post',
            url: APP_LINK + 'upload-jobfile',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#done' + index).show();
                $('#active' + index).removeClass('active');
                $('#progress' + index).hide();
                $('#msg' + index).html(data);
            },
            error: function () {
                alert("There was an error uploading the file!");
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentage = Math.floor((evt.loaded / evt.total) * 100);
                        $('#progress' + index).text(percentage + '%');
                    }
                }, false);

                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentage = Math.floor((evt.loaded / evt.total) * 100);
                        $('#progress' + index).text(percentage + '%');
                    }
                }, false);
                return xhr;
            },
        });
    }

    $('.jobrename').on('click', function (e) {
        var id = $(this).attr('file-id');
        e.preventDefault();
        swal({
            title: "Rename \"" + $('#name' + id).text() + "\"",
            type: "input",
            inputType: "text",
            inputPlaceholder: "New File Name",
            showCancelButton: true,
            confirmButtonColor: "#7266ba",
            confirmButtonText: "Rename it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
                function (inputValue) {
                    if (inputValue === false)
                        return false;

                    if (inputValue === "") {
                        swal.showInputError("Please enter new name!");
                        return false
                    }

                    $.post(APP_LINK + 'rename_jobfile', {file_id: id, new_name: inputValue}, function (data) {
                        if (data.error) {
                            swal("Oops!", data.msg, "error");
                            return;
                        } else {
                            $('#name' + id).text(inputValue);
                            swal("Success!", "Your file/folder has been successfully renamed!", "success");
                        }
                    }, 'json');
                });
    });
    $('.sharejob').click(function () {
        var id = $(this).attr('file-id');
        var job_id = $('#job_id').val();

        $.getJSON(APP_LINK + 'toggleSharingOfjobFile/' + id + '/' + job_id, function (data) {
            console.log(data);
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            }
            if (data.status) {
                $('#share' + id).addClass('btn-success').removeClass('btn-default');
            } else {
                $('#share' + id).removeClass('btn-success').addClass('btn-default');
            }
        });
    });

});
