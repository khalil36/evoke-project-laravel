<?php


class Evisit_Shortcodes{

	function __construct(){
		add_shortcode( 'state_telemedicine_policies' , [$this , 'state_telemedicine_policies'] );
	}

	public function state_telemedicine_policies(){
		$states = new WP_Query([
            'post_type' => 'state_policies',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
        ob_start();
        require get_theme_file_path('/shortcodes/views/state-telemedicine-policies.php');
        wp_reset_query();
		return ob_get_clean();
	}

}

add_action('init', function(){
    new Evisit_Shortcodes();
}, 99);