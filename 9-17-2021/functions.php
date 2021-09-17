<?php
// Adding hooks to fix nonce ajax requests
include_once('inc/dwe_hooks.php');
include_once('shortcodes/shortcodes.php');

// Enqueue styles and scripts
function wpdocs_theme_name_scripts() {
	wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/font-awesome-4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'child-name', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

// Remove wp version param from any enqueued scripts - https://www.virendrachandak.com/techtalk/how-to-remove-wordpress-version-parameter-from-js-and-css-files/
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

function register_my_menu() {
    register_nav_menu('main-menu',__( 'Main Menu' ));
  }
  add_action( 'init', 'register_my_menu' );


function selected_post_shortcode( $atts ) {

	$postIds = array();
	if(isset($atts['post_id'])){
		$postIds = array($atts['post_id']);
	}

	ob_start();
	$args_query = array(
		'post_type' => array('post'),
		'post_status' => array('publish'),
		'posts_per_page' => 1,
		'order' => 'DESC',
		'post__in' => $postIds
	);

	$query = new WP_Query( $args_query );

	if ( $query->have_posts() ) { ?>
<div class="home-single-post post-item">
    <?php while ( $query->have_posts() ) { ?>
    <?php $query->the_post();
				$post_id = get_the_id(); ?>
    <div class="post-image">
        <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
        <?php if($imageUrl != ''){?>
        <a href="<? echo get_the_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>">
        </a>
        <?php } ?>
    </div>
    <div class="post-content">
        <div class="post-topic">
            <?php  $categories =  get_the_category($post_id); ?>
            <?php if(!empty($categories)){ ?>
            <?php foreach ($categories as $category) { ?>
            <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="post-header">
            <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        </div>
    </div>
    <div class="reading-time">
        <span class="date"><?php echo get_the_date(); ?> </span>

    </div>
    <?php } ?>
</div>
<?php } ?>
<?php wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;
}
add_shortcode( 'selected_post', 'selected_post_shortcode' );


function newsroom_post_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'post_type' => 'post',
			'max_items' => '-1',
			'taxonomies' => '97',
		),
		$atts
	);

	ob_start();
	$args_query = array(
	'post_type' => array('post'),
	'post_status' => array('publish'),
	'posts_per_page' => -1,
	'order' => 'DESC',
		'tax_query' => array(
			array(
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => array(97),
			'operator' => 'IN',
		),
		),
	);
	?><div class="blog-section"><?php
	$query = new WP_Query( $args_query );

	if ( $query->have_posts() ) { ?>
    <div class="post-listing">
        <?php while ( $query->have_posts() ) { ?>
        <div class="post-item ">
            <div class="post-item-inner">
                <?php $query->the_post();
				$post_id = get_the_id(); ?>
                <div class="post-image">
                    <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
                    <?php if($imageUrl != ''){?>
                    <a href="<? echo get_the_permalink(); ?>">
                        <img src="<?php echo $imageUrl; ?>">
                    </a>
                    <?php } ?>
                </div>
                <div class="post-content">
                    <div class="post-topic">
                        <?php  $categories =  get_the_category($post_id); ?>
                        <?php if(!empty($categories)){ ?>
                        <?php foreach ($categories as $category) { ?>
                        <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="post-header">
                        <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                    </div>
                </div>
                <div class="reading-time">
                    <span class="date"><?php echo get_the_date(); ?> </span>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<?php wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;
}
add_shortcode( 'newsroom_post', 'newsroom_post_shortcode' );


function latest_post_shortcode( $atts ) {

	// Attributes
	/*$atts = shortcode_atts(
		array(
			'post_type' => 'post',
			'max_items' => '-1',
			'taxonomies' => '97',
		),
		$atts
	);*/

	ob_start();
	$args_query = array(
		'post_type' => array('post'),
		'post_status' => array('publish'),
		'posts_per_page' => 1,
		'order' => 'DESC'
	);

	$query = new WP_Query( $args_query );

	if ( $query->have_posts() ) { ?>
<div id="hubspot-post" class="hubspot-post home-single-post post-item ">
    <?php while ( $query->have_posts() ) { ?>
    <?php $query->the_post();
				$post_id = get_the_id(); ?>
    <div class="post-image">
        <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
        <?php if($imageUrl != ''){?>
        <a href="<? echo get_the_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>">
        </a>
        <?php } ?>
    </div>
    <div class="post-content">
        <div class="post-topic">
            <?php  $categories =  get_the_category($post_id); ?>
            <?php if(!empty($categories)){ ?>
            <?php foreach ($categories as $category) { ?>
            <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="post-header">
            <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        </div>
    </div>
    <div class="reading-time">
        <span class="date"><?php echo get_the_date(); ?> </span>

    </div>
    <?php } ?>
</div>
<?php } ?>
<?php wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;
}
add_shortcode( 'latest_post', 'latest_post_shortcode' );

function newsroom_latest_post_shortcode( $atts ) {

	// Attributes
	/*$atts = shortcode_atts(
		array(
			'post_type' => 'post',
			'max_items' => '-1',
			'taxonomies' => '97',
		),
		$atts
	);*/

	ob_start();
	$args_query = array(
		'post_type' => array('post'),
		'post_status' => array('publish'),
		'posts_per_page' => 1,
		'order' => 'DESC',
		'tax_query' => array(
			array(
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => array(97),
			'operator' => 'IN',
		),
		),
	);

	$query = new WP_Query( $args_query );

	if ( $query->have_posts() ) { ?>
<div class="home-single-post post-item ">
    <?php while ( $query->have_posts() ) { ?>
    <?php $query->the_post();
				$post_id = get_the_id(); ?>
    <div class="post-image">
        <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
        <?php if($imageUrl != ''){?>
        <a href="<? echo get_the_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>">
        </a>
        <?php } ?>
    </div>
    <div class="post-content">
        <div class="post-topic">
            <?php  $categories =  get_the_category($post_id); ?>
            <?php if(!empty($categories)){ ?>
            <?php foreach ($categories as $category) { ?>
            <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="post-header">
            <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        </div>
    </div>
    <div class="reading-time">
        <span class="date"><?php echo get_the_date(); ?> </span>

    </div>
    <?php } ?>
</div>
<?php } ?>
<?php 
wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;
}
add_shortcode( 'newsroom_latest_post', 'newsroom_latest_post_shortcode' );



function newsroom_hubspot_latest_post_shortcode( $atts ) {

	// ob_start();
	// $args_query = array(
	// 	'post_type' => array('post'),
	// 	'post_status' => array('publish'),
	// 	'posts_per_page' => 1,
	// 	'order' => 'DESC',
	// 	'tax_query' => array(
	// 		array(
	// 		'taxonomy' => 'category',
	// 		'field' => 'term_id',
	// 		'terms' => array(97),
	// 		'operator' => 'IN',
	// 	),
	// 	),
	// );


	// $query = new WP_Query( $args_query );

    ob_start();
	$args_query = array(
		'post_type' => array('post'),
		'post_status' => array('publish'),
		'posts_per_page' => 1,
		'order' => 'DESC'
	);

	$query = new WP_Query( $args_query );


	if ( $query->have_posts() ) { ?>

<div id="newsroom-hubspot-post" class="home-single-post post-item ">
    <?php while ( $query->have_posts() ) { ?>
    <?php $query->the_post();
				$post_id = get_the_id(); ?>
    <div class="post-image demo-img">
        <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
        <?php if($imageUrl != ''){?>
        <a href="<? echo get_the_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>">
        </a>
        <?php } ?>
    </div>
    <div class="post-content">
        <div class="post-topic">
            <?php  $categories =  get_the_category($post_id); ?>
            <?php if(!empty($categories)){ ?>
            <?php foreach ($categories as $category) { ?>
            <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="post-header">
            <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        </div>
    </div>
    <div class="reading-time">
        <span class="date"><?php echo get_the_date(); ?> </span>

    </div>
    <?php } ?>
</div>
<?php } ?>
<?php 
wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;
}
add_shortcode( 'newsroom_hubspot_latest_post', 'newsroom_hubspot_latest_post_shortcode' );


/*------- newsroom Homepage Promo Tag post ---------*/

function newsroom_hubspot_homepage_promo_post_shortcode( $atts ) {
    ob_start();
	$args_query = array(
		'post_type' => array('post'),
		'post_status' => array('publish'),
		'posts_per_page' => 1,
		'order' => 'DESC',
	);

	$query = new WP_Query( $args_query );


	if ( $query->have_posts() ) { ?>

<div id="newsroom-homepage_promo_hubspot-post" class="home-single-post post-item ">
    <?php while ( $query->have_posts() ) { ?>
    <?php $query->the_post();
				$post_id = get_the_id(); ?>
    <div class="post-image">
        <?php $imageUrl = wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>
        <?php if($imageUrl != ''){?>
        <a href="<? echo get_the_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>">
        </a>
        <?php } ?>
    </div>
    <div class="post-content">
        <div class="post-topic">
            <?php  $categories =  get_the_category($post_id); ?>
            <?php if(!empty($categories)){ ?>
            <?php foreach ($categories as $category) { ?>
            <a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="post-header">
            <h2><a href="<? echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
        </div>
    </div>
    <div class="reading-time">
        <span class="date"><?php echo get_the_date(); ?> </span>

    </div>
    <?php } ?>
</div>
<?php } ?>
<?php 
wp_reset_postdata();
	$html = ob_get_contents();
			ob_end_clean();
			return $html;

}
add_shortcode( 'newsroom_hubspot_homepage_promo_post', 'newsroom_hubspot_homepage_promo_post_shortcode' );


?>