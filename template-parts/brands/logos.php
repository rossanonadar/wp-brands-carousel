<?php
/**
 * Brands logos marquee.
 *
 * Expected variable:
 * - array $global_logos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$context = wp_parse_args(
    isset( $args ) ? $args : [],
    [
        'global_logos' => [],
    ]
);

$global_logos = is_array( $context['global_logos'] ) ? $context['global_logos'] : [];

if ( empty( $global_logos ) ) {
    return;
}
?>
<div class="brands-logos">
    <div class="brands-logos__marquee">
        <?php for ( $i = 0; $i < 2; $i++ ) : ?>
            <div class="brands-logos__track">
                <?php
                foreach ( $global_logos as $logo ) :
                    $logo_image = isset( $logo['logo'] ) ? $logo['logo'] : '';
                    $logo_label = isset( $logo['label'] ) ? $logo['label'] : '';

                    $logo_src = '';
                    if ( $logo_image ) {
                        if ( is_numeric( $logo_image ) ) {
                            $logo_src = wp_get_attachment_image_url( $logo_image, 'medium' );
                        } elseif ( is_array( $logo_image ) && isset( $logo_image['url'] ) ) {
                            $logo_src = $logo_image['url'];
                        } elseif ( is_string( $logo_image ) ) {
                            $logo_src = $logo_image;
                        }
                    }
                    ?>
                    <div class="brands-logos__item">
                        <?php if ( $logo_src ) : ?>
                            <img src="<?php echo esc_url( $logo_src ); ?>" alt="<?php echo esc_attr( $logo_label ); ?>" />
                        <?php elseif ( $logo_label ) : ?>
                            <span><?php echo esc_html( $logo_label ); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
