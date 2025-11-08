<?php
/**
 * Custom post type registrations.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'yotpo_theme_register_cpt_brands' );
/**
 * Register the "Brands" custom post type.
 */
function yotpo_theme_register_cpt_brands() {
    $labels = [
        'name'                  => _x( 'Brands', 'Post Type General Name', 'yotpo-theme' ),
        'singular_name'         => _x( 'Brand', 'Post Type Singular Name', 'yotpo-theme' ),
        'menu_name'             => __( 'Brands', 'yotpo-theme' ),
        'name_admin_bar'        => __( 'Brand', 'yotpo-theme' ),
        'add_new'               => __( 'Add New', 'yotpo-theme' ),
        'add_new_item'          => __( 'Add New Brand', 'yotpo-theme' ),
        'edit_item'             => __( 'Edit Brand', 'yotpo-theme' ),
        'new_item'              => __( 'New Brand', 'yotpo-theme' ),
        'view_item'             => __( 'View Brand', 'yotpo-theme' ),
        'view_items'            => __( 'View Brands', 'yotpo-theme' ),
        'search_items'          => __( 'Search Brands', 'yotpo-theme' ),
        'not_found'             => __( 'No brands found', 'yotpo-theme' ),
        'not_found_in_trash'    => __( 'No brands found in Trash', 'yotpo-theme' ),
        'all_items'             => __( 'All Brands', 'yotpo-theme' ),
        'archives'              => __( 'Brand Archives', 'yotpo-theme' ),
        'attributes'            => __( 'Brand Attributes', 'yotpo-theme' ),
        'insert_into_item'      => __( 'Insert into brand', 'yotpo-theme' ),
        'uploaded_to_this_item' => __( 'Uploaded to this brand', 'yotpo-theme' ),
        'featured_image'        => __( 'Brand Image', 'yotpo-theme' ),
        'set_featured_image'    => __( 'Set brand image', 'yotpo-theme' ),
        'remove_featured_image' => __( 'Remove brand image', 'yotpo-theme' ),
        'use_featured_image'    => __( 'Use as brand image', 'yotpo-theme' ),
    ];

    $args = [
        'label'               => __( 'Brands', 'yotpo-theme' ),
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'brands', 'with_front' => false ],
        'menu_icon'           => 'dashicons-awards',
        'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
        'menu_position'       => 20,
        'publicly_queryable'  => true,
        'show_in_nav_menus'   => true,
    ];

    register_post_type( 'brand', $args );
}

add_action( 'after_switch_theme', 'yotpo_theme_flush_rewrite' );
/**
 * Flush rewrite rules after theme activation to register CPT slugs.
 */
function yotpo_theme_flush_rewrite() {
    yotpo_theme_register_cpt_brands();
    flush_rewrite_rules();
}
