<?php
/**
 * Plugin Name: Elementor Cards Slider
 * Description: Elementor Cards Slider is a simple plugin that adds a new widget called Cards Slider.
 * Plugin URI: https://shineafrika.com/extensions/elementor-cards-slider/
 * Author: Wampamba David
 * Version: 0.0.7
 * Author URI: https://davidofug.com/
 *
 * Text Domain: elementor-cards-slider
 *
 * @package Elementor Cards Slider
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Cards Slider Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

function register_cards_slider_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/cards-slider-widget.php' );

	$widgets_manager->register( new \Elementor_Cards_Slider_Widget() );

}
add_action( 'elementor/widgets/register', 'register_cards_slider_widget' );

function load_cards_slider_scripts($hook) {

    $swiper_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'widgets/js/swiper-bundle.min.js' ));
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'widgets/js/script.js' ));
    $swiper_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'widgets/css/swiper-bundle.min.css' ));
	$my_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'widgets/css/style.css' ));

    wp_enqueue_script( 'swiper_js', plugins_url( 'widgets/js/swiper-bundle.min.js', __FILE__ ), array('jquery'), $swiper_js_ver, true);
    wp_enqueue_script( 'elementor_cards_slider_js', plugins_url( 'widgets/js/script.js', __FILE__ ), array('swiper_js'), $my_js_ver, true );

    wp_register_style( 'swiper_css',    plugins_url( 'widgets/css/swiper-bundle.min.css', __FILE__ ), false,   $swiper_css_ver );
    wp_enqueue_style ( 'swiper_css' );

    wp_register_style( 'elementor_cards_slider_css',    plugins_url( 'widgets/css/style.css', __FILE__ ), false,   $my_css_ver );
    wp_enqueue_style ( 'elementor_cards_slider_css' );

}

add_action('wp_enqueue_scripts', 'load_cards_slider_scripts');