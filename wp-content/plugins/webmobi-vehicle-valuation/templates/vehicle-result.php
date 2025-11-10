<?php 
$step = $_GET['step'];
// error_reporting(E_ALL);

get_header();

$uk_vehicle_nonce = wp_create_nonce( 'uk-vehicle-nonce' );
$uk_vehicle_final_step_nonce = wp_create_nonce( 'uk-vehicle-last-step-nonce' );

// $vehicleData = $vVehicleInformation->vehicleData($vehicleNumber);
// $valuationData = $vVehicleInformation->valuationData($vehicleNumber);
// $valuationCanPrice = $vVehicleInformation->valuationCanPrice($vehicleNumber);

?>

<div id="main-content" class="vehicle-search-container">

    <div class="container car-valuation-container" style="margin-top: 100px;" >
        <div class="row">
            <div class="col-md-12">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 66.6%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="row" style="<?php echo ($step ==1)?'display:block':'display:none'?>">
            <form action="" id="form-search-vehicle-form">
                

                <div class="col-md-12">
                    <!-- <h3>Step 1</h3> -->
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <h2>Get your free valuation now</h2>
                        <p>Enter your registration number to find your vehicle.</p>
                            
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vehicle-plate-number">Enter Number Plate *</label>
                                <input type="text" placeholder="AB12CDE" name="vehicle_plate_number" id="vehicle-plate-number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current-odometer-reading">Current Odometer Reading *</label>
                                <input type="text" placeholder="Enter your current mileage" name="current_odometer_reading" id="current-odometer-reading" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary next btn-inline">Search</button>
                </div>
            </form>
        </div>
        
        <div class="row step-2" style="<?php echo ($step ==2)?'display:block':'display:none'?>">>
            <div class="col-md-12">
                <!-- <h3>Step 2</h3> -->
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <h3>Your Vehicle</h3>
                    <p>Please see your vehicle details below</p>
                    <hr>
                    <div class="vehicle-info-wrapper">
                        <div class="row">
                            <div class="col-md-6 vehicle-thumb">
                                <img src="https://www.sellmycartoday.uk/smc/wp-content/uploads/2025/02/car-not-found.webp" alt="Vehicle Image" class="vehicle-image">
                                <h6>Image is representative only</h6>
                            </div>
                            <div class="col-md-6 vehicle-info">
                                <h3 class="vehicle-name"></h3>
                                Not your vehicle? <a href="https://www.sellmycartoday.uk/">Search Again</a>
                            </div>
                        </div>
                        
                        <div class="row valuation-unavailable">
                        <hr>
                        <br>
                        <br>
                            <div class="col-md-12">
                                <h3>What You Need To Know:</h3>
                                <div>
                                    You will receive a free no obligation quote based on your vehicles registration and mileage.
                                </div>
                                <div>
                                    An instant valuation with multiple values to base on your vehicles physical condition.
                                </div>
                                <div>
                                    A copy of your valuation will be sent to your email address for reference.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 vehicle-your-details">
                    <h3 class="mobile-m-t-15">Your Details</h3>
                    <p>To receive your valuation, please enter your details below</p>
                    
                    
                    <form action="" class="form" id="form-get-your-valuation-now" onsubmit="return getYourValuationNow(this, event)">
                    <input type="hidden" name="vehicle_plate_number" id="vehicle_plate_number" value="<?php echo sanitize_text_field($_GET['vehicle_plate_number'])?>">
                    <input type="hidden" name="current_odometer_reading" id="current_odometer_reading" value="<?php echo sanitize_text_field($_GET['current_odometer_reading'])?>">

                    <input type="hidden" name="vehicleFullName" id="vehicleFullName" class="vehicleFullName" value="">
                    <input type="hidden" name="vehicleImage" id="vehicleImage" class="vehicleImage" value="">
                    <input type="hidden" name="vehicleAveragePrice" id="vehicleAveragePrice" class="vehicleAveragePrice" value="">
                    <input type="hidden" name="vehiclePoorPrice" id="vehiclePoorPrice" class="vehiclePoorPrice" value="">
                    <input type="hidden" name="vehicleRetailPrice" id="vehicleRetailPrice" class="vehicleRetailPrice" value="">
                    <input type="hidden" name="vehicleAuctionPrice" id="vehicleAuctionPrice" class="vehicleAuctionPrice" value="">
                    <input type="hidden" name="vehiclePartExchangePrice" id="vehiclePartExchangePrice" class="vehiclePartExchangePrice" value="">
                    <input type="hidden" name="next_step" id="next_step" value="">
                    
                        <div class="form-group">
                            <label for="user_type">Title</label>
                            <select id="user_type" name="user_type"  class="form-control" require>
                                <option selected="selected" value="">Select</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                                <option value="Prof.">Prof.</option>
                                <option value="Sir">Sir</option>
                                <option value="Hon.">Hon.</option>
                                <option value="Rev.">Rev.</option>
                                <option value="Lord">Lord</option>
                                <option value="Lady">Lady</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="first-name">First Name *</label>
                            <input type="text" required name="first_name" class="form-control" id="first-name" placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name *</label>
                            <input type="text" required name="last_name" class="form-control" id="last-name" placeholder="Enter last name">
                        </div>
                        <div class="form-group">
                            <label for="email-address">Email Address *</label>
                            <input type="email" required name="email" class="form-control" id="email-address" placeholder="Enter email address">
                        </div>
                        <div class="form-group">
                            <label for="phone-number">Phone Number *</label>
                            <input type="tel" required name="phone" class="form-control" id="phone-number" placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label for="phone-type">Phone Type *</label>
                            <select  required name="phone_type" id="phone-type" class="form-control" >
                                <option selected="selected" value="">Select</option>
                                <option value="Home">Home</option>
                                <option value="Work">Work</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcN4BkrAAAAAEcaiQqx_ZmgJieMYD2DhyokHqls"></div>
                            <div class="captcha-error" style="color:red; display:none">Please complete the reCAPTCHA.</div>
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">GET YOUR VALUATION NOW</button>
                        </div>
                    </form>
                </div>

                <!-- Car valuation -->
                <div class="col-md-6 valuation-result" style="display: none; ">
                    <div class="valuation-unavailable" style="display: none; ">
                        <h3>Valuation Unavailable</h3>
                        <p>We are unable to value your vehicle right now but if you would like to speak to a member of staff, please contact your nearest dealership.</p>
                        <button class="btn btn-primary" type="button">START NEW VALUATION</button>
                    </div>
                    
                    <div class="valuation-available" style="display: none; ">
                        <h3 class="heading mobile-m-t-15">Your Car Valuation</h3>
                        <hr>
                        <img src="https://www.sellmycartoday.uk/smc/wp-content/uploads/2025/02/car-not-found.webp" alt="Vehicle Image" class="vehicle-image">
                        <hr>
                        <h3 class="vehicle-name"></h3>
                        <!-- <h6 >Auction: <span class="auction"></span> </h6> -->
                        <br>
                        <h5 class="trade-average-wrapper">Good Condition: <span class="trade-average"></span> </h5>
                        <h5 class="trade-poor-wrapper">Average condition: <span class="trade-poor"></span> </h5>
                        <!-- <h6 >Trade Retail: <span class="trade-retail"></span> </h6> -->
                        <a href="#" class="btn btn-primary">Sell My Car</a>
                    </div>
                </div>
                <!-- <div class="col-md-2">
                    <button type="button" class="btn btn-primary prev">Previous</button>
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-primary next">Next</button>
                </div> -->
            </div>
            
        </div>

        <div class="row"  style="<?php echo ($step == 3)?'display:block':'display:none'?>">>>
            <div class="col-md-12">
                <!-- <h3>Step 3</h3> -->
            </div>  
            <div class="col-md-6">

            </div>
            <button type="button" class="btn btn-primary prev">Previous</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </div>

</div>
<div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loadingModalLabel">Loading...</h5>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="overlay"></div>


<!-- Last Step -->
<div class="last-step-container  mi-vehicle-information show-with-vehicle-info" style="display:none">

    <div class="row vehicle-important-information">
        <div class="col-md-12">
        <br><br>
            Your Vehicle Value
            <div class="vehicle-value vehicle-value-big trade-average">£0,00,000</div>
            <p class="vehicle-value-validity">Your valuation is valid for 7 days until <?php echo priceDate();?></p>
        </div>
    </div>
    <div class="row mi-last-step-notice">
        <div class="col-md-12">
        We'd like to discuss your valuation with you, please let us know how you would like to proceed.
        </div>
    </div>
    <div class="container mi-last-step" style="width:100%">

    <!-- <form action="" method="POST" id="final_step" onsubmit="return finishForm(this, event);"> -->
    <form action="" method="POST" id="final_step">

        <div class="row mi-last-step-wrapper">
            <div class="col-md-12 mi-last-step-form">
                    <input type="hidden" id="post_id" name="post_id">
                    <h3 class="">Let's discuss your next steps..</h3>
                    <ol class="list-group contact-type-list">

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <label for="email-me">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">
                                            <input type="radio" required name="contact_type" value="Discuss my valuation" id="email-me">
                                            &nbsp;Discuss my valuation
                                    </div>
                                    
                                </div>
                            </label>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <label for="call-me-back">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                        <input type="radio" required name="contact_type" value="Call me back in 30 mins" id="call-me-back">
                                        &nbsp;Call me back in 30 mins
                                    </div>
                                    
                                </div>
                            </label>
                        </li>
<?php
/*
?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <label for="nothing-at-moment">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                        <input type="radio" required name="contact_type" value="Nothing at the moment" id="nothing-at-moment">
                                        &nbsp;Nothing at the moment
                                    </div>
                                    
                                </div>
                            </label>
                        </li>
<?php
*/
?>
                    </ol>

                    <!-- Vehicle Information -->
                    <div class="row vehicle-basic-information-wrapper">
                        <div class="col-md-12 vehicle-basic-information">
                            <img src="" alt="https://www.sellmycartoday.uk/smc/wp-content/uploads/2025/02/car-not-found.webp" class="vehicle-image">
                            <h3 class="vehicle-plate-number"></h3>
                            <h5 class="vehicle-name">LAND ROVER RANGE ROVER SPORT<br>HSE SDV<br>3.0 SDV6 HSE 5DR AUTO</h5>
                            <!-- <div class="vehicle-value vehicle-value-small">£6,893.25</div> -->
                            <h5 class="trade-average-wrapper">Good Condition: <span class="trade-average"></span> </h5>
                            <h5 class="trade-poor-wrapper">Average Condition: <span class="trade-poor"></span> </h5>
                        </div>
                    </div>
            </div>
        </div>
            
        <div class="row mi-btn-wrapper">
            <div class="col-12">
                <button disabled="disabled" onclick="finishForm2(jQuery('#final_step'))" type="button" class="btn btn-primary btn-mi-special btn-block btn-round submit-button">Finish</button>
            </div>
        </div>
            
        <div class="row">
            <div class="col-12">
                <!-- <a href="#" id="start-again"><i class="fa fa-reload"></i>&nbsp;Start again</a> -->
            </div>
        </div>

        </form>
    </div>
</div>


<!-- Vehical Information -->
<?php 
/*
<div class="container mi-vehicle-information show-with-vehicle-info" style="width:100%; display:none">
    <!-- <div class="row vehicle-important-information">
        <div class="col-md-12">
            Your Vehicle Value
            <div class="vehicle-value vehicle-value-big trade-average">£0,00,000</div>
            <p class="vehicle-value-validity">Your valuation is valid for 7 days until <?php echo priceDate();?></p>
        </div>
    </div> -->
    <div class="row vehicle-basic-information-wrapper">
        <div class="col-md-12 vehicle-basic-information">
            <img src="" alt="" class="vehicle-image">
            <h3 class="vehicle-plate-number"></h3>
            <h5 class="vehicle-name">LAND ROVER RANGE ROVER SPORT<br>HSE SDV<br>3.0 SDV6 HSE 5DR AUTO</h5>
            <!-- <div class="vehicle-value vehicle-value-small">£6,893.25</div> -->
            <h5 class="trade-average-wrapper">Good Condition: <span class="trade-average"></span> </h5>
            <h5 class="trade-poor-wrapper">Average condition: <span class="trade-poor"></span> </h5>
        </div>
    </div>
    <!-- <div class="row btn-wrapper">
        <div class="col-md-6 col-md-6 col-sm-6 col-xs-6">
            <a href="" class="btn btn-primary btn-mi-special">PART EXCHANGE</a>
        </div>
        <div class="col-md-6 col-md-6 col-sm-6 col-xs-6">
            <a href="" class="btn btn-primary btn-mi-special">SELL MY CAR</a>
        </div>
    </div> -->
</div>
*/
?>

<!-- Thank you -->
<div class="thank-you-container container" style="display: none;">
    <h2>Thanks for asking <a href="https://sellmycartoday.uk">Sellmycartoday.uk</a> to value your car.</h2>
    <br>
    <p>Your details have been sent to one of our vehicle purchasers who will get back to you soon. We try our best to be as fast as possible, but we also want to make sure it's the best price we can offer.</p>
    <p>Despite our best endeavours, occasionally our email will go into your spam folder. Please check if you haven't heard from us.</p>
    <p>Feel free to call us if you have any questions.</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LcjpRkrAAAAAA5Lj6IkRO7BWTJz0eu7vYiFX6yW"></script>
<script>
    
    $(document).ready(function() {

        $('.next').click(function() {
            var currentStep = $(this).closest('.row');
            var nextStep = currentStep.next('.row');
            var progressBar = $('.progress-bar');
            if (nextStep.length > 0) {
                progressBar.css('width', '66.6%');
                currentStep.hide();
                nextStep.show();
            } else {
               // $('#my-form').submit();
            }
        });
        
        $('.prev').click(function() {
            var currentStep = $(this).closest('.row');
            var prevStep = currentStep.prev('.row');
            var progressBar = $('.progress-bar');
            if (prevStep.length > 0) {
                progressBar.css('width', '33.3%');
                currentStep.hide();
                prevStep.show();
            }
        });

    });

    var valuationData;

    // get valuation information
    function getYourValuationNow(form,event){

        event.preventDefault();

        var vehicle_plate_number = $('#vehicle_plate_number').val();
        if(vehicle_plate_number == ''){
            alert("Vehicle Plate Number required");
            return;
        }
        var recaptchaResponse = grecaptcha.getResponse();

        if (recaptchaResponse === '') {
            // alert('Please complete the reCAPTCHA.');
            $('.captcha-error').show();
            return false;
        }
        $('.captcha-error').hide();
        // grecaptcha.ready(function() {
        //     grecaptcha.execute('6LcjpRkrAAAAAA5Lj6IkRO7BWTJz0eu7vYiFX6yW', {action: 'submit'}).then(function(token) {
                // var formData = $(form).serialize() + '&recaptcha_token=' + token;

                var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
                var data = {
                    // grecaptcha_token: token,
                    'g-recaptcha-response': recaptchaResponse,
                    action: 'mi_complete_valuation_action',
                    nonce: '<?php echo $uk_vehicle_nonce; ?>',
                    vehicle_plate_number: vehicle_plate_number,
                    metadata: valuationData,
                    user_type: $('#user_type').val(),
                    email: $('#email-address').val(),
                    phone: $('#phone-number').val(),
                    phone_type: $('#phone-type').val(),
                    first_name: $('#first-name').val(),
                    last_name: $('#last-name').val(),
                    postcode: $('#postcode').val(),

                    mileage: $('#current_odometer_reading').val(),

                    vehicleFullName: $('#vehicleFullName').val(),
                    vehicleImage: $('#vehicleImage').val(),
                    vehicleAveragePrice: $('#vehicleAveragePrice').val(),
                    vehicleRetailPrice: $('#vehicleRetailPrice').val(),
                    vehicleAuctionPrice: $('#vehicleAuctionPrice').val(),
                    vehiclePartExchangePrice: $('#vehiclePartExchangePrice').val(),
                    vehiclePoorPrice: $('#vehiclePoorPrice').val()

                };

                console.log("=======================");
                console.log("data request");
                console.log(data);

                jQuery.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: function(){
                        // showLoading();
                        // alert("Loading");
                    },
                    success: function(response) {
                       // console.log(response);
                        // hideLoading();
                        if(response.status){

                            var w = window.innerWidth;
                            var h = window.innerHeight;
                            var vehicleName = '';
                            if(response.data.model != undefined){
                                vehicleName = response.data.model+' '+response.data.vrm;
                            }else{
                                vehicleName = "Vehicle not found";
                            }
                            // var vehicleName = response.data.model+' '+response.data.vrm;

                            var currentStep = $(this).closest('.row');
                            var nextStep = currentStep.next('.row');
                            var progressBar = $('.progress-bar');
                            progressBar.css('width', '100%');

                            // $('.vehicle-name').text(vehicleName);
                            $('.vrm').text(response.data.vrm);

                            
                            $('.trade-average').text(formatCurrency($('.vehicleAveragePrice').val()));
                            $('.trade-poor').text( formatCurrency($('.vehiclePoorPrice').val()));    
                            $('#vehiclePartExchangePrice').val($('.vehiclePartExchangePrice').val());
                            
                            $('#post_id').val(response.post_id)

                            $(".valuation-available").show();
                            
                            // Update code
                            // $(".valuation-result").show();
                            $(".step-2").hide();
                            $(".mi-vehicle-information").show();
                            $(".show-with-vehicle-info").show();

                            $(".vehicle-your-details").hide();
                            $(".valuation-unavailable").hide();

                            if(w < 770){
                                $('.valuation-available .vehicle-image').hide();
                                // $('.valuation-available .heading').show();
                                $('.valuation-available .vehicle-name').hide();
                                $('.valuation-available hr').hide();
                            }else{
                                $('.valuation-available .vehicle-image').hide();
                                // $('.valuation-available .heading').hide();
                                $('.valuation-available .vehicle-name').hide();
                                $('.valuation-available hr').hide();
                            }
                            
                        }else{
                            $(".valuation-result").show();
                            $(".valuation-unavailable").show();
                        }
                    }
                });
        //     });
        // });

        return false;
    }

    function formatCurrency(number){
        return Intl.NumberFormat("en-GB", { style: 'currency', currency: 'GBP' }).format(number);
    }

    // calling vehicle information onload the page
    getVehicleInfo();
    function getVehicleInfo(){
        
        $(".car-valuation-container").hide();

        var vehicle_plate_number = $('#vehicle_plate_number').val();
        var current_odometer_reading = $('#current_odometer_reading').val();
        if(vehicle_plate_number == ''){
            alert("Vehicle Plate Number required");
            return;
        }
        var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
        var data = {
            action: 'mi_get_vehicle_info_action',
            nonce: '<?php echo $uk_vehicle_nonce; ?>',
            vehicle_plate_number: vehicle_plate_number,
            current_odometer_reading: current_odometer_reading
        };

        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function(){
                // showLoading();
                // alert("Loading");
            },
            success: function(response) {
                $(".car-valuation-container").fadeIn();
                // hideLoading();
                if(response.status){
                    let imageUrl = response.image.imageUrl;
                    if(imageUrl == null || imageUrl == undefined){
                        imageUrl = 'https://www.sellmycartoday.uk/smc/wp-content/uploads/2025/02/car-not-found.webp';
                    }
                    
                    let vehicleName 
                    if(response.valuationData.StatusMessage == 'Success'){
                    // if(response.vdata.status == 'success'){
                        vehicleName = response.valuationData.VehicleDescription +' '+response.vrm;
                        // vehicleName = response.vdata.vehicleRegistration.MakeModel +' '+response.vrm;
                        // vehicleName = response.valuationData.VehicleDescription +' '+$('#vehicle_plate_number').val();
                    }else{
                        vehicleName = "Vehicle not found";
                    }
                    //  response.valuationData.VehicleDescription +' '+response.valuationData.Vrm;

                    $(".vehicle-image").prop('src', imageUrl);
                    $(".vehicle-name").text(vehicleName);

                    $('.vehicleFullName').val(vehicleName);
                    $('.vehicleImage').val(imageUrl);

                    // Valuation Data
                    let valuations = response.valuationData.ValuationFigures;
                    $('.vehiclePartExchangePrice').val(valuations.PartExchange);
                    $('.vehicleAuctionPrice').val(valuations.Auction);
                    $('.vehicleRetailPrice').val(valuations.TradeRetail);

                    // $('.vehicleAveragePrice').val(valuations.TradeAverage);
                    // $('.vehiclePoorPrice').val(valuations.TradePoor);
                    
                    // console.log("response.tradeAverage: "+response.tradeAverage);
                    $('.vehicleAveragePrice').val(response.tradeAverage);

                    // console.log("response.poorAverage: "+response.tradePoor);
                    $('.vehiclePoorPrice').val(response.tradePoor);

                    // console.log("ValuationFigures");
                    // console.log(response.valuationData.ValuationFigures);
                    
                    // console.log("vehiclePartExchangePrice");
                    // console.log(valuations.PartExchange);

                    valuationData = response;
                }
                $("#loading").hide();
                console.log(response);
            }
        });

    }  

    function finishForm(form,e){

        e.preventDefault();

        // grecaptcha.ready(function() {
        //     grecaptcha.execute('6LcjpRkrAAAAAA5Lj6IkRO7BWTJz0eu7vYiFX6yW', {action: 'submit'}).then(function(token) {
        //         // var formData = $(form).serialize() + '&recaptcha_token=' + token;

        var vehicle_plate_number = $('#vehicle_plate_number').val();
        var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
        var data = {
            // recaptcha_token: token,
            action: 'mi_complete_next_step_valuation_action',
            nonce: '<?php echo $uk_vehicle_final_step_nonce; ?>',
            vehicle_plate_number: vehicle_plate_number,

            contact_type: $('input[name="contact_type"]:checked').val(),
            post_id: $('#post_id').val(),
            user_type: $('#user_type').val(),
            email: $('#email-address').val(),
            phone: $('#phone-number').val(),
            phone_type: $('#phone-type').val(),
            first_name: $('#first-name').val(),
            last_name: $('#last-name').val(),
            postcode: $('#postcode').val(),

            vehicleFullName: $('#vehicleFullName').val(),
            vehicleImage: $('#vehicleImage').val(),
            vehicleAveragePrice: $('#vehicleAveragePrice').val(),
            vehicleRetailPrice: $('#vehicleRetailPrice').val(),
            vehicleAuctionPrice: $('#vehicleAuctionPrice').val(),
            vehiclePartExchangePrice: $('#vehiclePartExchangePrice').val(),
            vehiclePoorPrice: $('#vehiclePoorPrice').val()
        };


            $(".car-valuation-container").hide();
            $(".show-with-vehicle-info").hide();
            $(".thank-you-container").show();

            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function(){
                    // showLoading();
                    // alert("Loading");
                },
                success: function(response) {
                    $(".car-valuation-container").hide();
                    $(".show-with-vehicle-info").hide();
                  //  $(".thank-you-container").show();
                },// success
            }).done(function(response) {
                    $(".car-valuation-container").hide();
                    $(".show-with-vehicle-info").hide();
                 //   $(".thank-you-container").show();
            });//ajax
            
        //     });
        // });
                return false;
        
        alert("Wait for car valuation");
    }

    // enable disable submit button
    $('input[name="contact_type"]').on('change', function() {
        if (this.checked) {
            $('.submit-button').prop('disabled', false);
        } else {
            $('.submit-button').prop('disabled', true); 
        }
    });

    function finishForm2(form){

        var vehicle_plate_number = $('#vehicle_plate_number').val();
        var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
        var data = {
            action: 'mi_complete_next_step_valuation_action',
            nonce: '<?php echo $uk_vehicle_final_step_nonce; ?>',
            vehicle_plate_number: vehicle_plate_number,

            contact_type: $('input[name="contact_type"]:checked').val(),
            post_id: $('#post_id').val(),
            user_type: $('#user_type').val(),
            email: $('#email-address').val(),
            phone: $('#phone-number').val(),
            phone_type: $('#phone-type').val(),
            first_name: $('#first-name').val(),
            last_name: $('#last-name').val(),
            postcode: $('#postcode').val(),

            vehicleFullName: $('#vehicleFullName').val(),
            vehicleImage: $('#vehicleImage').val(),
            vehicleAveragePrice: $('#vehicleAveragePrice').val(),
            vehicleRetailPrice: $('#vehicleRetailPrice').val(),
            vehicleAuctionPrice: $('#vehicleAuctionPrice').val(),
            vehiclePartExchangePrice: $('#vehiclePartExchangePrice').val(),
            vehiclePoorPrice: $('#vehiclePoorPrice').val()
        };

        if (! jQuery(form)[0].checkValidity()) {
            jQuery(form)[0].reportValidity();
            $('.call-me-back').text().css('color','red')
            return false;
        }


            // $(".car-valuation-container").hide();
            // $(".show-with-vehicle-info").hide();
            // $(".thank-you-container").show();

            //document.title = 'Thank you for valuation';
            //var urlParams = new URLSearchParams(window.location.search);
           // window.history.pushState('Thank you for valuation', 'Thank you for valuation', '/valuation/thankyou?'+urlParams.toString());


            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function(){
                    // showLoading();
                    // alert("Loading");
                },
                success: function(response) {
                    $(".car-valuation-container").hide();
                    $(".show-with-vehicle-info").hide();
                  //  $(".thank-you-container").show();

                    // window.location = 'https://www.sellmycartoday.uk/thank-you/?lead='+response.lead_id
                },// success
            }).done(function(response) {
                    $(".car-valuation-container").hide();
                    $(".show-with-vehicle-info").hide();
                  //  $(".thank-you-container").show();

                     window.location = 'https://www.sellmycartoday.uk/thank-you/?lead='+response.lead_id
                });//ajax
                return false;
        
        //alert("Wait for car valuation");
    }

</script>

<?php
function priceDate(){
    $start_date = date("Y/m/d");  
    $date = strtotime($start_date);
    $date = strtotime("+7 day", $date);
    echo date('d/m/Y', $date);
}
get_footer();