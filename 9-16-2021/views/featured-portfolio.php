 <!--  <div class="portfolio-item____132">
      <img src="https://creatingdigital-ubaid.dev.securedatatransit.com/wp-content/uploads/2021/01/s1.png" alt="">
      <img src="https://creatingdigital-ubaid.dev.securedatatransit.com/wp-content/uploads/2021/01/s2.png" alt="">
    </div> -->
<?php 
if( $portfolio->have_posts() ){
    ?>
        <div class="featured-portfolio__container">
            <?php
                while( $portfolio->have_posts() ){
                    $portfolio->the_post();
                     $portfolio_first_image = get_field('portfolio_first_image', get_the_ID());
                     $portfolio_second_image = get_field('portfolio_second_image', get_the_ID());
                     $portfolio_background_color = get_field('portfolio_background_color_', get_the_ID());
                    ?>
                  
                    <!-- <div class="feature-portfolio portfolio-grid-container"> -->
                      
                        <div class="portfolio_seaction portfolio-grid-item" style="background:<?php echo $portfolio_background_color;?> ;" >
                            <img src="https://creatingdigital-ubaid.dev.securedatatransit.com/wp-content/uploads/2021/01/s1.png" alt="">
                             <img  class="second-img__overlay" src="https://creatingdigital-ubaid.dev.securedatatransit.com/wp-content/uploads/2021/01/s2.png" alt="">

                           <!--  <img src="<?//= $portfolio_first_image ?>">    
                        
                            <img class="second-img__overlay" src="<?//= $portfolio_second_image ?>"> -->

                         </div>
                        
                    <!-- </div> -->
                    <?php
                }
            ?>
        </div>
    <?php
}

