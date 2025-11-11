jQuery(document).ready(function ($) {
    $('#cv-lead-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();
        // alert("form submited");

        form.find('.cv-submit-btn').prop('disabled', true).text('Processing...');

        $.ajax({
            url: cv_ajax_object.ajax_url,
            type: 'POST',
            data: formData+'&action=cv_get_valuation&nonce='+cv_ajax_object.nonce,
            dataType: 'json',
            success: function (response) {

                form.find('.cv-submit-btn').prop('disabled', false).text('Get Valuation');
                
                console.log('RESPONSE');
                console.log(response);

                if (response.success) {
                    

                    const car = response.data.vehicle;
                    const prices = response.data.prices;
                    const image = response.data.image;

                    const thankYouHTML = `
                        <div class="cv-thankyou-container">
                            <div class="cv-card">
                                <!--<img src="${image}" alt="${car.make}" class="cv-car-image" />-->
                                <h2>Thank you for vehicle valuation</h2>
                                <p class="cv-price">Trade Average: <strong>£${prices.tradeAverage}</strong></p>
                                <p class="cv-price">Trade Poor: <strong>£${prices.tradePoor}</strong></p>
                                <p class="cv-message">Thank you for submitting your valuation! One of our experts will contact you shortly.</p>
                                <a href="tel:08001234567" class="cv-call-btn">Call Us Now</a>
                            </div>
                        </div>
                    `;

                    // $('.cv-result-form-container').fadeOut(300, function(){
                    $('#cv-lead-form').fadeOut(300, function(){
                        $(this).html(thankYouHTML).fadeIn(500);
                    });

                    // Optional: change URL without reload for lead tracking
                    window.history.pushState({}, '', window.location.pathname + '?thank-you=true');
               








                    
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function () {
                form.find('.cv-submit-btn').prop('disabled', false).text('Get Valuation');
                alert('Something went wrong. Please try again.');
            }
        });
        return false;
    });
});
