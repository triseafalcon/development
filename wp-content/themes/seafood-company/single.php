<?php
/**
 * Single post
 */
get_header(); 

$single_style = seafood_company_storage_get('single_style');
if (empty($single_style)) $single_style = seafood_company_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	seafood_company_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !seafood_company_param_is_off(seafood_company_get_custom_option('show_sidebar_main')),
			'content' => seafood_company_get_template_property($single_style, 'need_content'),
			'terms_list' => seafood_company_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>