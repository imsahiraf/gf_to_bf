<?php

add_filter('gfbf_bunny_fonts_filter_output', function ($output) {

    // if html contains 'fonts.googleapis.com'
    if (str_contains($output, 'fonts.googleapis.com/css')) {
        // replace with 'fonts.bunny.net'
        $output = str_replace('fonts.googleapis.com/css', 'fonts.bunny.net/css', $output);
    }

    if (apply_filters('gfbf_bunny_remove_google_preconnect', true)) {

       // Lookup for preconnect to fonts.googleapis.com
        $preconnect_lookups = [
            '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
            '<link href="https://fonts.gstatic.com" crossorigin rel="preconnect" />',
            '<link href="https://fonts.gstatic.com" rel="preconnect" />',
            '<link rel="preconnect" href="https://fonts.googleapis.com">',
            '<link href="https://fonts.googleapis.com" crossorigin rel="preconnect" />',
            '<link href="https://fonts.googleapis.com" rel="preconnect" />'
        ];

        $preconnect_lookups = apply_filters('gfbf_bunny_preconnect_lookup', $preconnect_lookups);

       // Remove preconnects
        foreach ($preconnect_lookups as $preconnect_lookup) {
            $output = str_replace($preconnect_lookup, '', $output);
        }
    }

    if (apply_filters('gfbf_bunny_remove_google_prefetch', true)) {

        // Lookup for prefetch to fonts.googleapis.com
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

?>