<?php 
if( $states->have_posts() ){
    ?>
    <div class="states-telemedicine-container">
        <select name="state_telemedicine_policies" id="state_telemedicine_policies">
            <option value="not_selected">Select State</option>
        
        <?php
        while( $states->have_posts() ){
            $states->the_post();  ?>

            <option value="<?= get_permalink() ?>"><?= get_the_title() ?></option>

        <?php } ?>
        </select>
    </div>
    <?php
}