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
require_once CV_PLUGIN_PATH . 'includes/class-cv-api-valuation.php';
require_once CV_PLUGIN_PATH . 'includes/email/class-cv-email-handler.php';
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
            
            wp_enqueue_script('cv-ajax', plugin_dir_url(__FILE__) . 'assets/cv-ajax.js', 
            array('jquery'), '1.0', true);

       
            wp_localize_script('cv-ajax', 'cv_ajax_object', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cv_ajax_nonce')
            ]);

        }
    }

    public function handle_valuation_ajax() {

        check_ajax_referer('cv_ajax_nonce', 'nonce');

        parse_str($_POST['form_data'], $form_data);
        $vrm = sanitize_text_field($_POST['cv_vrm']);
        $mileage = !empty($_POST['cv_mileage']) ? intval($_POST['cv_mileage']) : 18000;

        if (empty($vrm)) {
            wp_send_json_error(['message' => 'Missing VRM']);
        }

        // print($_POST['form_data']); exit;
        // Call valuation API
        $valuation_api = new CV_API_Valuation();
        $valuation_data = $valuation_api->get_valuation_data($vrm, $mileage);
        $valuation_data['vehicle_data']['Mileage'] = $mileage;

        // send emails
        $email_handler = new CV_Email_Handler();
        $email_handler->send_valuation_emails(
            $valuation_data['customer_data'],
            $valuation_data['vehicle_data'],
            $valuation_data['prices'],
            $valuation_data['adjusted_prices'],
            $valuation_data['vehicle_image_data']['Image']
        );

        // wp_send_json_success([
        //     // 'valuation' => $valuation_data,
        //     'vrm' => $valuation_data['vehicle_data']['VRM'],
        //     'mileage' => $mileage,
        //     'goodPrice' => $valuation_data['adjusted_prices']['tradeAverage'],
        //     'averagePrice' => $valuation_data['adjusted_prices']['tradePoor'],
        // ]);

        wp_send_json_success([
            'vehicle' => [
                'vrm'  => $valuation_data['vehicle_data']['VRM'],
                'mileage' => $mileage,
                'make'  => $valuation_data['vehicle_data']['Make'],
                'model' => $valuation_data['vehicle_data']['Range']
            ],
            'prices' => [
                'tradeAverage' => $valuation_data['adjusted_prices']['tradeAverage'],
                'tradePoor'    => $valuation_data['adjusted_prices']['tradePoor'],
            ],
            'image' => $valuation_data['vehicle_image_data']['Image']
        ]);

        // $valuation = $valuation_data['Results']['ValuationDetails']['ValuationFigures'];

        // wp_send_json_success([
        //     'valuation' => $valuation,
        //     'vehicle' => $valuation_data['Results']['ValuationDetails']['VehicleDescription']
        // ]);
    }

}

new CV_System();

