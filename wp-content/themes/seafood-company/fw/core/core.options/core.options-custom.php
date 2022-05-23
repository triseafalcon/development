<?php
/**
 * SeaFood Company Framework: Theme options custom fields
 *
 * @package	seafood_company
 * @since	seafood_company 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_options_custom_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_options_custom_theme_setup' );
	function seafood_company_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'seafood_company_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'seafood_company_options_custom_load_scripts' ) ) {
	
	function seafood_company_options_custom_load_scripts() {
		wp_enqueue_script( 'seafood-company-options-custom-script',	seafood_company_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'seafood_company_show_custom_field' ) ) {
	function seafood_company_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(seafood_company_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager seafood_company_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'seafood-company') : esc_html__( 'Choose Image', 'seafood-company')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'seafood-company') : esc_html__( 'Choose Image', 'seafood-company')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'seafood-company') : esc_html__( 'Choose Image', 'seafood-company')) . '</a>';
				break;
		}
		return apply_filters('seafood_company_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>