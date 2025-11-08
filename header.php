<?php
/**
 * Header template for Yotpo Theme.
 */

do_action( 'yotpo_theme_before_html' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="site-header__inner">
        <?php
        $logo_value = function_exists( 'yotpo_theme_get_option' ) ? yotpo_theme_get_option( 'main_logo' ) : null;
        $logo_id    = is_numeric( $logo_value ) ? (int) $logo_value : 0;
        $logo_url   = '';

        if ( $logo_id ) {
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );

            if ( ! $logo_url ) {
                $logo_url = wp_get_attachment_url( $logo_id );
            }
        } elseif ( is_string( $logo_value ) ) {
            $logo_url = $logo_value;
        }

        if ( $logo_url ) :
            $alt_text = $logo_id ? get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) : '';
            $alt_text = $alt_text ? $alt_text : get_bloginfo( 'name' );
            ?>
            <div class="site-header__logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Main Logo', 'yotpo-theme' ); ?>" rel="home">
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" />
                </a>
            </div>
        <?php else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title" rel="home">
                <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            </a>
        <?php endif; ?>
    </div>
</header>
<main class="site-main yotpo-main">
