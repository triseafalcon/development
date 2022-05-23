<?php
/* Product Delivery Date for WooCommerce - Lite
------------------------------------------------------------------------------- */


// Theme init
if (!function_exists('seafood_company_product_delivery_date_for_woocommerce_lite_theme_setup')) {
    add_action( 'seafood_company_action_before_init_theme', 'seafood_company_product_delivery_date_for_woocommerce_lite_theme_setup', 1 );
    function seafood_company_product_delivery_date_for_woocommerce_lite_theme_setup() {
        if (is_admin()) {
            add_filter( 'seafood_company_filter_required_plugins', 'seafood_company_product_delivery_date_for_woocommerce_lite_required_plugins' );
        }
    }
}

// Check if elegro Crypto Payment installed and activated
if ( !function_exists( 'seafood_company_exists_product_delivery_date_for_woocommerce_lite' ) ) {
    function seafood_company_exists_product_delivery_date_for_woocommerce_lite() {
        return function_exists('is_prdd_lite_active');
    }
}


// Filter to add in the required plugins list
if ( !function_exists( 'seafood_company_product_delivery_date_for_woocommerce_lite_required_plugins' ) ) {
    function seafood_company_product_delivery_date_for_woocommerce_lite_required_plugins($list=array()) {
        if (in_array('product-delivery-date-for-woocommerce-lite', (array)seafood_company_storage_get('required_plugins')))
            $list[] = array(
                'name' 		=> esc_html__('Product Delivery Date for WooCommerce - Lite', 'seafood-company'),
                'slug' 		=> 'product-delivery-date-for-woocommerce-lite',
                'required' 	=> false
            );
        return $list;
    }
}
