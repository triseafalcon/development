<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_template_no_search_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_template_no_search_theme_setup', 1 );
	function seafood_company_template_no_search_theme_setup() {
		seafood_company_add_template(array(
			'layout' => 'no-search',
			'mode'   => 'internal',
			'title'  => esc_html__('No search results found', 'seafood-company')
		));
	}
}

// Template output
if ( !function_exists( 'seafood_company_template_no_search_output' ) ) {
	function seafood_company_template_no_search_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php echo sprintf(esc_html__('Search: %s', 'seafood-company'), get_search_query()); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'seafood-company' ); ?></p>
				<p><?php echo wp_kses_data( sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'seafood-company'), esc_url(home_url('/')), get_bloginfo()) ); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'seafood-company'); ?></p>
				<?php
                if(function_exists('seafood_company_sc_search'))
                seafood_company_show_layout(seafood_company_sc_search(array('state'=>"fixed"))); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>