<?php
// print_r($vehicle_image_data);
$vehicle_image_data_set = base64_encode(serialize($vehicle_image_data));
$vehicle_data_set = base64_encode(serialize($vehicle_data));
// echo $vehicle_image_data['Image'];
?>
<div class="cv-result-container">
    <!-- Vehicle Info -->
    <div class="cv-vehicle-info">
        <?php if (!empty($vehicle_image_data['Image'])) : ?>
            <img src="<?php echo esc_url($vehicle_image_data['Image']); ?>" alt="Vehicle Image" class="cv-vehicle-image">
        <?php endif; ?>
        <h2 class="cv-vehicle-name">
            <?php echo '<small class="heading-caption">Vehicle:</small><br>'.esc_html($vehicle_data['DvlaModel'] ?? 'Get Your Car Valuation'); ?>
        </h2>
    </div>

    <!-- Lead Form -->
    <form action="" method="post" class="cv-lead-form" id="cv-lead-form">

        <input type="hidden" name="cv_vrm" value="<?php echo esc_attr($_GET['cv_vrm'] ?? ''); ?>">
        <input type="hidden" name="cv_mileage" value="<?php echo esc_attr($_GET['cv_mileage'] ?? ''); ?>">
        <input type="hidden" name="cv_page_source" value="<?php echo esc_attr($_GET['cv_page_source'] ?? 'unknown'); ?>">
        <input type="hidden" name="vehicle_data" value="<?php echo $vehicle_data_set; ?>">
        <input type="hidden" name="vehicle_image_data" value="<?php echo $vehicle_image_data_set; ?>">

        <div class="cv-form-row">
            <div class="cv-form-group">
                <!-- <label for="cv_name">Full Name*</label> -->
                <input type="text" name="cv_name" id="cv_name" required placeholder="FULL NAME">
            </div>
            <div class="cv-form-group">
                <!-- <label for="cv_email">Email*</label> -->
                <input type="email" name="cv_email" id="cv_email" required placeholder="EMAIL ADDRESS">
            </div>
        </div>
        <div class="cv-form-row">
            <div class="cv-form-group">
                <!-- <label for="cv_phone">Phone*</label> -->
                <input type="tel" name="cv_phone" id="cv_phone" required placeholder="PHONE NUMBER">
            </div>
            <div class="cv-form-group">
                <!-- <label for="cv_postcode">Postcode*</label> -->
                <input type="text" name="cv_postcode" id="cv_postcode" required placeholder="POST CODE">
            </div>
        </div>
        
        
        <!-- Damage Question as Toggle -->
        <div class="cv-form-row">
            <div class="cv-damage-question">
                <span>Any major vehicle damage or issues?</span>
                <div class="cv-toggle-switch">
                    <input type="radio" id="cv_damage_no" name="cv_damage" value="no" checked>
                    <label for="cv_damage_no">No</label>

                    <input type="radio" id="cv_damage_yes" name="cv_damage" value="yes">
                    <label for="cv_damage_yes">Yes</label>
                </div>
            </div>
        </div>

        <div class="cv-form-row cv-agreement">
            <label><input type="checkbox" name="cv_policy_agree" value="Yes" required> I agree to the terms & privacy policy.</label>
            <label><input type="checkbox" required name="cv_agree_to_contact" value="Yes"> I consent to being contacted regarding this valuation.</label>
        </div>
        
        

        <div class="cv-form-row">
            <button type="submit" class="cv-submit-btn">Submit</button>
        </div>

    </form>
</div>
