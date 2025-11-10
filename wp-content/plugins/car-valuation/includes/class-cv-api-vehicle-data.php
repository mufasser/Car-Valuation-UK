<?php
/**
 * Handles Vehicle Data API requests
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class CV_API_VehicleData {

    private $api_base = 'https://uk.api.vehicledataglobal.com/r2/lookup';
    private $package_name = 'VehicleData';
    private $api_key = '90c2f03d-481c-4f6b-96e1-561413703732'; 
    // LiveKey: e387636a-8360-48fd-9d47-fde0e75fd40d

    /**
     * Fetch vehicle data by VRM
     *
     * @param string $vrm Vehicle registration mark
     * @return array|WP_Error
     */
    public function fetch_vehicle_data( $vrm ) {
        if ( empty( $vrm ) ) {
            return new WP_Error( 'missing_vrm', __( 'Vehicle registration is required.', 'car-valuation' ) );
        }

        $endpoint = add_query_arg(
            array(
                'packageName' => $this->package_name,
                'vrm'         => sanitize_text_field( $vrm ),
                'apikey'      => $this->api_key,
            ),
            $this->api_base
        );

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

        return $this->prepare_vehicle_data( $body );
    }

    /**
     * Prepare clean and structured vehicle data
     *
     * @param array $data
     * @return array
     */
    private function prepare_vehicle_data( $data ) {
        
        $results = $data['Results'] ?? [];

        $vehicle_details = $results['VehicleDetails']['VehicleIdentification'] ?? [];
        $history_details = $results['VehicleDetails']['VehicleHistory'] ?? [];
        // $technical_details = $results['VehicleDetails']['DvlaTechnicalDetails'] ?? [];
        $technical_details = $results['SmmtDetails']['TechnicalDetails'] ?? [];
        $smmt_details    = $results['SmmtDetails']['IdentificationDetails'] ?? [];

        $model_details   = $results['ModelDetails']['ModelIdentification'] ?? [];
        $body_details   = $results['ModelDetails']['BodyDetails'] ?? [];
        $dimensions_details   = $results['ModelDetails']['Dimensions'] ?? [];
        $weight_details   = $results['ModelDetails']['Weights'] ?? [];

        return array(

            'VRM'                       => $vehicle_details['Vrm'] ?? '',
            'DvlaModel'                 => $vehicle_details['DvlaModel'] ?? '',
            'DvlaMake'                  => $vehicle_details['DvlaMake'] ?? '',
            'DvlaWheelPlan'             => $vehicle_details['DvlaWheelPlan'] ?? '',
            'DvlaFuelType'             => $vehicle_details['DvlaFuelType'] ?? '',

            'CurrentColour'             => $history_details['ColourDetails']['CurrentColour'] ?? '',
            'NumberOfColourChanges'     => $history_details['ColourDetails']['NumberOfColourChanges'] ?? '',
            'OriginalColour'            => $history_details['ColourDetails']['OriginalColour'] ?? '',

            'TotalKeepers'              => $history_details['KeeperDetails']['KeeperChangeList'] ?? '',
            // 'TotalV5cCertificateList'   => $history_details['KeeperDetails']['TotalV5cCertificateList'] ?? '',
            
            // Technical Details
            'NumberOfSeats'             => $technical_details['NumberOfSeats'] ?? '',
            'NumberOfDoors'             => $technical_details['NumberOfDoors'] ?? '',
            'BodyStyle'             => $technical_details['BodyStyle'] ?? '',
            'EngineLocation'             => $technical_details['EngineLocation'] ?? '',
            'EngineMake'             => $technical_details['EngineMake'] ?? '',
            'EuroStatus'             => $technical_details['EuroStatus'] ?? '',
            'FuelType'             => $technical_details['FuelType'] ?? '',
            'EngineCapacityCc'             => $technical_details['EngineCapacityCc'] ?? '',
            'ValvesPerCylinder'             => $technical_details['ValvesPerCylinder'] ?? '',
            'NumberOfCylinders'             => $technical_details['NumberOfCylinders'] ?? '',
            'TransmissionType'             => $technical_details['TransmissionType'] ?? '',

            'DvlaModelDescription'      => $smmt_details['DvlaModelDescription'] ?? '',
            'SmmtMarketSectorCode'      => $smmt_details['SmmtMarketSectorCode'] ?? '',
            'Marque'                    => $smmt_details['Marque'] ?? '',
            'Series'                     => $smmt_details['Series'] ?? '',
            'Variant'                    => $smmt_details['Variant'] ?? '',
            'CountryOfOrigin'                    => $smmt_details['CountryOfOrigin'] ?? '',
            
            // Model Details
            'Make'                      => $model_details['Make'] ?? $vehicle_details['DvlaMake'] ?? '',
            'Range'                     => $model_details['Range'] ?? '',
            'Model'                     => $model_details['Model'] ?? '',
            'ModelVariant'              => $model_details['ModelVariant'] ?? '',
            'Series'                    => $model_details['Series'] ?? '',
            'Mark'                      => $model_details['Mark'] ?? '',

            // body style
            'BodyStyle'                 => $body_details['BodyStyle'] ?? '',
            // 'WheelbaseType'             => $body_details['WheelbaseType'] ?? '',
            // 'NumberOfAxles'             => $body_details['NumberOfAxles'] ?? '',
            // 'NumberOfDoors'             => $body_details['NumberOfDoors'] ?? '',
            // 'NumberOfSeats'             => $body_details['NumberOfSeats'] ?? '',

            // Dimensions & Dimensions
            'HeightMm'                 => $dimensions_details['HeightMm'] ?? '',
            'LengthMm'                 => $dimensions_details['LengthMm'] ?? '',
            'WidthMm'                  => $dimensions_details['WidthMm'] ?? '',
            'WheelbaseLengthMm'        => $dimensions_details['WheelbaseLengthMm'] ?? '',

            'KerbWeightKg'             => $weight_details['KerbWeightKg'] ?? '',
            'GrossTrainWeightKg'       => $weight_details['GrossTrainWeightKg'] ?? '',
            'GrossVehicleWeightKg'     => $weight_details['GrossVehicleWeightKg'] ?? '',
            'GrossCombinedWeightKg'    => $weight_details['GrossCombinedWeightKg'] ?? '',
            

            'CountryOfOrigin'           => $smmt_details['CountryOfOrigin'] ?? '',
        
            // 'CountryOfOriginDuplicate'  => $smmt_details['CountryOfOrigin'] ?? '',
        );
    }
}
