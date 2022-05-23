<?php
/* elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('seafood_company_woocommerce_elegro_payment_theme_setup')) {
    add_action( 'seafood_company_action_before_init_theme', 'seafood_company_woocommerce_elegro_payment_theme_setup', 1 );
    function seafood_company_woocommerce_elegro_payment_theme_setup() {
        if (is_admin()) {
            add_filter( 'seafood_company_filter_required_plugins', 'seafood_company_woocommerce_elegro_payment_required_plugins' );
        }
    }
}

// Check if elegro Crypto Payment installed and activated
if ( !function_exists( 'seafood_company_exists_woocommerce_elegro_payment' ) ) {
    function seafood_company_exists_woocommerce_elegro_payment() {
        return function_exists('init_Elegro_Payment');
    }
}


// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_woocommerce_elegro_payment_required_plugins' ) ) {
    function seafood_company_woocommerce_elegro_payment_required_plugins($list=array()) {
        if (in_array('elegro-payment', (array)seafood_company_storage_get('required_plugins')))
            $list[] = array(
                'name' 		=> esc_html__('elegro Crypto Payment', 'seafood-company'),
                'slug' 		=> 'elegro-payment',
                'required' 	=> false
            );
        return $list;
    }
}
