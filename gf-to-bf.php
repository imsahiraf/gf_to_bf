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
$__gfbf_filelist = ['essential', 'plugin_check', 'hooks'];

foreach($__gfbf_filelist as $gf_key => $bf_value){
    require_once($bf_value);
}

$gfbf::check_plugin();
