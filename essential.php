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

// Here list of plugins which can be active
$plugin = [
    'autoptimize/autoptimize' => 'autoptimize_html_after_minify',
    'wp-fastest-cache/wpFastestCache' => 'wpfc_buffer_callback_filter',
    'wp-rocket/wp-rocket' => 'rocket_buffer',
    'w3-total-cache/w3-total-cache' => 'w3tc_process_content',
    'wp-super-cache/wp-cache' => 'wp_cache_ob_callback_filter'
];
?>