<?php
/*
Plugin Name: Webmobi Vehicle Valuation
Plugin URI: https://www.webmobi.dev/
Description: Plugin use to search uk vehicle by using api https://ukvehicledata.co.uk/
Version: 1.0.0
Author: Mufassir Islam
Author URI: https://www.webmobi.dev/contact/
License: GPL2
*/

define('WM_SITE_BASE_URL',site_url());

define('WM_VEHICLE_PLUGIN_DIR',plugin_dir_path(__FILE__));
define('WM_VEHICLE_PLUGIN_URI',plugin_dir_url(__FILE__));

require_once WM_VEHICLE_PLUGIN_DIR.'/VehicleInformation.php';
require_once WM_VEHICLE_PLUGIN_DIR.'/vehicle-api.php';

function ukEnqueueScript(){
    
    // script
    wp_enqueue_script('ukv-bootstrap-script','https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', [], '5.2.3');
    wp_enqueue_script( 'mi-custom-js', plugins_url(  '/js/custom.js' , __FILE__ ) , ['jquery'], '1.0'  );
    

    // style
    wp_enqueue_style('ukv-bootstrap-style','https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',[],'5.2.3');
    
    wp_enqueue_style( 'mi-custom-css', plugins_url( '/css/style.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'ukEnqueueScript' );


function ukVehicleSearchForm(){
    
    $action = home_url("valuations");
    $form = '
    <section>
        <div class="container vehicle-search-form-container">
            <form action="'.$action.'" method="GET" id="form-search-vehicle-form" class="form vehicle-search-form">
                <div class="row">
                    <div class="col-md-12">
                          <div class="input-box">
                            <input class="vrm registration-ui" autocomplete="off" type="text" maxlength="7" name="numberPlate" placeholder="VRM">
                            <span class="unit">GB</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="controls">
                                <input type="text" class="form-control millage-input" required name="current_odometer_reading" placeholder="Millage" id="current-mileage">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" title="Value My Car"class="btn btn-block btn-primary button"><span>Get Valuation</span></a>
                    </div>
                </div> <!-- row -->
            </form>
        </div> <!-- container -->
    </section>
    ';
    return $form;
}
add_shortcode('uk_vehicle_search_form','ukVehicleSearchForm');



// // page routes defining moment
// add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){
//     $wp_rewrite->rules = array_merge(
//         [
//             'valuate/?$' => 'index.php?vehicleresult=1',
//             'valuations/?$' => 'index.php?vvv=1'
//         ],
//         $wp_rewrite->rules
//     );
    
// } );

add_filter( 'query_vars', function( $query_vars ){
    $query_vars[] = 'vehicleresult';
    $query_vars[] = 'vvv';
    return $query_vars;
} );


add_filter('template_include', 'miCustomTemplate', 1, 1);

function miCustomTemplate($template){
    
    $vehicleresult = intval( get_query_var( 'vehicleresult' ) );
    if ( $vehicleresult > 0 ) {
        $template = plugin_dir_path( __FILE__ ) . 'templates/vehicle-result.php';
        // return $template;
    }

    $valuations = intval( get_query_var( 'vvv' ) );
    if ( $valuations > 0 ) {
        $template = plugin_dir_path( __FILE__ ) . 'templates/vehicle-result.php';
    }
    // echo $template;
        return $template;
    
    }
