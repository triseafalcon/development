<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_essgrids_theme_setup')) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_essgrids_theme_setup', 1 );
	function seafood_company_essgrids_theme_setup() {
		if (is_admin()) {
			add_filter( 'seafood_company_filter_required_plugins',				'seafood_company_essgrids_required_plugins' );
		}
	}
}


// Check if Ess. Grid installed and activated
if ( !function_exists( 'seafood_company_exists_essgrids' ) ) {
	function seafood_company_exists_essgrids() {
		return defined('EG_PLUGIN_PATH') || defined('ESG_PLUGIN_PATH');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_essgrids_required_plugins' ) ) {
	
	function seafood_company_essgrids_required_plugins($list=array()) {
		if (in_array('essgrids', seafood_company_storage_get('required_plugins'))) {
			$path = seafood_company_get_file_dir('plugins/install/essential-grid.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Essential Grid', 'seafood-company'),
					'slug' 		=> 'essential-grid',
					'version'   => '3.0.14',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}

?>