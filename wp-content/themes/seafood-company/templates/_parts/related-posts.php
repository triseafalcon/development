<?php
// Get template args
extract(seafood_company_template_last_args('single-footer'));

$need_dummy = true;

if (seafood_company_get_custom_option("show_post_related") == 'yes' && $post_data['post_type'] != 'page') {

	if (empty($body_style) && !empty($post_options['body_style'])) $body_style = $post_options['body_style'];
	if (empty($body_style)) $body_style = seafood_company_get_custom_option('body_style');
	
	$sidebar_present = !seafood_company_param_is_off(seafood_company_get_custom_option('show_sidebar_main'));

	if ($body_style!='fullscreen' && !$sidebar_present) {
		seafood_company_close_all_wrappers();
	}

	$need_wrap = $body_style=='fullscreen' || !$sidebar_present;

	$args = array( 
		'posts_per_page' => seafood_company_get_custom_option('post_related_count'),
		'post_type' => $post_data['post_type'], 
		'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
		'ignore_sticky_posts' => true,
		'post__not_in' => array($post_data['post_id']) 
	);
	
	if (!empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
		$args = seafood_company_query_add_posts_and_cats($args, '', $post_data['post_type'], $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids, $post_data['post_taxonomy']);
	$args = seafood_company_query_add_sort_order($args, seafood_company_get_custom_option('post_related_sort'), seafood_company_get_custom_option('post_related_order'));

	// Uncomment this section if you want filter related posts on post formats
	if ($post_data['post_type']=='post' && $post_data['post_format'] != '' && $post_data['post_format'] != 'standard') {
		if (!isset($args['tax_query'])) $args['tax_query'] = array();
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-' . ($post_data['post_format'])
			)
		);
	}

	$args = apply_filters('seafood_company_filter_related_posts_args', $args, $post_data);

	$recent_posts = get_posts( $args, OBJECT );

	$number = is_array($recent_posts) ? count($recent_posts) : 0;
	if ($number > 0) {
		$columns = max(1, seafood_company_get_custom_option('post_related_columns'));
		if ($columns < 2) {
			if ($number < 3)
				$columns = 3;
			else
				seafood_company_enqueue_slider();	// Add slider and scrollbar scripts
		}
		$need_dummy = false;
		?>
		<section class="related_wrap<?php echo ((int) $columns > 1 ? '' : ' scroll_wrap') . esc_attr(seafood_company_get_template_property('related', 'container_classes')); ?>">

			<?php if ($need_wrap) seafood_company_open_wrapper('<div class="content_wrap">'); ?>
			
			<h2 class="section_title"><?php echo apply_filters('seafood_company_filter_related_posts_title', esc_html__('Related Posts', 'seafood-company'), $post_data['post_type']); ?></h2>

			<?php if ($columns < 2) { ?>
			<div class="sc_scroll_container sc_scroll_controls sc_scroll_controls_horizontal sc_scroll_controls_type_top">
				<div class="sc_scroll sc_scroll_horizontal swiper-slider-container scroll-container" id="related_scroll">
					<div class="sc_scroll_wrapper swiper-wrapper">
						<div class="sc_scroll_slide swiper-slide">
			<?php } else if (seafood_company_get_template_property('related', 'need_columns')) { ?>
				<div class="columns_wrap">
			<?php } ?>
					<?php
					$i=0;
					if (is_array($recent_posts) && count($recent_posts) > 0) {
						foreach ($recent_posts as $recent) {
							$i++;
							seafood_company_show_post_layout(
								array(
									'layout' => 'related' . ($columns < 2 ? '' : '_'.max(2, min(4, $columns))),
									
									'number' => $i,
									'add_view_more' => false,
									'posts_on_page' => seafood_company_get_custom_option('post_related_count'),
									'columns_count' => $columns,
									'strip_teaser' => false,
									'sidebar' => !seafood_company_param_is_off(seafood_company_get_custom_option('show_sidebar_main')),
									'content' => seafood_company_get_template_property('related', 'need_content'),
									'terms_list' => seafood_company_get_template_property('related', 'need_terms')
								),
								null,
								$recent
							);
						}
					}
					?>
					
			<?php if ($columns < 2) { ?>
						</div>
				   </div>
					<div id="related_scroll_bar" class="sc_scroll_bar sc_scroll_bar_horizontal related_scroll_bar"></div>
				</div>
				<div class="sc_scroll_controls_wrap"><a class="sc_scroll_prev" href="#"></a><a class="sc_scroll_next" href="#"></a></div>
			</div>
			<?php } else if (seafood_company_get_template_property('related', 'need_columns')) { ?>
				</div>
			<?php } ?>

			<?php if ($need_wrap) seafood_company_close_wrapper(); ?>

		</section>
		<?php
	}
	if ($body_style!='fullscreen' && !$sidebar_present) seafood_company_open_all_wrappers();
}

if ($need_dummy) {
	?>
	<section class="related_wrap related_wrap_empty"></section>
	<?php
}
?>