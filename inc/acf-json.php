<?php
/**
 * Configure ACF Local JSON save/load paths.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'acf/settings/save_json', 'yotpo_theme_acf_json_save_path' );
/**
 * Adjust where ACF saves JSON exports.
 *
 * @param string $path Default save path.
 * @return string
 */
function yotpo_theme_acf_json_save_path( $path ) {
    return get_theme_file_path( 'acf-json' );
}

add_filter( 'acf/settings/load_json', 'yotpo_theme_acf_json_load_paths' );
/**
 * Ensure ACF loads JSON field groups from the theme.
 *
 * @param array $paths Default load paths.
 * @return array
 */
function yotpo_theme_acf_json_load_paths( $paths ) {
    $paths[] = get_theme_file_path( 'acf-json' );
    return $paths;
}
