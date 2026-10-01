<?php
defined('ABSPATH') || exit;
require_once get_template_directory() . '/inc/defaults.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/admin.php';

function rema_theme_setup() {
    load_theme_textdomain('rima-ramroma', get_template_directory() . '/languages');
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form','gallery','caption','style','script'));
    register_nav_menus(array('primary'=>__('Primary navigation','rima-ramroma'),'footer'=>__('Footer navigation','rima-ramroma')));
}
add_action('after_setup_theme','rema_theme_setup');

function rema_enqueue_assets() {
    $v = wp_get_theme()->get('Version');
    wp_enqueue_style('rema-google-fonts','https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Mulish:wght@400;600;700&display=swap',array(),null);
    wp_enqueue_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',array(),'5.3.8');
    wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/vendor/fontawesome/css/all.min.css',array(),'6.7.2');
    wp_enqueue_style('rema-style',get_template_directory_uri().'/assets/css/theme.css',array('bootstrap','font-awesome'),$v);
    wp_enqueue_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',array(),'5.3.8',true);
    wp_enqueue_script('rema-theme',get_template_directory_uri().'/assets/js/theme.js',array(),$v,true);
}
add_action('wp_enqueue_scripts','rema_enqueue_assets');

function rema_register_polylang_strings() {
    if (!function_exists('pll_register_string')) return;
    $settings=rema_get_settings();
    foreach(rema_translatable_fields() as $path=>$label){$value=rema_array_get($settings,$path);if(is_string($value)&&$value!=='')pll_register_string('rema_'.str_replace('.','_',$path),$value,'Rima Theme',true);}
}
add_action('init','rema_register_polylang_strings');
