<?php

function cooking_setup() {
    wp_enqueue_style('foodfolio-google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap');
    wp_enqueue_style('cooking-style', get_stylesheet_uri());
    wp_enqueue_script('cooking-script', get_template_directory_uri() . '/script.js', [], false, true);
}

add_action( 'wp_enqueue_scripts', 'cooking_setup');