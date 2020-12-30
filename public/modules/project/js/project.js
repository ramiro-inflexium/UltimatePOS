//project related code
// project - add form model
$(document).on('click', 'button.add_new_project', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('#project_model').html(result).modal("show");
        }
    });
});

// project - edit form model
$(document).on('click', '#edit_a_project', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('#project_model').html(result).modal("show");
        }
    });
});

//initialize ck editor, date picker and form validation when model is opened
$('#project_model').on('shown.bs.modal', function (e) {

    $('form#project_form .datepicker').datepicker({
        autoclose: true,
        format:datepicker_date_format
    });
    
    CKEDITOR.replace('description');

    $(".select2").select2();
    //form validation
        $("form#project_form").validate();
});

//project form submit
$(document).on('submit', 'form#project_form', function(e){
    e.preventDefault();
    var url = $('form#project_form').attr('action');
    var method = $('form#project_form').attr('method');
    var data = $('form#project_form').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('#project_model').modal("hide");
                location.reload();
                toastr.success(result.msg);
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

//project delete
$(document).on('click', '#delete_a_project', function(e) {
    e.preventDefault();
    var url = $(this).data('href');
    swal({
      title: LANG.sure,
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $.ajax({
                method:'DELETE',
                dataType: 'json',
                url: url,
                success: function(result){
                    if (result.success) {
                        toastr.success(result.msg);
                        location.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        }
    });
});


// project task related code
// project task - add form model
$(document).on('click', '.task_btn', function(){
    var url = $(this).data('href');
    $.ajax({
        methods: "GET",
        dataType: 'html',
        url: url,
        success: function(result) {
            $('.project_task_model').html(result).modal("show");
        }
    });
});

// project task - edit form model
$(document).on('click', '#edit_a_project_task', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('.project_task_model').html(result).modal("show");
        }
    });
});

//initialize ck editor, date picker and form validation when model is opened
$('.project_task_model').on('shown.bs.modal', function (e) {

    $('form#project_task_form .datepicker').datepicker({
        autoclose: true,
        format:datepicker_date_format
    });
    
    CKEDITOR.replace('description');

    $(".select2").select2();
    //form validation
        $("form#project_task_form").validate();
});

//project task form submit
$(document).on('submit', 'form#project_task_form', function(e){
    e.preventDefault();
    var url = $('form#project_task_form').attr('action');
    var method = $('form#project_task_form').attr('method');
    var data = $('form#project_task_form').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('.project_task_model').modal("hide");
                toastr.success(result.msg);

                if (typeof(project_task_datatable) != 'undefined') {
                    project_task_datatable.ajax.reload();
                }

                if (typeof(my_task_datatable) != 'undefined') {
                    my_task_datatable.ajax.reload();
                }
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

//data table related codes
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr('href');
    if ( target == '#project_task') {
        if(typeof project_task_datatable == 'undefined') {
            project_task_datatable = $('#project_task_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax:{
                        url: '/project/project-task',
                        data: function(d) {
                            d.project_id = $('#project_id').val();
                            d.user_id = $('#assigned_to_filter').val();
                            d.status = $('#status_filter').val();
                            d.due_date = $('#due_date_filter').val();
                            d.priority = $('#priority_filter').val();
                        }
                    },
                    columnDefs: [
                        {
                            targets: [1, 6, 7],
                            orderable: false,
                            searchable: false,
                        },
                    ],
                    aaSorting: [[5, 'asc']],
                    columns: [
                        { data: 'subject', name: 'subject' },
                        { data: 'members'},
                        { data: 'priority', name: 'priority' },
                        { data: 'start_date', name: 'start_date' },
                        { data: 'due_date', name: 'due_date' },
                        { data: 'status', name: 'status' },
                        { data: 'createdBy'},
                        { data: 'action', name: 'action' },
                    ]
            });
        } else {
            project_task_datatable.ajax.reload();
        }
    } else if(target == '#time_log') {
        if(typeof time_logs_data_table == 'undefined') {
            time_logs_data_table = $('#time_logs_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: '/project/project-task-time-logs',
                    data: function(d) {
                        d.project_id = $('#project_id').val();
                    }
                },
                columnDefs: [
                    {
                        targets: [0, 3, 4, 6],
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [
                    { data: 'task'},
                    { data: 'start_datetime', name: 'start_datetime' },
                    { data: 'end_datetime', name: 'end_datetime' },
                    { data: 'work_hour'},
                    { data: 'user'},
                    { data: 'note', name: 'note'},
                    { data: 'action', name: 'action' },
                ]
            });
        }else {
            time_logs_data_table.ajax.reload();
        }
    } else if(target == '#documents_and_notes') {
        if(typeof documents_and_notes_data_table == 'undefined') {
            documents_and_notes_data_table = $('#documents_and_notes_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: '/project/project-docs-notes',
                    data: function(d) {
                        d.project_id = $('#project_id').val();
                    }
                },
                columnDefs: [
                    {
                        targets: [1, 4],
                        orderable: false,
                        searchable: false,
                    },
                ],
                aaSorting: [[2, 'asc']],
                columns: [
                    { data: 'heading', name: 'heading' },
                    { data: 'createdBy'},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' },
                ]
            });
        }else {
            documents_and_notes_data_table.ajax.reload();
        }
    } else if (target == '#activities') {
        var data = {'project_id' : $('#project_id').val()};
        $.ajax({
            method:'GET',
            dataType: 'json',
            url: '/project/activities',
            data: data,
            success: function(result){
                if (result.success) {
                    $(".timeline").html(result.activities);
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    } else if(target == '#project_overview') {
        location.reload();
    }
});

//project task delete
$(document).on('click', '#delete_a_project_task', function(e) {
    e.preventDefault();
    var url = $(this).data('href');
    swal({
        title: LANG.sure,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $.ajax({
                method:'DELETE',
                dataType: 'json',
                url: url,
                success: function(result){
                    if (result.success) {
                        toastr.success(result.msg);

                        if (typeof(project_task_datatable) != 'undefined') {
                            project_task_datatable.ajax.reload();
                        }
                        
                        if (typeof(my_task_datatable) != 'undefined') {
                            my_task_datatable.ajax.reload();
                        }

                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        }
    });
});

// update project task status
$(document).on('click', '.change_status_of_project_task', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('.view_modal').html(result).modal("show");
        }
    });
});

//update task status form submission
$(document).on('submit', 'form#change_status', function(e){
    e.preventDefault();
    var url = $('form#change_status').attr('action');
    var method = $('form#change_status').attr('method');
    var data = $('form#change_status').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('.view_modal').modal("hide");
                toastr.success(result.msg);

                if (typeof(project_task_datatable) != 'undefined') {
                    project_task_datatable.ajax.reload();
                }

                if (typeof(my_task_datatable) != 'undefined') {
                    my_task_datatable.ajax.reload();
                }
                 
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

// view a task
$(document).on('click', '.view_a_project_task', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('.view_project_task_model').html(result).modal("show");
        }
    });
});

// codes for  editing project task description
$('.view_project_task_model').on('shown.bs.modal', function (e) {
    $('form#update_task_description').hide();
    $('.toggleMedia').hide();
    $("form#add_comment_form").validate();
});

//toggle description edit btn
$(document).on('click', '.edit_task_description', function() {
    $('.toggle_description_fields').hide();
    $('form#update_task_description').show();
    CKEDITOR.replace('edit_description_of_task');
});

$(document).on('click', '.close_update_task_description_form', function() {
    toggleTaskForm();
});

//project task description form submit
$(document).on('submit', 'form#update_task_description', function(e){
    e.preventDefault();
    var url = $('form#update_task_description').attr('action');
    var method = $('form#update_task_description').attr('method');
    var data = $('form#update_task_description').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $("div.form_n_description").html(result.task_description_html);
                toastr.success(result.msg);
                toggleTaskForm();
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

//toggling task description form
function toggleTaskForm() {
    $('.toggle_description_fields').show();
    $('form#update_task_description').hide();
}

//dropzone related code
var dropzoneInstance = {};
$(document).on('click', '.upload_doc', function() {
    $('.upload_doc').hide();
    $('.toggleMedia').show();
    initialize_dropzone();
});

//toggle dropzone
$(document).on('click', '.hide_upload_btn', function() {
    $('.toggleMedia').hide();
    $('.upload_doc').show();
});

//on close model destroy dropzone
$('.view_project_task_model').on('hide.bs.modal', function(){
    if (dropzoneInstance.length > 0) {
        Dropzone.forElement("div#fileupload").destroy();
        dropzoneInstance = {};
    }
});

//initialize dropzone
function initialize_dropzone() {
    var file_names = [];

    if (dropzoneInstance.length > 0) {
        Dropzone.forElement("div#fileupload").destroy();
    }

    dropzoneInstance = $("div#fileupload").dropzone({
            url: '/project/post-media-dropzone-upload',
            paramName: 'file',
            uploadMultiple: true,
            autoProcessQueue: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                if (response.success) {
                    toastr.success(response.msg);
                    file_names.push(response.file_name);
                    $('input#comment_media').val(file_names);
                } else {
                    toastr.error(response.msg);
                }
            },
        });
}

//project task comment form submit
$(document).on('submit', 'form#add_comment_form', function(e){
    e.preventDefault();
    var url = $('form#add_comment_form').attr('action');
    var method = $('form#add_comment_form').attr('method');
    var data = $('form#add_comment_form').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('input#comment_media').val('');
                initialize_dropzone();
                $('form#add_comment_form')[0].reset();
                $('.direct-chat-messages').prepend(result.comment_html);
                toastr.success(result.msg);
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

// project task time logs related code
$(document).on('click', '.time_log_btn', function() {
    var url = $(this).data('href');
    $.ajax({
        method: 'GET',
        dataType: 'html',
        url: url,
        success: function(result) {
            $('#time_log_model').html(result).modal('show');
        }
    });
});

//initialize datetime picker for timelog form on model open
$('#time_log_model').on('shown.bs.modal', function(e) {
    $('form#time_log_form .datetimepicker').datetimepicker({
        ignoreReadonly: true,
        format: moment_date_format + ' ' + moment_time_format
    });
    $(".select2").select2();
    $('form#time_log_form').validate();
});

//project task time log form submit
$(document).on('submit', 'form#time_log_form', function(e){
    e.preventDefault();
    var url = $('form#time_log_form').attr('action');
    var method = $('form#time_log_form').attr('method');
    var data = $('form#time_log_form').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('#time_log_model').modal('hide');
                toastr.success(result.msg);
                time_logs_data_table.ajax.reload();
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

// delete a time log
$(document).on('click', '#delete_a_time_log', function(e) {
    e.preventDefault();
    var url = $(this).data('href');
    swal({
        title: LANG.sure,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $.ajax({
                method:'DELETE',
                dataType: 'json',
                url: url,
                success: function(result){
                    if (result.success) {
                        toastr.success(result.msg);
                        time_logs_data_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        }
    });
});

// project document and notes related code
$(document).on('click', '.docs_and_notes_btn', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('#docus_notes_model').html(result).modal("show");
        }
    });
});

// initialize ck editor & dropzone on docs & notes model open
var dropzoneForDocsAndNotes = {};
$('#docus_notes_model').on('shown.bs.modal', function(e) {
    CKEDITOR.replace('docs_note_description');
    $('form#docus_notes_form').validate();
    initialize_dropzone_for_docus_n_notes();
});
// fun initializing dropzone for docs & notes
function initialize_dropzone_for_docus_n_notes() {
    var file_names = [];

    if (dropzoneForDocsAndNotes.length > 0) {
        Dropzone.forElement("div#docusUpload").destroy();
    }

    dropzoneForDocsAndNotes = $("div#docusUpload").dropzone({
        url: '/project/post-media-dropzone-upload',
        paramName: 'file',
        uploadMultiple: true,
        autoProcessQueue: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response) {
            if (response.success) {
                toastr.success(response.msg);
                file_names.push(response.file_name);
                $('input#docus_notes_media').val(file_names);
            } else {
                toastr.error(response.msg);
            }
        },
    });
}

//form submittion of docs & notes form
$(document).on('submit', 'form#docus_notes_form', function(e){
    e.preventDefault();
    var url = $('form#docus_notes_form').attr('action');
    var method = $('form#docus_notes_form').attr('method');
    var data = $('form#docus_notes_form').serialize();
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
            if (result.success) {
                $('#docus_notes_model').modal('hide');
                toastr.success(result.msg);
                documents_and_notes_data_table.ajax.reload();
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

// on close of docs & notes form destroy dropzone
$('#docus_notes_model').on('hide.bs.modal', function(){
    if (dropzoneForDocsAndNotes.length > 0) {
        Dropzone.forElement("div#docusUpload").destroy();
        dropzoneForDocsAndNotes = {};
    }
});

// delete a docs & note
$(document).on('click', '#delete_project_note', function(e) {
    e.preventDefault();
    var url = $(this).data('href');
    swal({
        title: LANG.sure,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirmed) => {
        if (confirmed) {
            $.ajax({
                method:'DELETE',
                dataType: 'json',
                url: url,
                success: function(result){
                    if (result.success) {
                        toastr.success(result.msg);
                        documents_and_notes_data_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        }
    });
});

// view docs & note
$(document).on('click', '.view_a_project_note', function() {
    var url  = $(this).data('href');
    $.ajax({
        method: "GET",
        dataType: "html",
        url: url,
        success: function(result){
            $('.view_modal').html(result).modal("show");
        }
    });
});

// project task filter related code
$(document).on('change', "#assigned_to_filter, #status_filter, #due_date_filter, #priority_filter", function(){
    project_task_datatable.ajax.reload();
});

// project activities related code
$(document).on('click', '.load_more_activities', function() {
    var url = $(this).data('href');
    var data = {'project_id' : $('#project_id').val()};
    $.ajax({
        method:'GET',
        dataType: 'json',
        url: url,
        data: data,
        success: function(result){
            if (result.success) {
                $('.load_more_activities').hide();
                $(".timeline").append(result.activities);
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

// my task data table related code
my_task_datatable = $("#my_task_table").DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: '/project/project-task',
                    data: function(d) {
                        d.project_id = $('#project_id_my_task_filter').val();
                        d.user_id = $('#assigned_to_my_task_filter').val();
                        d.status = $('#status_my_task_filter').val();
                        d.due_date = $('#due_date_my_task_filter').val();
                        d.priority = $('#priority_my_task_filter').val();
                    }
                },
                columnDefs: [
                    {
                        targets: [0, 2, 7, 8],
                        orderable: false,
                        searchable: false,
                    },
                ],
                aaSorting: [[5, 'asc']],
                columns: [
                    {data: 'project'},
                    { data: 'subject', name: 'subject' },
                    { data: 'members'},
                    { data: 'priority', name: 'priority' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'status', name: 'status' },
                    { data: 'createdBy'},
                    { data: 'action', name: 'action' },
                ]
            });

//reload my task data table on change of filter
$(document).on('change', "#project_id_my_task_filter, #assigned_to_my_task_filter, #status_my_task_filter, #due_date_my_task_filter, #priority_my_task_filter", function(){
    my_task_datatable.ajax.reload();
});

// project index page code
getProjectList();

// on change project filter get project
$(document).on('change', "#project_status_filter, #project_end_date_filter", function(){
    $(".project_html").html('');
    getProjectList();
});

function getProjectList(url = '') {

    var data = {
            'status' : $('#project_status_filter').val(),
            'end_date' : $('#project_end_date_filter').val()
        };

    if (url.length == 0) {
        url = '/project/project';
    }

    $.ajax({
        method:'GET',
        dataType: 'json',
        url: url,
        data: data,
        success: function(result){
            if (result.success) {
                $('.load_more_project').hide();
                $(".project_html").append(result.projects_html);
            } else {
                toastr.error(result.msg);
            }
        }
    });
}

// load more project if any
$(document).on('click', '.load_more_project', function() {
    var url = $(this).data('href');
    getProjectList(url);
});