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
    $font_awesome_path = get_template_directory() . '/assets/vendor/fontawesome/css/all.min.css';
    $font_awesome_version = file_exists($font_awesome_path) ? (string) filemtime($font_awesome_path) : '6.7.2';
    $theme_css_path = get_template_directory() . '/assets/css/theme.css';
    $theme_css_version = file_exists($theme_css_path) ? (string) filemtime($theme_css_path) : $v;
    wp_enqueue_style('rema-google-fonts','https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&family=Mulish:wght@400;600;700&display=swap',array(),null);
    wp_enqueue_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',array(),'5.3.8');
    wp_enqueue_style('rema-font-awesome',get_template_directory_uri().'/assets/vendor/fontawesome/css/all.min.css',array(),$font_awesome_version);
    wp_enqueue_style('rema-style',get_template_directory_uri().'/assets/css/theme.css',array('bootstrap','rema-font-awesome'),$theme_css_version);
    wp_enqueue_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',array(),'5.3.8',true);
    wp_enqueue_script('rema-theme',get_template_directory_uri().'/assets/js/theme.js',array(),$v,true);
}
add_action('wp_enqueue_scripts','rema_enqueue_assets');

function rema_apply_figma_refresh_v2() {
    if ((int) get_option('rema_figma_design_version', 0) >= 2) return;
    $settings = (array) get_option('rema_theme_settings', array());
    if ($settings) {
        $updates = array(
            'intro.text' => array(
                'Move with confidence, style, and elegance in every step.<br>Discover Rima &amp; Ramroma, part of the BabeChic collection, bringing world-class sportswear to the GCC, MENA region, and North Africa.',
                'Move with confidence, style, and elegance in every step.<br>Discover <strong>Rima &amp; Ramroma</strong>, part of the <strong>BabeChic</strong> collection, bringing world-class sportswear to the GCC, MENA region, and North Africa.'
            ),
            'brands.rima_text' => array(
                'Inspired by modern women, Rima delivers elegant, high-performance activewear for confidence in every move.',
                'Inspired by Al Reem (Gizalla Al Reem), blends elegance, strength, and grace in activewear for women.'
            ),
            'vision.text' => array(
                'Leading the MENA women’s activewear market with high-performance, trendy designs that support Saudi Arabia’s Quality of Life goals and Vision 2030.',
                '“Leading the MENA women’s activewear market with high-performance, trendy designs that support Saudi Arabia’s Quality of Life goals and Vision 2030.”'
            ),
            'footer.copyright' => array(
                '© 2025 Rima &amp; Ramroma. All rights reserved.<br>Part of the BabeChic Collection.',
                '© 2026 Rima &amp; Ramroma. All rights reserved.<br>Part of the BabeChic Collection.'
            ),
        );
        foreach ($updates as $path => $values) {
            if (rema_array_get($settings, $path, null) === $values[0]) rema_array_set($settings, $path, $values[1]);
        }
        if (!rema_array_get($settings, 'divider.logo')) rema_array_set($settings, 'divider.logo', get_template_directory_uri() . '/assets/images/babechic-logo.png');
        update_option('rema_theme_settings', $settings);
    }
    update_option('rema_figma_design_version', 2);
}
add_action('init', 'rema_apply_figma_refresh_v2', 5);

function rema_register_polylang_strings() {
    if (!function_exists('pll_register_string')) return;
    $settings=rema_get_settings();
    foreach(rema_translatable_fields() as $path=>$label){$value=rema_array_get($settings,$path);if(is_string($value)&&$value!=='')pll_register_string('rema_'.str_replace('.','_',$path),$value,'Rima Theme',true);}
}
add_action('init','rema_register_polylang_strings');
