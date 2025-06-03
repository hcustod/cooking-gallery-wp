<?php

function cooking_setup() {
    wp_enqueue_style(
        'cooking-google-fonts',
        'https://fonts.googleapis.com/css2?family=Crimson+Pro&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'cooking-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    wp_enqueue_script(
        'cooking-script',
        get_template_directory_uri() . '/script.js',
        [],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'cooking_setup');

function cooking_create_gallery_page() {
    $page_title = 'Gallery';
    $page_check = get_page_by_title($page_title);

    if (!$page_check) {
        wp_insert_post([
            'post_title'    => $page_title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page-gallery.php',
        ]);
    }
}
add_action('after_setup_theme', 'cooking_create_gallery_page');

function cooking_disable_nav_keep_title() {
    if (is_page_template('page-gallery.php')) {
        remove_all_actions('astra_header');
        remove_all_actions('astra_masthead');
        remove_all_actions('astra_footer');

        add_action('wp_head', function () {
            echo '<style>.site-header, .main-header-bar, .ast-site-identity { display: none !important; }</style>';
        });

        add_action('wp_body_open', function () {
            echo '<h1 class="custom-gallery-title">' . esc_html(get_bloginfo('name')) . '</h1>';
        });
    }
}
add_action('template_redirect', 'cooking_disable_nav_keep_title');
