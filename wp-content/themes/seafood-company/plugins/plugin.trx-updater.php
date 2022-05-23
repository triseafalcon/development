<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_trx_updater_theme_setup')) {
    add_action( 'seafood_company_action_before_init_theme', 'seafood_company_trx_updater_theme_setup', 1 );
    function seafood_company_trx_updater_theme_setup() {
        if (is_admin()) {
            add_filter( 'seafood_company_filter_required_plugins', 'seafood_company_trx_updater_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'seafood_company_exists_trx_updater' ) ) {
    function seafood_company_exists_trx_updater() {
        return function_exists( 'trx_updater_load_plugin_textdomain' );
    }
}



// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_trx_updater_required_plugins' ) ) {
    function seafood_company_trx_updater_required_plugins($list=array()) {
        if (in_array('trx-updater', (array)seafood_company_storage_get('required_plugins'))) {
            $path = seafood_company_get_file_dir('plugins/install/trx_updater.zip');
            if (file_exists($path)) {
                $list[] = array(
                    'name' 		=> esc_html__('ThemeREX Updater', 'seafood-company'),
                    'slug' 		=> 'trx_updater',
                    'source'	=> $path,
                    'version'   => '1.9.6',
                    'required' 	=> false
                );
            }
        }
        return $list;
    }
}