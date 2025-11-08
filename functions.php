<?php
/**
 * Theme bootstrap for Yotpo Theme.
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

define( 'YOTPO_THEME_VERSION', '1.0.0' );

$yotpo_theme_includes = [
    'inc/setup.php',
    'inc/assets.php',
    'inc/post-types.php',
    'inc/acf-options.php',
    'inc/acf-json.php',
    'inc/fonts.php',
    'inc/svg.php',
];

foreach ( $yotpo_theme_includes as $include ) {
    $filepath = get_theme_file_path( $include );

    if ( is_readable( $filepath ) ) {
        require_once $filepath;
    }
}
