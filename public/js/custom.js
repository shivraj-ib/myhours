/* 
 * All custom scripts related to application
 */
var global_form_error = 'oops !!! something went wrong.';

$(document).ready(function () {
    $('#data-table-list').DataTable();    
    ajaxFormRequest('#add_form', '#addModal', $('form#add_form input[name="action"]').val());
    ajaxFormRequest('#upload_profile_pic', '#profilePicModal', $('form#upload_profile_pic input[name="action"]').val());

    $(document).on('click', 'a.delete-item', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = $(this).attr('title');
        var confirmModal = $('#confirm');
        $("div.modal-body",confirmModal).html("Delete, Are you sure ?");
        confirmModal.modal().one('click', '#delete', function () {
            ajaxDeleteRecord(url);            
        });
    });

    $(document).on('click', 'a.edit-item', function (e) {
        e.preventDefault();
        //remove older edit modal
        $('#editModal').remove();
        ajaxEditRecord($(this).attr('href'));
    });

});


function ajaxEditRecord(request_url) {
    $.ajax({
        url: request_url,
        error: function () {
            $.notify(global_form_error);
        },
        success: function (data) {
            $('body').append(data);
            $('#editModal').modal('show');
            ajaxFormRequest('#edit_form', "#editModal", $('form#edit_form input[name="action"]').val());
        },
        type: 'GET'
    });
}


function ajaxFormRequest(form_id, modal_id, request_url) {
    $(form_id).ajaxForm({
        url: request_url,
        data: $(this).serializeArray(),
        type: 'POST',
        dataType: 'json',
        beforeSubmit: function(){
            $('.validation-error').remove();
        },
        success: function (response) {
            if (response.success) {
                $.notify(response.success, 'success');
                if(form_id == '#add_form' || form_id == '#upload_profile_pic'){
                    $(form_id)[0].reset();
                }
                $(modal_id).modal('hide');
                refreshList();
            } else if (response.error) {
                $.notify(response.error);
            } else {
                $.notify(global_form_error);
            }
        },
        error: function (response) {
            $.notify(global_form_error);
            $.each(response, function () {
                $.each(this, function (field, error) {
                    $(form_id + " input[name='" + field + "']").after('<div class="validation-error">' + error + '</div>');
                });
            });
        }
    });
}

function ajaxDeleteRecord(request_url) {
    $.ajax({
        url: request_url,
        error: function () {
            $.notify(global_form_error);
        },
        success: function (data) {     
            $('#confirm').modal('hide');            
            $.notify(data.success, 'success');
            refreshList();
        },
        type: 'GET'
    });
}


function refreshList() {
    $.ajax({
        url: $('.list-container').data('route'),
        error: function () {
            $.notify(global_form_error);
        },
        success: function (data) {
            $(".list-container").html(data);
            $('#data-table-list').DataTable();
        },
        type: 'GET'
    });
}