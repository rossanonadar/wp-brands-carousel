<?php
/**
 * Brands hero section.
 *
 * Expected variables (with defaults applied here):
 * - string $hero_title
 * - string $hero_description
 * - array  $hero_cta
 * - string $hero_media_src
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$context = wp_parse_args(
    isset( $args ) ? $args : [],
    [
        'hero_title'       => '',
        'hero_description' => '',
        'hero_cta'         => [],
    
    ]
);

    $hero_title       = $context['hero_title'];
    $hero_description = $context['hero_description'];
    $hero_cta         = $context['hero_cta'];
?>
<section class="brands-hero">
    <div class="brands-hero__content">
        <?php if ( $hero_title ) : ?>
            <h1 class="brands-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
        <?php endif; ?>

        <?php if ( $hero_description ) : ?>
            <p class="brands-hero__description"><?php echo esc_html( $hero_description ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $hero_cta['url'] ) ) :
            $cta_target = ! empty( $hero_cta['target'] ) ? $hero_cta['target'] : '_self';
            $cta_label  = ! empty( $hero_cta['title'] ) ? $hero_cta['title'] : __( 'Request a demo', 'yotpo-theme' );
            ?>
            <a class="brands-hero__cta" href="<?php echo esc_url( $hero_cta['url'] ); ?>" target="<?php echo esc_attr( $cta_target ); ?>" rel="noopener">
                <?php echo esc_html( $cta_label ); ?>
            </a>
        <?php endif; ?>
    </div>

</section>
