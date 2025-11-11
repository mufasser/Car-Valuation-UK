<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CV_API_Valuation {


    private $api_base = 'https://uk.api.vehicledataglobal.com/r2/lookup';
    private $package_name = 'ValuationDetailsv2';
    private $api_key = '90c2f03d-481c-4f6b-96e1-561413703732'; 
    // LiveKey: e387636a-8360-48fd-9d47-fde0e75fd40d



    public function get_valuation_data($vrm, $mileage=null) {

        if ( empty( $vrm ) ) {
            return new WP_Error( 'missing_vrm', __( 'Vehicle registration is required.', 'car-valuation' ) );
        }

        $params = array(
                'packageName' => $this->package_name,
                'vrm'         => sanitize_text_field( $vrm ),
                'apikey'      => $this->api_key
            );
        if($mileage){
            $params['mileage'] = $mileage;
        } 

        $endpoint = add_query_arg($params,$this->api_base);
        $response = wp_remote_get( $endpoint, array( 'timeout' => 20 ) );

        
        
        if ( is_wp_error( $response ) ) {
            print_r($response);
            return $response;
        }

        $code = wp_remote_retrieve_response_code( $response );
        if ( 200 !== $code ) {
            return new WP_Error( 'api_error', __( 'Vehicle data API request failed.', 'car-valuation' ), array( 'status' => $code ) );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( empty( $body['ResponseInformation']['IsSuccessStatusCode'] ) || $body['ResponseInformation']['StatusCode'] !== 0 ) {
            return new WP_Error( 'api_failed', __( 'Vehicle data not found or invalid response.', 'car-valuation' ), $body );
        }

        // die("Valuation: " . $endpoint);


        $customer_data = [
            'name' => sanitize_text_field( $_POST['cv_name'] ),
            'email' => sanitize_email( $_POST['cv_email'] ),
            'phone' => sanitize_text_field( $_POST['cv_phone'] ),
            'postcode' => sanitize_text_field( $_POST['cv_postcode'] ),
            'cv_damage' => sanitize_text_field( $_POST['cv_damage'] ),
            'cv_policy_agree' => sanitize_text_field( $_POST['cv_policy_agree'] ),
            'cv_agree_to_contact' => sanitize_text_field( $_POST['cv_agree_to_contact'] ),
            ];
        
        $vehicle_data = unserialize( base64_decode( sanitize_text_field( $_POST['vehicle_data'])));
        $vehicle_image_data = unserialize( base64_decode( sanitize_text_field( $_POST['vehicle_image_data'])));

        // valuation and price adjustments
        $valuation_info = $this->prepare_vehicle_valuation( $body );
        $adjustments =  [
            'global' => -15
        ];
        $adjusted_prices = $this->prepare_prices_for_customer( $valuation_info['prices'], $adjustments );
        
        // $valuation_data = [];
        // $vehicle_image_url = $vehicle_image_data['Image'];

        $response = [
            'vehicle_data'=>$vehicle_data,
            'vehicle_image_data'=>$vehicle_image_data,
            'prices'=>$valuation_info['prices'],
            'adjusted_prices'=>$adjusted_prices,
            'customer_data'=>$customer_data
        ];

        return $response;
    }

    /**
     * Prepare clean and structured vehicle valuation data
     *
     * @param array $data
     * @return array
     */
    private function prepare_vehicle_valuation( $data ) {

        $results = $data['Results'] ?? [];
        
        $valuationMilage = $results['ValuationDetails']['ValuationMileage'] ?? null;
        $valuationTime = $results['ValuationDetails']['ValuationTime'] ?? null;
        $vehicleDescription = $results['ValuationDetails']['VehicleDescription'] ?? null;
        $dateOfFirstRegistration = $results['ValuationDetails']['DateOfFirstRegistration'] ?? null;
        
       
        $valuationFigures = $data['Results']['ValuationDetails']['ValuationFigures'] ?? [];
        $onTheRoad = $valuationFigures['OnTheRoad'] ?? null;
        $dealerForecourt = $valuationFigures['DealerForecourt'] ?? null;
        $tradeRetail = $valuationFigures['TradeRetail'] ?? null;
        $privateClean = $valuationFigures['PrivateClean'] ?? null;
        $privateAverage = $valuationFigures['PrivateAverage'] ?? null;
        $partExchange = $valuationFigures['PartExchange'] ?? null;
        $auction = $valuationFigures['Auction'] ?? null;
        $tradeAverage = $valuationFigures['TradeAverage'] ?? null;
        $tradePoor = $valuationFigures['TradePoor'] ?? null;

        $valuation_base_data = [
            'valuationMilage' => $valuationMilage,
            'valuationTime' => $valuationTime,
            'vehicleDescription' => $vehicleDescription,
            'dateOfFirstRegistration' => $dateOfFirstRegistration
        ];

        $valuationPrices = [
            'onTheRoad' => $onTheRoad,
            'dealerForecourt' => $dealerForecourt,
            'tradeRetail' => $tradeRetail,
            'privateClean' => $privateClean,
            'privateAverage' => $privateAverage,
            'partExchange' => $partExchange,
            'auction' => $auction,
            'tradeAverage' => $tradeAverage,
            'tradePoor' => $tradePoor
        ];


        // vehicle description
        return [
            'valuation_base_data' => $valuation_base_data, 
            'prices' => $valuationPrices
        ];
    }

    private function prepare_prices_for_customer( $valuation_data, $adjustments = [] ) {

        // if the input is invalid or empty, just return it
        if ( empty( $valuation_data ) || ! is_array( $valuation_data ) ) {
            return $valuation_data;
        }

        // Clone the array so we don't mutate original
        $adjusted = $valuation_data;

        // Optional: global adjustment key
        $global_percentage = $adjustments['global'] ?? 0;

        // Define which keys are considered price fields
        $price_keys = [
            'onTheRoad',
            'dealerForecourt',
            'tradeRetail',
            'privateClean',
            'privateAverage',
            'partExchange',
            'auction',
            'tradeAverage',
            'tradePoor',
        ];

        foreach ( $price_keys as $key ) {
            if ( isset( $adjusted[$key] ) && is_numeric( $adjusted[$key] ) ) {
                // Get specific adjustment for this key if set, otherwise use global
                $percentage = $adjustments[$key] ?? $global_percentage;

                // Apply adjustment
                $factor = 1 + ( $percentage / 100 );
                $adjusted[$key] = round( $adjusted[$key] * $factor, 2 );
            }
        }

        // Add note for tracking
        $adjusted['AdjustmentMeta'] = [
            'AppliedAt' => current_time( 'mysql' ),
            'GlobalAdjustment' => $global_percentage,
            'IndividualAdjustments' => $adjustments,
        ];

        return $adjusted;
    }

    
}
