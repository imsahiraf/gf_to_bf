<?php

class gfbf {

	private $__gfbf_pluginlist = '';

	function __construct(){

		// Here list of plugins which can be active
		$this->__gfbf_pluginlist = [
			'autoptimize/autoptimize' => 'autoptimize_html_after_minify',
			'wp-fastest-cache/wpFastestCache' => 'wpfc_buffer_callback_filter',
			'wp-rocket/wp-rocket' => 'rocket_buffer',
			'w3-total-cache/w3-total-cache' => 'w3tc_process_content',
			'wp-super-cache/wp-cache' => 'wp_cache_ob_callback_filter'
		];

	}
	static function check_plugin(){
		
		foreach(self::$__gfbf_pluginlist as $pl_key => $pl_val){

			if (is_plugin_active($pl_key.'.php')) {

				add_filter($pl_val, function ($data) {
					return apply_filters('gfbf_bunny_fonts_filter_output', $data);
				});
			
			}

			//we use 'init' action to use ob_start()
			add_action('init', 'gfbf_bunny_init_ob');

			// get the pages html
			add_action('shutdown', 'gfbf_bunny_shutdown', 0);

		}

	}

}
?>