<?php
/*
Plugin Name: TinySlider
Plugin URI: https://redoyit.com/
Description: Used by millions, WordCount is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. WordCount Anti-spam keeps your site protected even while you sleep. To get started: activate the WordCount plugin and then go to your WordCount Settings page to set up your API key.
Version: 5.3
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Md. Redoy Islam
Author URI: https://redoyit.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: tinyslider
Domain Path: /languages
*/
/*
function wordcount_activation_hook(){}
register_activation_hook(__FILE__, "wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook(__FILE__, "wordcount_deactivation_hook");
*/

function tinyslider_load_textdomain(){
    load_plugin_textdomain('tinyslider', false, dirname(__FILE__) . '/languages');
}
add_action("plugins_loaded", "tinyslider_load_textdomain");
function tinys_init(){
    add_image_size( 'tiny-slider', 800, 600, true );
}
add_action('init', 'tinys_init');

function tinys_assets(){
    wp_enqueue_style('tinyslider-css','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.4/tiny-slider.css', null,'1.0');
    wp_enqueue_script('tinyslider-js','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.4/min/tiny-slider.js', null, '1.0', true);

    wp_enqueue_script('tinyslider-min-js', plugin_dir_url(__FILE__)."/assets/js/main.js", array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'tinys_assets');

function tinys_shortcode_tslider($arguments, $content){
    $defaults = array(
        'width' => 800,
        'height' => 600, 
        'id' => '',
    );
    $attributes = shortcode_atts( $defaults, $arguments );
    $content = do_shortcode($content);
    $shortcode_output = <<<EOD
    
        <div id="{$attributes['id']}" style="width:{$attributes['width']};height:{$attributes['height']}">
            <div class="slider">
                {$content}
            </div>
        </div> 
    
    EOD;
    return $shortcode_output;
}
add_shortcode('tslider','tinys_shortcode_tslider');

function tinys_shortcode_tslide($arguments){
    $defaults = array(
        'caption' =>'', 
        'id' => '',
        'size' => 'tiny-slider',
    );
    $attributes = shortcode_atts( $defaults, $arguments );
    $image_src = wp_get_attachment_image_src($attributes['id'], $attributes['size']);

    $shortcode_output = <<<EOD
        <div class='slide'>
            <p><img src="{$image_src[0]}" alt="{$attributes['caption']}"></p>
            <p>{$attributes['caption']}</p>
        </div>
    EOD;
    return $shortcode_output;
}
add_shortcode('tslide','tinys_shortcode_tslide');

//[tslider][tslide caption='Our Beautiful Caption 1' id=207 /][tslide caption='Our Beautiful Caption 2' id=206 /][tslide caption='Our Beautiful Caption 3' id=71 /][tslide caption='Our Beautiful Caption 4' id=67 /][tslide caption='Our Beautiful Caption 5' id=65 /][/tslider]