<?php
/**
 * Template Name: Brands
 *
 * Brands landing page displaying hero content, carousel, and logo marquee.
 */

get_header();

if ( have_posts() ) :
    $brands     = [];
    $has_brands = false;
    while ( have_posts() ) :
        the_post();

        $hero_title       = function_exists( 'get_field' ) ? get_field( 'hero_title', get_the_ID() ) : '';
        $hero_description = function_exists( 'get_field' ) ? get_field( 'hero_description', get_the_ID() ) : '';
        $hero_cta         = function_exists( 'get_field' ) ? get_field( 'hero_cta', get_the_ID() ) : '';

        $hero_title       = $hero_title ? $hero_title : get_the_title();

        if ( ! $hero_description ) {
            $excerpt = get_the_excerpt();
            if ( ! $excerpt ) {
                $excerpt = wp_strip_all_tags( wp_trim_words( get_the_content(), 32 ) );
            }
            $hero_description = $excerpt;
        }

        if ( ! $hero_cta ) {
            $hero_cta = [
                'url'    => home_url( '/contact' ),
                'title'  => __( 'Request a demo', 'yotpo-theme' ),
                'target' => '_self',
            ];
        }


        $hero_media_src = '';

        $brands = get_posts(
            [
                'post_type'      => 'brand',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'post_status'    => 'publish',
            ]
        );
        $has_brands = ! empty( $brands );
        ?>

        <div class="brands-layout">
            <?php
                get_template_part('template-parts/brands/hero', null, compact( 'hero_title', 'hero_description', 'hero_cta', 'hero_media_src' ));
                get_template_part('template-parts/brands/carousel', null,compact( 'brands', 'has_brands' ));
            ?>
        </div>
        <?php endwhile; endif;

        $global_logos = function_exists( 'yotpo_theme_get_option' ) ? yotpo_theme_get_option( 'global_logos', [] ) : [];

            if ( empty( $global_logos ) && ! empty( $brands ) ) {
                $global_logos = array_map(
                    static function ( $brand_post ) {
                        $brand_id = $brand_post->ID;

                        return [
                            'logo'  => function_exists( 'get_field' ) ? get_field( 'logo', $brand_id ) : '',
                            'label' => get_the_title( $brand_id ),
                        ];
                    },
                    $brands
                );
            }

            if ( ! empty( $global_logos ) ) {
            }
            get_template_part( 'template-parts/brands/logos', null, compact( 'global_logos' ) );
            
get_footer();
