/* 
 * All custom scripts related to application
 */
var global_form_error = 'oops !!! something went wrong.';
var table ;
$(document).ready(function () {
    table = $('#data-table-list').DataTable();    
    ajaxFormRequest('#add_form', '#addModal', $('form#add_form input[name="action"]').val());
    ajaxFormRequest('#upload_profile_pic', '#profilePicModal', $('form#upload_profile_pic input[name="action"]').val());
    initDatePicker();
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
            
            if(data.error){
                $.notify(data.error);
            }
            
            $('body').append(data);
            $('#editModal').modal('show');
            initDatePicker();
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
                    $(form_id + " input[name='" + field + "'],select[name='" + field + "'],textarea[name='" + field + "']").after('<div class="validation-error">' + error + '</div>');
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
            
            if(data.error){
                $.notify(data.error);
            }
            
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
            table = $('#data-table-list').DataTable();
            initDatePicker();
        },
        type: 'GET'
    });
}


function initDatePicker() {
    $(".datepicker").datepicker({dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});

    //date range filter
    $(function () {
        var dateFormat = "dd-mm-yy",
                from = $("#date_from")
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true                                      
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#date_to").datepicker({
            defaultDate: "+1w",
            changeMonth: true                    
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });
}


/*** Data table record filter ****/


$(document).on('change','#date_from, #date_to',function(){
    table.draw();
    
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var start_date_value = $('#date_from').val().split('-');
            var end_date_value = $('#date_to').val().split('-');
            var act_date_value = data[2].split('-');
            
            var start_date = Number(start_date_value[2]+start_date_value[1]+start_date_value[0]);
            var end_date = Number(end_date_value[2]+end_date_value[1]+end_date_value[0]);
            var act_date = Number(act_date_value[2]+act_date_value[1]+act_date_value[0]); // use data for the activity_date column            
           
            if ((isNaN(start_date) && isNaN(end_date)) ||
                (isNaN(end_date) && act_date >= start_date) ||
                (isNaN(start_date) && act_date <= end_date) ||
                (act_date >= start_date && act_date <= end_date)
                )
            {
                return true;
            }
           return false;
        }
);
});

$(document).on('click',"#reset-table",function(){
    $('#date_from, #date_to').val('').trigger('change');
});

/*****Export Hours********************/
//$("form#export_form").ajaxForm({
//    url: $(this).attr('action'),
//    data: $(this).serializeArray(),
//    type: 'POST',
//    dataType: 'json',
//    beforeSubmit: function () {
//        $('.validation-error').remove();
//    },
//    success: function (response) {
//        if (response.success) {
//            $.notify(response.success, 'success');            
//        } else if (response.error) {
//            $.notify(response.error);
//        } else {
//            $.notify(global_form_error);
//        }
//    },
//    error: function (response) {
//        $.notify(global_form_error);
//        $.each(response, function () {
//            $.each(this, function (field, error) {
//                $("form#export_form input[name='" + field + "'],select[name='" + field + "'],textarea[name='" + field + "']").after('<div class="validation-error">' + error + '</div>');
//            });
//        });
//    }
//});