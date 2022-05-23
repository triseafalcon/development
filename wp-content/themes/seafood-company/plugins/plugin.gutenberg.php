<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_gutenberg_theme_setup')) {
    add_action( 'seafood_company_action_before_init_theme', 'seafood_company_gutenberg_theme_setup', 1 );
    function seafood_company_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'seafood_company_filter_required_plugins', 'seafood_company_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'seafood_company_exists_gutenberg' ) ) {
    function seafood_company_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_gutenberg_required_plugins' ) ) {
    
    function seafood_company_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)seafood_company_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'seafood-company'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}