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
        $('#hdn_fileid').val(id);
        $('#filename').val(name);

        $('#Edit_modal').modal();
    });

    $('#editsubmitfile').on('click', function (e) {
        var id = $('#hdn_fileid').val();
        var editfileDtata = $('#editfile_id').val();
        $.post(APP_LINK + 'rename_file_data', {file_id: id, editfileDtata: String(editfileDtata)}, function (data) {
            console.log(data);
            if (data.error) {
                swal("Oops!", data.msg, "error");
                return;
            } else {
                swal("Success!", "Your file/folder has been successfully renamed!", "success");
            }
        }, 'json');
    });

    $('.rename').on('click', function (e) {
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

    $('#new_folder').on('click', function (e) {
        var id = $('#parent_id').val();
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

                    $.post(APP_LINK + 'createNewFolder', {parent_id: id, folder_name: inputValue}, function (data) {
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
    $('#upload').on('click', function (e) {
        $('#upload_modal').modal();
    });

    /////upload

    var index = 0;


    $(document).on('change', '.btn-file :file', function () {
        for (var i = 0; i < this.files.length; i++)
            sendFile(this.files[i], index++);
    });


    function sendFile(file, index) {
        $('#alert-upload').hide();
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('parent_id', $('#parent_id').val());
        form_data.append('file_name', file.name);
        var job_id = $('#state_id').val();
        form_data.append('job_id', job_id);
        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td><span id="done' + index + '" class="fa fa-check" style="display:none;color:#27c24c"></span><span id="progress' + index + '">0%</span></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" id="msg' + index + '"></span></td></tr>');
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
