<?php

// Check if your PHP does contains str_contains function
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

// Check if is_plugin_active plugin is there or not
if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

function gfbf_bunny_init_ob(){
    ob_start();
}

function gfbf_bunny_shutdown()
    {
        $data = '';

        // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
        // that buffer's output into the output.
        $levels = ob_get_level();

        for ($i = 0; $i < $levels; $i++) {
            $data .= ob_get_clean();
        }

        // Apply any filters to the output
        echo apply_filters('gfbf_bunny_fonts_filter_output', $data);
    }
?>