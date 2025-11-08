<?php
/**
 * ACF options pages and helpers.
 *
 * Provides a single place to register theme-wide settings using the
 * Advanced Custom Fields options pages feature.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'yotpo_theme_register_acf_options_pages' );
/**
 * Register the Options pages exposed through ACF.
 */
function yotpo_theme_register_acf_options_pages() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page(
        [
            'page_title'      => __( 'Theme Settings', 'yotpo-theme' ),
            'menu_title'      => __( 'Theme Settings', 'yotpo-theme' ),
            'menu_slug'       => 'theme-settings',
            'capability'      => 'manage_options',
            'redirect'        => false,
            'position'        => 60,
            'post_id'         => 'yotpo_theme_options',
            'update_button'   => __( 'Save Settings', 'yotpo-theme' ),
            'updated_message' => __( 'Theme settings updated', 'yotpo-theme' ),
        ]
    );
}

add_action( 'acf/init', 'yotpo_theme_register_acf_fields' );
/**
 * Register local ACF field groups for theme settings.
 */
function yotpo_theme_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // acf_add_local_field_group(
    //     [
    //         'key'    => 'group_yotpo_theme_settings',
    //         'title'  => __( 'Theme Settings', 'yotpo-theme' ),
    //         'fields' => [
    //             [
    //                 'key'           => 'field_yotpo_main_logo',
    //                 'label'         => __( 'Main Logo', 'yotpo-theme' ),
    //                 'name'          => 'main_logo',
    //                 'type'          => 'image',
    //                 'instructions'  => __( 'Upload the main header logo (SVG recommended).', 'yotpo-theme' ),
    //                 'required'      => 0,
    //                 'return_format' => 'id',
    //                 'preview_size'  => 'medium',
    //                 'library'       => 'all',
    //             ],
    //             [
    //                 'key'          => 'field_yotpo_global_logos',
    //                 'label'        => __( 'Brand Logos', 'yotpo-theme' ),
    //                 'name'         => 'global_logos',
    //                 'type'         => 'repeater',
    //                 'instructions' => __( 'Logos displayed in the Brands footer strip.', 'yotpo-theme' ),
    //                 'button_label' => __( 'Add Logo', 'yotpo-theme' ),
    //                 'layout'       => 'table',
    //                 'sub_fields'   => [
    //                     [
    //                         'key'           => 'field_yotpo_brand_logo_image',
    //                         'label'         => __( 'Logo Image', 'yotpo-theme' ),
    //                         'name'          => 'logo',
    //                         'type'          => 'image',
    //                         'return_format' => 'id',
    //                         'preview_size'  => 'thumbnail',
    //                         'library'       => 'all',
    //                     ],
    //                     [
    //                         'key'   => 'field_yotpo_brand_logo_label',
    //                         'label' => __( 'Label', 'yotpo-theme' ),
    //                         'name'  => 'label',
    //                         'type'  => 'text',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //         'location' => [
    //             [
    //                 [
    //                     'param'    => 'options_page',
    //                     'operator' => '==',
    //                     'value'    => 'theme-settings',
    //                 ],
    //             ],
    //         ],
    //         'position' => 'normal',
    //         'style'    => 'default',
    //     ]
    // );
}

/**
 * Retrieve a field value from the Theme Settings options page.
 *
 * @param string $field    ACF field name or key.
 * @param mixed  $default  Optional fallback when value is empty.
 *
 * @return mixed
 */
function yotpo_theme_get_option( $field, $default = null ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $default;
    }

    $value = get_field( $field, 'yotpo_theme_options' );

    if ( ! isset( $value ) || '' === $value ) {
        $value = get_field( $field, 'theme-settings' );
    }

    if ( ! isset( $value ) || '' === $value ) {
        $value = get_field( $field, 'option' );
    }

    if ( is_array( $value ) ) {
        if ( isset( $value['ID'] ) ) {
            $value = $value['ID'];
        } elseif ( isset( $value['url'] ) ) {
            $value = $value['url'];
        }
    }

    if ( isset( $value ) && '' !== $value ) {
        return $value;
    }

    return $default;
}

/**
 * Echo an ACF option value with optional escaping callback.
 *
 * @param string        $field   Field name/key.
 * @param mixed         $default Default fallback value.
 * @param callable|null $escape  Escaping callback (e.g. 'esc_html').
 */
function yotpo_theme_the_option( $field, $default = '', callable $escape = null ) {
    $value = yotpo_theme_get_option( $field, $default );

    if ( null !== $escape && is_callable( $escape ) ) {
        $value = call_user_func( $escape, $value );
    }

    echo $value; 
}

