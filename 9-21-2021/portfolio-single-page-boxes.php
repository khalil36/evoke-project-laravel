<div class="portfolio-single__boxes-container">

    <?php if (get_field('ecommerce_conversion_rate', get_the_ID())) { ?>
        <div class="portfolio-single__box">
            <h5 class="box-label">Ecommerce Conversion Rate:</h5>
            <h2 class="box-data"><?= get_field('ecommerce_conversion_rate', get_the_ID()) ?></h2>
        </div>
    <?php }?>

    <?php if (get_field('transactions', get_the_ID())) { ?>
        <div class="portfolio-single__box">
            <h5 class="box-label">Transactions:</h5>
            <h2 class="box-data"><?= get_field('transactions', get_the_ID()) ?></h2>
        </div>
    <?php }?>

    <?php if (get_field('pageviews', get_the_ID())) { ?>
        <div class="portfolio-single__box">
            <h5 class="box-label">Pageviews:</h5>
            <h2 class="box-data"><?= get_field('pageviews', get_the_ID()) ?></h2>
        </div>
    <?php }?>

    <?php if (get_field('average_session_duration', get_the_ID())) { ?>
        <div class="portfolio-single__box">
            <h5 class="box-label">Average Session Duration:</h5>
            <h2 class="box-data"><?= get_field('average_session_duration', get_the_ID()) ?></h2>
        </div>
    <?php }?>

</div>


