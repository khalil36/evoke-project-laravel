<?php
/*
Plugin Name: Announcement Plugin
Description: This plugin will be used to show anouncement before the header of a website.
Version: 1.0
Author: Creating Digital
Author URI: https://www.creatingdigital.com
*/


if ( ! defined( 'ABSPATH' ) ) exit();

class AnnouncementPlugin{

    function __construct(){
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );       
        add_action('admin_menu', array($this, 'CreatePages')); 
        add_action('wp_body_open', array($this, 'getAnnouncementData')); 
    }
    

    public function activate(){
        do_action( 'AnnouncementPlugin_activate' );
        flush_rewrite_rules();
    }

    public function deactivate(){
        flush_rewrite_rules();
   
    }

    function CreatePages(){

        if( function_exists('acf_add_options_page') ) {
            
            acf_add_options_page(array(
                'page_title'        => 'Announcement',
                'menu_title'        => 'Announcement',
                'menu_slug'         => 'announcement',
                'capability'        => 'edit_posts',
                'icon_url'          => 'dashicons-bell',
                'updated_message'   => __("Announcement Data Updated", 'acf'),
                'position'          => '46.6',
                'redirect'          => false
            ));
            
        }
    }

    function getAnnouncementData()
    {
        echo "<style>
            .announcement-bar {
                background: ".get_field('background_color', 'option').";
                color: #fff;
                font-weight: 600;
                font-size: 1.1rem;
                letter-spacing: 1px;
                text-align:center;
                padding: 12px 0;
            }
            p{
                margin-bottom:0;
                margin-top: -5px;
            }
        </style>";
        echo '<a href="'.get_field('link', 'option').'"><div class="announcement-bar">'.get_field('announcement_content', 'option').'</div></a>';
    }
    
}

if (class_exists('AnnouncementPlugin')) {
    $Announcement = new AnnouncementPlugin();
}



