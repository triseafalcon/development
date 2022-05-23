<?php
/**
 * SeaFood Company Framework: Theme options manager
 *
 * @package	seafood_company
 * @since	seafood_company 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_options_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_options_theme_setup' );
	function seafood_company_options_theme_setup() {

		if ( is_admin() ) {
			// Add Theme Options in WP menu
			add_action('admin_menu', 								'seafood_company_options_admin_menu_item');

			if ( seafood_company_options_is_used() ) {

				// Ajax Save and Export Action handler
				add_action('wp_ajax_seafood_company_options_save', 		'seafood_company_options_save');
				

				// Ajax Import Action handler
				add_action('wp_ajax_seafood_company_options_import',		'seafood_company_options_import');
				

				// Prepare global variables
				seafood_company_storage_set('to_data', null);
				seafood_company_storage_set('to_delimiter', ',');
				seafood_company_storage_set('to_colorpicker', 'tiny');			// wp - WP colorpicker, custom - internal theme colorpicker, tiny - external script
			}
		}
		
	}
}


// Add 'Theme options' in Admin Interface
if ( !function_exists( 'seafood_company_options_admin_menu_item' ) ) {
	
	function seafood_company_options_admin_menu_item() {
		seafood_company_admin_add_menu_item('theme', array(
			'page_title' => esc_html__('Global Options', 'seafood-company'),
			'menu_title' => esc_html__('Theme Options', 'seafood-company'),
			'capability' => 'manage_options',
			'menu_slug'  => 'seafood_company_options',
			'callback'   => 'seafood_company_options_page',
			'icon'		 => ''
			)
		);
	}
}



/* Theme options utils
-------------------------------------------------------------------- */

// Check if theme options are now used
if ( !function_exists( 'seafood_company_options_is_used' ) ) {
	function seafood_company_options_is_used() {
		$used = false;

		if (is_admin()) {

			if (isset($_REQUEST['action']) && ($_REQUEST['action']=='seafood_company_options_save' || $_REQUEST['action']=='seafood_company_options_import'))		// AJAX: Save or Import Theme Options
				$used = true;

			else if (isset($_REQUEST['page']) && seafood_company_strpos($_REQUEST['page'], 'seafood_company_options')!==false)																// Edit Theme Options
				$used = true;

			else if (seafood_company_check_admin_page('post-new.php') || seafood_company_check_admin_page('post.php')) {		// Create or Edit Post (page, product, ...)
				$post_type = seafood_company_admin_get_current_post_type();
				if (empty($post_type)) $post_type = 'post';
				$used = seafood_company_get_override_key($post_type, 'post_type')!='';

			} else if (seafood_company_check_admin_page('edit-tags.php') || seafood_company_check_admin_page('term.php')) {		// Edit Taxonomy
				$inheritance = seafood_company_get_theme_inheritance();
				if (!empty($inheritance) && is_array($inheritance)) {
					$post_type = seafood_company_admin_get_current_post_type();
					if (empty($post_type)) $post_type = 'post';
					foreach ($inheritance as $k=>$v) {
						if (!empty($v['taxonomy']) && is_array($v['taxonomy'])) {
							foreach ($v['taxonomy'] as $tax) {
								if ( isset($_REQUEST['taxonomy']) && $_REQUEST['taxonomy']==$tax && in_array($post_type, $v['post_type']) ) {
									$used = true;
									break;
								}
							}
						}
					}
				}

			} else if ( isset($_POST['override_options_taxonomy_nonce']) ) {																				// AJAX: Save taxonomy
				$used = true;
			}

		} else {
			$used = (seafood_company_get_theme_option("allow_editor")=='yes' && 
						(
						(is_single() && current_user_can('edit_posts', get_the_ID())) 
						|| 
						(is_page() && current_user_can('edit_pages', get_the_ID()))
						)
					);
		}
		return apply_filters('seafood_company_filter_theme_options_is_used', $used);
	}
}


// Load all theme options
if ( !function_exists( 'seafood_company_load_main_options' ) ) {
	function seafood_company_load_main_options() {
		$values = get_option(seafood_company_storage_get('options_prefix') . '_options', array());
		$options = seafood_company_storage_get('options');
		if (is_array($options) && count($options) > 0) {
			foreach ($options as $id => $item) {
				if (isset($item['std'])) {
					if (isset($values[$id]))
						$options[$id]['val'] = $values[$id];
					else
						$options[$id]['val'] = $item['std'];
				}
			}
			seafood_company_storage_set('options', $options);
		}
		// Call actions after load options
		do_action('seafood_company_action_load_main_options');
	}
}


// Get custom options arrays (from current category, post, page, shop, event, etc.)
if ( !function_exists( 'seafood_company_load_custom_options' ) ) {
	function seafood_company_load_custom_options() {
		global $wp_query, $post;

		seafood_company_storage_set('custom_options', array());
		seafood_company_storage_set('post_options', array());
		seafood_company_storage_set('taxonomy_options', array());
		seafood_company_storage_set('template_options', array());
		seafood_company_storage_set('theme_options_loaded', false);
		
		if ( is_admin() ) {
			seafood_company_storage_set('theme_options_loaded', true);
			return;
		}

		// This way used then user set options in admin menu (new variant)
		$inheritance_key = seafood_company_detect_inheritance_key();
		if (!empty($inheritance_key)) $inheritance = seafood_company_get_theme_inheritance($inheritance_key);
		$slug = seafood_company_detect_template_slug($inheritance_key);
		if ( !empty($slug) ) {
			$tmp = false;
			if (empty($inheritance['use_options_page']) || $inheritance['use_options_page'])
				$tmp = get_option(seafood_company_storage_get('options_prefix') . '_options_template_'.trim($slug));
			// If settings for current slug not saved - use settings from compatible overriden type
			if ($tmp===false && !empty($inheritance['override'])) {
				$slug = seafood_company_get_template_slug($inheritance['override']);
				if ( !empty($slug) ) $tmp = get_option(seafood_company_storage_get('options_prefix') . '_options_template_'.trim($slug));
			}
			seafood_company_storage_set('template_options', $tmp===false ? array() : $tmp);
		}

		// Load taxonomy and post options
		if (!empty($inheritance_key)) {
			// Load taxonomy options
			if (!empty($inheritance['taxonomy']) && is_array($inheritance['taxonomy'])) {
				foreach ($inheritance['taxonomy'] as $tax) {
					$tax_obj = get_taxonomy($tax);
					$tax_query = !empty($tax_obj->query_var) ? $tax_obj->query_var : $tax;
					if ($tax == 'category' && is_category()) {		// Current page is category's archive (Categories need specific check)
						$tax_id = (int) get_query_var( 'cat' );
						if (empty($tax_id)) $tax_id = get_query_var( 'category_name' );
						seafood_company_storage_set('taxonomy_options', seafood_company_taxonomy_get_inherited_properties('category', $tax_id));
						break;
					} else if ($tax == 'post_tag' && is_tag()) {	// Current page is tag's archive (Tags need specific check)
						$tax_id = get_query_var( $tax_query );
						seafood_company_storage_set('taxonomy_options', seafood_company_taxonomy_get_inherited_properties('post_tag', $tax_id));
						break;
					} else if (is_tax($tax)) {						// Current page is custom taxonomy archive (All rest taxonomies check)
						$tax_id = get_query_var( $tax_query );
						seafood_company_storage_set('taxonomy_options', seafood_company_taxonomy_get_inherited_properties($tax, $tax_id));
						break;
					}
				}
			}
			// Load post options
			if ( is_singular() && (!seafood_company_storage_empty('page_template') || !seafood_company_storage_get('blog_streampage')) ) {
				$post_id = get_the_ID();
				if ( $post_id == 0 && !empty($wp_query->queried_object_id) ) $post_id = $wp_query->queried_object_id;
				seafood_company_storage_set('post_options', get_post_meta($post_id, seafood_company_storage_get('options_prefix') . '_post_options', true));
				if ( !empty($inheritance['post_type']) && !empty($inheritance['taxonomy'])
					&& ( in_array( get_query_var('post_type'), $inheritance['post_type']) 
						|| ( !empty($post->post_type) && in_array( $post->post_type, $inheritance['post_type']) )
						) 
					) {
					$tax_list = array();
					foreach ($inheritance['taxonomy'] as $tax) {
						$tax_terms = seafood_company_get_terms_by_post_id( array(
							'post_id'=>$post_id, 
							'taxonomy'=>$tax
							)
						);
						if (!empty($tax_terms[$tax]->terms)) {
							$tax_list[] = seafood_company_taxonomies_get_inherited_properties($tax, $tax_terms[$tax]);
						}
					}
					if (!empty($tax_list)) {
						$tmp = seafood_company_storage_get('taxonomy_options');
						foreach($tax_list as $tax_options) {
							if (!empty($tax_options) && is_array($tax_options)) {
								foreach($tax_options as $tk=>$tv) {
									if ( !isset($tmp[$tk]) || seafood_company_is_inherit_option($tmp[$tk]) ) {
										$tmp[$tk] = $tv;
									}
								}
							}
						}
						seafood_company_storage_set('taxonomy_options', $tmp);
					}
				}
			}
		}
		
		// Merge Template options with required for current page template
		$layout_name = seafood_company_get_custom_option(is_singular() && !seafood_company_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		if (!seafood_company_storage_empty('registered_templates', $layout_name, 'theme_options')) {
			seafood_company_storage_set('template_options', array_merge(seafood_company_storage_get('template_options'), seafood_company_storage_get_array('registered_templates', $layout_name, 'theme_options')));
		}
		
		do_action('seafood_company_action_load_custom_options');

		seafood_company_storage_set('theme_options_loaded', true);

	}
}


// Get theme setting
if ( !function_exists( 'seafood_company_get_theme_setting' ) ) {
	function seafood_company_get_theme_setting($option_name, $default='') {
		return seafood_company_storage_get_array('settings', $option_name, $default);
	}
}


// Set theme setting
if ( !function_exists( 'seafood_company_set_theme_setting' ) ) {
	function seafood_company_set_theme_setting($option_name, $value) {
		seafood_company_storage_set_array('settings', $option_name, $value);
	}
}


// Get theme option. If not exists - try get site option. If not exist - return default
if ( !function_exists( 'seafood_company_get_theme_option' ) ) {
	function seafood_company_get_theme_option($option_name, $default = false, $options = null) {
		static $last_options = false;
		$val = '';	
		if (is_array($options)) {
			if (isset($option[$option_name])) {
				$val = $option[$option_name]['val'];
			}
		} else if (seafood_company_storage_isset('options', $option_name, 'val')) {
			$val = seafood_company_storage_get_array('options', $option_name, 'val');
		} else {
			if ($last_options===false) $last_options = get_option(seafood_company_storage_get('options_prefix') . '_options', array());
			if (isset($last_options[$option_name])) {
				$val = $last_options[$option_name];
			} else if (seafood_company_storage_isset('options', $option_name, 'std')) {
				$val = seafood_company_storage_get_array('options', $option_name, 'std');
			}
		}
		if ($val === '') {	
			if (($val = get_option($option_name, false)) !== false) {
				return $val;
			} else {
				return $default;
			}
		} else {
			return $val;
		}
	}
}


// Return property value from request parameters < post options < category options < theme options
if ( !function_exists( 'seafood_company_get_custom_option' ) ) {
	function seafood_company_get_custom_option($name, $defa=null, $post_id=0, $post_type='post', $tax_id=0, $tax_type='category') {
		if (isset($_GET[$name]))
			$rez = sanitize_text_field($_GET[$name]);
		else {
			$hash_name = ($name).'_'.($tax_id).'_'.($post_id);
			if (!seafood_company_storage_empty('theme_options_loaded') && seafood_company_storage_isset('custom_options', $hash_name)) {
				$rez = seafood_company_storage_get_array('custom_options', $hash_name);
			} else {
				if ($tax_id > 0) {
					$rez = seafood_company_taxonomy_get_inherited_property($tax_type, $tax_id, $name);
					if ($rez=='') $rez = seafood_company_get_theme_option($name, $defa);
				} else if ($post_id > 0) {
					$rez = seafood_company_get_theme_option($name, $defa);
					$custom_options = get_post_meta($post_id, seafood_company_storage_get('options_prefix') . '_post_options', true);
					if (isset($custom_options[$name]) && !seafood_company_is_inherit_option($custom_options[$name])) {
						$rez = $custom_options[$name];
					} else {
						$terms = array();
						$tax = seafood_company_get_taxonomy_categories_by_post_type($post_type);
						$tax_obj = get_taxonomy($tax);
						$tax_query = !empty($tax_obj->query_var) ? $tax_obj->query_var : $tax;
						if ( ($tax=='category' && is_category()) || ($tax=='post_tag' && is_tag()) || is_tax($tax) ) {		// Current page is taxonomy's archive (Categories and Tags need specific check)
							$terms = array( get_queried_object() );
						} else {
							$taxes = seafood_company_get_terms_by_post_id(array('post_id'=>$post_id, 'taxonomy'=>$tax));
							if (!empty($taxes[$tax]->terms)) {
								$terms = $taxes[$tax]->terms;
							}
						}
						$tmp = '';
						if (!empty($terms)) {
							for ($cc = 0; $cc < count($terms) && (empty($tmp) || seafood_company_is_inherit_option($tmp)); $cc++) {
								$tmp = seafood_company_taxonomy_get_inherited_property($terms[$cc]->taxonomy, $terms[$cc]->term_id, $name);
							}
						}
						if ($tmp!='') $rez = $tmp;
					}
				} else {
					$rez = seafood_company_get_theme_option($name, $defa);
					if (seafood_company_get_theme_option('show_theme_customizer') == 'yes' && seafood_company_get_theme_option('remember_visitors_settings') == 'yes' && function_exists('seafood_company_get_value_gpc')) {
						$tmp = seafood_company_get_value_gpc($name, $rez);
						if (!seafood_company_is_inherit_option($tmp)) {
							$rez = $tmp;
						}
					}
					if (seafood_company_storage_isset('template_options', $name)) {
						 $tmp = seafood_company_storage_get_array('template_options', $name);
						 if (!seafood_company_is_inherit_option($tmp)) $rez = is_array($tmp) ? $tmp[0] : $tmp;
					}
					if (seafood_company_storage_isset('taxonomy_options', $name)) {
						 $tmp = seafood_company_storage_get_array('taxonomy_options', $name);
						 if (!seafood_company_is_inherit_option($tmp)) $rez = $tmp;
					}
					if (seafood_company_storage_isset('post_options', $name)) {
						 $tmp = seafood_company_storage_get_array('post_options', $name);
						 if (!seafood_company_is_inherit_option($tmp)) $rez = is_array($tmp) ? $tmp[0] : $tmp;
					}
				}
				$rez = apply_filters('seafood_company_filter_get_custom_option', $rez, $name);
				if (!seafood_company_storage_empty('theme_options_loaded')) seafood_company_storage_set_array('custom_options', $hash_name, $rez);
			}
		}
		return $rez;
	}
}

// Check params for "on" | "off" | "inherit" values
if (!function_exists('seafood_company_param_is_on')) {
	function seafood_company_param_is_on($prm) {
        return is_numeric( $prm ) && $prm > 0 || in_array(seafood_company_strtolower($prm), array('true', 'on', 'yes', 'show'));
	}
}
if (!function_exists('seafood_company_param_is_off')) {
	function seafood_company_param_is_off($prm) {
        return empty($prm) || is_numeric( $prm ) && $prm === 0 || in_array(seafood_company_strtolower($prm), array('false', 'off', 'no', 'none', 'hide'));
	}
}
if (!function_exists('seafood_company_param_is_inherit')) {
	function seafood_company_param_is_inherit($prm) {
		return in_array(seafood_company_strtolower($prm), array('inherit', 'default'));
	}
}

// Check option for inherit value
if ( !function_exists( 'seafood_company_is_inherit_option' ) ) {
	function seafood_company_is_inherit_option($value) {
		while (is_array($value) && count($value)>0) {
			foreach ($value as $val) {
				$value = $val;
				break;
			}
		}
		return seafood_company_strtolower($value)=='inherit';	
	}
}

// Return options_param value
if ( !function_exists( 'seafood_company_get_options_param' ) ) {
	function seafood_company_get_options_param($prm) {
		return seafood_company_storage_get_array('options_params', $prm);
	}
}

// Set options_param value
if ( !function_exists( 'seafood_company_set_options_param' ) ) {
	function seafood_company_set_options_param($prm, $val) {
		seafood_company_storage_set_array('options_params', $prm, $val);
	}
}



/* Theme options manager
-------------------------------------------------------------------- */

// Load required styles and scripts for Options Page
if ( !function_exists( 'seafood_company_options_load_scripts' ) ) {
	function seafood_company_options_load_scripts() {
		static $loaded = false;

		if (!$loaded) {
			$loaded = true;

			// SeaFood Company fontello styles
			wp_enqueue_style( 'fontello-admin-style',	seafood_company_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null);
			wp_enqueue_style( 'fontello-style', 			seafood_company_get_file_url('css/fontello/css/fontello.css'), array(), null);
			wp_enqueue_style( 'fontello-animation-style',seafood_company_get_file_url('css/fontello-admin/css/animation.css'), array(), null);
			// SeaFood Company options styles
			wp_enqueue_style( 'seafood-company-options-style',			seafood_company_get_file_url('core/core.options/css/core.options.css'), array(), null);
			wp_enqueue_style( 'seafood-company-options-datepicker-style',	seafood_company_get_file_url('core/core.options/css/core.options-datepicker.css'), array(), null);

			// WP core media scripts
			wp_enqueue_media();

			// Color Picker
			wp_enqueue_style( 'wp-color-picker', false, array(), null);
			wp_enqueue_script('wp-color-picker', false, array('jquery'), null, true);
			wp_enqueue_script( 'seafood-company-colors-script',		seafood_company_get_file_url('js/colorpicker/colors.js'), array('jquery'), null, true );
			
			wp_enqueue_script( 'seafood-company-colorpicker-script',	seafood_company_get_file_url('js/colorpicker/jqColorPicker.js'), array('jquery'), null, true );

			// Input masks for text fields

			// SeaFood Company core scripts
			wp_enqueue_script( 'seafood-company-core-utils-script',		seafood_company_get_file_url('js/core.utils.js'), array(), null, true );
			// SeaFood Company options scripts
			wp_enqueue_script( 'seafood-company-options-script',			seafood_company_get_file_url('core/core.options/js/core.options.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-datepicker'), null, true );
			wp_enqueue_script( 'seafood-company-options-custom-script',	seafood_company_get_file_url('core/core.options/js/core.options-custom.js'), array('seafood_company-options-script'), null, true );
		
			wp_localize_script( 'seafood-company-options-script', 'SEAFOOD_COMPANY_OPTIONS_DATA', seafood_company_storage_get('to_data') );

			seafood_company_enqueue_messages();
			seafood_company_enqueue_popup();
		}
	}
}


// Prepare javascripts global variables
if ( !function_exists( 'seafood_company_options_prepare_scripts' ) ) {
	function seafood_company_options_prepare_scripts($override='') {
		static $prepared = false;
		
		if (!$prepared) {
			$prepared = true;

			if (empty($override)) $override = 'general';

			seafood_company_storage_set_array('js_vars', 'to_delimiter', 	seafood_company_storage_get('to_delimiter'));
			seafood_company_storage_set_array('js_vars', 'to_slug', 		seafood_company_storage_get_array('to_flags', 'slug'));
			seafood_company_storage_set_array('js_vars', 'to_popup', 		seafood_company_get_theme_option('popup_engine'));
			seafood_company_storage_set_array('js_vars', 'to_override',	$override);
			$list = '';
			if (($export_opts = get_option(seafood_company_storage_get('options_prefix') . '_options_export_'.($override), false)) !== false)
				$list = array_keys($export_opts);
			seafood_company_storage_set_array('js_vars', 'to_export_list',	$list);

			seafood_company_storage_set_array2('js_vars', 'to_strings', 'del_item_error',			esc_html__("You can't delete last item! To disable it - just clear value in field.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'del_item',				esc_html__("Delete item error!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'recompile_styles',		esc_html__("When saving color schemes and font settings, recompilation of .less files occurs. It may take from 5 to 15 secs dependning on your server's speed and size of .less files.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'wait',					esc_html__("Please wait a few seconds!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'reload_page',				esc_html__("After 3 seconds this page will be reloaded.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'save_options',			esc_html__("Options saved!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'reset_options',			esc_html__("Options reset!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'reset_options_confirm',	esc_html__("Do you really want reset all options to default values?", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'reset_options_complete',	esc_html__("Settings are reset to their default values.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options_header',	esc_html__("Export options", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options_error',	esc_html__("Name for options set is not selected! Export cancelled.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options_label',	esc_html__("Name for the options set:", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options_label2',	esc_html__("or select one of exists set (for replace):", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options_select',	esc_html__("Select set for replace ...", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_empty',			esc_html__("No exported sets for import!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_options',			esc_html__("Options exported!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_link',				esc_html__("If need, you can download the configuration file from the following link: %s", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'export_download',			esc_html__("Download theme options settings", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_label',	esc_html__("or put here previously exported data:", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_label2',	esc_html__("or select file with saved settings:", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_header',	esc_html__("Import options", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_error',	esc_html__("You need select the name for options set or paste import data! Import cancelled.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_failed',	esc_html__("Error while import options! Import cancelled.", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options_broken',	esc_html__("Attention! Some options are not imported:", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_options',			esc_html__("Options imported!", 'seafood-company'));
			seafood_company_storage_set_array2('js_vars', 'to_strings', 'import_dummy_confirm',	esc_html__("Attention! During the import process, all existing data will be replaced with new.", 'seafood-company'));
		}
	}
}


// Build the Options Page
if ( !function_exists( 'seafood_company_options_page' ) ) {
	function seafood_company_options_page() {

		$page = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : '';
		$mode = isset($_REQUEST['subpage']) ? sanitize_text_field($_REQUEST['subpage']) : '';
		$override = $slug = '';
		if (!empty($mode)) {
			$inheritance = seafood_company_get_theme_inheritance();
			if (!empty($inheritance) && is_array($inheritance)) {
				foreach ($inheritance as $k=>$v) {
					$tpl = false;
					if (!empty($v['stream_template'])) {
						$cur_slug = seafood_company_get_slug($v['stream_template']);
						$tpl = true;
						if ($mode == $cur_slug) {
							$override = !empty($v['override']) ? $v['override'] : $k;
							$slug = $cur_slug;
							break;
						}
					}
					if (!empty($v['single_template'])) {
						$cur_slug = seafood_company_get_slug($v['single_template']);
						$tpl = true;
						if ($mode == $cur_slug) {
							$override = !empty($v['override']) ? $v['override'] : $k;
							$slug = $cur_slug;
							break;
						}
					}
					if (!$tpl) {
						$cur_slug = seafood_company_get_slug($k);
						$tpl = true;
						if ($mode == $cur_slug) {
							$override = !empty($v['override']) ? $v['override'] : $k;
							$slug = $cur_slug;
							break;
						}
					}
				}
			}
		}

		$custom_options = empty($override) ? false : get_option(seafood_company_storage_get('options_prefix') . '_options'.(!empty($slug) ? '_template_'.trim($slug) : ''));

		seafood_company_options_page_start(array(
			'add_inherit' => !empty($override),
			'subtitle' => empty($slug) 
								? (empty($override) 
									? esc_html__('Global Options', 'seafood-company')
									: '') 
								: seafood_company_strtoproper(str_replace('_', ' ', $slug)) . ' ' . esc_html__('Options', 'seafood-company'),
			'description' => empty($slug) 
								? (empty($override) 
									? wp_kses_data( __("Global settings affect the entire website's display. They can be overriden when editing settings for a certain post type (if select it in the popup menu above) or when editing category or single page/post (affect only on this category/page/post)", 'seafood-company') )
									: '') 
								: wp_kses_data( __('Settings template for a certain post type: affects the display of just one specific post type. They can be overriden when editing categories and/or posts of a certain type', 'seafood-company') ),
			'subpage' => $mode,
			'slug' => $slug,
			'override' => $override
		));

		$to_data = seafood_company_storage_get('to_data');
		if (is_array($to_data) && count($to_data) > 0) {
			foreach ($to_data as $id=>$field) {
				if (!empty($override) && (!isset($field['override']) || !in_array($override, explode(',', $field['override'])))) continue;
				seafood_company_options_show_field( $id, $field, empty($override) ? null : (isset($custom_options[$id]) ? $custom_options[$id] : 'inherit') );
			}
		}
	
		seafood_company_options_page_stop();
	}
}


// Start render the options page (initialize flags)
if ( !function_exists( 'seafood_company_options_page_start' ) ) {
	function seafood_company_options_page_start($args = array()) {
		$to_flags = array_merge(array(
			'data'				=> null,
			'title'				=> esc_html__('Theme Options', 'seafood-company'),	// Theme Options page title
			'subtitle'			=> '',								// Subtitle for top of page
			'description'		=> '',								// Description for top of page
			'icon'				=> 'iconadmin-cog',					// Theme Options page icon
			'nesting'			=> array(),							// Nesting stack for partitions, tabs and groups
			'radio_as_select'	=> false,							// Display options[type="radio"] as options[type="select"]
			'add_inherit'		=> false,							// Add value "Inherit" in all options with lists
			'create_form'		=> true,							// Create tag form or use form from current page
			'buttons'			=> array('save', 'reset', 'import', 'export'),	// Buttons set
			'subpage'			=> '',								// Current options subpage
			'slug'				=> '',								// Slug for save options. If empty - global options
			'override'			=> ''								// Override mode - page|post|category|products-category|...
			), is_array($args) ? $args : array( 'add_inherit' => $args ));
		seafood_company_storage_set('to_flags', $to_flags);
		seafood_company_storage_set('to_data', empty($args['data']) ? seafood_company_storage_get('options') : $args['data']);
		// Load required styles and scripts for Options Page
		seafood_company_options_load_scripts();
		// Prepare javascripts global variables
		seafood_company_options_prepare_scripts($to_flags['override']);
		?>
		<div class="seafood_company_options">
			<?php if ($to_flags['create_form']) { ?>
			<form class="seafood_company_options_form">
			<?php }	?>
				<div class="seafood_company_options_header">
					<div id="seafood_company_options_logo" class="seafood_company_options_logo">
						<span class="<?php echo esc_attr($to_flags['icon']); ?>"></span>
						<h2><?php seafood_company_show_layout($to_flags['title']); ?></h2>
					</div>
					<?php if (in_array('import', $to_flags['buttons'])) { ?>
					<div class="seafood_company_options_button_import"><span class="iconadmin-download"></span><?php esc_html_e('Import', 'seafood-company'); ?></div>
					<?php }	?>
					<?php if (in_array('export', $to_flags['buttons'])) { ?>
					<div class="seafood_company_options_button_export"><span class="iconadmin-upload"></span><?php esc_html_e('Export', 'seafood-company'); ?></div>
					<?php }	?>
					<?php if (in_array('reset', $to_flags['buttons'])) { ?>
					<div class="seafood_company_options_button_reset"><span class="iconadmin-spin3"></span><?php esc_html_e('Reset', 'seafood-company'); ?></div>
					<?php }	?>
					<?php if (in_array('save', $to_flags['buttons'])) { ?>
					<div class="seafood_company_options_button_save"><span class="iconadmin-check"></span><?php esc_html_e('Save', 'seafood-company'); ?></div>
					<?php }	?>
					<div id="seafood_company_options_title" class="seafood_company_options_title">
						<h2><?php echo (!empty($to_flags['create_form']) ? '<a href="#" class="seafood_company_options_override_title">' : '') . trim($to_flags['subtitle']) . ($to_flags['create_form'] ? '</a>' : ''); ?></h2>
						<?php
						if ($to_flags['create_form']) seafood_company_options_show_override_menu($to_flags);
						?>
						<p><?php seafood_company_show_layout($to_flags['description']); ?></p>
					</div>
				</div>
				<div class="seafood_company_options_body">
		<?php
	}
}


// Finish render the options page (close groups, tabs and partitions)
if ( !function_exists( 'seafood_company_options_page_stop' ) ) {
	function seafood_company_options_page_stop() {
		seafood_company_show_layout(seafood_company_options_close_nested_groups('', true));
				?>
				</div> <!-- .seafood_company_options_body -->
				<?php
		if (seafood_company_storage_get_array('to_flags', 'create_form')) {
			?>
			</form>
			<?php
		}
		?>
		</div>	<!-- .seafood_company_options -->
		<?php
	}
}


// Add popup menu with override modes
if ( !function_exists( 'seafood_company_options_show_override_menu' ) ) {
	function seafood_company_options_show_override_menu($to_flags) {
		$menu_url = menu_page_url('seafood_company_options', false);
		// Add submenu items for each inheritance item
		$items = array(
			'00_global' => '<a href="'.esc_url($menu_url).'"'.($to_flags['subpage']=='' ? ' class="selected"' : '').'>'.esc_html__('Global Options', 'seafood-company').'</a>'
		);
		$inheritance = seafood_company_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach($inheritance as $k=>$v) {
				if (isset($v['use_options_page']) && !$v['use_options_page']) continue;
				$tpl = false;
				$title_slug = $slug = seafood_company_get_slug($k);
				$title = seafood_company_strtoproper(str_replace('_', ' ', $title_slug));
				$items_idx = sprintf('%02d', !empty($v['priority']) ? $v['priority'] : 99) . '_' . $title_slug;
				if (!empty($v['stream_template'])) {
					$slug = seafood_company_get_slug($v['stream_template']);
					if (!empty($v['single_template'])) $title = seafood_company_strtoproper(sprintf(esc_html__('%s Stream', 'seafood-company'), $title_slug));
					$items[$items_idx.'_blog'] = '<a href="'.esc_url($menu_url.'&subpage='.$slug).'"'.($to_flags['subpage']==$slug ? ' class="selected"' : '').'>'.esc_html($title).'</a>';
					$tpl = true;
				}
				if (!empty($v['single_template'])) {
					$slug = seafood_company_get_slug($v['single_template']);
					if (!empty($v['stream_template'])) $title = seafood_company_strtoproper(sprintf(esc_html__('%s Single', 'seafood-company'), $title_slug));
					$items[$items_idx.'_single'] = '<a href="'.esc_url($menu_url.'&subpage='.$slug).'"'.($to_flags['subpage']==$slug ? ' class="selected"' : '').'>'.esc_html($title).'</a>';
					$tpl = true;
				}
				if (!$tpl) {
					$items[$items_idx] = '<a href="'.esc_url($menu_url.'&subpage='.$slug).'"'.($to_flags['subpage']==$slug ? ' class="selected"' : '').'>'.esc_html($title).'</a>';
				}
			}
		}
		if (count($items) > 1) {
			echo '<div class="seafood_company_options_override_menu">';
			ksort($items);
			foreach ($items as $item)
				seafood_company_show_layout($item);
			echo '</div>';
		}
	}
}


// Return true if current type is groups type
if ( !function_exists( 'seafood_company_options_is_group' ) ) {
	function seafood_company_options_is_group($type) {
		return in_array($type, array('group', 'toggle', 'accordion', 'tab', 'partition'));
	}
}


// Close nested groups until type
if ( !function_exists( 'seafood_company_options_close_nested_groups' ) ) {
	function seafood_company_options_close_nested_groups($type='', $end=false) {
		$output = '';
		$nesting = seafood_company_storage_get_array('to_flags', 'nesting');
		if ($nesting) {
			for ($i=count($nesting)-1; $i>=0; $i--) {
				$container = array_pop($nesting);
				switch ($container) {
					case 'group':
						$output = '</fieldset>' . ($output);
						break;
					case 'toggle':
						$output = '</div></div>' . ($output);
						break;
					case 'tab':
					case 'partition':
						$output = '</div>' . ($container!=$type || $end ? '</div>' : '') . ($output);
						break;
					case 'accordion':
						$output = '</div></div>' . ($container!=$type || $end ? '</div>' : '') . ($output);
						break;
				}
				if ($type == $container)
					break;
			}
			seafood_company_storage_set_array('to_flags', 'nesting', $nesting);
		}
		return $output;
	}
}


// Collect tabs titles for current tabs or partitions
if ( !function_exists( 'seafood_company_options_collect_tabs' ) ) {
	function seafood_company_options_collect_tabs($type, $id) {
		$start = false;
		$nesting = array();
		$tabs = '';
		$to_data = seafood_company_storage_get('to_data');
		if (is_array($to_data) && count($to_data) > 0) {
			foreach ($to_data as $field_id=>$field) {
				if (!seafood_company_storage_empty('to_flags', 'override') && (empty($field['override']) || !in_array(seafood_company_storage_get_array('to_flags', 'override'), explode(',', $field['override'])))) continue;
				if ($field['type']==$type && !empty($field['start']) && $field['start']==$id)
					$start = true;
				if (!$start) continue;
				if (seafood_company_options_is_group($field['type'])) {
					if (empty($field['start']) && (!in_array($field['type'], array('group', 'toggle')) || !empty($field['end']))) {
						if ($nesting) {
							for ($i = count($nesting)-1; $i>=0; $i--) {
								$container = array_pop($nesting);
								if ($field['type'] == $container) {
									break;
								}
							}
						}
					}
					if (empty($field['end'])) {
						if (!$nesting) {
							if ($field['type']==$type) {
								$tabs .= '<li id="'.esc_attr($field_id).'">'
									. '<a id="'.esc_attr($field_id).'_title"'
										. ' href="#'.esc_attr($field_id).'_content"'
										. (!empty($field['action']) ? ' onclick="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
										. '>'
										. (!empty($field['icon']) ? '<span class="'.esc_attr($field['icon']).'"></span>' : '')
										. ($field['title'])
										. '</a>';
							} else
								break;
						}
						array_push($nesting, $field['type']);
					}
				}
			}
	    }
		return $tabs;
	}
}



// Return menu items list (menu, images or icons)
if ( !function_exists( 'seafood_company_options_menu_list' ) ) {
	function seafood_company_options_menu_list($field, $clone_val) {

		$to_delimiter = seafood_company_storage_get('to_delimiter');

		if ($field['type'] == 'socials') $clone_val = $clone_val['icon'];
		$list = '<div class="seafood_company_options_input_menu '.(empty($field['style']) ? '' : ' seafood_company_options_input_menu_'.esc_attr($field['style'])).'">';
		$caption = '';
		if (is_array($field['options']) && count($field['options']) > 0) {
			foreach ($field['options'] as $key => $item) {
				if (in_array($field['type'], array('list', 'icons', 'socials'))) $key = $item;
				$selected = '';
				if (seafood_company_strpos(($to_delimiter).($clone_val).($to_delimiter), ($to_delimiter).($key).($to_delimiter))!==false) {
					$caption = esc_attr($item);
					$selected = ' seafood_company_options_state_checked';
				}
				$list .= '<span class="seafood_company_options_menuitem' 
					. ($selected) 
					. '" data-value="'.esc_attr($key).'"'
					. '>';
				if (in_array($field['type'], array('list', 'select', 'fonts')))
					$list .= $item;
				else if ($field['type'] == 'icons' || ($field['type'] == 'socials' && $field['style'] == 'icons'))
					$list .= '<span class="'.esc_attr($item).'"></span>';
				else if ($field['type'] == 'images' || ($field['type'] == 'socials' && $field['style'] == 'images'))
					$list .= '<span style="background-image:url('.esc_url($item).')" data-src="'.esc_url($item).'" data-icon="'.esc_attr($key).'" class="seafood_company_options_input_image"></span>';
				$list .= '</span>';
			}
		}
		$list .= '</div>';
		return array($list, $caption);
	}
}


// Return action buttom
if ( !function_exists( 'seafood_company_options_action_button' ) ) {
	function seafood_company_options_action_button($data, $type) {
		$class = ' seafood_company_options_button_'.esc_attr($type).(!empty($data['icon']) ? ' seafood_company_options_button_'.esc_attr($type).'_small' : '');
		$output = '<span class="' 
					. ($type == 'button' ? 'seafood_company_options_input_button'  : 'seafood_company_options_field_'.esc_attr($type))
					. (!empty($data['action']) ? ' seafood_company_options_with_action' : '')
					. (!empty($data['icon']) ? ' '.esc_attr($data['icon']) : '')
					. '"'
					. (!empty($data['icon']) && !empty($data['title']) ? ' title="'.esc_attr($data['title']).'"' : '')
					. (!empty($data['action']) ? ' onclick="seafood_company_options_action_'.esc_attr($data['action']).'(this);return false;"' : '')
					. (!empty($data['type']) ? ' data-type="'.esc_attr($data['type']).'"' : '')
					. (!empty($data['multiple']) ? ' data-multiple="'.esc_attr($data['multiple']).'"' : '')
					. (!empty($data['sizes']) ? ' data-sizes="'.esc_attr($data['sizes']).'"' : '')
					. (!empty($data['linked_field']) ? ' data-linked-field="'.esc_attr($data['linked_field']).'"' : '')
					. (!empty($data['captions']['choose']) ? ' data-caption-choose="'.esc_attr($data['captions']['choose']).'"' : '')
					. (!empty($data['captions']['update']) ? ' data-caption-update="'.esc_attr($data['captions']['update']).'"' : '')
					. '>'
					. ($type == 'button' || (empty($data['icon']) && !empty($data['title'])) ? $data['title'] : '')
					. '</span>';
		return array($output, $class);
	}
}


// Theme options page show option field
if ( !function_exists( 'seafood_company_options_show_field' ) ) {
	function seafood_company_options_show_field($id, $field, $value=null) {
	
		// Set start field value
		if ($value !== null) $field['val'] = $value;
		if (!isset($field['val']) || $field['val']=='') $field['val'] = 'inherit';
		if (!empty($field['subset'])) {
			$sbs = seafood_company_get_theme_option($field['subset'], '', seafood_company_storage_get('to_data'));
			$field['val'] = isset($field['val'][$sbs]) ? $field['val'][$sbs] : '';
		}
		
		if (empty($id))
			$id = 'seafood_company_options_id_'.str_replace('.', '', mt_rand());
		if (!isset($field['title']))
			$field['title'] = '';
		
		// Options delimiter 
		$to_delimiter = seafood_company_storage_get('to_delimiter');
		
		// Divider before field
		$divider = (!isset($field['divider']) && !in_array($field['type'], array('info', 'partition', 'tab', 'toggle'))) || (isset($field['divider']) && $field['divider']) ? ' seafood_company_options_divider' : '';

		// Setup default parameters
		if ($field['type']=='media') {
			if (!isset($field['before'])) $field['before'] = array();
			$field['before'] = array_merge(array(
					'title' => esc_html__('Choose image', 'seafood-company'),
					'action' => 'media_upload',
					'type' => 'image',
					'multiple' => false,
					'sizes' => false,
					'linked_field' => '',
					'captions' => array('choose' => esc_html__( 'Choose image', 'seafood-company'),
										'update' => esc_html__( 'Select image', 'seafood-company')
										)
				), $field['before']);
			if (!isset($field['after'])) $field['after'] = array();
			$field['after'] = array_merge(array(
					'icon'=>'iconadmin-cancel',
					'action'=>'media_reset'
				), $field['after']);
		}
		if ($field['type']=='color' && (seafood_company_storage_get('to_colorpicker')=='tiny' || (isset($field['style']) && $field['style']!='wp'))) {
			if (!isset($field['after'])) $field['after'] = array();
			$field['after'] = array_merge(array(
					'icon'=>'iconadmin-cancel',
					'action'=>'color_reset'
				), $field['after']);
		}

		// Buttons before and after field
		$before = $after = $buttons_classes = '';
		if (!empty($field['before'])) {
			list($before, $class) = seafood_company_options_action_button($field['before'], 'before');
			$buttons_classes .= $class;
		}
		if (!empty($field['after'])) {
			list($after, $class) = seafood_company_options_action_button($field['after'], 'after');
			$buttons_classes .= $class;
		}
		if ( in_array($field['type'], array('list', 'select', 'fonts')) || ($field['type']=='socials' && (empty($field['style']) || $field['style']=='icons')) ) {
			$buttons_classes .= ' seafood_company_options_button_after_small';
		}
	
		// Is it inherit field?
		$inherit = seafood_company_is_inherit_option($field['val']) ? 'inherit' : '';
	
		// Is it cloneable field?
		$cloneable = isset($field['cloneable']) && $field['cloneable'];
	
		// Prepare field
		if (!$cloneable)
			$field['val'] = array($field['val']);
		else {
			if (!is_array($field['val']))
				$field['val'] = array($field['val']);
			else if ($field['type'] == 'socials') {
				if (count($field['val']) > 0) {
					foreach ($field['val'] as $k=>$v) {
						if (!is_array($v)) 
							$field['val'] = array($field['val']);
						break;
					}
				}
			}
		}

		// Field container
		if (seafood_company_options_is_group($field['type'])) {					// Close nested containers
			if (empty($field['start']) && (!in_array($field['type'], array('group', 'toggle')) || !empty($field['end']))) {
				seafood_company_show_layout(seafood_company_options_close_nested_groups($field['type'], !empty($field['end'])));
				if (!empty($field['end'])) {
					return;
				}
			}
		} else {														// Start field layout
			if ($field['type'] != 'hidden') {
				echo '<div class="seafood_company_options_field'
					. ' seafood_company_options_field_' . (in_array($field['type'], array('list','fonts')) ? 'select' : $field['type'])
					. (in_array($field['type'], array('media', 'fonts', 'list', 'select', 'socials', 'date', 'time')) ? ' seafood_company_options_field_text'  : '')
					. ($field['type']=='socials' && !empty($field['style']) && $field['style']=='images' ? ' seafood_company_options_field_images'  : '')
					. ($field['type']=='socials' && (empty($field['style']) || $field['style']=='icons') ? ' seafood_company_options_field_icons'  : '')
					. (isset($field['dir']) && $field['dir']=='vertical' ? ' seafood_company_options_vertical' : '')
					. (!empty($field['multiple']) ? ' seafood_company_options_multiple' : '')
					. (isset($field['size']) ? ' seafood_company_options_size_'.esc_attr($field['size']) : '')
					. (isset($field['class']) ? ' ' . esc_attr($field['class']) : '')
					. (!empty($field['columns']) ? ' seafood_company_options_columns seafood_company_options_columns_'.esc_attr($field['columns']) : '')
					. ($divider)
					. '">'."\n";
				if ( !in_array($field['type'], array('divider'))) {
					echo '<label class="seafood_company_options_field_label'
						. (!seafood_company_storage_empty('to_flags', 'add_inherit') && isset($field['std']) ? ' seafood_company_options_field_label_inherit' : '')
						. '"'
						. (!empty($field['title']) ? ' for="'.esc_attr($id).'"' : '')
						. '>' 
						. ($field['title']) 
						. (!empty($field['info']) && ($fdir=seafood_company_get_file_url('images/to_info/'.seafood_company_esc($id).'.jpg'))!='' 
							? '<a href="'.esc_url($fdir).'" data-rel="popup" target="_blank" class="seafood_company_options_field_label_info iconadmin-info-circled" title="'. esc_attr__('More info', 'seafood-company').'"></a>' 
							: '')
						. (!seafood_company_storage_empty('to_flags', 'add_inherit') && isset($field['std']) 
							? '<span id="'.esc_attr($id).'_inherit" class="seafood_company_options_button_inherit'
								.($inherit ? '' : ' seafood_company_options_inherit_off')
								.'" title="' . esc_attr__('Unlock this field', 'seafood-company') . '"></span>' 
							: '')
						. '</label>'
						. "\n";
				}
				if ( !in_array($field['type'], array('info', 'label', 'divider'))) {
					echo '<div class="seafood_company_options_field_content'
						. ($buttons_classes)
						. ($cloneable ? ' seafood_company_options_cloneable_area' : '')
						. '">' . "\n";
				}
			}
		}
	
		// Parse field type
		if (is_array($field['val']) && count($field['val']) > 0) {
		foreach ($field['val'] as $clone_num => $clone_val) {
			
			if ($cloneable) {
				echo '<div class="seafood_company_options_cloneable_item">'
					. '<span class="seafood_company_options_input_button seafood_company_options_clone_button seafood_company_options_clone_button_del">-</span>';
			}
	
			switch ( $field['type'] ) {
		
			case 'group':
				echo '<fieldset id="'.esc_attr($id).'" class="seafood_company_options_container seafood_company_options_group seafood_company_options_content'.esc_attr($divider).'">';
				if (!empty($field['title'])) echo '<legend>'.(!empty($field['icon']) ? '<span class="'.esc_attr($field['icon']).'"></span>' : '').esc_html($field['title']).'</legend>'."\n";
				seafood_company_storage_push_array('to_flags', 'nesting', 'group');
			break;
		
			case 'toggle':
				seafood_company_storage_push_array('to_flags', 'nesting', 'toggle');
				echo '<div id="'.esc_attr($id).'" class="seafood_company_options_container seafood_company_options_toggle'.esc_attr($divider).'">';
				echo '<h3 id="'.esc_attr($id).'_title"'
					. ' class="seafood_company_options_toggle_header'.(empty($field['closed']) ? ' ui-state-active' : '') .'"'
					. (!empty($field['action']) ? ' onclick="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. '>'
					. (!empty($field['icon']) ? '<span class="seafood_company_options_toggle_header_icon '.esc_attr($field['icon']).'"></span>' : '') 
					. ($field['title'])
					. '<span class="seafood_company_options_toggle_header_marker iconadmin-left-open"></span>'
					. '</h3>'
					. '<div class="seafood_company_options_content seafood_company_options_toggle_content"'.(!empty($field['closed']) ? ' style="display:none;"' : '').'>';
			break;
		
			case 'accordion':
				seafood_company_storage_push_array('to_flags', 'nesting', 'accordion');
				if (!empty($field['start']))
					echo '<div id="'.esc_attr($field['start']).'" class="seafood_company_options_container seafood_company_options_accordion'.esc_attr($divider).'">';
				echo '<div id="'.esc_attr($id).'" class="seafood_company_options_accordion_item">'
					. '<h3 id="'.esc_attr($id).'_title"'
					. ' class="seafood_company_options_accordion_header"'
					. (!empty($field['action']) ? ' onclick="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. '>' 
					. (!empty($field['icon']) ? '<span class="seafood_company_options_accordion_header_icon '.esc_attr($field['icon']).'"></span>' : '') 
					. ($field['title'])
					. '<span class="seafood_company_options_accordion_header_marker iconadmin-left-open"></span>'
					. '</h3>'
					. '<div id="'.esc_attr($id).'_content" class="seafood_company_options_content seafood_company_options_accordion_content">';
			break;
		
			case 'tab':
				seafood_company_storage_push_array('to_flags', 'nesting', 'tab');
				if (!empty($field['start']))
					echo '<div id="'.esc_attr($field['start']).'" class="seafood_company_options_container seafood_company_options_tab'.esc_attr($divider).'">'
						. '<ul>' . trim(seafood_company_options_collect_tabs($field['type'], $field['start'])) . '</ul>';
				echo '<div id="'.esc_attr($id).'_content"  class="seafood_company_options_content seafood_company_options_tab_content">';
			break;
		
			case 'partition':
				seafood_company_storage_push_array('to_flags', 'nesting', 'partition');
				if (!empty($field['start']))
					echo '<div id="'.esc_attr($field['start']).'" class="seafood_company_options_container seafood_company_options_partition'.esc_attr($divider).'">'
						. '<ul>' . trim(seafood_company_options_collect_tabs($field['type'], $field['start'])) . '</ul>';
				echo '<div id="'.esc_attr($id).'_content" class="seafood_company_options_content seafood_company_options_partition_content">';
			break;
		
			case 'hidden':
				echo '<input class="seafood_company_options_input seafood_company_options_input_hidden" type="hidden"'
					. ' name="'.esc_attr($id).'"'
					. ' id="'.esc_attr($id).'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '" />';
			break;
	
			case 'date':
				if (isset($field['style']) && $field['style']=='inline') {
					echo '<div class="seafood_company_options_input_date" id="'.esc_attr($id).'_calendar"'
						. ' data-format="' . (!empty($field['format']) ? $field['format'] : 'yy-mm-dd') . '"'
						. ' data-months="' . (!empty($field['months']) ? max(1, min(3, $field['months'])) : 1) . '"'
						. ' data-linked-field="' . (!empty($data['linked_field']) ? $data['linked_field'] : $id) . '"'
						. '></div>'
					. '<input id="'.esc_attr($id).'"'
						. ' data-param="'.esc_attr($id).'"'
						. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
						. ' type="hidden"'
						. ' value="' . esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
						. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '')
						. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
						. ' />';
				} else {
					echo '<input class="seafood_company_options_input seafood_company_options_input_date' . (!empty($field['mask']) ? ' seafood_company_options_input_masked' : '') . '"'
						. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') . '"'
						. ' id="'.esc_attr($id). '"'
						. ' data-param="'.esc_attr($id).'"'
						. ' type="text"'
						. ' value="' . esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
						. ' data-format="' . (!empty($field['format']) ? $field['format'] : 'yy-mm-dd') . '"'
						. ' data-months="' . (!empty($field['months']) ? max(1, min(3, $field['months'])) : 1) . '"'
						. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '')
						. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
						. ' />'
					. ($before)
					. ($after);
				}
			break;
	
			case 'text':
				echo '<input class="seafood_company_options_input seafood_company_options_input_text' . (!empty($field['mask']) ? ' seafood_company_options_input_masked' : '') . '"'
					. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' id="'.esc_attr($id) .'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' type="text"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '')
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
				. ($before)
				. ($after);
			break;
			
			case 'textarea':
				$cols = isset($field['cols']) && $field['cols'] > 10 ? $field['cols'] : '40';
				$rows = isset($field['rows']) && $field['rows'] > 1 ? $field['rows'] : '8';
				echo '<textarea class="seafood_company_options_input seafood_company_options_input_textarea"'
					. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' id="'.esc_attr($id).'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' cols="'.esc_attr($cols).'"'
					. ' rows="'.esc_attr($rows).'"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. '>'
					. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) 
					. '</textarea>';
			break;
			
			case 'editor':
				$cols = isset($field['cols']) && $field['cols'] > 10 ? $field['cols'] : '40';
				$rows = isset($field['rows']) && $field['rows'] > 1 ? $field['rows'] : '10';
				wp_editor( seafood_company_is_inherit_option($clone_val) ? '' : $clone_val, $id . ($cloneable ? '[]' : ''), array(
					'wpautop' => false,
					'textarea_rows' => $rows
				));
			break;
	
			case 'spinner':
				echo '<input class="seafood_company_options_input seafood_company_options_input_spinner' . (!empty($field['mask']) ? ' seafood_company_options_input_masked' : '') 
					. '" name="'.esc_attr($id). ($cloneable ? '[]' : '') .'"'
					. ' id="'.esc_attr($id).'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' type="text"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '') 
					. (isset($field['min']) ? ' data-min="'.esc_attr($field['min']).'"' : '') 
					. (isset($field['max']) ? ' data-max="'.esc_attr($field['max']).'"' : '') 
					. (!empty($field['step']) ? ' data-step="'.esc_attr($field['step']).'"' : '') 
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />' 
					. '<span class="seafood_company_options_arrows"><span class="seafood_company_options_arrow_up iconadmin-up-dir"></span><span class="seafood_company_options_arrow_down iconadmin-down-dir"></span></span>';
			break;
	
			case 'tags':
				if (!seafood_company_is_inherit_option($clone_val)) {
					$tags = explode($to_delimiter, $clone_val);
					if (is_array($tags) && count($tags) > 0) {
						foreach ($tags as $tag) {
							if (empty($tag)) continue;
							echo '<span class="seafood_company_options_tag iconadmin-cancel">'.($tag).'</span>';
						}
					}
				}
				echo '<input class="seafood_company_options_input_tags"'
					. ' type="text"'
					. ' value=""'
					. ' />'
					. '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
						. ' type="hidden"'
						. ' data-param="'.esc_attr($id).'"'
						. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
						. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
						. ' />';
			break;
			
			case "checkbox": 
				echo '<input type="checkbox" class="seafood_company_options_input seafood_company_options_input_checkbox"'
					. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' id="'.esc_attr($id) .'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' value="true"'
					. ($clone_val == 'true' ? ' checked="checked"' : '') 
					. (!empty($field['disabled']) ? ' readonly="readonly"' : '') 
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
					. '<label for="'.esc_attr($id).'" class="' . (!empty($field['disabled']) ? 'seafood_company_options_state_disabled' : '') . ($clone_val=='true' ? ' seafood_company_options_state_checked' : '').'"><span class="seafood_company_options_input_checkbox_image iconadmin-check"></span>' . (!empty($field['label']) ? $field['label'] : $field['title']) . '</label>';
			break;
			
			case "radio":
				if (is_array($field['options']) && count($field['options']) > 0) {
					foreach ($field['options'] as $key => $title) { 
						echo '<span class="seafood_company_options_radioitem">'
							.'<input class="seafood_company_options_input seafood_company_options_input_radio" type="radio"'
								. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') . '"'
								. ' value="'.esc_attr($key) .'"'
								. ($clone_val == $key ? ' checked="checked"' : '') 
								. ' id="'.esc_attr(($id).'_'.($key)).'"'
								. ' />'
								. '<label for="'.esc_attr(($id).'_'.($key)).'"'. ($clone_val == $key ? ' class="seafood_company_options_state_checked"' : '') .'><span class="seafood_company_options_input_radio_image iconadmin-circle-empty'.($clone_val == $key ? ' iconadmin-dot-circled' : '') . '"></span>' . ($title) . '</label></span>';
					}
				}
				echo '<input type="hidden"'
						. ' value="' . esc_attr($clone_val) . '"'
						. ' data-param="' . esc_attr($id) . '"'
						. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
						. ' />';
			break;
			
			case "switch":
				$opt = array();
				if (is_array($field['options']) && count($field['options']) > 0) {
					foreach ($field['options'] as $key => $title) { 
						$opt[] = array('key'=>$key, 'title'=>$title);
						if (count($opt)==2) break;
					}
				}
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) || empty($clone_val) ? $opt[0]['key'] : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
					. '<span class="seafood_company_options_switch'.($clone_val==$opt[1]['key'] ? ' seafood_company_options_state_off' : '').'"><span class="seafood_company_options_switch_inner iconadmin-circle"><span class="seafood_company_options_switch_val1" data-value="'.esc_attr($opt[0]['key']).'">'.($opt[0]['title']).'</span><span class="seafood_company_options_switch_val2" data-value="'.esc_attr($opt[1]['key']).'">'.($opt[1]['title']).'</span></span></span>';
			break;
	
			case 'media':
				echo '<input class="seafood_company_options_input seafood_company_options_input_text seafood_company_options_input_media"'
					. ' name="'.esc_attr($id).($cloneable ? '[]' : '').'"'
					. ' id="'.esc_attr($id).'"'
					. ' data-param="'.esc_attr($id).'"'
					. ' type="text"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"' 
					. (!isset($field['readonly']) || $field['readonly'] ? ' readonly="readonly"' : '') 
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
				. ($before)
				. ($after);
				if (!empty($clone_val) && !seafood_company_is_inherit_option($clone_val)) {
					$info = pathinfo($clone_val);
					$ext = isset($info['extension']) ? $info['extension'] : '';
                    $alt = basename($clone_val);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<a class="seafood_company_options_image_preview" data-rel="popup" target="_blank" href="'.esc_url($clone_val).'">'
							. (!empty($ext) && seafood_company_strpos('jpg,png,gif', $ext)!==false 
									? '<img src="'.esc_url($clone_val).'" alt="'. esc_attr($alt).'" />'
									: '<span>'.trim($info['basename']).'</span>'
								)
							. '</a>';
				}
			break;
			
			case 'button':
				list($button, $class) = seafood_company_options_action_button($field, 'button');
				seafood_company_show_layout($button);
			break;
	
			case 'range':
				echo '<div class="seafood_company_options_input_range" data-step="'.(!empty($field['step']) ? $field['step'] : 1).'">';
				echo '<span class="seafood_company_options_range_scale"><span class="seafood_company_options_range_scale_filled"></span></span>';
				if (seafood_company_strpos($clone_val, $to_delimiter)===false)
					$clone_val = max($field['min'], intval($clone_val));
				if (seafood_company_strpos($field['std'], $to_delimiter)!==false && seafood_company_strpos($clone_val, $to_delimiter)===false)
					$clone_val = ($field['min']).','.($clone_val);
				$sliders = explode($to_delimiter, $clone_val);
				foreach($sliders as $s) {
					echo '<span class="seafood_company_options_range_slider"><span class="seafood_company_options_range_slider_value">'.intval($s).'</span><span class="seafood_company_options_range_slider_button"></span></span>';
				}
				echo '<span class="seafood_company_options_range_min">'.($field['min']).'</span><span class="seafood_company_options_range_max">'.($field['max']).'</span>';
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="' . esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />';
				echo '</div>';			
			break;
			
			case "checklist":
				if (is_array($field['options']) && count($field['options']) > 0) {
					foreach ($field['options'] as $key => $title) { 
						echo '<span class="seafood_company_options_listitem'
							. (seafood_company_strpos(($to_delimiter).($clone_val).($to_delimiter), ($to_delimiter).($key).($to_delimiter))!==false ? ' seafood_company_options_state_checked' : '') . '"'
							. ' data-value="'.esc_attr($key).'"'
							. '>'
							. esc_attr($title)
							. '</span>';
					}
				}
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />';
			break;
			
			case 'fonts':
				if (is_array($field['options']) && count($field['options']) > 0) {
					foreach ($field['options'] as $key => $title) {
						$field['options'][$key] = $key;
					}
				}
			case 'list':
			case 'select':
				if (!isset($field['options']) && !empty($field['from']) && !empty($field['to'])) {
					$field['options'] = array();
					for ($i = $field['from']; $i <= $field['to']; $i+=(!empty($field['step']) ? $field['step'] : 1)) {
						$field['options'][$i] = $i;
					}
				}
				list($list, $caption) = seafood_company_options_menu_list($field, $clone_val);
				if (empty($field['style']) || $field['style']=='select') {
					echo '<input class="seafood_company_options_input seafood_company_options_input_select" type="text" value="'.esc_attr($caption) . '"'
						. ' readonly="readonly"'
						. ' />'
						. ($before)
						. '<span class="seafood_company_options_field_after seafood_company_options_with_action iconadmin-down-open" onclick="return false;"></span>';
				}
				seafood_company_show_layout($list);
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') .'"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />';
			break;
	
			case 'images':
				list($list, $caption) = seafood_company_options_menu_list($field, $clone_val);
				if (empty($field['style']) || $field['style']=='select') {
					echo '<div class="seafood_company_options_caption_image iconadmin-down-open">'
						.'<span style="background-image: url('.esc_url($caption).')"></span>'
						.'</div>';
				}
				seafood_company_show_layout($list);
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') . '"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="' . esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />';
			break;
			
			case 'icons':
				if (isset($field['css']) && $field['css']!='' && file_exists($field['css'])) {
					$field['options'] = seafood_company_parse_icons_classes($field['css']);
				}
				list($list, $caption) = seafood_company_options_menu_list($field, $clone_val);
				if (empty($field['style']) || $field['style']=='select') {
					echo '<div class="seafood_company_options_caption_icon iconadmin-down-open"><span class="'.esc_attr($caption).'"></span></div>';
				}
				seafood_company_show_layout($list);
				echo '<input name="'.esc_attr($id) . ($cloneable ? '[]' : '') . '"'
					. ' type="hidden"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' value="' . esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />';
			break;
	
			case 'socials':
				if (!is_array($clone_val)) $clone_val = array('url'=>'', 'icon'=>'');
				list($list, $caption) = seafood_company_options_menu_list($field, $clone_val);
				if (empty($field['style']) || $field['style']=='icons') {
					list($after, $class) = seafood_company_options_action_button(array(
						'action' => empty($field['style']) || $field['style']=='icons' ? 'select_icon' : '',
						'icon' => (empty($field['style']) || $field['style']=='icons') && !empty($clone_val['icon']) ? $clone_val['icon'] : 'iconadmin-users'
						), 'after');
				} else
					$after = '';
				echo '<input class="seafood_company_options_input seafood_company_options_input_text seafood_company_options_input_socials' 
					. (!empty($field['mask']) ? ' seafood_company_options_input_masked' : '') . '"'
					. ' name="'.esc_attr($id).($cloneable ? '[]' : '') .'"'
					. ' id="'.esc_attr($id) .'"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' type="text" value="'. esc_attr(seafood_company_is_inherit_option($clone_val['url']) ? '' : $clone_val['url']) . '"' 
					. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '') 
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
					. ($after);
				if (!empty($field['style']) && $field['style']=='images') {
					echo '<div class="seafood_company_options_caption_image iconadmin-down-open">'
						.'<span style="background-image: url('.esc_url($caption).')"></span>'
						.'</div>';
				}
				seafood_company_show_layout($list);
				echo '<input name="'.esc_attr($id) . '_icon' . ($cloneable ? '[]' : '') .'" type="hidden" value="'. esc_attr(seafood_company_is_inherit_option($clone_val['icon']) ? '' : $clone_val['icon']) . '" />';
			break;
	
			case "color":
				$cp_style = isset($field['style']) ? $field['style'] : seafood_company_storage_get('to_colorpicker');
				echo '<input class="seafood_company_options_input seafood_company_options_input_color seafood_company_options_input_color_'.esc_attr($cp_style).'"'
					. ' name="'.esc_attr($id) . ($cloneable ? '[]' : '') . '"'
					. ' id="'.esc_attr($id) . '"'
					. ' data-param="' . esc_attr($id) . '"'
					. ' type="text"'
					. ' value="'. esc_attr(seafood_company_is_inherit_option($clone_val) ? '' : $clone_val) . '"'
					. (!empty($field['action']) ? ' onchange="seafood_company_options_action_'.esc_attr($field['action']).'(this);return false;"' : '')
					. ' />'
					. trim($before);
				if ($cp_style=='custom')
					echo '<span class="seafood_company_options_input_colorpicker iColorPicker"></span>';
				else if ($cp_style=='tiny')
					seafood_company_show_layout($after);
			break;   
	
			default:
				if (function_exists('seafood_company_show_custom_field')) {
					seafood_company_show_layout(seafood_company_show_custom_field($id, $field, $clone_val));
				}
			} 
	
			if ($cloneable) {
				echo '<input type="hidden" name="'.esc_attr($id) . '_numbers[]" value="'.esc_attr($clone_num).'" />'
					. '</div>';
			}
		}	//foreach
		}	
	
		if (!seafood_company_options_is_group($field['type']) && $field['type'] != 'hidden') {
			if ($cloneable) {
				echo '<div class="seafood_company_options_input_button seafood_company_options_clone_button seafood_company_options_clone_button_add">'. esc_html__('+ Add item', 'seafood-company') .'</div>';
			}
			if (!seafood_company_storage_empty('to_flags', 'add_inherit') && isset($field['std']))
				echo  '<div class="seafood_company_options_content_inherit"'.($inherit ? '' : ' style="display:none;"').'><div>'.esc_html__('Inherit', 'seafood-company').'</div><input type="hidden" name="'.esc_attr($id).'_inherit" value="'.esc_attr($inherit).'" /></div>';
			if ( !in_array($field['type'], array('info', 'label', 'divider')))
				echo '</div>';
			if (!empty($field['desc']))
				echo '<div class="seafood_company_options_desc">' . ($field['desc']) .'</div>' . "\n";
			echo '</div>' . "\n";
		}
	}
}


// Ajax Save and Export Action handler
if ( !function_exists( 'seafood_company_options_save' ) ) {
	
	
	function seafood_company_options_save() {

		$mode = sanitize_text_field($_POST['mode']);
		$override = empty($_POST['override']) ? 'general' : sanitize_text_field($_POST['override']);
		$slug = empty($_POST['slug']) ? '' :sanitize_text_field( $_POST['slug']);
		
		if (!in_array($mode, array('save', 'reset', 'export')) || $override=='customizer')
			return;

		if ( !wp_verify_nonce( seafood_company_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || !current_user_can('manage_options'))
			wp_die();
	

		$options = seafood_company_storage_get('options');
	
		if ($mode == 'save') {
            parse_str(seafood_company_get_value_gp('data'), $post_data);
		} else if ($mode=='export') {
            parse_str(seafood_company_get_value_gp('data'), $post_data);
			if (!seafood_company_storage_empty('post_override_options', 'fields')) {
				$options = seafood_company_array_merge(seafood_company_storage_get('options'), seafood_company_storage_get_array('post_override_options', 'fields'));
			}
		} else
			$post_data = array();
	
		$custom_options = array();
	
		seafood_company_options_merge_new_values($options, $custom_options, $post_data, $mode, $override);
	
		if ($mode=='export') {
			$name  = trim(chop($_POST['name']));
			$name2 = isset($_POST['name2']) ? trim(chop($_POST['name2'])) : '';
			$key = $name=='' ? $name2 : $name;
			$export = get_option(seafood_company_storage_get('options_prefix') . '_options_export_'.($override), array());
			$export[$key] = $custom_options;
			if ($name!='' && $name2!='') unset($export[$name2]);
			update_option(seafood_company_storage_get('options_prefix') . '_options_export_'.($override), $export);
			$file = seafood_company_get_file_dir('core/core.options/core.options.txt');
			$url  = seafood_company_get_file_url('core/core.options/core.options.txt');
			$export = serialize($custom_options);
			seafood_company_fpc($file, $export);
			$response = array('error'=>'', 'data'=>$export, 'link'=>$url);
			echo json_encode($response);
		} else {
			update_option(seafood_company_storage_get('options_prefix') . '_options'.(!empty($slug) ? '_template_'.trim($slug) : ''), apply_filters('seafood_company_filter_save_options', $custom_options, $override, $slug));
			if ($override=='general') {
				seafood_company_load_main_options();
			}
		}
		
		wp_die();
	}
}


// Ajax Import Action handler
if ( !function_exists( 'seafood_company_options_import' ) ) {
	
	
	function seafood_company_options_import() {

		if ( !wp_verify_nonce( seafood_company_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || !current_user_can('manage_options') )
			wp_die();
	
		$override = $_POST['override']=='' ? 'general' : sanitize_text_field($_POST['override']);
		$text = stripslashes(trim(chop($_POST['text'])));
		if (!empty($text)) {
			$opt = seafood_company_unserialize($text);
		} else {
			$key = trim(chop($_POST['name2']));
			$import = get_option(seafood_company_storage_get('options_prefix') . '_options_export_'.($override), array());
			$opt = isset($import[$key]) ? $import[$key] : false;
		}
		$response = array('error'=>$opt===false ? esc_html__('Error while unpack import data!', 'seafood-company') : '', 'data'=>$opt);
		echo json_encode($response);
	
		wp_die();
	}
}

// Merge data from POST and current post/page/category/theme options
if ( !function_exists( 'seafood_company_options_merge_new_values' ) ) {
	function seafood_company_options_merge_new_values(&$post_options, &$custom_options, &$post_data, $mode, $override) {
		$need_save = false;
		if (is_array($post_options) && count($post_options) > 0) {
			foreach ($post_options as $id=>$field) { 
				if ($override!='general' && (!isset($field['override']) || !in_array($override, explode(',', $field['override'])))) continue;
				if (!isset($field['std'])) continue;
				if ($override!='general' && !isset($post_data[$id.'_inherit'])) continue;
				if ($id=='reviews_marks' && $mode=='export') continue;
				$need_save = true;
				if ($mode == 'save' || $mode=='export') {
					if ($override!='general' && seafood_company_is_inherit_option($post_data[$id.'_inherit']))
						$new = '';
					else if (isset($post_data[$id])) {
						// Prepare specific (combined) fields
						if (!empty($field['subset'])) {
							$sbs = $post_data[$field['subset']];
							$field['val'][$sbs] = $post_data[$id];
							$post_data[$id] = $field['val'];
						}   	
						if ($field['type']=='socials') {
							if (!empty($field['cloneable'])) {
								if (is_array($post_data[$id]) && count($post_data[$id]) > 0) {
									foreach($post_data[$id] as $k=>$v)
										$post_data[$id][$k] = array('url'=>strip_tags(stripslashes($v)), 'icon'=>stripslashes($post_data[$id.'_icon'][$k]));
								}
							} else {
								$post_data[$id] = array('url'=>strip_tags(stripslashes($post_data[$id])), 'icon'=>stripslashes($post_data[$id.'_icon']));
							}
						} else if (is_array($post_data[$id])) {
							if (is_array($post_data[$id]) && count($post_data[$id]) > 0) {
								foreach ($post_data[$id] as $k=>$v)
									$post_data[$id][$k] = strip_tags(stripslashes($v));
							}
						} else {
							$post_data[$id] = stripslashes($post_data[$id]);
							if (empty($field['allow_html'])) 
								$post_data[$id] = strip_tags($post_data[$id]);
							else if (is_array($field['allow_html'])) 
								$post_data[$id] = wp_kses($post_data[$id], $field['allow_html']);
							else if ($field['allow_html']===true && empty($field['allow_js']))
								$post_data[$id] = wp_kses_post($post_data[$id]);
						}
						// Add cloneable index
						if (!empty($field['cloneable'])) {
							$rez = array();
							if (is_array($post_data[$id]) && count($post_data[$id]) > 0) {
								foreach ($post_data[$id] as $k=>$v)
									$rez[$post_data[$id.'_numbers'][$k]] = $v;
							}
							$post_data[$id] = $rez;
						}   	
						$new = $post_data[$id];
						// Post type specific data handling
						if ($id == 'reviews_marks' && function_exists('seafood_company_reviews_theme_setup')) {
							$new = is_array($new) ? join(',', $new) : $new;
							if (($avg = seafood_company_reviews_get_average_rating($new)) > 0) {
								$new = seafood_company_reviews_marks_to_save($new);
							}
						} else if ($id == 'reviews_criterias') {
							if (is_array($new) && count($new) > 1) {
								$rez = array();
								foreach ($new as $cr) {
									if (!empty($cr))
										$rez[] = $cr;
								}
								$new = $rez;
							}
						}
					} else
						$new = $field['type'] == 'checkbox' ? 'false' : '';
				} else {
					$new = $field['std'];
				}
				$custom_options[$id] = $new!=='' || $override=='general' ? $new : 'inherit';
			}
	    }
		return $need_save;
	}
}



// Load default theme options
require_once SEAFOOD_COMPANY_THEME_PATH . 'includes/theme.options.php';

// Load inheritance system
require_once SEAFOOD_COMPANY_FW_PATH . 'core/core.options/core.options-inheritance.php';

// Load custom fields
require_once SEAFOOD_COMPANY_FW_PATH . 'core/core.options/core.options-custom.php';
?>