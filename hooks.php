<?php

add_filter('gfbf_bunny_fonts_filter_output', function ($gfbf_page) {

	// if html contains 'fonts.googleapis.com'
	if (str_contains($gfbf_page, 'fonts.googleapis.com')) {
		// replace with 'fonts.bunny.net'
		$gfbf_page = str_replace('fonts.googleapis.com', 'fonts.bunny.net', $gfbf_page);
	}

	// if html contains 'fonts.googleapis.com/css'
	if (str_contains($gfbf_page, 'fonts.googleapis.com/css')) {
		// replace with 'fonts.bunny.net'
		$gfbf_page = str_replace('fonts.googleapis.com/css', 'fonts.bunny.net/css', $gfbf_page);
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
			$gfbf_page = str_replace($preconnect_lookup, '', $gfbf_page);
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

		// Remove prefetches
		foreach ($prefetch_lookups as $prefetch_lookup) {
			$gfbf_page = str_replace($prefetch_lookup, '', $gfbf_page);
		}
	}

	if (apply_filters('gfbf_bunny_insert_gfbf_bunny_preconnect', true)) {
		// check if html contains <link rel="preconnect" href="https://fonts.bunny.net"> when not insert it
		if (!str_contains($gfbf_page, '<link rel="preconnect" href="https://fonts.bunny.net">')) {
			$gfbf_page = str_replace('<link href="https://fonts.bunny.net', '<link rel="preconnect" href="https://fonts.bunny.net"> <link href="https://fonts.bunny.net', $gfbf_page);
		}
	}


	return $gfbf_page;
});

// Display the banner notice on the plugins and themes pages
add_action('admin_notices', function (){
	// Get the current screen
	$screen = get_current_screen();

	// Return early if not on the plugins or themes pages
	if ($screen->id !== 'plugins' && $screen->id !== 'dashboard') {
	return;
	}

	$gfbf_urllist = [
		'https://zarsco.com/' => 'Zarsco',
		'https://blog.zarsco.com/' => 'Zarsco Blogs',
		'https://scriptosys.com/' => 'Scriptosys'
	];

	$bfgf_url = array_rand($gfbf_urllist);
	$bfgf_page = $gfbf_urllist[$bfgf_url];

	// Build and print the banner notice HTML
	echo "<div class='notice notice-success is-dismissible' >
		<p>
			Thank You for Installing GF to BF.<br>We are here right away to help you more incase you need any free plugin we are ready to help you to built in that plugin as soon as possible.<br>Visit us for more free plugins <em><strong><a href='$bfgf_url' target='_blank'>$bfgf_page</a></strong></em> or connect with us at <em><strong><a href='mailto:info@zarsco.com'>info@zarsco.com</a></strong></em>.
		</p>
		<a href='javascript:' aria-label='Dismiss this Notice'></a>
	</div>";
	
});

?>