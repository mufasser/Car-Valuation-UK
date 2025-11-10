<?php
if (!defined('ABSPATH')) exit;

class CV_API_VehicleImage {

    private $api_base = 'https://uk.api.vehicledataglobal.com/r2/lookup';
    private $package_name = 'VehicleImageData';
    private $api_key = '90c2f03d-481c-4f6b-96e1-561413703732'; 

    public function get_vehicle_image($vrm) {
        if (empty($vrm)) return [];

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

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        return $this->prepare_image_data($data);
    }

    private function prepare_image_data( $data ) {
        
        $results = $data['Results'] ?? [];
        
        // print_r($data);

        $vrm = $data['RequestInformation']['SearchTerm'] ?? [];
        $vehicle_image_list = $results['VehicleImageDetails']['VehicleImageList'] ?? [];
        return [
            'VRM' => $vrm,
            'Image' => $vehicle_image_list[0]['ImageUrl'] ?? '',
            'Colour' => $vehicle_image_list[0]['Colour'] ?? '',
            'Description' => $vehicle_image_list[0]['Description'] ?? '',
            'ImageList' => $vehicle_image_list,
            ];
    }
}
