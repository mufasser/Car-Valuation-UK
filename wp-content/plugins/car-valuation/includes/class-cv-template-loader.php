<?php
if (!defined('ABSPATH')) exit;

class CV_Template_Loader {
    public static function get_template($template_name, $vars = array()) {
        $template_path = CV_PLUGIN_PATH . 'templates/' . $template_name;
        if (file_exists($template_path)) {
            extract($vars); // Extract variables for template
            // echo $cv_page_source;
            include $template_path;
        } else {
            echo '<p>Template not found: ' . esc_html($template_name) . '</p>';
        }
    }
}
