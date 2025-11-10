<?php



add_action( 'wp_ajax_mi_complete_valuation_action', 'mi_complete_valuation_action' );
add_action( 'wp_ajax_nopriv_mi_complete_valuation_action', 'mi_complete_valuation_action' );

function mi_complete_valuation_action() {

    
    
    $response = [
        "status" => false,
        "msg" => "Security check failed",
        'vehicleImageInfo'=> [],
        'vehicleInfo' => []
    ];
    
    // $nonce = sanitize_text_field($_POST['nonce']);
    $nonce = sanitize_text_field($_POST['nonce']);
    if ( ! wp_verify_nonce( $nonce, 'uk-vehicle-nonce' ) ) {
        die(json_encode($response));
    }else{

    
    
    //     // Parse form data
    // parse_str($_POST['form_data'], $form_data);
    // $recaptcha_token = $form_data['recaptcha_token'];

    // // Verify reCAPTCHA v3
    // $secret_key = '6LcjpRkrAAAAAHsIN5wj1lViPgEnC_OMxGtFAbkh'; // Replace with your secret key
    // $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    // $response = wp_remote_post($verify_url, array(
    //     'body' => array(
    //         'secret' => $secret_key,
    //         'response' => $recaptcha_token,
    //         'remoteip' => $_SERVER['REMOTE_ADDR']
    //     )
    // ));

    // if (is_wp_error($response)) {
    //     wp_send_json_error('reCAPTCHA verification failed.');
    // }

    // $response_body = wp_remote_retrieve_body($response);
    // $result = json_decode($response_body, true);

    // if ($result['success'] && $result['score'] >= 0.5) {
    
            // error_reporting(E_ALL);
            // @ini_set('display_errors', 1); 

            // echo("Start Data");

            $metadata = $_POST['metadata'];

            // print_r($metadata); exit;


            $vehiclePlateNumber = sanitize_text_field($_POST['vehicle_plate_number']);
            $userType = sanitize_text_field($_POST['user_type']);
            $firstName = sanitize_text_field($_POST['first_name']);
            $lastName = sanitize_text_field($_POST['last_name']);
            $email = sanitize_text_field($_POST['email']);
            // $postcode = sanitize_text_field($_POST['postcode']);
            $phone = sanitize_text_field($_POST['phone']);
            $phoneType = sanitize_text_field($_POST['phone_type']);

            $mileage = sanitize_text_field($_POST['mileage']);

            $vehiclePoorPrice = sanitize_text_field($_POST['vehiclePoorPrice']);
            $vehicleAveragePrice = sanitize_text_field($_POST['vehicleAveragePrice']);

            $vehicleFullName = sanitize_text_field($_POST['vehicleFullName']);
            $vehicleImage = sanitize_text_field($_POST['vehicleImage']);
            // $partExchange = sanitize_text_field($_POST['partExchange']);
            $partExchange = sanitize_text_field($_POST['vehiclePartExchangePrice']);

            $userData = [
                'vehiclePlateNumber' => $vehiclePlateNumber,
                'userType' => $userType,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                // 'postcode' => $postcode,
                'phone' => $phone,
                'phoneType' => $phoneType,
                'mileage' => $mileage,
                'vehiclePoorPrice' => $vehiclePoorPrice,
                'vehicleAveragePrice' => $vehicleAveragePrice,
                'vehicleFullName' => $vehicleFullName,
                'vehicleImage' => $vehicleImage,
                'partExchange' => $partExchange
            ];


          


                $vehicleInformation = [];

                $imageUrl = $metadata['image']['imageUrl'];
                $vehicleInformation['image'] = $imageUrl;

                $completeData = $metadata['vdata']['completeData'];
                $requestInformation = $completeData['RequestInformation'];
                $billingInformation = $completeData['BillingInformation'];
                $vehicleDetails = $completeData['Results']['VehicleDetails'];
                $vehicleIdentification = $vehicleDetails['VehicleIdentification'];
                // $vehicleStatus = $vehicleDetails['VehicleStatus'];

                $vehicleInformation['dvlaBodyType'] = $vehicleIdentification['DvlaBodyType'];
                $vehicleInformation['dvlaFuelType'] = $vehicleIdentification['DvlaFuelType'];
                $vehicleInformation['YearOfManufacture'] = $vehicleIdentification['YearOfManufacture'];

                $vehicleInformation['vrm'] = $requestInformation['SearchTerm'];
                $vehicleInformation['apiBalance'] = $billingInformation['AccountBalance'];

                // Car history and transfers details
                $vehicleHistory = $vehicleDetails['VehicleHistory'];
                $currentColour = $vehicleHistory['ColourDetails']['CurrentColour'];
                $originalColour = $vehicleHistory['ColourDetails']['OriginalColour'];
                $keeperChangeList = count($vehicleHistory['KeeperChangeList']);
                $v5cCertificateList = count($vehicleHistory['V5cCertificateList']);

                $vehicleInformation['currentColour'] = $currentColour;
                $vehicleInformation['originalColour'] = $originalColour;
                $vehicleInformation['keeperChangeList'] = $keeperChangeList;
                $vehicleInformation['v5cCertificateList'] = $v5cCertificateList;


                $dvlaTechnicalDetails = $vehicleDetails['DvlaTechnicalDetails'];
                $vehicleInformation['engineCapacity'] = $dvlaTechnicalDetails['EngineCapacityCc'];
                $vehicleInformation['numberOfSeats'] = $dvlaTechnicalDetails['NumberOfSeats'];
                $vehicleInformation['massInServiceKg'] = $dvlaTechnicalDetails['MassInServiceKg'];
                $vehicleInformation['maxNetPowerKw'] = $dvlaTechnicalDetails['MaxNetPowerKw'];


                // Vehicle Model Details 
                $modelDetails = $completeData['Results']['ModelDetails'];
                $modelIdentification = $modelDetails['ModelIdentification'];

                $vehicleInformation['make'] = $modelIdentification['Make'];
                $vehicleInformation['range'] = $modelIdentification['Range'];
                $vehicleInformation['model'] = $modelIdentification['Model'];
                $vehicleInformation['modelVariant'] = $modelIdentification['ModelVariant'];
                $vehicleInformation['series'] = $modelIdentification['Series'];
                $vehicleInformation['mark'] = $modelIdentification['Mark'];
                $vehicleInformation['countryOfOrigin'] = $modelIdentification['CountryOfOrigin'];
                $vehicleInformation['variantCode'] = $modelIdentification['VariantCode'];

                $modelClassification = $modelDetails['ModelClassification'];
                $powertrain = $modelDetails['Powertrain'];

                $vehicleInformation['typeApprovalCategory'] = $modelClassification['TypeApprovalCategory'];
                $vehicleInformation['marketSectorCode'] = $modelClassification['MarketSectorCode'];
                $vehicleInformation['vehicleClass'] = $modelClassification['VehicleClass'];
                $vehicleInformation['taxationClass'] = $modelClassification['TaxationClass'];
                $vehicleInformation['powertrain'] = $powertrain;
                $vehicleInformation['fuelType'] = $powertrain['FuelType'];
                $vehicleInformation['powertrainType'] = $powertrain['PowertrainType'];

                $vehicleInformation['transmission'] = $powertrain['Transmission'];

                // Car Technical Information
                $smmtDetails = $completeData['SmmtDetails'];

                $vehicleInformation['IdentificationDetails'] = $smmtDetails['IdentificationDetails'];
                $vehicleInformation['technicalDetails'] = $smmtDetails['TechnicalDetails'];
                $vehicleInformation['dimensions'] = $smmtDetails['Dimensions'];
                $vehicleInformation['weights'] = $smmtDetails['Weights'];
                $vehicleInformation['performance'] = $smmtDetails['Performance'];
                $vehicleInformation['economy'] = $smmtDetails['Economy'];

                // Vehicle Registration
                $vrm = $metadata['vdata']['vrm'];
                $valuationData = $metadata['valuationData'];
                $vehicleInformation['millage'] = $valuationData['ValuationMileage'];
                // $valuationMileage = $metadata['valuationData']['ValuationMileage'];
                // $vehicleDescription = $metadata['valuationData']['VehicleDescription'];

                // valuation Prices
                // print_r($metadata['valuationData']['ValuationFigures']);
                $vehiclePrices = processPricesArray($metadata['valuationData']['ValuationFigures']);
                $tradePoor = ceil($vehiclePrices['TradePoor']);
                $tradeAverage = ceil($vehiclePrices['TradeAverage']);

                $vehicleInformation['valuationMileage'] = $metadata['valuationData']['ValuationMileage'];
                $vehicleInformation['vehicleDescription'] = $metadata['valuationData']['vehicleDescription'];
                $vehicleInformation['valuationFigures'] = $metadata['valuationData']['ValuationFigures'];
                $vehicleInformation['tradePoor'] = $tradePoor;
                $vehicleInformation['tradeAverage'] = $tradeAverage;
                
                $data['tradeAverage'] =  $tradeAverage;
                $data['tradePoor'] =  $tradePoor;

              
                
                $data['color'] =  $vehicleInformation['currentColour'];
                $data['vehicleClass'] =  $vehicleInformation['vehicleClass'];
                $data['model'] =  $vehicleInformation['model'];
                $data['make'] =  $vehicleInformation['make'];
                $data['fuelType'] =  $vehicleInformation['fuelType'];
                $data['makeModel'] =  $vehicleInformation['make'].' '.$vehicleInformation['model'];
                $data['transmissionType'] =  $vehicleInformation['powertrainType'];

                $data['mileage'] =  $vehicleInformation['valuationMileage'];
                // $data['plateYear'] =  $plateYear;
                $data['vrm'] =  $vrm;
                // $data['otr'] =  $otr;
                $data['dealerForecourt'] =  $vehicleInformation['valuationFigures']['DealerForecourt'];
                $data['privateAverage'] =  $vehicleInformation['valuationFigures']['PrivateClean'];
                $data['partExchange'] =  $vehicleInformation['valuationFigures']['PartExchange'];
                $data['auction'] =  $vehicleInformation['valuationFigures']['Auction'];
                $data['tradeRetail'] =  $vehicleInformation['valuationFigures']['TradeRetail'];

                


                // save custom
                $postData = [
                    'vehicleImage' => $vehicleImage,
                    'vehicleFullName' => $vehicleFullName,
                    'vehiclePlateNumber' => $vehiclePlateNumber,
                    
                    'vehicleAveragePrice' => $vehicleAveragePrice,
                    'vehiclePoorPrice' => $vehiclePoorPrice,
                    'vehiclePartExchangePrice' => $partExchange,
                    
                    'userType' => $userType,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'phoneType' => $phoneType,
                    'next_step' => ''
                ];
            $post_id = saveVehicleValuation($postData);
            $postData['vehiclePoorPrice'];

            // Admin Email
            // $adminEmail = 'hello@sellmycartoday.uk';
            // $adminEmail = 'mufasseri@gmail.com';
            // $emailResponse =  mi_send_email($adminEmail,"$vehiclePlateNumber - Valuation", $html);
            $emailResponse = mi_sendAdminEmail($userData, $vehicleInformation);
            // Customer Email 
            $emailResponse = mi_sendCustomerEmail($firstName, $lastName, $email, $vehiclePlateNumber, $tradeAverage, $tradePoor);
            // $emailResponse =  mi_send_email($email,"$vehiclePlateNumber - Valuation", $customerMessage);

            $response = [
                "emailResponse" => $emailResponse,
                "status" => true,
                "msg" => "Email Sent",
                'data'=> $data,
                'post_id' => $post_id
            // "html" => $html
            ];
        //}

    }
    die(json_encode($response));

}

function mi_sendAdminEmail($userData, $vehicleInformation){

    $html = "<div>First Name: ".$userData['userType']." ".$userData['firstName']."</div>";
    $html .= "<div>Last Name: ".$userData['lastName']."</div>";
    $html .= "<div>Email: ".$userData['email']."</div>";
    // $html .= "<div>Postcode: $postcode</div>";
    $html .= "<div>Phone: ".$userData['phone']."</div>";
    $html .= "<div>Phone Type: ".$userData['phoneType']."</div>";
    $html .= "<br>";
    $html .= "<br>";
    $html .= "<table>";
        $html .= "<thead><tr><th>Name</th><th>Value</th></tr></thead>";
        $html .= '<tbody>';


        $html .= '<tr><td colspan="2"><h3>API Balance: '.$vehicleInformation['apiBalance'].'</h3></td></tr>';
        $html .= '<tr><td colspan="2"><h3>Vehicle Information</h3></td></tr>';
        
        $html .= "<tr><td>VRM</td><td>".$vehicleInformation['vrm']."</td></tr>";

        $html .= "<tr><td>Year</td><td>".$vehicleInformation['YearOfManufacture']."</td></tr>";
        $html .= "<tr><td>Mileage</td><td>".$vehicleInformation['millage']."</td></tr>";
        $html .= "<tr><td>Transmission</td><td>".$vehicleInformation['transmission']['TransmissionType']."</td></tr>";
        $html .= "<tr><td>Number Of Gears</td><td>".$vehicleInformation['transmission']['NumberOfGears']."</td></tr>";
        $html .= "<tr><td>Driving Axle</td><td>".$vehicleInformation['transmission']['DrivingAxle']."</td></tr>";
        $html .= "<tr><td>Drive Type</td><td>".$vehicleInformation['transmission']['DriveType']."</td></tr>";

        $html .= "<tr><td style=\"padding-right:150px\">Current Colour: </td><td>".$vehicleInformation['currentColour']."</td></tr>";
        $html .= "<tr><td>Original Colour: </td><td>".$vehicleInformation['originalColour']."</td></tr>";
        $html .= "<tr><td>Total Keepers: </td><td>".$vehicleInformation['keeperChangeList']."</td></tr>";
        $html .= "<tr><td>Total V5c Certificate List: </td><td>".$vehicleInformation['v5cCertificateList']."</td></tr>";

        $html .= "<tr><td>Engine Capacity: </td><td>".$vehicleInformation['engineCapacity']."</td></tr>";
        $html .= "<tr><td>Number Of Seats: </td><td>".$vehicleInformation['numberOfSeats']."</td></tr>";
        $html .= "<tr><td>Mass In Service Kg: </td><td>".$vehicleInformation['massInServiceKg']."</td></tr>";
        $html .= "<tr><td>Max Net Power Kw: </td><td>".$vehicleInformation['maxNetPowerKw']."</td></tr>";

        $html .= "<tr><td>Make: </td><td>".$vehicleInformation['make']."</td></tr>";
        $html .= "<tr><td>Range: </td><td>".$vehicleInformation['range']."</td></tr>";
        $html .= "<tr><td>Model Variant: </td><td>".$vehicleInformation['modelVariant']."</td></tr>";
        $html .= "<tr><td>Series: </td><td>".$vehicleInformation['series']."</td></tr>";
        $html .= "<tr><td>Mark: </td><td>".$vehicleInformation['mark']."</td></tr>";
        $html .= "<tr><td>Country Of Origin: </td><td>".$vehicleInformation['countryOfOrigin']."</td></tr>";
        $html .= "<tr><td>Variant Code: </td><td>".$vehicleInformation['variantCode']."</td></tr>";

        $html .= "<tr><td>Type Approval Category: </td><td>".$vehicleInformation['typeApprovalCategory']."</td></tr>";
        $html .= "<tr><td>Market Sector Code: </td><td>".$vehicleInformation['marketSectorCode']."</td></tr>";
        $html .= "<tr><td>Vehicle Class Code: </td><td>".$vehicleInformation['vehicleClass']."</td></tr>";
        $html .= "<tr><td>Taxation Class: </td><td>".$vehicleInformation['taxationClass']."</td></tr>";
        $html .= "<tr><td>Vehicle Class Code: </td><td>".$vehicleInformation['vehicleClass']."</td></tr>";
        $html .= "<tr><td>Fuel Type: </td><td>".$vehicleInformation['fuelType']."</td></tr>";
        $html .= "<tr><td>Power Train Type: </td><td>".$vehicleInformation['powertrainType']."</td></tr>";

        $html .= "<tr><td>Country Of Origin: </td><td>".$vehicleInformation['IdentificationDetails']['countryOfOrigin']."</td></tr>";

        // Technical Details
        $html .= '<tr><td colspan="2"><h4>Technical Details</h4></td></tr>';
        foreach($vehicleInformation['technicalDetails'] as $tDetailsKey => $tDetailsVal){
            $html .= "<tr><td>".$tDetailsKey." </td><td>".$tDetailsVal."</td></tr>";    
        }
        // Prices
        $html .= '<tr><td colspan="2"><h4>Prices</h4></td></tr>';
        foreach($vehicleInformation['valuationFigures'] as $valuationFiguresKey => $valuationFiguresVal){
            $html .= "<tr><td>".$valuationFiguresKey." </td><td>".$valuationFiguresVal."</td></tr>";    
        }
        $html .= '<tr><td colspan="2"><h4>Customer Prices</h4></td></tr>';
        $html .= "<tr><td>Trade Poor: </td><td>".$vehicleInformation['tradePoor']."</td></tr>";
        $html .= "<tr><td>Trade Average: </td><td>".$vehicleInformation['tradeAverage']."</td></tr>";
        
        $html .= '</tbody>';
    $html .= "</table>";

    // die($html);

    // Admin Email
    $adminEmail = 'hello@sellmycartoday.uk';
    // $adminEmail = 'mufasseri@gmail.com';
    $emailResponse =  mi_send_email($adminEmail,$vehicleInformation['vrm']." - Valuation", $html);
    return $emailResponse;
}


function mi_sendCustomerEmail($firstName, $lastName, $email, $vrm, $tradeAverage, $tradePoor){

    if($tradeAverage != ""){
        $customerMessage = '<div style="text-align:center">';
        $customerMessage .= '<img src="https://www.sellmycartoday.uk/smc/wp-content/uploads/2021/04/smctl.png" width="250">';
        $customerMessage .= "</div>";

        $customerMessage .= '<div style="text-align:center">';
        $customerMessage .= '<h3>Free instant payment and home visits available</h3>';
        $customerMessage .= "<br><hr><br>";
        $customerMessage .= "</div>";

        $customerMessage .= '<div style="text-align:center">';
        $customerMessage .= 'Dear '.$firstName.' '.$lastName.',<br><br>';

        $customerMessage .= '<p style="text-align:center">We recently valued your car at<br>
        Good Condition: <b>£'.$tradeAverage.'</b><br>
        Average Condition: <b>£'.$tradePoor.'</b><br>
        Sell your car in under an hour with a free home visit.<br>
        7 days price guarantee - <br>
        <h3></h3>Book your</h3>
        <b>Appointment Now!</b><br>
        Please call us directly on <a href="tel:+443337729283">03337 729 283</a>.</p>';
        $customerMessage .= "</div>";
    }else{
        $customerMessage = '<div style="text-align:center">';
        $customerMessage .= '';
        $customerMessage .= "</div>";

        $customerMessage .= '<div style="text-align:center">';
        $customerMessage .= '<h3>Free instant payment and home visits available</h3>';
        $customerMessage .= "<br><hr><br>";
        $customerMessage .= "</div>";

        $customerMessage .= '<div style="text-align:center">';
        $customerMessage .= 'Dear '.$firstName.' '.$lastName.',<br><br>';

        $customerMessage .= '<p style="text-align:center">We do not found your vehicle in our database.<br>
        But still we can give you a quote for your vehicle.<br>
        Sell your car in under an hour with a free home visit.<br>
        7 days price guarantee - <br>
        <h3></h3>Book your</h3>
        <b>Appointment Now!</b><br>
        Please call us directly on <a href="tel:+443337729283">03337 729 283</a>.</p>';
        $customerMessage .= "</div>";
    }
    // Customer Email 
    $emailResponse =  mi_send_email($email,"$vrm - Valuation", $customerMessage);
    return $emailResponse;


}

function getPercentages($poorPrice, $averagePrice){
    
    $pageId = 356;
    $return = ['poor_price' => $poorPrice, 'new_poor_price'=>$poorPrice, 'average_price'=>$averagePrice, 'new_average_price'=>$averagePrice];
    // poor
    $poorIncrementFor = get_field('field_645980d5cfe67',$pageId);
    $poorIncrementValue = (float) get_field('field_64597fe48e071',$pageId);
    $poorDecrementValue = (float) get_field('field_645980048e072',$pageId);

    switch($poorIncrementFor){
        case "Increment":
            $return['new_poor_price'] = $poorPrice + ($poorPrice * $poorIncrementValue)/100;
            
            break;
        case "Decrement":
            $return['new_poor_price'] = $poorPrice - ($poorPrice * $poorDecrementValue)/100;
            break;
        case "Decement":
            $return['new_poor_price'] = $poorPrice - ($poorPrice * $poorDecrementValue)/100;
            break;
        default:
            $return['new_poor_price'] = ($poorPrice - ($poorPrice * $poorDecrementValue)/100 ) ?? 'Call us for price: 03337 729 283';
            break;
    }
    $return['poor_price_action'] = $poorIncrementFor;
    

    // average
    $averageIncrementFor = get_field('field_645981951c80d',$pageId);
    $averageIncrementValue = get_field('field_645981b4edb68',$pageId);
    $averageDecrementValue = get_field('field_645981d0edb69',$pageId);
    // die($averageIncrementFor);
    switch($averageIncrementFor){
        case "Increment":
            $return['new_average_price'] = $averagePrice + ($averagePrice * $averageIncrementValue)/100;
            $return['average_price_action'] = 'Increment';
            break;
        case "Decrement":
            
            $return['new_average_price'] = $averagePrice - ($averagePrice * $averageDecrementValue)/100;
            $return['average_price_action'] = 'Decrement';
            break;
        case "Decement":
        
            $return['new_average_price'] = $averagePrice - ($averagePrice * $averageDecrementValue)/100;
            $return['average_price_action'] = 'Decrement';
            break;
    }
    
    
    return $return;
}


function saveVehicleValuation($data){

        // echo json_encode($data); exit;
        // Create the post object
        $post_data = array(
          'post_title' => $data['vehicleFullName'],
          'post_status' => 'draft',
          'post_author' => get_current_user_id(),
          'post_type' => 'vehicle-variation'
        );
        
        // try{
        // Insert the post into the database
        $post_id = wp_insert_post( $post_data );
        // print_r($post_id); exit;
        
        // Saving in Advance Custom
        update_field( 'field_64485d1a90226', $data['vehicleImage'], $post_id); //vehicle_image
        update_field( 'field_64485d3490227', $data['vehicleFullName'], $post_id); // vehicle_full_name
        
        // Price 
        update_field( 'field_6455100772e7a', $data['vehiclePartExchangePrice'], $post_id); // vehicle_part_exchange_price
        update_field( 'field_64485d57e3710', $data['vehicleAveragePrice'], $post_id); // vehicle_average_price
        update_field( 'field_64485d65e3711', $data['vehiclePoorPrice'], $post_id); //vehicle_poor_price

        update_field( 'field_64485d71e3712', $data['userType'], $post_id); //user_type
        update_field( 'field_64485d8b2d01a', $data['firstName'], $post_id); //first_name
        update_field( 'field_64485d962d01b', $data['lastName'], $post_id); //last_name
        update_field( 'field_64485d9e2d01c', $data['email'], $post_id); //email
        update_field( 'field_64485da52d01d', $data['phone'], $post_id); //phone
        update_field( 'field_64485da92d01e', $data['phoneType'], $post_id); //phone_type
        update_field( 'field_64485dbb2d01f', $data['next_step'], $post_id); //next_step
      
        return $post_id;
        // Redirect to the newly created post
        // wp_redirect( get_permalink( $post_id ) );
    //   }
      
}

// update next step
add_action( 'wp_ajax_mi_complete_next_step_valuation_action', 'mi_complete_next_step_valuation_action' );
add_action( 'wp_ajax_nopriv_mi_complete_next_step_valuation_action', 'mi_complete_next_step_valuation_action' );

function mi_complete_next_step_valuation_action(){

    $response = [
        "status" => false,
        "msg" => "Security check failed",
    ];
    
    // $nonce = sanitize_text_field($_POST['nonce']);
    $nonce = sanitize_text_field($_POST['nonce']);
    if ( ! wp_verify_nonce( $nonce, 'uk-vehicle-last-step-nonce' ) ) {
        die(json_encode($response));
    }else{
        $post_id = sanitize_text_field($_POST['post_id']);
        $next_step = sanitize_text_field($_POST['contact_type']);
        $firstName = sanitize_text_field($_POST['first_name']);
        $lastName = sanitize_text_field($_POST['last_name']);
        // update_post_meta( $post_id, 'next_step', $next_step );
        update_field( 'field_64485dbb2d01f', $next_step, $post_id); //next_step
        $response = [
            "status" => true,
            "msg" => "Next step saved",
            "lead_id" => $post_id
        ];

        // send email to admin to notify user finish his process.
        $subject = 'Last Step ';
        $message = 'Dear Admin,<br><br>';
        $message .= "$firstName $lastName wants to you contact to communicate  $next_step. you can view his car valuation information by <a href=\"https://www.sellmycartoday.uk/smc/wp-admin/post.php?post=$post_id&action=edit\">CLICK HERE</a>";
        $message .= "<br>Regards<br>".get_bloginfo('name');
        // mi_send_email('mufasseri@gmail.com', $subject, $message);
        mi_send_email('hello@sellmycartoday.uk', $subject, $message);
    }
    die(json_encode($response));

}


function prepareTable($data, $heading){
    $html = '<tr><td colspan="2"><h3>'.$heading.'</h3></td></tr>';
    foreach ($data as $key => $value){
        $html .= "<tr><td>$key</td><td>$value</td></tr>";
    }
    return $html;
}

function mi_send_email($to, $subject, $message, $file_path=''){



    // Set the recipient email address
    // $to = 'recipient@example.com';

    // Set the subject line
    // $subject = 'Email with attachment';

    // From email
    $fromName = 'Sell My Car Today';
    $fromEmail = 'info@sellmycartoday.uk';

    // Set the email message
    // $message = 'Here is the attachment you requested.';

    if($file_path){
        // Set the attachment file path
        $file_path = '/path/to/attachment/file.pdf';

        // Get the file content and encode it for email
        $file_content = file_get_contents($file_path);
        $encoded_file_content = chunk_split(base64_encode($file_content));
    }
    // Set the email headers, including the attachment
    $headers = "From: $fromName <$fromEmail>\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    if($file_path){
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n\r\n";
        $headers .= "--boundary\r\n";
        $headers .= "Content-Type: application/octet-stream; name=\"" . basename($file_path) . "\"\r\n";
        $headers .= "Content-Transfer-Encoding: base64\r\n";
        $headers .= "Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"\r\n\r\n";
        $headers .= $encoded_file_content . "\r\n";
        $headers .= "--boundary\r\n";
    }

    // Send the email
    return wp_mail($to, $subject, $message, $headers);
    // return wp_mail("mufasseri@gmail.com", "my message for you", "this is car valuation report");

}

// set header html
function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );



add_action( 'wp_ajax_mi_get_vehicle_info_action', 'mi_get_vehicle_info_action' );
add_action( 'wp_ajax_nopriv_mi_get_vehicle_info_action', 'mi_get_vehicle_info_action' );

function mi_get_vehicle_info_action() {
    
    $response = [
        "status" => false,
        "msg" => "Security check failed",
        'vehicleImageInfo'=> [],
        'vehicleInfo' => []
    ];
    
    // $nonce = sanitize_text_field($_POST['nonce']);
    $nonce = $_POST['nonce'];
    
    if ( ! wp_verify_nonce( $nonce, 'uk-vehicle-nonce' ) ) {
        die(json_encode($response));
    }else{
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

        $vehicleNumber = sanitize_text_field($_POST['vehicle_plate_number']);
        $mileage = sanitize_text_field($_POST['current_odometer_reading']);
        $vehicleInformation = new VehicleInformation();

        $response['status'] = true;
        $response['msg'] = 'Security check passed.';

        // images
        $vehicleImageData = $vehicleInformation->vehicleImageData($vehicleNumber);
        $response['image']['status'] = $vehicleImageData['response']->Response->StatusCode;
        $response['image']['imageUrl'] = $vehicleImageData['response']->Response->DataItems->VehicleImages->ImageDetailsList[0]->ImageUrl;

        // vehicleData
        $vehicleImageData = $vehicleInformation->vehicleData($vehicleNumber);
        $response['vdata']['completeData'] = $vehicleImageData['response'];
        $response['vdata']['generalData'] = $vehicleImageData['response']->Response->DataItems->TechnicalDetails->General;
        $response['vdata']['status'] = $vehicleImageData['response']->Response->StatusCode;
        $response['vdata']['vehicleRegistration'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration;
        $response['vdata']['technicalDetails'] = $vehicleImageData['response']->Response->DataItems->TechnicalDetails;
        
        // die(json_encode([$vehicleNumber, $mileage]));
        $valuationCanPrice = $vehicleInformation->valuationData($vehicleNumber, $mileage);

        
        $response['vrm'] = $valuationCanPrice['response']->RequestInformation->SearchTerm;
        $response['valuationData'] = $valuationCanPrice['response']->Results->ValuationDetails;
        $response['valuationDataNEW'] = $valuationCanPrice['response'];

        // valuation data
        $vehiclePrices = processPrices($valuationCanPrice['response']->Results->ValuationDetails->ValuationFigures);
        $response['tradePoor'] = ceil($vehiclePrices['TradePoor']);
        $response['tradeAverage'] = ceil($vehiclePrices['TradeAverage']);

        @session_start();
        $_SESSION['vData'] = $valuationCanPrice['response'];


        // $response['vehicleImageInfo']['vdata']['vehicleClass'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->VehicleClass;
        // $response['vehicleImageInfo']['vdata']['model'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->Model;
        // $response['vehicleImageInfo']['vdata']['Vrm'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->Vrm;
        // $response['vehicleImageInfo']['vdata']['ttransmissionType'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->TransmissionType;
        // $response['vehicleImageInfo']['vdata']['FuelType'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->FuelType;
        // $response['vehicleImageInfo']['vdata']['yearMonthFirstRegistered'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->YearMonthFirstRegistered;
        // $response['vehicleImageInfo']['vdata']['vinLast5'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->VinLast5;
        // $response['vehicleImageInfo']['vdata']['engineNumber'] = $vehicleImageData['response']->Response->DataItems->VehicleRegistration->EngineNumber;
        // $response['vehicleImageInfo']['vdata']['technicalDetails'] = $vehicleImageData['response']->Response->DataItems->TechnicalDetails;


        // 

        die(json_encode($response));
    }

}

function processPricesArray($vehicleFigures){
    $auction = $vehicleFigures['Auction'];
    $dealerForecourt = $vehicleFigures['DealerForecourt'];
    $onTheRoad = $vehicleFigures['OnTheRoad'];

    $partExchange = $vehicleFigures['PartExchange'];
    $privateAverage = $vehicleFigures['PrivateAverage'];
    $privateClean = $vehicleFigures['PrivateClean'];


    $tradeRetail = $vehicleFigures['TradeRetail'];

    $tradeAverage = $vehicleFigures['TradeAverage'];
    $tradePoor = $vehicleFigures['TradePoor'];

    
    // $vehicleFigures->TradeAverage = round($vehicleFigures->TradeAverage - ($vehicleFigures->TradeAverage *.15));
    // $vehicleFigures->TradeGood = round($vehicleFigures->TradeGood - ($vehicleFigures->TradeGood *.15));
    // $vehicleFigures->TradePoor = round($vehicleFigures->TradePoor - ($vehicleFigures->TradePoor *.15));
    return [
        'Auction' => $auction,
        'DealerForecourt' => $dealerForecourt,
        'OnTheRoad' => $onTheRoad,
        'PartExchange' => $partExchange,
        'PrivateAverage' => $privateAverage,
        'PrivateClean' => $privateClean,
        'TradeRetail' => $tradeRetail,
        'TradeAverage' => $tradeAverage,
        'TradePoor' => $tradePoor,
        'TradeAverage' => incrementDecrementValueInPrices($tradeAverage),
        'TradePoor' => incrementDecrementValueInPrices($tradePoor)
    ];
}
function processPrices($vehicleFigures){
// echo "VehicleFigures";
// print_r($vehicleFigures); exit;

    $auction = $vehicleFigures->Auction;
    $dealerForecourt = $vehicleFigures->DealerForecourt;
    $onTheRoad = $vehicleFigures->OnTheRoad;

    $partExchange = $vehicleFigures->PartExchange;
    $privateAverage = $vehicleFigures->PrivateAverage;
    $privateClean = $vehicleFigures->PrivateClean;


    $tradeRetail = $vehicleFigures->TradeRetail;

    $tradeAverage = $vehicleFigures->TradeAverage;
    $tradePoor = $vehicleFigures->TradePoor;

    
    // $vehicleFigures->TradeAverage = round($vehicleFigures->TradeAverage - ($vehicleFigures->TradeAverage *.15));
    // $vehicleFigures->TradeGood = round($vehicleFigures->TradeGood - ($vehicleFigures->TradeGood *.15));
    // $vehicleFigures->TradePoor = round($vehicleFigures->TradePoor - ($vehicleFigures->TradePoor *.15));
    return [
        'Auction' => $auction,
        'DealerForecourt' => $dealerForecourt,
        'OnTheRoad' => $onTheRoad,
        'PartExchange' => $partExchange,
        'PrivateAverage' => $privateAverage,
        'PrivateClean' => $privateClean,
        'TradeRetail' => $tradeRetail,
        'TradeAverage' => $tradeAverage,
        'TradePoor' => $tradePoor,
        'TradeAverage' => incrementDecrementValueInPrices($tradeAverage),
        'TradePoor' => incrementDecrementValueInPrices($tradePoor)
    ];
}

function incrementDecrementValueInPrices($value, $increment=false) {
    if($value == null){
        $value = 0;
    }
    $percentage = .15;
    if($value < 3000){
        $percentage = .20;
    }else if($value > 3000 && $value < 5000){
        $percentage = .15;
    }else if($value > 5000 && $value < 20000){
        $percentage = .10;
    }else{
        $percentage = .10;
    }
    if($increment){
        $value = $value + ($value * $percentage);
    }else{
        $value = $value - ($value * $percentage);   
    }
    ceil($value);
    return $value;
}


add_action('wp_ajax_my_form_submit', 'handle_form_submit');
add_action('wp_ajax_nopriv_my_form_submit', 'handle_form_submit');

function handle_form_submit() {
    // Verify nonce for security
    if (!check_ajax_referer('my_form_nonce', 'nonce', false)) {
        wp_send_json_error('Security check failed.');
    }

    // Parse form data
    parse_str($_POST['form_data'], $form_data);
    $recaptcha_token = $form_data['recaptcha_token'];

    // Verify reCAPTCHA v3
    $secret_key = '6LcjpRkrAAAAAHsIN5wj1lViPgEnC_OMxGtFAbkh'; // Replace with your secret key
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    $response = wp_remote_post($verify_url, array(
        'body' => array(
            'secret' => $secret_key,
            'response' => $recaptcha_token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        )
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('reCAPTCHA verification failed.');
    }

    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body, true);

    if ($result['success'] && $result['score'] >= 0.5) {
        // Sanitize and validate form data
        $name = sanitize_text_field($form_data['name']);
        $email = sanitize_email($form_data['email']);

        if (empty($name) || empty($email)) {
            wp_send_json_error('Please fill all required fields.');
        }

        // Process the form (e.g., send email)
        $to = 'your@email.com';
        $subject = 'New Form Submission';
        $message = "Name: $name\nEmail: $email";
        wp_mail($to, $subject, $message);

        wp_send_json_success('Form submitted successfully.');
    } else {
        wp_send_json_error('reCAPTCHA validation failed. Are you a bot?');
    }
}

// FTP
// QFi2((F)7N#O
// dev@sellmycartoday.uk