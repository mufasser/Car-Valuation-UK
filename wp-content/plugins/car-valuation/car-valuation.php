<?php
/**
 * Plugin Name: Car Valuation Plugin
 * Description: Vehicle valuation and lead capture system.
 * Version: 1.0.0
 * Author: Mufassir Islam
 */

if (!defined('ABSPATH')) exit;

define('CV_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CV_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once CV_PLUGIN_PATH . 'includes/class-cv-api-client.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-template-loader.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-api-vehicleimage.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-api-vehicle-data.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-shortcodes.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-leads-handler.php';
require_once CV_PLUGIN_PATH . 'includes/class-cv-utils.php';

final class CV_System {
    public function __construct() {
        add_action('init', [$this, 'init']);
        // Enqueue scripts & styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        add_action('wp_ajax_cv_get_valuation', [$this, 'handle_valuation_ajax']);
        add_action('wp_ajax_nopriv_cv_get_valuation', [$this, 'handle_valuation_ajax']);
    }

    public function init() {
        new CV_Shortcodes();
    }

    public function enqueue_assets() {
        // Enqueue only on frontend
        if (!is_admin()) {
            // CSS
            wp_enqueue_style(
                'cv-plugin-style',
                CV_PLUGIN_URL . 'assets/cv-style.css',
                array(),
                '1.0.0'
            );

            // JS
            wp_enqueue_script(
                'cv-plugin-script',
                CV_PLUGIN_URL . 'assets/cv-script.js',
                array('jquery'),
                '1.0.0',
                true
            );

            // Pass ajax URL and nonce to JS if needed
            wp_localize_script('cv-plugin-script', 'cv_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('cv_plugin_nonce')
            ));
            
            wp_enqueue_script('cv-ajax', plugin_dir_url(__FILE__) . 'assets/js/cv-ajax.js', 
            array('jquery'), '1.0', true);

        }
    }

    public function handle_valuation_ajax() {
        check_ajax_referer('cv_ajax_nonce', 'nonce');

        parse_str($_POST['form_data'], $form_data);
        $vrm = sanitize_text_field($form_data['cv_vrm']);
        $mileage = !empty($form_data['cv_mileage']) ? intval($form_data['cv_mileage']) : 18000;

        if (empty($vrm)) {
            wp_send_json_error(['message' => 'Missing VRM']);
        }

        // Call valuation API
        $valuation_api = new CV_API_Valuation();
        $valuation_data = $valuation_api->get_vehicle_valuation($vrm, $mileage);

        if (!$valuation_data || empty($valuation_data['Results']['ValuationDetails'])) {
            wp_send_json_error(['message' => 'Failed to retrieve valuation.']);
        }

        $valuation = $valuation_data['Results']['ValuationDetails']['ValuationFigures'];

        wp_send_json_success([
            'valuation' => $valuation,
            'vehicle' => $valuation_data['Results']['ValuationDetails']['VehicleDescription']
        ]);
    }

}

new CV_System();

