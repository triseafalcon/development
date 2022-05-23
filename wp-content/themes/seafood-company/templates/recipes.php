<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_template_recipes_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_template_recipes_theme_setup', 1 );
	function seafood_company_template_recipes_theme_setup() {
		seafood_company_add_template(array(
			'layout' => 'recipes_2',
			'template' => 'recipes',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Recipes tile (different height) /2 columns/', 'seafood-company'),
			'thumb_title'  => esc_html__('Medium recipes image', 'seafood-company'),
			'w'		 => 370,
			'h' => 230,
			));
		seafood_company_add_template(array(
			'layout' => 'recipes_3',
			'template' => 'recipes',
			'mode'   => 'blog',
			'need_isotope' => true,
			'title'  => esc_html__('Recipes tile /3 columns/', 'seafood-company'),
			'thumb_title'  => esc_html__('Medium recipes image', 'seafood-company'),
			'w'		 => 370,
			'h' => 230,
			));
		// Add template specific scripts
		add_action('seafood_company_action_blog_scripts', 'seafood_company_template_recipes_add_scripts');
	}
}

// Add template specific scripts
if (!function_exists('seafood_company_template_recipes_add_scripts')) {
	function seafood_company_template_recipes_add_scripts($style) {
		if (in_array(seafood_company_substr($style, 0, 8), array('classic_', 'recipes_'))) {
			wp_enqueue_script( 'isotope', seafood_company_get_file_url('js/jquery.isotope.min.js'), array(), null, true );
		}
	}
}

// Template output
if ( !function_exists( 'seafood_company_template_recipes_output' ) ) {
	function seafood_company_template_recipes_output($post_options, $post_data) {

		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($post_options['columns_count'])
			? (empty($parts[1]) ? 1 : (int) $parts[1])
			: $post_options['columns_count']
			));
		$tag = seafood_company_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<div class="isotope_item isotope_item_<?php echo esc_attr($style); ?> isotope_item_<?php echo esc_attr($post_options['layout']); ?> isotope_column_<?php echo esc_attr($columns); ?>
			<?php
			if ($post_options['filters'] != '') {
				if ($post_options['filters']=='categories' && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
					echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids);
				else if ($post_options['filters']=='tags' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids))
					echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids);
			}
			?>">
			<<?php seafood_company_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['layout']); ?>
			<?php echo ' post_format_'.esc_attr($post_data['post_format']) 
			. ($post_options['number']%2==0 ? ' even' : ' odd') 
			. ($post_options['number']==0 ? ' first' : '') 
			. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
			?>">

			<?php if ($post_data['post_video'] || $post_data['post_audio'] || $post_data['post_thumb'] ||  $post_data['post_gallery']) { ?>
				<div class="post_featured">
					<?php
					seafood_company_template_set_args('post-featured', array(
						'post_options' => $post_options,
						'post_data' => $post_data
						));
					get_template_part(seafood_company_get_file_slug('templates/_parts/post-featured.php'));
					?>
				</div>
				<?php } ?>

				<div class="post_content isotope_item_content">
					
					<?php


					if ($show_title) {
						if (!isset($post_options['links']) || $post_options['links']) {
							?>
							<h5 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php seafood_company_show_layout($post_data['post_title']); ?></a></h5>
							<?php
						} else {
							?>
							<h5 class="post_title"><?php seafood_company_show_layout($post_data['post_title']); ?></h5>
							<?php
						}
					}
					?>

					<div class="post_descr">
						<?php
						if ($post_data['post_protected']) {
							seafood_company_show_layout($post_data['post_excerpt']);
						} else {
							if ($post_data['post_excerpt']) {
								echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(seafood_company_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : seafood_company_get_custom_option('post_excerpt_maxlength_recipes'))).'</p>';
							}
							if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('Read more', 'seafood-company');
							if (!seafood_company_param_is_off($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
								?><a href="<?php echo esc_url($post_data['post_link']); ?>" class="sc_button sc_button_square sc_button_style_filled sc_button_size_small read_more_button  sc_button_hover_fade"><?php seafood_company_show_layout($post_options['readmore']); ?></a><?php
							}
						}

						?>
					</div>

				</div>				<!-- /.post_content -->
				</<?php seafood_company_show_layout($tag); ?>>	<!-- /.post_item -->
			</div>						<!-- /.isotope_item -->
			<?php
		}
	}
	?>