<?php
/*
Plugin Name: Announcement Plugin
Description: This plugin will be used to show anouncement before the header of a website.
Version: 1.0
Author: Creating Digital
Author URI: https://www.creatingdigital.com
*/


if ( ! defined( 'ABSPATH' ) ) exit();

class CD_Announcement_Plugin{

    function __construct(){
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );       
        add_action('admin_menu', array($this, 'create_pages')); 
        add_action('ebor_before_header', array($this, 'get_announcement_data')); 
        add_action('init', array( $this, 'register_acf_fields'));
    }

    function activate(){
        do_action( 'CD_Announcement_Plugin_activate' );
        flush_rewrite_rules();
    }

    function deactivate(){
        flush_rewrite_rules();
    }

    function create_pages(){

        if( function_exists('acf_add_options_page') ) {
            
            acf_add_options_page(array(
                'page_title'        => 'Announcement',
                'menu_title'        => 'Announcement',
                'menu_slug'         => 'announcement',
                'capability'        => 'edit_posts',
                'icon_url'          => 'dashicons-bell',
                'updated_message'   => 'Announcement Updated',
                'position'          => '46.6',
                'redirect'          => false
            ));
            
        }
    }

    function register_acf_fields ()  {

        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array (
                'title' => 'Announcement Fields',
                'fields' => array (
                    array (
                        'key' => 'field_582d62caed7e8',
                        'label' => 'Start Date',
                        'name' => 'start_date',
                        'type' => 'date_time_picker',
                        'required' => 0,
                        ),
                    array (
                        'key' => 'field_582d62caed7f8',
                        'label' => 'End Date',
                        'name' => 'end_date',
                        'type' => 'date_time_picker',
                        'required' => 0,
                        ),
                    array (
                        'key' => 'field_582d62caed7h9',
                        'label' => 'Announcement Content',
                        'name' => 'announcement_content',
                        'type' => 'wysiwyg',
                        'required' => 0,
                        ),
                    array (
                        'key' => 'field_582d62caed7d7',
                        'label' => 'link',
                        'name' => 'link',
                        'type' => 'text',
                        'required' => 0,
                        ),
                    array (
                        'key' => 'field_582d62caed7d8',
                        'label' => 'Background Color',  
                        'name' => 'background_color',
                        'type' => 'color_picker',
                        'required' => 0,
                        ),
                    array (
                        'key' => 'field_582d62caed7k8',
                        'label' => 'Font Color',  
                        'name' => 'font_color',
                        'type' => 'color_picker',
                        'required' => 0,
                        ),
                    ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'announcement',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
                ));

        endif;

    }


    function get_announcement_data()
    {

        if (get_field('start_date', 'option') && ( !get_field('end_date', 'option') || time() < strtotime(str_replace('/', '-', get_field('end_date', 'option'))) )){

            $bg_color = 'transparent';
            $color = 'inherit';

            if (get_field('background_color', 'option')) {
                $bg_color = get_field('background_color', 'option');
            }

            if (get_field('font_color', 'option')) {
                $color = get_field('font_color', 'option');
            }

            echo "<style>
                .announcement-bar {
                    background: ". $bg_color .";
                    color: ". $color .";
                    font-weight: 600;
                    font-size: 1.1rem;
                    letter-spacing: 1px;
                    text-align:center;
                    padding: 12px 15px;
                    position: relative;
                    width: 100%;
                    z-index: 1111;
                }
                .announcement-bar a{
                    text-decoration: none;
                }
                p{
                    margin:0 !important;
                    font-weight: 600;
                    color: ". $color .";
                }
                #header{
                    position: sticky;
                    position: -webkit-sticky;
                }
                .main-container {
                    margin-top: 0;
                }
                body, html {
                    overflow-x: unset;
                }
            </style>";

        // }

        // if (get_field('start_date', 'option') && ( !get_field('end_date', 'option') || time() < strtotime(str_replace('/', '-', get_field('end_date', 'option'))) ) ) {
  
            if (get_field('link', 'option') && get_field('link', 'option') != '#') {
                echo '<div class="announcement-bar"><a href="'.get_field('link', 'option').'"><div class="container">'.get_field('announcement_content', 'option').'</div></a></div>';
            } else {
                echo '<div class="announcement-bar"><div class="container">'.get_field('announcement_content', 'option').'</div></div>';
            }

        }

    }
    
}

if (class_exists('CD_Announcement_Plugin')) {
    $Announcement = new CD_Announcement_Plugin();
}



