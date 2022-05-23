<?php
if (!function_exists('seafood_company_theme_shortcodes_setup')) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_theme_shortcodes_setup', 1 );
	function seafood_company_theme_shortcodes_setup() {
		add_filter('seafood_company_filter_googlemap_styles', 'seafood_company_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'seafood_company_theme_shortcodes_googlemap_styles' ) ) {
	function seafood_company_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'seafood-company');
		$list['greyscale']	= esc_html__('Greyscale', 'seafood-company');
		$list['inverse']	= esc_html__('Inverse', 'seafood-company');
		$list['apple']		= esc_html__('Apple', 'seafood-company');
		return $list;
	}
}
?>