<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move seafood_company_set_post_views to the javascript - counter will work under cache system
	if (seafood_company_get_custom_option('use_ajax_views_counter')=='no') {
        do_action('trx_utils_filter_set_post_views', get_the_ID());
	}

	seafood_company_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !seafood_company_param_is_off(seafood_company_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>