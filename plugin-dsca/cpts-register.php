<?php

add_action('init', function () {
    $cptName = 'Images';
    $cptSlug = 'images';
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
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'rest_base' => $cptSlug,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'exclude_from_search' => true
    ];
    register_post_type($cptSlug, $args);
});

add_action('init', function () {
    $cptName = 'art';
    $cptSlug = 'art';
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
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'rest_base' => $cptSlug,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'exclude_from_search' => true
    ];
    register_post_type($cptSlug, $args);
});

add_action('init', function () {
    $cptName = 'Status';
    $cptSlug = 'status';
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
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        'show_in_rest' => true,
        'rest_base' => $cptSlug,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'exclude_from_search' => true
    ];
    register_post_type($cptSlug, $args);
});

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
function dsca_make_labels($cptName)
{
    return [
        'name' => _x($cptName, 'post type general name'),
        'singular_name' => _x($cptName, 'post type singular name'),
        'add_new' => _x('Add New', $cptName),
        'add_new_item' => __('Add New ' . $cptName),
        'edit_item' => __('Edit ' . $cptName),
        'new_item' => __('New ' . $cptName),
        'all_items' => __('All ' . $cptName),
        'view_item' => __('View ' . $cptName),
        'search_items' => __('Search ' . $cptName),
        'not_found' => __('No ' . $cptName . ' found'),
        'not_found_in_trash' => __('No ' . $cptName . ' found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => $cptName
    ];
}
