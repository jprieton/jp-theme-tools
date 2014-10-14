jQuery(function () {

    if (typeof admin_url === 'undefined' ) return false;

    jQuery('#contact-form').ajaxForm({
        url: admin_url,
        data: {
            action: 'send_contact_form'
        },
        dataType: 'json',
        beforeSubmit: function (formData, jqForm, options) {

            if (!jQuery("#contact-form").validationEngine('validate')) {
                return false;
            }

            // optionally process data before submitting the form via AJAX
            jQuery('#send').attr('disabled', '').html('Enviando <i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (responseText, statusText, xhr, $form) {
            if (responseText === 1) {
                jQuery('#send').removeClass('btn-primary').addClass('btn-success').html('Enviado <i class="fa fa-check"></i>');
            } else {
                jQuery('#send').removeClass('btn-primary').addClass('btn btn-danger').html('Error en el envío <i class="fa fa-warning"></i>');
            }
            // code that's executed when the request is processed successfully
        }
    });
});