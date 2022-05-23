<?php
/**
 * SeaFood Company Framework: return lists
 *
 * @package seafood_company
 * @since seafood_company 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'seafood_company_get_list_styles' ) ) {
	function seafood_company_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'seafood-company'), $i);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'seafood_company_get_list_margins' ) ) {
	function seafood_company_get_list_margins($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'seafood-company'),
				'tiny'		=> esc_html__('Tiny',		'seafood-company'),
				'small'		=> esc_html__('Small',		'seafood-company'),
				'medium'	=> esc_html__('Medium',		'seafood-company'),
				'large'		=> esc_html__('Large',		'seafood-company'),
				'huge'		=> esc_html__('Huge',		'seafood-company'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'seafood-company'),
				'small-'	=> esc_html__('Small (negative)',	'seafood-company'),
				'medium-'	=> esc_html__('Medium (negative)',	'seafood-company'),
				'large-'	=> esc_html__('Large (negative)',	'seafood-company'),
				'huge-'		=> esc_html__('Huge (negative)',	'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_margins', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'seafood_company_get_list_line_styles' ) ) {
	function seafood_company_get_list_line_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'seafood-company'),
				'dashed'=> esc_html__('Dashed', 'seafood-company'),
				'dotted'=> esc_html__('Dotted', 'seafood-company'),
				'double'=> esc_html__('Double', 'seafood-company'),
				'image'	=> esc_html__('Image', 'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_line_styles', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'seafood_company_get_list_animations' ) ) {
	function seafood_company_get_list_animations($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'seafood-company'),
				'bounce'		=> esc_html__('Bounce',		'seafood-company'),
				'elastic'		=> esc_html__('Elastic',	'seafood-company'),
				'flash'			=> esc_html__('Flash',		'seafood-company'),
				'flip'			=> esc_html__('Flip',		'seafood-company'),
				'pulse'			=> esc_html__('Pulse',		'seafood-company'),
				'rubberBand'	=> esc_html__('Rubber Band','seafood-company'),
				'shake'			=> esc_html__('Shake',		'seafood-company'),
				'swing'			=> esc_html__('Swing',		'seafood-company'),
				'tada'			=> esc_html__('Tada',		'seafood-company'),
				'wobble'		=> esc_html__('Wobble',		'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_animations', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'seafood_company_get_list_animations_in' ) ) {
	function seafood_company_get_list_animations_in($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'seafood-company'),
				'bounceIn'			=> esc_html__('Bounce In',			'seafood-company'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'seafood-company'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'seafood-company'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'seafood-company'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'seafood-company'),
				'elastic'			=> esc_html__('Elastic In',			'seafood-company'),
				'fadeIn'			=> esc_html__('Fade In',			'seafood-company'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'seafood-company'),
				'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'seafood-company'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'seafood-company'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'seafood-company'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'seafood-company'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'seafood-company'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'seafood-company'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'seafood-company'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'seafood-company'),
				'flipInX'			=> esc_html__('Flip In X',			'seafood-company'),
				'flipInY'			=> esc_html__('Flip In Y',			'seafood-company'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'seafood-company'),
				'rotateIn'			=> esc_html__('Rotate In',			'seafood-company'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','seafood-company'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'seafood-company'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'seafood-company'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','seafood-company'),
				'rollIn'			=> esc_html__('Roll In',			'seafood-company'),
				'slideInUp'			=> esc_html__('Slide In Up',		'seafood-company'),
				'slideInDown'		=> esc_html__('Slide In Down',		'seafood-company'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'seafood-company'),
				'slideInRight'		=> esc_html__('Slide In Right',		'seafood-company'),
				'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'seafood-company'),
				'zoomIn'			=> esc_html__('Zoom In',			'seafood-company'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'seafood-company'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'seafood-company'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'seafood-company'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_animations_in', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'seafood_company_get_list_animations_out' ) ) {
	function seafood_company_get_list_animations_out($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'seafood-company'),
				'bounceOut'			=> esc_html__('Bounce Out',			'seafood-company'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'seafood-company'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',	'seafood-company'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',	'seafood-company'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'seafood-company'),
				'fadeOut'			=> esc_html__('Fade Out',			'seafood-company'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',		'seafood-company'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',	'seafood-company'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'seafood-company'),
				'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','seafood-company'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'seafood-company'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'seafood-company'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'seafood-company'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'seafood-company'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'seafood-company'),
				'flipOutX'			=> esc_html__('Flip Out X',			'seafood-company'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'seafood-company'),
				'hinge'				=> esc_html__('Hinge Out',			'seafood-company'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',	'seafood-company'),
				'rotateOut'			=> esc_html__('Rotate Out',			'seafood-company'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left','seafood-company'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right','seafood-company'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',	'seafood-company'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right','seafood-company'),
				'rollOut'			=> esc_html__('Roll Out',			'seafood-company'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'seafood-company'),
				'slideOutDown'		=> esc_html__('Slide Out Down',		'seafood-company'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',		'seafood-company'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'seafood-company'),
				'zoomOut'			=> esc_html__('Zoom Out',			'seafood-company'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'seafood-company'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',		'seafood-company'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',		'seafood-company'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',		'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_animations_out', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('seafood_company_get_animation_classes')) {
	function seafood_company_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return seafood_company_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!seafood_company_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of the main menu hover effects
if ( !function_exists( 'seafood_company_get_list_menu_hovers' ) ) {
	function seafood_company_get_list_menu_hovers($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_menu_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',		'seafood-company'),
				'slide_line'	=> esc_html__('Slide Line',	'seafood-company'),
				'slide_box'		=> esc_html__('Slide Box',	'seafood-company'),
				'zoom_line'		=> esc_html__('Zoom Line',	'seafood-company'),
				'path_line'		=> esc_html__('Path Line',	'seafood-company'),
				'roll_down'		=> esc_html__('Roll Down',	'seafood-company'),
				'color_line'	=> esc_html__('Color Line',	'seafood-company'),
				);
			$list = apply_filters('seafood_company_filter_list_menu_hovers', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_menu_hovers', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the button's hover effects
if ( !function_exists( 'seafood_company_get_list_button_hovers' ) ) {
	function seafood_company_get_list_button_hovers($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_button_hovers'))=='') {
			$list = array(
				'default'		=> esc_html__('Default',			'seafood-company'),
				'fade'			=> esc_html__('Fade',				'seafood-company'),
				'slide_left'	=> esc_html__('Slide from Left',	'seafood-company'),
				'slide_top'		=> esc_html__('Slide from Top',		'seafood-company'),
				'arrow'			=> esc_html__('Arrow',				'seafood-company'),
				);
			$list = apply_filters('seafood_company_filter_list_button_hovers', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_button_hovers', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the input field's hover effects
if ( !function_exists( 'seafood_company_get_list_input_hovers' ) ) {
	function seafood_company_get_list_input_hovers($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_input_hovers'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'seafood-company'),
				'accent'	=> esc_html__('Accented',	'seafood-company'),
				'path'		=> esc_html__('Path',		'seafood-company'),
				'jump'		=> esc_html__('Jump',		'seafood-company'),
				'underline'	=> esc_html__('Underline',	'seafood-company'),
				'iconed'	=> esc_html__('Iconed',		'seafood-company'),
				);
			$list = apply_filters('seafood_company_filter_list_input_hovers', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_input_hovers', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the search field's styles
if ( !function_exists( 'seafood_company_get_list_search_styles' ) ) {
	function seafood_company_get_list_search_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_search_styles'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'seafood-company'),
				'fullscreen'=> esc_html__('Fullscreen',	'seafood-company'),
				'slide'		=> esc_html__('Slide',		'seafood-company'),
				'expand'	=> esc_html__('Expand',		'seafood-company'),
				);
			$list = apply_filters('seafood_company_filter_list_search_styles', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_search_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'seafood_company_get_list_categories' ) ) {
	function seafood_company_get_list_categories($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'seafood_company_get_list_terms' ) ) {
	function seafood_company_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = seafood_company_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = seafood_company_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'seafood_company_get_list_posts_types' ) ) {
	function seafood_company_get_list_posts_types($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('seafood_company_filter_list_post_types', array());
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'seafood_company_get_list_posts' ) ) {
	function seafood_company_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = seafood_company_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'seafood-company');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set($hash, $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'seafood_company_get_list_pages' ) ) {
	function seafood_company_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return seafood_company_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'seafood_company_get_list_users' ) ) {
	function seafood_company_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = seafood_company_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'seafood-company');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_users', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'seafood_company_get_list_sliders' ) ) {
	function seafood_company_get_list_sliders($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_list_sliders', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'seafood_company_get_list_slider_controls' ) ) {
	function seafood_company_get_list_slider_controls($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'seafood-company'),
				'side'		=> esc_html__('Side', 'seafood-company'),
				'bottom'	=> esc_html__('Bottom', 'seafood-company'),
				'pagination'=> esc_html__('Pagination', 'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_slider_controls', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'seafood_company_get_slider_controls_classes' ) ) {
	function seafood_company_get_slider_controls_classes($controls) {
		if (seafood_company_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'seafood_company_get_list_popup_engines' ) ) {
	function seafood_company_get_list_popup_engines($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'seafood-company'),
				"magnific"	=> esc_html__("Magnific popup", 'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_popup_engines', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_menus' ) ) {
	function seafood_company_get_list_menus($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'seafood-company');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'seafood_company_get_list_sidebars' ) ) {
	function seafood_company_get_list_sidebars($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_sidebars'))=='') {
			if (($list = seafood_company_storage_get('registered_sidebars'))=='') $list = array();
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'seafood_company_get_list_sidebars_positions' ) ) {
	function seafood_company_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'seafood-company'),
				'left'  => esc_html__('Left',  'seafood-company'),
				'right' => esc_html__('Right', 'seafood-company')
				);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'seafood_company_get_sidebar_class' ) ) {
	function seafood_company_get_sidebar_class() {
		$sb_main = seafood_company_get_custom_option('show_sidebar_main');
		$sb_outer = seafood_company_get_custom_option('show_sidebar_outer');
		return (seafood_company_param_is_off($sb_main) || !is_active_sidebar(seafood_company_get_custom_option('sidebar_main')) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (seafood_company_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_body_styles' ) ) {
	function seafood_company_get_list_body_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'seafood-company'),
				'wide'	=> esc_html__('Wide',		'seafood-company')
				);
			if (seafood_company_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'seafood-company');
				$list['fullscreen']	= esc_html__('Fullscreen',	'seafood-company');
			}
			$list = apply_filters('seafood_company_filter_list_body_styles', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates' ) ) {
	function seafood_company_get_list_templates($mode='') {
		if (($list = seafood_company_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = seafood_company_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: seafood_company_strtoproper($v['layout'])
										);
				}
			}
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates_blog' ) ) {
	function seafood_company_get_list_templates_blog($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_templates_blog'))=='') {
			$list = seafood_company_get_list_templates('blog');
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates_blogger' ) ) {
	function seafood_company_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_templates_blogger'))=='') {
			$list = seafood_company_array_merge(seafood_company_get_list_templates('blogger'), seafood_company_get_list_templates('blog'));
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates_single' ) ) {
	function seafood_company_get_list_templates_single($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_templates_single'))=='') {
			$list = seafood_company_get_list_templates('single');
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates_header' ) ) {
	function seafood_company_get_list_templates_header($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_templates_header'))=='') {
			$list = seafood_company_get_list_templates('header');
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_templates_forms' ) ) {
	function seafood_company_get_list_templates_forms($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_templates_forms'))=='') {
			$list = seafood_company_get_list_templates('forms');
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_article_styles' ) ) {
	function seafood_company_get_list_article_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'seafood-company'),
				"stretch" => esc_html__('Stretch', 'seafood-company')
				);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_post_formats_filters' ) ) {
	function seafood_company_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'seafood-company'),
				"thumbs"  => esc_html__('With thumbs', 'seafood-company'),
				"reviews" => esc_html__('With reviews', 'seafood-company'),
				"video"   => esc_html__('With videos', 'seafood-company'),
				"audio"   => esc_html__('With audios', 'seafood-company'),
				"gallery" => esc_html__('With galleries', 'seafood-company')
				);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_portfolio_filters' ) ) {
	function seafood_company_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'seafood-company'),
				"tags"		=> esc_html__('Tags', 'seafood-company'),
				"categories"=> esc_html__('Categories', 'seafood-company')
				);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_hovers' ) ) {
	function seafood_company_get_list_hovers($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'seafood-company');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'seafood-company');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'seafood-company');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'seafood-company');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'seafood-company');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'seafood-company');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'seafood-company');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'seafood-company');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'seafood-company');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'seafood-company');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'seafood-company');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'seafood-company');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'seafood-company');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'seafood-company');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'seafood-company');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'seafood-company');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'seafood-company');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'seafood-company');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'seafood-company');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'seafood-company');
			$list['square effect1']  = esc_html__('Square Effect 1',  'seafood-company');
			$list['square effect2']  = esc_html__('Square Effect 2',  'seafood-company');
			$list['square effect3']  = esc_html__('Square Effect 3',  'seafood-company');
			$list['square effect5']  = esc_html__('Square Effect 5',  'seafood-company');
			$list['square effect6']  = esc_html__('Square Effect 6',  'seafood-company');
			$list['square effect7']  = esc_html__('Square Effect 7',  'seafood-company');
			$list['square effect8']  = esc_html__('Square Effect 8',  'seafood-company');
			$list['square effect9']  = esc_html__('Square Effect 9',  'seafood-company');
			$list['square effect10'] = esc_html__('Square Effect 10',  'seafood-company');
			$list['square effect11'] = esc_html__('Square Effect 11',  'seafood-company');
			$list['square effect12'] = esc_html__('Square Effect 12',  'seafood-company');
			$list['square effect13'] = esc_html__('Square Effect 13',  'seafood-company');
			$list['square effect14'] = esc_html__('Square Effect 14',  'seafood-company');
			$list['square effect15'] = esc_html__('Square Effect 15',  'seafood-company');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'seafood-company');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'seafood-company');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'seafood-company');
			$list['square effect_more']  = esc_html__('Square Effect More',  'seafood-company');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'seafood-company');
			$list['square effect_pull']  = esc_html__('Square Effect Pull',  'seafood-company');
			$list['square effect_slide'] = esc_html__('Square Effect Slide', 'seafood-company');
			$list['square effect_border'] = esc_html__('Square Effect Border', 'seafood-company');
			$list = apply_filters('seafood_company_filter_portfolio_hovers', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'seafood_company_get_list_blog_counters' ) ) {
	function seafood_company_get_list_blog_counters($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'seafood-company'),
				'likes'		=> esc_html__('Likes', 'seafood-company'),
				'rating'	=> esc_html__('Rating', 'seafood-company'),
				'comments'	=> esc_html__('Comments', 'seafood-company')
				);
			$list = apply_filters('seafood_company_filter_list_blog_counters', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'seafood_company_get_list_alter_sizes' ) ) {
	function seafood_company_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'seafood-company'),
					'1_2' => esc_html__('1x2', 'seafood-company'),
					'2_1' => esc_html__('2x1', 'seafood-company'),
					'2_2' => esc_html__('2x2', 'seafood-company'),
					'1_3' => esc_html__('1x3', 'seafood-company'),
					'2_3' => esc_html__('2x3', 'seafood-company'),
					'3_1' => esc_html__('3x1', 'seafood-company'),
					'3_2' => esc_html__('3x2', 'seafood-company'),
					'3_3' => esc_html__('3x3', 'seafood-company')
					);
			$list = apply_filters('seafood_company_filter_portfolio_alter_sizes', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_hovers_directions' ) ) {
	function seafood_company_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'seafood-company'),
				'right_to_left' => esc_html__('Right to Left',  'seafood-company'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'seafood-company'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'seafood-company'),
				'scale_up'      => esc_html__('Scale Up',  'seafood-company'),
				'scale_down'    => esc_html__('Scale Down',  'seafood-company'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'seafood-company'),
				'from_left_and_right' => esc_html__('From Left and Right',  'seafood-company'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_portfolio_hovers_directions', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'seafood_company_get_list_label_positions' ) ) {
	function seafood_company_get_list_label_positions($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'seafood-company'),
				'bottom'	=> esc_html__('Bottom',		'seafood-company'),
				'left'		=> esc_html__('Left',		'seafood-company'),
				'over'		=> esc_html__('Over',		'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_label_positions', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'seafood_company_get_list_bg_image_positions' ) ) {
	function seafood_company_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'seafood-company'),
				'center top'   => esc_html__("Center Top", 'seafood-company'),
				'right top'    => esc_html__("Right Top", 'seafood-company'),
				'left center'  => esc_html__("Left Center", 'seafood-company'),
				'center center'=> esc_html__("Center Center", 'seafood-company'),
				'right center' => esc_html__("Right Center", 'seafood-company'),
				'left bottom'  => esc_html__("Left Bottom", 'seafood-company'),
				'center bottom'=> esc_html__("Center Bottom", 'seafood-company'),
				'right bottom' => esc_html__("Right Bottom", 'seafood-company')
			);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'seafood_company_get_list_bg_image_repeats' ) ) {
	function seafood_company_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'seafood-company'),
				'repeat-x'	=> esc_html__('Repeat X', 'seafood-company'),
				'repeat-y'	=> esc_html__('Repeat Y', 'seafood-company'),
				'no-repeat'	=> esc_html__('No Repeat', 'seafood-company')
			);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'seafood_company_get_list_bg_image_attachments' ) ) {
	function seafood_company_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'seafood-company'),
				'fixed'		=> esc_html__('Fixed', 'seafood-company'),
				'local'		=> esc_html__('Local', 'seafood-company')
			);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'seafood_company_get_list_bg_tints' ) ) {
	function seafood_company_get_list_bg_tints($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'seafood-company'),
				'light'	=> esc_html__('Light', 'seafood-company'),
				'dark'	=> esc_html__('Dark', 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_bg_tints', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_field_types' ) ) {
	function seafood_company_get_list_field_types($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'seafood-company'),
				'textarea' => esc_html__('Text Area','seafood-company'),
				'password' => esc_html__('Password',  'seafood-company'),
				'radio'    => esc_html__('Radio',  'seafood-company'),
				'checkbox' => esc_html__('Checkbox',  'seafood-company'),
				'select'   => esc_html__('Select',  'seafood-company'),
				'date'     => esc_html__('Date','seafood-company'),
				'time'     => esc_html__('Time','seafood-company'),
				'button'   => esc_html__('Button','seafood-company')
			);
			$list = apply_filters('seafood_company_filter_field_types', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'seafood_company_get_list_googlemap_styles' ) ) {
	function seafood_company_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_googlemap_styles', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return images list
if (!function_exists('seafood_company_get_list_images')) {
	function seafood_company_get_list_images($folder, $ext='', $only_names=false) {
		return function_exists('trx_utils_get_folder_list') ? trx_utils_get_folder_list($folder, $ext, $only_names) : array();
	}
}

// Return iconed classes list
if ( !function_exists( 'seafood_company_get_list_icons' ) ) {
	function seafood_company_get_list_icons($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_icons'))=='') {
			$list = seafood_company_parse_icons_classes(seafood_company_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'seafood_company_get_list_socials' ) ) {
	function seafood_company_get_list_socials($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_socials'))=='') {
			$list = seafood_company_get_list_images("images/socials", "png");
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'seafood_company_get_list_yesno' ) ) {
	function seafood_company_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'seafood-company'),
			'no'  => esc_html__("No", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'seafood_company_get_list_onoff' ) ) {
	function seafood_company_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'seafood-company'),
			"off" => esc_html__("Off", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'seafood_company_get_list_showhide' ) ) {
	function seafood_company_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'seafood-company'),
			"hide" => esc_html__("Hide", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'seafood_company_get_list_orderings' ) ) {
	function seafood_company_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'seafood-company'),
			"desc" => esc_html__("Descending", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'seafood_company_get_list_directions' ) ) {
	function seafood_company_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'seafood-company'),
			"vertical" => esc_html__("Vertical", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'seafood_company_get_list_shapes' ) ) {
	function seafood_company_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'seafood-company'),
			"square" => esc_html__("Square", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'seafood_company_get_list_sizes' ) ) {
	function seafood_company_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'seafood-company'),
			"small"  => esc_html__("Small", 'seafood-company'),
			"medium" => esc_html__("Medium", 'seafood-company'),
			"large"  => esc_html__("Large", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'seafood_company_get_list_controls' ) ) {
	function seafood_company_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'seafood-company'),
			"side" => esc_html__("Side", 'seafood-company'),
			"bottom" => esc_html__("Bottom", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'seafood_company_get_list_floats' ) ) {
	function seafood_company_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'seafood-company'),
			"left" => esc_html__("Float Left", 'seafood-company'),
			"right" => esc_html__("Float Right", 'seafood-company')
		);
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'seafood_company_get_list_alignments' ) ) {
	function seafood_company_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'seafood-company'),
			"left" => esc_html__("Left", 'seafood-company'),
			"center" => esc_html__("Center", 'seafood-company'),
			"right" => esc_html__("Right", 'seafood-company')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'seafood-company');
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'seafood_company_get_list_hpos' ) ) {
	function seafood_company_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'seafood-company');
		if ($center) $list['center'] = esc_html__("Center", 'seafood-company');
		$list['right'] = esc_html__("Right", 'seafood-company');
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'seafood_company_get_list_vpos' ) ) {
	function seafood_company_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'seafood-company');
		if ($center) $list['center'] = esc_html__("Center", 'seafood-company');
		$list['bottom'] = esc_html__("Bottom", 'seafood-company');
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'seafood_company_get_list_sortings' ) ) {
	function seafood_company_get_list_sortings($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'seafood-company'),
				"title" => esc_html__("Alphabetically", 'seafood-company'),
				"views" => esc_html__("Popular (views count)", 'seafood-company'),
				"comments" => esc_html__("Most commented (comments count)", 'seafood-company'),
				"author_rating" => esc_html__("Author rating", 'seafood-company'),
				"users_rating" => esc_html__("Visitors (users) rating", 'seafood-company'),
				"random" => esc_html__("Random", 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_list_sortings', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'seafood_company_get_list_columns' ) ) {
	function seafood_company_get_list_columns($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'seafood-company'),
				"1_1" => esc_html__("100%", 'seafood-company'),
				"1_2" => esc_html__("1/2", 'seafood-company'),
				"1_3" => esc_html__("1/3", 'seafood-company'),
				"2_3" => esc_html__("2/3", 'seafood-company'),
				"1_4" => esc_html__("1/4", 'seafood-company'),
				"3_4" => esc_html__("3/4", 'seafood-company'),
				"1_5" => esc_html__("1/5", 'seafood-company'),
				"2_5" => esc_html__("2/5", 'seafood-company'),
				"3_5" => esc_html__("3/5", 'seafood-company'),
				"4_5" => esc_html__("4/5", 'seafood-company'),
				"1_6" => esc_html__("1/6", 'seafood-company'),
				"5_6" => esc_html__("5/6", 'seafood-company'),
				"1_7" => esc_html__("1/7", 'seafood-company'),
				"2_7" => esc_html__("2/7", 'seafood-company'),
				"3_7" => esc_html__("3/7", 'seafood-company'),
				"4_7" => esc_html__("4/7", 'seafood-company'),
				"5_7" => esc_html__("5/7", 'seafood-company'),
				"6_7" => esc_html__("6/7", 'seafood-company'),
				"1_8" => esc_html__("1/8", 'seafood-company'),
				"3_8" => esc_html__("3/8", 'seafood-company'),
				"5_8" => esc_html__("5/8", 'seafood-company'),
				"7_8" => esc_html__("7/8", 'seafood-company'),
				"1_9" => esc_html__("1/9", 'seafood-company'),
				"2_9" => esc_html__("2/9", 'seafood-company'),
				"4_9" => esc_html__("4/9", 'seafood-company'),
				"5_9" => esc_html__("5/9", 'seafood-company'),
				"7_9" => esc_html__("7/9", 'seafood-company'),
				"8_9" => esc_html__("8/9", 'seafood-company'),
				"1_10"=> esc_html__("1/10", 'seafood-company'),
				"3_10"=> esc_html__("3/10", 'seafood-company'),
				"7_10"=> esc_html__("7/10", 'seafood-company'),
				"9_10"=> esc_html__("9/10", 'seafood-company'),
				"1_11"=> esc_html__("1/11", 'seafood-company'),
				"2_11"=> esc_html__("2/11", 'seafood-company'),
				"3_11"=> esc_html__("3/11", 'seafood-company'),
				"4_11"=> esc_html__("4/11", 'seafood-company'),
				"5_11"=> esc_html__("5/11", 'seafood-company'),
				"6_11"=> esc_html__("6/11", 'seafood-company'),
				"7_11"=> esc_html__("7/11", 'seafood-company'),
				"8_11"=> esc_html__("8/11", 'seafood-company'),
				"9_11"=> esc_html__("9/11", 'seafood-company'),
				"10_11"=> esc_html__("10/11", 'seafood-company'),
				"1_12"=> esc_html__("1/12", 'seafood-company'),
				"5_12"=> esc_html__("5/12", 'seafood-company'),
				"7_12"=> esc_html__("7/12", 'seafood-company'),
				"10_12"=> esc_html__("10/12", 'seafood-company'),
				"11_12"=> esc_html__("11/12", 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_list_columns', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'seafood_company_get_list_dedicated_locations' ) ) {
	function seafood_company_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'seafood-company'),
				"center"  => esc_html__('Above the text of the post', 'seafood-company'),
				"left"    => esc_html__('To the left the text of the post', 'seafood-company'),
				"right"   => esc_html__('To the right the text of the post', 'seafood-company'),
				"alter"   => esc_html__('Alternates for each post', 'seafood-company')
			);
			$list = apply_filters('seafood_company_filter_list_dedicated_locations', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'seafood_company_get_post_format_name' ) ) {
	function seafood_company_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'seafood-company') : esc_html__('galleries', 'seafood-company');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'seafood-company') : esc_html__('videos', 'seafood-company');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'seafood-company') : esc_html__('audios', 'seafood-company');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'seafood-company') : esc_html__('images', 'seafood-company');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'seafood-company') : esc_html__('quotes', 'seafood-company');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'seafood-company') : esc_html__('links', 'seafood-company');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'seafood-company') : esc_html__('statuses', 'seafood-company');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'seafood-company') : esc_html__('asides', 'seafood-company');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'seafood-company') : esc_html__('chats', 'seafood-company');
		else						$name = $single ? esc_html__('standard', 'seafood-company') : esc_html__('standards', 'seafood-company');
		return apply_filters('seafood_company_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'seafood_company_get_post_format_icon' ) ) {
	function seafood_company_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('seafood_company_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'seafood_company_get_list_fonts_styles' ) ) {
	function seafood_company_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','seafood-company'),
				'u' => esc_html__('U', 'seafood-company')
			);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'seafood_company_get_list_fonts' ) ) {
	function seafood_company_get_list_fonts($prepend_inherit=false) {
		if (($list = seafood_company_storage_get('list_fonts'))=='') {
			$list = array();
			$list = seafood_company_array_merge($list, seafood_company_get_list_font_faces());
			// Google and custom fonts list:
			$list = seafood_company_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('seafood_company_filter_list_fonts', $list);
			if (seafood_company_get_theme_setting('use_list_cache')) seafood_company_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? seafood_company_array_merge(array('inherit' => esc_html__("Inherit", 'seafood-company')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'seafood_company_get_list_font_faces' ) ) {
	function seafood_company_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$fonts = seafood_company_storage_get('required_custom_fonts');
		$list = array();
		if (is_array($fonts)) {
			foreach ($fonts as $font) {
				if (($url = seafood_company_get_file_url('css/font-face/'.trim($font).'/stylesheet.css'))!='') {
					$list[sprintf(esc_html__('%s (uploaded font)', 'seafood-company'), $font)] = array('css' => $url);
				}
			}
		}
		return $list;
	}
}
?>