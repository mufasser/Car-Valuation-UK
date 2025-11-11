<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CV_Email_Handler {

    private $admin_email;

    public function __construct() {
        $this->admin_email = get_option( 'admin_email' );
    }

    /**
     * Send both admin and customer emails
     */
    public function send_valuation_emails( $customer_data, $vehicle_data, $valuation_data, $adjusted_prices, $vehicle_image_url ) {
        $this->send_admin_email( $customer_data, $vehicle_data, $valuation_data, $adjusted_prices, $vehicle_image_url );
        $this->send_customer_email( $customer_data, $vehicle_data, $adjusted_prices, $vehicle_image_url );
    }

    /**
     * Admin email — includes all valuation and adjustment data
     */
    private function send_admin_email( $customer_data, $vehicle_data, $valuation_data, $adjusted_prices, $vehicle_image_url ) {

        $subject = "New Vehicle Valuation Lead - " . esc_html( $vehicle_data['VRM'] ?? 'Unknown' );

        ob_start();
        ?>
        <h2>New Car Valuation Lead</h2>
        <p><strong>Name:</strong> <?php echo esc_html($customer_data['name']); ?><br>
        <strong>Email:</strong> <?php echo esc_html($customer_data['email']); ?><br>
        <strong>Phone:</strong> <?php echo esc_html($customer_data['phone']); ?><br>
        <strong>Postcode:</strong> <?php echo esc_html($customer_data['postcode']); ?><br>
        <strong>Mileage:</strong> <?php echo esc_html($vehicle_data['Mileage'] ?? 'N/A'); ?><br>
        <strong>VRM:</strong> <?php echo esc_html($vehicle_data['VRM'] ?? 'N/A'); ?></p>

        <?php if ( $vehicle_image_url ) : ?>
            <p><img src="<?php echo esc_url($vehicle_image_url); ?>" alt="Vehicle Image" style="max-width:300px;border-radius:8px;"></p>
        <?php endif; ?>

        <h3>Vehicle Details</h3>
        <ul>
            <?php foreach ( $vehicle_data as $key => $value ) : ?>
                <li><strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Original Valuation Data</h3>
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;width:100%;">
            <tr><th>Price Type</th><th>Original</th><th>Adjusted</th></tr>
            <?php foreach ( $valuation_data as $key => $value ) :
                if ( is_numeric( $value ) && isset( $adjusted_prices[$key] ) ) : ?>
                    <tr>
                        <td><?php echo esc_html($key); ?></td>
                        <td>£<?php echo number_format($value, 2); ?></td>
                        <td>£<?php echo number_format($adjusted_prices[$key], 2); ?></td>
                    </tr>
                <?php endif;
            endforeach; ?>
        </table>
        <?php
        $message = ob_get_clean();
        // echo $message; exit;

        wp_mail( $this->admin_email, $subject, $message, [ 'Content-Type: text/html; charset=UTF-8' ] );
        wp_mail( 'mufasseri@gmail.com', $subject, $message, [ 'Content-Type: text/html; charset=UTF-8' ] );
    }

    /**
     * Customer email — simplified, friendly, and brand-styled
     */
    private function send_customer_email( $customer_data, $vehicle_data, $adjusted_prices, $vehicle_image_url ) {
        $subject = "Your Car Valuation - " . esc_html( $vehicle_data['VRM'] ?? '' );

        ob_start();
        ?>
        <div style="font-family:Arial, sans-serif;max-width:600px;margin:auto;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <div style="background:#000;color:#fff;padding:15px 20px;text-align:center;">
                <h2 style="margin:0;">Your Car Valuation</h2>
            </div>
            <div style="padding:20px;text-align:center;">
                <?php if ( $vehicle_image_url ) : ?>
                    <img src="<?php echo esc_url($vehicle_image_url); ?>" alt="Vehicle Image" style="width:100%;max-width:400px;border-radius:8px;margin-bottom:10px;">
                <?php endif; ?>

                <h3 style="margin-bottom:5px;"><?php echo esc_html( $vehicle_data['Make'] ?? 'Your Vehicle' ); ?></h3>
                <p style="color:#666;margin-top:0;">VRM: <?php echo esc_html( $vehicle_data['VRM'] ?? 'N/A' ); ?></p>

                <div style="margin:20px 0;">
                    <p><strong>Trade Average:</strong> £<?php echo number_format( $adjusted_prices['tradeAverage'] ?? 0, 2 ); ?></p>
                    <p><strong>Trade Poor:</strong> £<?php echo number_format( $adjusted_prices['tradePoor'] ?? 0, 2 ); ?></p>
                </div>

                <p style="color:#666;">Thank you for using our valuation service. Our team will contact you shortly.</p>
                <a style="color:red" href="tel:+442080098009">Call: +44 (0) 20 8009 8009</a> | <a style="color:red" href="https://sellmyaudi.com">SellMyAudi.com</a>
            </div>
        </div>
        <?php
        $message = ob_get_clean();

        // echo $message; exit;

        wp_mail( $customer_data['email'], $subject, $message, [ 'Content-Type: text/html; charset=UTF-8' ] );
    }
}
