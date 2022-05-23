<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_revslider_theme_setup')) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_revslider_theme_setup', 1 );
	function seafood_company_revslider_theme_setup() {
		if (seafood_company_exists_revslider()) {
			add_filter( 'seafood_company_filter_list_sliders',					'seafood_company_revslider_list_sliders' );
			add_filter( 'seafood_company_filter_shortcodes_params',			'seafood_company_revslider_shortcodes_params' );
			add_filter( 'seafood_company_filter_theme_options_params',			'seafood_company_revslider_theme_options_params' );
		}
		if (is_admin()) {
			add_filter( 'seafood_company_filter_required_plugins',				'seafood_company_revslider_required_plugins' );
		}
	}
}

if ( !function_exists( 'seafood_company_revslider_settings_theme_setup2' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_revslider_settings_theme_setup2', 3 );
	function seafood_company_revslider_settings_theme_setup2() {
		if (seafood_company_exists_revslider()) {

			// Add Revslider specific options in the Theme Options
			seafood_company_storage_set_array_after('options', 'slider_engine', "slider_alias", array(
				"title" => esc_html__('Revolution Slider: Select slider',  'seafood-company'),
				"desc" => wp_kses_data( __("Select slider to show (if engine=revo in the field above)", 'seafood-company') ),
				"override" => "category,services_group,page",
				"dependency" => array(
					'show_slider' => array('yes'),
					'slider_engine' => array('revo')
				),
				"std" => "",
				"options" => seafood_company_get_options_param('list_revo_sliders'),
				"type" => "select"
				)
			);

		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'seafood_company_exists_revslider' ) ) {
	function seafood_company_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_revslider_required_plugins' ) ) {
	
	function seafood_company_revslider_required_plugins($list=array()) {
		if (in_array('revslider', seafood_company_storage_get('required_plugins'))) {
			$path = seafood_company_get_file_dir('plugins/install/revslider.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'seafood-company'),
					'slug' 		=> 'revslider',
					'source'	=> $path,
                    'version'   => '6.5.18',
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}



// Lists
//------------------------------------------------------------------------

// Add RevSlider in the sliders list, prepended inherit (if need)
if ( !function_exists( 'seafood_company_revslider_list_sliders' ) ) {
	
	function seafood_company_revslider_list_sliders($list=array()) {
		$list["revo"] = esc_html__("Layer slider (Revolution)", 'seafood-company');
		return $list;
	}
}

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'seafood_company_get_list_revo_sliders' ) ) {
	function seafood_company_get_list_revo_sliders($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_revo_sliders'))=='') {
			$list = array();
			if (seafood_company_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
			$list = apply_filters('seafood_company_filter_list_revo_sliders', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_revo_sliders', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Add RevSlider in the shortcodes params
if ( !function_exists( 'seafood_company_revslider_shortcodes_params' ) ) {
	
	function seafood_company_revslider_shortcodes_params($list=array()) {
		$list["revo_sliders"] = seafood_company_get_list_revo_sliders();
		return $list;
	}
}

// Add RevSlider in the Theme Options params
if ( !function_exists( 'seafood_company_revslider_theme_options_params' ) ) {
	
	function seafood_company_revslider_theme_options_params($list=array()) {
		$list["list_revo_sliders"] = array('$seafood_company_get_list_revo_sliders' => '');
		return $list;
	}
}
?>