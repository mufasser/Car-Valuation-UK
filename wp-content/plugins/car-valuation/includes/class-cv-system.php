<?php
// if ( ! defined( 'ABSPATH' ) ) exit;

// require_once plugin_dir_path(__FILE__) . 'class-cv-api-vehicleimage.php';
// require_once plugin_dir_path(__FILE__) . 'class-cv-api-valuation.php';

// class CV_System {

//     public function __construct() {
//         add_shortcode('car_valuation_form', [$this, 'render_search_form']);
//         add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
//         add_action('init', [$this, 'register_valuation_endpoint']);
//     }

//     public function enqueue_assets() {
//         wp_enqueue_style('cv-style', plugin_dir_url(__FILE__) . '../assets/style.css');
//     }

//     /**
//      * Register custom endpoint for results page (e.g. /car-valuation-result)
//      */
//     public function register_valuation_endpoint() {
//         add_rewrite_rule('^car-valuation-result/?', 'index.php?car_valuation_result=1', 'top');
//         add_rewrite_tag('%car_valuation_result%', '1');
//         add_action('template_redirect', [$this, 'load_result_template']);
//     }

//     /**
//      * Render shortcode form
//      */
//     public function render_search_form($atts) {
//         $atts = shortcode_atts(['page' => 'unknown'], $atts);

//         ob_start();
//         include plugin_dir_path(__FILE__) . '../templates/form-search.php';
//         return ob_get_clean();
//     }

//     /**
//      * Load valuation result template
//      */
//     public function load_result_template() {
//         if (get_query_var('car_valuation_result') != 1) return;

//         $vrm = sanitize_text_field($_GET['vrm'] ?? '');
//         $mileage = intval($_GET['mileage'] ?? 0);

//         if (!$vrm || !$mileage) {
//             wp_die('Invalid request — missing VRM or mileage.');
//         }

//         // API classes
//         $image_api = new CV_API_VehicleImage();
//         $valuation_api = new CV_API_Valuation();

//         $vehicle_data = $image_api->get_vehicle_data($vrm);
//         $valuation_data = $valuation_api->get_valuation_data($vrm, $mileage);

//         if (!$valuation_data) {
//             wp_die('Error fetching vehicle data.');
//         }

//         include plugin_dir_path(__FILE__) . '../templates/result-page.php';
//         exit;
//     }
// }
