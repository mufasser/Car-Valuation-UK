jQuery(document).ready(function ($) {
    $('#cv-lead-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();

        form.find('.cv-submit-btn').prop('disabled', true).text('Processing...');

        $.ajax({
            url: cv_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'cv_get_valuation',
                nonce: cv_ajax_object.nonce,
                form_data: formData
            },
            success: function (response) {
                form.find('.cv-submit-btn').prop('disabled', false).text('Get Valuation');

                if (response.success) {
                    // Display valuation result in UI
                    alert('Car Valuation: £' + response.data.valuation.TradeRetail);
                    console.log(response.data);
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function () {
                form.find('.cv-submit-btn').prop('disabled', false).text('Get Valuation');
                alert('Something went wrong. Please try again.');
            }
        });
    });
});
