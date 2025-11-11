<div class="vehicle-search-form-container <?php echo esc_attr($form_display ?? 'cv-form-block'); ?>">
    <form action="<?php echo esc_url(site_url('/car-valuation-result')); ?>" method="get" class="cv-vrm-form form vehicle-search-form">
        <input type="hidden" name="car_valuation_result" value="1">
        <input type="hidden" name="cv_page_source" value="<?php echo esc_attr($cv_page_source ?? 'unknown'); ?>">

        
            <div class="input-box">
                <input class="vrm registration-ui" autocomplete="off" type="text" maxlength="7" name="cv_vrm" placeholder="VRM">
                <span class="unit">GB</span>
            </div>            
            <div class="controls">
                <input type="text" class="form-control millage-input" required name="cv_mileage" placeholder="Millage" id="current-mileage">
            </div>
        <button type="submit" title="Get Car Valuation"class="btn btn-block btn-primary button btn-cv"><span>Get Valuation</span></a>
    </form>
</div>
    