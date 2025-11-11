<?php
if (!defined('ABSPATH')) exit;

class CV_Shortcodes {
    public function __construct() {
        add_shortcode('car_valuation_form', [$this, 'render_search_form']);
        add_shortcode('car_valuation_result', [$this, 'render_result_page']);
    }

    public function render_search_form($atts) {
        // Default attributes
        $atts = shortcode_atts(
            array(
                'page' => 'unknown', // default page if not passed
                'display' => 'cv-form-block', // default form display if not passed
            ),
            $atts,
            'cv_search_form'
        );

        // Make page source available to template
        $cv_page_source = sanitize_text_field($atts['page']);
        $form_display = sanitize_text_field($atts['display']);

        ob_start();
        // Pass variable to template
        CV_Template_Loader::get_template('form-search.php', array(
            'cv_page_source' => $cv_page_source,
            'form_display' => $form_display
        ));
        return ob_get_clean();
    }


    public function render_result_page() {


        $cv_vrm = isset($_GET['cv_vrm']) ? sanitize_text_field($_GET['cv_vrm']) : '';
        $cv_mileage = isset($_GET['cv_mileage']) ? sanitize_text_field($_GET['cv_mileage']) : '';
        $cv_page_source = isset($_GET['cv_page_source']) ? sanitize_text_field($_GET['cv_page_source']) : '';

        if (empty($cv_vrm)) {
            // return do_shortcode('[car_valuation_form page="' . $cv_page_source . '"]').'<p>Please enter a valid registration number. <a href="' . site_url('/') . '">Go back to search form</a></p>';
            return do_shortcode('[car_valuation_form page="' . $cv_page_source . '"]').'<p>Please enter a valid registration number.</p>';
        }


        // ✅ Fetch vehicle image from API
        $vehicle_api = new CV_API_VehicleImage();
        $vehicle_image_data = $vehicle_api->get_vehicle_image($cv_vrm);
        $vehicleDetailsList = $vehicle_image_data['Results']['VehicleImageDetails']['VehicleImageList'];

        //print_r($vehicleDetailsList); exit;

        $cv_vehicle_image = !empty($vehicleDetailsList['ImageUrl'])
            ? $vehicleDetailsList['ImageUrl']
            : CV_PLUGIN_URL . 'assets/img/default-car.webp';

        $cv_vehicle_color = !empty($vehicleDetailsList['Color']) 
            ? $vehicleDetailsList['Color'] 
            : '';

        $cv_vehicle_description = !empty($vehicleDetailsList['Description']) 
            ? $vehicleDetailsList['Description'] 
            : '';


        // ✅ Call Valuation API to get detailed info (no valuation process yet)
        $valuation_api = new CV_API_VehicleData();
        $vehicle_data = $valuation_api->fetch_vehicle_data($cv_vrm);

        // print_r($valuation_data);

        // $vehicle_description = $valuation_data['Results']['ValuationDetails']['VehicleDescription'] ?? 'Vehicle details not found';
        // $date_first_registered = $valuation_data['Results']['ValuationDetails']['DateOfFirstRegistration'] ?? '';
        // $valuation_generated_at = $valuation_data['Results']['ValuationDetails']['GeneratedAt'] ?? '';


        ob_start();
        include CV_PLUGIN_PATH . 'templates/result-page.php';
        return ob_get_clean();
    }
}
