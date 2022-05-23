<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_cooked_theme_setup')) {
    add_action( 'seafood_company_action_before_init_theme', 'seafood_company_cooked_theme_setup', 1 );
    function seafood_company_cooked_theme_setup() {
        if (seafood_company_exists_cooked()) {
            add_filter('seafood_company_filter_list_post_types', 			'seafood_company_cooked_list_post_types');
        }
        if (is_admin()) {
            add_filter( 'seafood_company_filter_required_plugins', 'seafood_company_cooked_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'seafood_company_exists_cooked' ) ) {
    function seafood_company_exists_cooked() {
        return function_exists('Cooked');
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_cooked_required_plugins' ) ) {
    function seafood_company_cooked_required_plugins($list=array()) {
        if (in_array('cooked', (array)seafood_company_storage_get('required_plugins')))
            $path = seafood_company_get_file_dir('plugins/install/cooked.zip');
            $list[] = array(
                'name'         => esc_html__('Cooked – Recipe Plugin', 'seafood-company'),
                'slug'         => 'cooked',
                'source'	   => $path,
                'required'     => false
            );
        return $list;
    }
}

// Add custom post type into list
if ( !function_exists( 'seafood_company_cooked_list_post_types' ) ) {
    function seafood_company_cooked_list_post_types($list) {

        $list['cp_recipe'] = esc_html__('Recipe', 'seafood-company');
        return $list;
    }
}