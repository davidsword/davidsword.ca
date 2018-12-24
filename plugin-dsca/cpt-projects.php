<?php

add_action('init', function () {
    $cptName = 'Projects';
    $cptSlug = 'projects';
    $args = [
        'labels' => dsca_make_labels($cptName),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        'show_in_rest' => true,
        'rest_base' => 'projects',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    ];
    register_post_type($cptSlug, $args);
});
