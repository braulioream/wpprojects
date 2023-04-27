<?php

/**
 * Static string Return
 */

if ( ! function_exists('wp_staffdigital_theme_text_srt') ) {

    function wp_staffdigital_theme_text_srt($str = '') {
        global $wp_staffdigital_static_text;
        if ( isset($wp_staffdigital_static_text[$str]) ) {
            return $wp_staffdigital_static_text[$str];
        }
    }

}
if ( ! class_exists('wp_staffdigital_theme_all_strings') ) {

    class wp_staffdigital_theme_all_strings {

        public function wp_staffdigital_theme_option_strings() {
            global $wp_staffdigital_static_text;

            /* Alojamientos / Viajes Sugeridos */

            $wp_staffdigital_static_text['wp_staffdigital_theme_option_price'] = esc_html__('The average price is', 'colorfull');

            
            /*
             * Use this filter to add more strings from Add on.
             */
            $wp_staffdigital_static_text = apply_filters('wp_staffdigital_theme_option_strings', $wp_staffdigital_static_text);

            return $wp_staffdigital_static_text;
        }

    }

    new wp_staffdigital_theme_all_strings;
}
