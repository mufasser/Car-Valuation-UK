
function showLoading() {

    var myModal = document.getElementById('loadingModal');
    myModal.addEventListener('shown.bs.modal');
    // jQuery('#loadingModal').modal('show');
    jQuery('#overlay').show();
    
  }
  
  // Hide the loading modal and overlay
  function hideLoading() {
    jQuery('#loadingModal').modal('hide');
    jQuery('#overlay').hide();
  }

  jQuery(function($) {
    $('#my-custom-form').on('submit', function(event) {
        event.preventDefault();
        var form = this;
        grecaptcha.ready(function() {
            grecaptcha.execute('YOUR_SITE_KEY', {action: 'submit'}).then(function(token) {
                var formData = $(form).serialize() + '&recaptcha_token=' + token;
                $.ajax({
                    type: 'POST',
                    url: myAjax.ajaxurl,
                    data: {
                        action: 'my_form_submit',
                        form_data: formData,
                        nonce: myAjax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Form submitted successfully!');
                            $(form)[0].reset(); // Optional: reset form
                        } else {
                            alert('Error: ' + response.data);
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    });
});