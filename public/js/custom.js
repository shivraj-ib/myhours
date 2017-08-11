/* 
 * All custom scripts related to application
 */
var global_form_error = 'oops !!! something went wrong.';
$(document).ready(function () {
    $('#example').DataTable();
    $('#add_team_form').ajaxForm({
        url: $('input[name="action"]', this).val(),
        data: $(this).serializeArray(),
        type: 'POST',
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
            $(".form-success").html('').removeClass('validation-error');
            $('.validation-error').remove();
        },
        success: function (response) {
            if (response.success) {
                $("div.form-success").show().html(response.success);
                location.reload();
            } else if (response.error) {
                $("div.form-success").addClass('validation-error').show().html(response.error);
            } else {
                $("div.form-success").addClass('validation-error').show().html(global_form_error);
            }
        },
        error: function (response) {
            $.each(response, function () {
                $.each(this, function (field, error) {
                    $("#add_team_form input[name='" + field + "']").after('<div class="validation-error">' + error + '</div>');
                });
            });
        }
    });

    $(document).on('click', 'a.edit-team', function (e) {
        e.preventDefault();
        $('#edit-team-modal').remove();
        $.ajax({
            url: $(this).attr('href'),
            error: function () {
                alert('<p>An error has occurred</p>');
            },
            success: function (data) {
                $('body').append(data);
                $('#edit-team-modal').modal('show');
                $('#edit_team_form').ajaxForm({
                    url: $('#edit_team_form input[name="action"]').val(),
                    data: $(this).serializeArray(),
                    type: 'POST',
                    dataType: 'json',
                    beforeSubmit: function (arr, $form, options) {                        
                        $(".form-success").html('').removeClass('validation-error');
                        $('.validation-error').remove();
                    },
                    success: function (response) {
                        if (response.success) {
                            $("div.form-success").show().html(response.success);
                            location.reload();
                        } else if (response.error) {
                            $("div.form-success").addClass('validation-error').show().html(response.error);
                        } else {
                            $("div.form-success").addClass('validation-error').show().html(global_form_error);
                        }
                    },
                    error: function (response) {
                        $.each(response, function () {
                            $.each(this, function (field, error) {
                                $("#edit_team_form input[name='" + field + "']").after('<div class="validation-error">' + error + '</div>');
                            });
                        });
                    }
                });
            },
            type: 'GET'
        });
    });

});