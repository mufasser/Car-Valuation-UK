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

        // $data = json_decode(wp_remote_retrieve_body($response), true);
        return $this->prepare_vehicle_valuation( $body );
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



        // vehicle description
        return [
            'valuationMilage' => $valuationMilage,
            'valuationTime' => $valuationTime,
            'vehicleDescription' => $vehicleDescription,
            'dateOfFirstRegistration' => $dateOfFirstRegistration,
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
    }

    
}
