<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_template_matches_2_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_template_matches_2_theme_setup', 1 );
	function seafood_company_template_matches_2_theme_setup() {
		seafood_company_add_template(array(
			'layout' => 'matches-2',
			'template' => 'matches-2',
			'mode'   => 'matches',
			'title'  => esc_html__('Matches /Style 2/', 'seafood-company'),
			'thumb_title'  => esc_html__('Medium square image (crop)', 'seafood-company'),
			'w' => 370,
			'h' => 370
		));
	}
}

// Template output
if ( !function_exists( 'seafood_company_template_matches_2_output' ) ) {
	function seafood_company_template_matches_2_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));

		?>
			<li<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
				class="sc_match sc_match_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
				<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!seafood_company_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(seafood_company_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>>			
				<?php
				if (!$post_data['post_protected']) {
					$post_options['info_parts'] = array('snippets'=>true);
					seafood_company_template_set_args('post-info', array(
						'post_options' => $post_options,
						'post_data' => $post_data
					));
					get_template_part(seafood_company_get_file_slug('templates/trx_matches/_parts/match-info.php'));
					
					$post_meta = get_post_meta($post_data['post_id'], seafood_company_storage_get('options_prefix') . '_post_options', true);
					$match_preview =(!empty($post_meta['match_link']) ? $post_meta['match_link'] : '');	
					$start_date = $post_meta['match_date'].' '.$post_meta['match_time'];
					$today = date("Y-m-d G:i");  
					$match_passed = false;
					if ($start_date > $today) {
						$match_passed = true;
					}
					if (!empty($match_preview) && $match_passed){
					?>
						<div class="match_preview"><a href="<?php echo esc_url($match_preview); ?>"><?php echo esc_html__("Go to the announcement &#8594;", 'seafood-company'); ?></a></div>
					<?php
					} 
				}	
				?>
			</li>
		<?php
	}
}
?>