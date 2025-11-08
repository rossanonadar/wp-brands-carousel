<?php
/**
 * Font loading helpers.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'yotpo_theme_maybe_enqueue_typekit', 5 );
/**
 * Optionally enqueue an Adobe Fonts (Typekit) stylesheet.
 *
 * Kit ID can be provided via the `yotpo_theme_typekit_kit_id` filter or the
 * "typekit_kit_id" option field (see `yotpo_theme_get_option`).
 */
function yotpo_theme_maybe_enqueue_typekit() {
    $kit_id = apply_filters( 'yotpo_theme_typekit_kit_id', '' );

    if ( empty( $kit_id ) && function_exists( 'yotpo_theme_get_option' ) ) {
        $kit_id = yotpo_theme_get_option( 'typekit_kit_id', '' );
    }

    if ( ! is_string( $kit_id ) || '' === $kit_id ) {
        return;
    }

    $kit_id = strtolower( preg_replace( '/[^a-z0-9]/', '', $kit_id ) );

    if ( '' === $kit_id ) {
        return;
    }

    wp_enqueue_style(
        'yotpo-theme-typekit',
        sprintf( 'https://use.typekit.net/%s.css', $kit_id ),
        [],
        null
    );
}
