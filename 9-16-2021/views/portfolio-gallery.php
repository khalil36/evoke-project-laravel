<?php 
if( have_rows('portfolio_gallery', get_the_ID()) ){
    while( have_rows('portfolio_gallery' , get_the_ID()) ){
        the_row();
        ?>
        <div class="portfolio__gallery-image">
            <img src="<?php the_sub_field('image', get_the_ID())?>">
        </div>
        <?php
    }
}