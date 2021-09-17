<?php
class Cd_Theme_Shortcodes{

	function __construct(){
		add_shortcode( 'cd_team' , [$this , 'cd_team'] );
		add_shortcode( 'featured_portfolio' , [$this , 'featured_portfolio'] );
		add_shortcode( 'portfolio_gallery' , [$this , 'portfolio_gallery'] );
	}

	public function cd_team(){
		$team = new WP_Query([
            'post_type' => 'team',
            'posts_per_page' => 20,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ]);
        ob_start();
        include( CHILD_THEME_DIR . '/inc/views/cd_team.php' );
        wp_reset_query();
		return ob_get_clean();
	}

	public function featured_portfolio(){
		$portfolio = new WP_Query([
            'post_type' => 'portfolio',
            'posts_per_page' => 9,
            'orderby' => 'date',
            'order' => 'Desc'
        ]);
        ob_start();
        include( CHILD_THEME_DIR . '/inc/views/featured-portfolio.php' );
        wp_reset_query();
		return ob_get_clean();
	}

	public function portfolio_gallery(){

        ob_start();
        include( CHILD_THEME_DIR . '/inc/views/portfolio-gallery.php' );
        wp_reset_query();
		return ob_get_clean();

	}
}

add_action('init', function(){
    new Cd_Theme_Shortcodes();
}, 99);