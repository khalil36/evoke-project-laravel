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

        acf_add_local_field_group(array(
            'key' => 'group_61448d80f24dc',
            'title' => 'Announcement Fields',
            'fields' => array(
                 array(
                    'key' => 'field_61448ef5928cb',
                    'label' => 'Enable Announcement Bar',
                    'name' => 'enable_announcement_bar',
                    'type' => 'checkbox',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'yes' => 'Yes',
                    ),
                    'allow_custom' => 0,
                    'default_value' => array(
                    ),
                    'layout' => 'vertical',
                    'toggle' => 0,
                    'return_format' => 'value',
                    'save_custom' => 0,
                ),
                array(
                    'key' => 'field_61448d9bc8908',
                    'label' => 'Start Date (WP ENGINE caching does not work with start/end time)',
                    'name' => 'start_date',
                    'type' => 'date_time_picker',
                    'instructions' => '',
                    'required' => 0,
                    'disabled' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d H:i:s',
                    'return_format' => 'm/d/Y g:i a',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_61448dcfc8909',
                    'label' => 'End Date (WP ENGINE caching does not work with start/end time)',
                    'name' => 'end_date',
                    'type' => 'date_time_picker',
                    'instructions' => '',
                    'required' => 0,
                    'disabled' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d H:i:s',
                    'return_format' => 'm/d/Y g:i a',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_61448debc890a',
                    'label' => 'Announcement Content',
                    'name' => 'announcement_content',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_61448e00c890b',
                    'label' => 'Link',
                    'name' => 'link',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_61448e1bc890c',
                    'label' => 'Background Color',
                    'name' => 'background_color',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                ),
                array(
                    'key' => 'field_61448e2fc890d',
                    'label' => 'Font Color',
                    'name' => 'font_color',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                ),
                array(
                    'key' => 'field_61448e6ec890e',
                    'label' => 'Clear Wp Engin Cache',
                    'name' => '',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => 'NOTE: Please clear wpengin cache after making changes.',
                    'new_lines' => 'wpautop',
                    'esc_html' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
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
            'active' => true,
            'description' => '',
        ));

        endif;      

    
    }


    function get_announcement_data()
    {
        
        if(current(get_field('enable_announcement_bar', 'option')) == 'yes'){

            $background_color = 'transparent';
            $font_color = 'inherit';

            if (get_field('background_color', 'option')) {
                $background_color = get_field('background_color', 'option');
            }

            if (get_field('font_color', 'option')) {
                $font_color = get_field('font_color', 'option');
            }

            echo "<style>
                .evisit-announcement-bar {
                    background: ". $background_color .";
                    text-align:center;
                    position: relative;
                    padding:5px 0;
                    width: 100%;
                    z-index: 1111;
                }
                .evisit-announcement-bar a{
                    text-decoration: none;
                }
                .evisit-announcement-bar p{
                    margin:0 !important;
                    font-size: 1.1rem;
                    font-weight: normal;
                    color: ". $font_color .";
                    letter-spacing: 0px;
                    text-transform: uppercase;
                    line-height: 30px;
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

  
            if (get_field('link', 'option') && get_field('link', 'option') != '#') {
                echo '<div class="evisit-announcement-bar"><a href="'.get_field('link', 'option').'"><div class="container">'.get_field('announcement_content', 'option').'</div></a></div>';
            } else {
                echo '<div class="evisit-announcement-bar"><div class="container">'.get_field('announcement_content', 'option').'</div></div>';
            }

        }

    }
    
}

if (class_exists('CD_Announcement_Plugin')) {
    $Announcement = new CD_Announcement_Plugin();
}



