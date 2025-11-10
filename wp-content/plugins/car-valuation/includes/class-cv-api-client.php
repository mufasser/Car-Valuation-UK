<?php
if (!defined('ABSPATH')) exit;

class CV_API_Client {
    private $valuation_endpoint = 'https://uk.api.vehicledataglobal.com/r2/lookup?packagename=ValuationDetailsv2';
    private $image_endpoint = 'https://uk.api.vehicledataglobal.com/r2/lookup?packageName=VehicleImageData';
    private $api_key = '90c2f03d-481c-4f6b-96e1-561413703732';

    public function get_vehicle_data($vrm) {
        $url = "{$this->image_endpoint}&vrm={$vrm}";
        return $this->fetch($url);
    }

    public function get_valuation($vrm, $mileage) {
        $url = "{$this->valuation_endpoint}&vrm={$vrm}&mileage={$mileage}&apikey={$this->api_key}";
        return $this->fetch($url);
    }

    private function fetch($url) {
        $response = wp_remote_get($url);
        if (is_wp_error($response)) return false;
        return json_decode(wp_remote_retrieve_body($response), true);
    }
}
