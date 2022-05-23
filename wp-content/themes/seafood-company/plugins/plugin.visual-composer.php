<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_vc_theme_setup')) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_vc_theme_setup', 1 );
	function seafood_company_vc_theme_setup() {
		if (seafood_company_exists_visual_composer()) {
			add_action('seafood_company_action_add_styles',		 				'seafood_company_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'seafood_company_filter_required_plugins',					'seafood_company_vc_required_plugins' );
		}
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'seafood_company_exists_visual_composer' ) ) {
	function seafood_company_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'seafood_company_vc_is_frontend' ) ) {
	function seafood_company_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_vc_required_plugins' ) ) {
	
	function seafood_company_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', seafood_company_storage_get('required_plugins'))) {
			$path = seafood_company_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('WPBakery PageBuilder', 'seafood-company'),
					'slug' 		=> 'js_composer',
                    'version'   => '6.8.0',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'seafood_company_vc_frontend_scripts' ) ) {
	
	function seafood_company_vc_frontend_scripts() {
		if (file_exists(seafood_company_get_file_dir('css/plugin.visual-composer.css')))
			wp_enqueue_style( 'seafood-company-plugin-visual-composer-style',  seafood_company_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}

?>