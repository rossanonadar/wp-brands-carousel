<?php
/**
 * Brands carousel section.
 *
 * Expected variables:
 * - array $brands
 * - bool  $has_brands
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$context = wp_parse_args(
    isset( $args ) ? $args : [],
    [
        'brands'     => [],
        'has_brands' => false,
    ]
);

$brands     = is_array( $context['brands'] ) ? $context['brands'] : [];
$has_brands = (bool) ( $context['has_brands'] ?: ! empty( $brands ) );

$resolve_media_url = static function ( $media_value, $size = 'full' ) {
    if ( ! $media_value ) {
        return '';
    }

    if ( is_numeric( $media_value ) ) {
        return wp_get_attachment_image_url( (int) $media_value, $size );
    }

    if ( is_array( $media_value ) ) {
        if ( isset( $media_value['ID'] ) ) {
            return wp_get_attachment_image_url( (int) $media_value['ID'], $size );
        }

        if ( isset( $media_value['url'] ) ) {
            return $media_value['url'];
        }
    }

    if ( is_string( $media_value ) ) {
        return $media_value;
    }

    return '';
};

$render_card_body = static function ( $args_card ) {
    $classes      = isset( $args_card['classes'] ) ? trim( $args_card['classes'] ) : '';
    $variant      = isset( $args_card['variant'] ) ? trim( $args_card['variant'] ) : '';
    $logo_src     = isset( $args_card['logo'] ) ? $args_card['logo'] : '';
    $brand_title  = isset( $args_card['title'] ) ? $args_card['title'] : '';
    $brand_desc   = isset( $args_card['description'] ) ? $args_card['description'] : '';
    $button       = isset( $args_card['button'] ) ? $args_card['button'] : [];
    $body_classes = 'brands-card__body' . ( $classes ? ' ' . esc_attr( $classes ) : '' );
    $variant_attr = $variant ? ' data-brand-card-variant="' . esc_attr( $variant ) . '"' : '';

    ob_start();
    ?>
    <div class="<?php echo $body_classes; ?>"<?php echo $variant_attr; ?>>
        <?php if ( $logo_src ) : ?>
            <img class="brands-card__logo" src="<?php echo esc_url( $logo_src ); ?>" alt="<?php echo esc_attr( $brand_title ); ?>" loading="lazy" decoding="async" />
        <?php else : ?>
            <span class="brands-card__title"><?php echo esc_html( $brand_title ); ?></span>
        <?php endif; ?>

        <?php if ( $brand_desc ) : ?>
            <p class="brands-card__description"><?php echo esc_html( $brand_desc ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $button ) ) : ?>
            <a class="brands-card__cta" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>" rel="noopener">
                <?php echo esc_html( $button['label'] ); ?>
            </a>
        <?php endif; ?>
    </div>
    <?php

    return trim( ob_get_clean() );
};
?>
<section class="brands-carousel" data-brands-slider>
    <div class="brands-carousel__wrapper">
        <div class="brands-carousel__inner swiper">
            <div class="swiper-wrapper">
                <?php
                if ( $has_brands ) :
                    foreach ( $brands as $brand_post ) :
                        $brand_id       = $brand_post->ID;
                        $brand_logo     = function_exists( 'get_field' ) ? get_field( 'logo', $brand_id ) : '';
                        $brand_desc     = function_exists( 'get_field' ) ? get_field( 'description', $brand_id ) : '';
                        $brand_button   = function_exists( 'get_field' ) ? get_field( 'button', $brand_id ) : '';
                        $brand_image_id = get_post_thumbnail_id( $brand_id );
                        $brand_image    = $brand_image_id ? wp_get_attachment_image_url( $brand_image_id, 'large' ) : '';
                        $brand_title    = get_the_title( $brand_id );

                        $background_desktop = function_exists( 'get_field' ) ? get_field( 'background_image', $brand_id ) : '';
                        $background_mobile  = function_exists( 'get_field' ) ? get_field( 'background_image_mobile', $brand_id ) : '';

                        $background_desktop_url = $resolve_media_url( $background_desktop, 'full' );
                        $background_mobile_url  = $resolve_media_url( $background_mobile, 'full' );
                        $logo_src               = $resolve_media_url( $brand_logo, 'medium' );

                        $style_rules = [];

                        if ( $background_desktop_url ) {
                            $style_rules[] = sprintf( '--brand-card-bg:url("%s")', esc_url( $background_desktop_url ) );
                        }

                        if ( $background_mobile_url ) {
                            $style_rules[] = sprintf( '--brand-card-bg-mobile:url("%s")', esc_url( $background_mobile_url ) );
                        }

                        $style_attribute = $style_rules ? ' style="' . esc_attr( implode( ';', $style_rules ) ) . '"' : '';

                        $button_payload = [];

                        if ( $brand_button && isset( $brand_button['url'] ) && $brand_button['url'] ) {
                            $button_payload = [
                                'url'    => $brand_button['url'],
                                'target' => isset( $brand_button['target'] ) && $brand_button['target'] ? $brand_button['target'] : '_self',
                                'label'  => isset( $brand_button['title'] ) && $brand_button['title'] ? $brand_button['title'] : __( 'Learn more', 'yotpo-theme' ),
                            ];
                        }

                        $mobile_media_src = $background_mobile_url ?: $background_desktop_url ?: $brand_image;
                        ?>
                            <article class="brands-card swiper-slide"<?php echo $style_attribute; ?>>
                                <?php echo $render_card_body(
                                    [
                                        'classes'     => 'brands-card__body--desktop',
                                        'variant'     => 'desktop',
                                        'logo'        => $logo_src,
                                        'title'       => $brand_title,
                                        'description' => $brand_desc,
                                        'button'      => $button_payload,
                                    ]
                                ); ?>

                                <div class="brands-card__mobile" data-brand-card-mobile-wrapper>
                                    <?php echo $render_card_body(
                                        [
                                            'classes'     => 'brands-card__body--mobile',
                                            'variant'     => 'mobile',
                                            'logo'        => $logo_src,
                                            'title'       => $brand_title,
                                            'description' => $brand_desc,
                                            'button'      => $button_payload,
                                        ]
                                    ); ?>

                                    <?php if ( $mobile_media_src ) : ?>
                                        <div class="brands-card__media brands-card__media--mobile">
                                            <img src="<?php echo esc_url( $mobile_media_src ); ?>" alt="<?php echo esc_attr( $brand_title ); ?>" loading="lazy" decoding="async" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php
                    endforeach;
                else :
                    ?>
                    <div class="brands-carousel__empty swiper-slide">
                        <p><?php esc_html_e( 'No brands available yet.', 'yotpo-theme' ); ?></p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
    
           
        </div>

        <div class="brands-carousel__nav-stack">
            <button class="brands-carousel__nav brands-carousel__nav--prev" type="button" aria-label="<?php esc_attr_e( 'Previous brand', 'yotpo-theme' ); ?>"></button>
            <button class="brands-carousel__nav brands-carousel__nav--next" type="button" aria-label="<?php esc_attr_e( 'Next brand', 'yotpo-theme' ); ?>"></button>
        </div>
        
        <div class="brands-carousel__pagination swiper-pagination"></div> 
    </div>
</section>
