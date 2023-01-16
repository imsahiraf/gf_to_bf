<?php
/**
 * Plugin Name:     GF to BF 
 * Description:     Plugin replace Google Fonts with Bunny Fonts.
 * Author:          scriptosys
 * Author URI:      https://scriptosys.com
 * Domain Path:     /languages
 * Version:         1.0.0
 * @package         GF to BF
 */

if (!defined('ABSPATH')) {
    exit;
}

// First include the require files
$__gfbf_filelist = ['essential', 'plugin_check'];

foreach($__gfbf_filelist as $gf_key => $bf_value){
    require_once($bf_value);
}

$gfbf::check_plugin();

/**
 * Check if autoptimize is active
 */


if (is_plugin_active('autoptimize/autoptimize.php')) {

    add_filter('autoptimize_html_after_minify', function ($data) {
        return apply_filters('gfbf_bunny_fonts_filter_output', $data);
    });

} /**
 * Check if wp-fastest-cache is active
 */
elseif (is_plugin_active('wp-fastest-cache/wpFastestCache.php')) {

    add_filter('wpfc_buffer_callback_filter', function ($data) {
        return apply_filters('gfbf_bunny_fonts_filter_output', $data);
    });

} /**
 * Check if wp-rocket is active
 */
elseif (is_plugin_active('wp-rocket/wp-rocket.php')) {

    add_filter('rocket_buffer', function ($data) {
        return apply_filters('gfbf_bunny_fonts_filter_output', $data);
    });

} /**
 * Check if w3-total-cache is active
 */
elseif (is_plugin_active('w3-total-cache/w3-total-cache.php')) {
    add_filter('w3tc_process_content', function ($data) {
        return apply_filters('gfbf_bunny_fonts_filter_output', $data);
    });
} /**
 * Check if wp-super-cache is active
 */
elseif (is_plugin_active('wp-super-cache/wp-cache.php')) {

    add_filter('wp_cache_ob_callback_filter', function ($data) {
        return apply_filters('gfbf_bunny_fonts_filter_output', $data);
    });

} else {

    //we use 'init' action to use ob_start()
    add_action('init', 'gfbf_bunny_init_ob');

    function gfbf_bunny_init_ob()
    {
        ob_start();
    }

    // get the pages html
    add_action('shutdown', 'gfbf_bunny_shutdown', 0);

    function gfbf_bunny_shutdown()
    {
        $data = '';

        // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
        // that buffer's output into the final output.
        $levels = ob_get_level();

        for ($i = 0; $i < $levels; $i++) {
            $data .= ob_get_clean();
        }

        // Apply any filters to the final output
        echo apply_filters('gfbf_bunny_fonts_filter_output', $data);
    }


}

add_filter('gfbf_bunny_fonts_filter_output', function ($output) {

    // if html contains 'fonts.googleapis.com'
    if (str_contains($output, 'fonts.googleapis.com/css')) {
        // replace with 'fonts.bunny.net'
        $output = str_replace('fonts.googleapis.com/css', 'fonts.bunny.net/css', $output);
    }

    if (apply_filters('gfbf_bunny_remove_google_preconnect', true)) {

        /**
         * Lookup for preconnect to fonts.googleapis.com
         */
        $preconnect_lookups = [
            '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
            '<link href="https://fonts.gstatic.com" crossorigin rel="preconnect" />',
            '<link href="https://fonts.gstatic.com" rel="preconnect" />',
            '<link rel="preconnect" href="https://fonts.googleapis.com">',
            '<link href="https://fonts.googleapis.com" crossorigin rel="preconnect" />',
            '<link href="https://fonts.googleapis.com" rel="preconnect" />'
        ];

        $preconnect_lookups = apply_filters('gfbf_bunny_preconnect_lookup', $preconnect_lookups);

        /**
         * Remove preconnects
         */
        foreach ($preconnect_lookups as $preconnect_lookup) {
            $output = str_replace($preconnect_lookup, '', $output);
        }
    }

    if (apply_filters('gfbf_bunny_remove_google_prefetch', true)) {


        /**
         * Lookup for prefetch to fonts.googleapis.com
         */
        $prefetch_lookups = [
            '<link rel="dns-prefetch" href="https://fonts.googleapis.com">',
            '<link rel="dns-prefetch" href="https://fonts.gstatic.com">',
            '<link href="https://fonts.googleapis.com" rel="dns-prefetch">',
            '<link href="https://fonts.gstatic.com" rel="dns-prefetch">'
        ];

        $prefetch_lookups = apply_filters('gfbf_bunny_prefetch_lookup', $prefetch_lookups);

        /**
         * Remove prefetches
         */
        foreach ($prefetch_lookups as $prefetch_lookup) {
            $output = str_replace($prefetch_lookup, '', $output);
        }
    }

    if (apply_filters('gfbf_bunny_insert_gfbf_bunny_preconnect', true)) {
        // check if html contains <link rel="preconnect" href="https://fonts.bunny.net"> when not insert it
        if (!str_contains($output, '<link rel="preconnect" href="https://fonts.bunny.net">')) {
            $output = str_replace('<link href="https://fonts.bunny.net', '<link rel="preconnect" href="https://fonts.bunny.net"> <link href="https://fonts.bunny.net', $output);
        }
    }


    return $output;
});
