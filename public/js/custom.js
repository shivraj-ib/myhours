/* 
 * All custom scripts related to application
 */
jQuery('#add_team_form').ajaxForm({
    url: jQuery('input[name="action"]',this).val(),
    data: jQuery(this).serializeArray(),
    type: 'POST',
    dataType: 'json',
    beforeSubmit: function (arr, $form, options) {

    },
    success: function (response) {

    },
    error: function () {

    },
    complete: function () {

    }
});

