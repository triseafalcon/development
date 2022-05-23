<?php
/**
 * SeaFood Company Framework: Clients support
 *
 * @package	seafood_company
 * @since	seafood_company 1.0
 */

// Theme init
if (!function_exists('seafood_company_clients_theme_setup')) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_clients_theme_setup', 1 );
	function seafood_company_clients_theme_setup() {

		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('seafood_company_filter_get_blog_type',			'seafood_company_clients_get_blog_type', 9, 2);
		add_filter('seafood_company_filter_get_blog_title',		'seafood_company_clients_get_blog_title', 9, 2);
		add_filter('seafood_company_filter_get_current_taxonomy',	'seafood_company_clients_get_current_taxonomy', 9, 2);
		add_filter('seafood_company_filter_is_taxonomy',			'seafood_company_clients_is_taxonomy', 9, 2);
		add_filter('seafood_company_filter_get_stream_page_title',	'seafood_company_clients_get_stream_page_title', 9, 2);
		add_filter('seafood_company_filter_get_stream_page_link',	'seafood_company_clients_get_stream_page_link', 9, 2);
		add_filter('seafood_company_filter_get_stream_page_id',	'seafood_company_clients_get_stream_page_id', 9, 2);
		add_filter('seafood_company_filter_query_add_filters',		'seafood_company_clients_query_add_filters', 9, 2);
		add_filter('seafood_company_filter_detect_inheritance_key','seafood_company_clients_detect_inheritance_key', 9, 1);

		// Extra column for clients lists
		if (seafood_company_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-clients_columns',			'seafood_company_post_add_options_column', 9);
			add_filter('manage_clients_posts_custom_column',	'seafood_company_post_fill_options_column', 9, 2);
		}
		
		// Add supported data types
		seafood_company_theme_support_pt('clients');
		seafood_company_theme_support_tx('clients_group');
	}
}

if ( !function_exists( 'seafood_company_clients_settings_theme_setup2' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_clients_settings_theme_setup2', 3 );
	function seafood_company_clients_settings_theme_setup2() {
		// Add post type 'clients' and taxonomy 'clients_group' into theme inheritance list
		seafood_company_add_theme_inheritance( array('clients' => array(
			'stream_template' => 'blog-clients',
			'single_template' => 'single-client',
			'taxonomy' => array('clients_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('clients'),
			'override' => 'custom'
			) )
		);
	}
}


if (!function_exists('seafood_company_clients_after_theme_setup')) {
	add_action( 'seafood_company_action_after_init_theme', 'seafood_company_clients_after_theme_setup' );
	function seafood_company_clients_after_theme_setup() {
		// Update fields in the override options
		if (seafood_company_storage_get_array('post_override_options', 'page')=='clients') {
			// Meta box fields
			seafood_company_storage_set_array('post_override_options', 'title', esc_html__('Client Options', 'seafood-company'));
			seafood_company_storage_set_array('post_override_options', 'fields', array(
				"mb_partition_clients" => array(
					"title" => esc_html__('Clients', 'seafood-company'),
					"override" => "page,post,custom",
					"divider" => false,
					"icon" => "iconadmin-users",
					"type" => "partition"),
				"mb_info_clients_1" => array(
					"title" => esc_html__('Client details', 'seafood-company'),
					"override" => "page,post,custom",
					"divider" => false,
					"desc" => wp_kses_data( __('In this section you can put details for this client', 'seafood-company') ),
					"class" => "client_meta",
					"type" => "info"),
				"client_name" => array(
					"title" => esc_html__('Contact name',  'seafood-company'),
					"desc" => wp_kses_data( __("Name of the contacts manager", 'seafood-company') ),
					"override" => "page,post,custom",
					"class" => "client_name",
					"std" => '',
					"type" => "text"),
				"client_position" => array(
					"title" => esc_html__('Position',  'seafood-company'),
					"desc" => wp_kses_data( __("Position of the contacts manager", 'seafood-company') ),
					"override" => "page,post,custom",
					"class" => "client_position",
					"std" => '',
					"type" => "text"),
				"client_show_link" => array(
					"title" => esc_html__('Show link',  'seafood-company'),
					"desc" => wp_kses_data( __("Show link to client page", 'seafood-company') ),
					"override" => "page,post,custom",
					"class" => "client_show_link",
					"std" => "no",
					"options" => seafood_company_get_list_yesno(),
					"type" => "switch"),
				"client_link" => array(
					"title" => esc_html__('Link',  'seafood-company'),
					"desc" => wp_kses_data( __("URL of the client's site. If empty - use link to this page", 'seafood-company') ),
					"override" => "page,post,custom",
					"class" => "client_link",
					"std" => '',
					"type" => "text")
				)
			);
		}
	}
}


// Return true, if current page is clients page
if ( !function_exists( 'seafood_company_is_clients_page' ) ) {
	function seafood_company_is_clients_page() {
		$is = in_array(seafood_company_storage_get('page_template'), array('blog-clients', 'single-client'));
		if (!$is) {
			if (!seafood_company_storage_empty('pre_query'))
				$is = seafood_company_storage_call_obj_method('pre_query', 'get', 'post_type')=='clients'
						|| seafood_company_storage_call_obj_method('pre_query', 'is_tax', 'clients_group') 
						|| (seafood_company_storage_call_obj_method('pre_query', 'is_page') 
							&& ($id=seafood_company_get_template_page_id('blog-clients')) > 0 
							&& $id==seafood_company_storage_get_obj_property('pre_query', 'queried_object_id', 0)
							);
			else
				$is = get_query_var('post_type')=='clients' 
						|| is_tax('clients_group') 
						|| (is_page() && ($id=seafood_company_get_template_page_id('blog-clients')) > 0 && $id==get_the_ID());
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'seafood_company_clients_detect_inheritance_key' ) ) {
	
	function seafood_company_clients_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return seafood_company_is_clients_page() ? 'clients' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'seafood_company_clients_get_blog_type' ) ) {
	
	function seafood_company_clients_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('clients_group') || is_tax('clients_group'))
			$page = 'clients_category';
		else if ($query && $query->get('post_type')=='clients' || get_query_var('post_type')=='clients')
			$page = $query && $query->is_single() || is_single() ? 'clients_item' : 'clients';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'seafood_company_clients_get_blog_title' ) ) {
	
	function seafood_company_clients_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( seafood_company_strpos($page, 'clients')!==false ) {
			if ( $page == 'clients_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'clients_group' ), 'clients_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'clients_item' ) {
				$title = seafood_company_get_post_title();
			} else {
				$title = esc_html__('All clients', 'seafood-company');
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'seafood_company_clients_get_stream_page_title' ) ) {
	
	function seafood_company_clients_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (seafood_company_strpos($page, 'clients')!==false) {
			if (($page_id = seafood_company_clients_get_stream_page_id(0, $page=='clients' ? 'blog-clients' : $page)) > 0)
				$title = seafood_company_get_post_title($page_id);
			else
				$title = esc_html__('All clients', 'seafood-company');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'seafood_company_clients_get_stream_page_id' ) ) {
	
	function seafood_company_clients_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (seafood_company_strpos($page, 'clients')!==false) $id = seafood_company_get_template_page_id('blog-clients');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'seafood_company_clients_get_stream_page_link' ) ) {
	
	function seafood_company_clients_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (seafood_company_strpos($page, 'clients')!==false) {
			$id = seafood_company_get_template_page_id('blog-clients');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'seafood_company_clients_get_current_taxonomy' ) ) {
	
	function seafood_company_clients_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( seafood_company_strpos($page, 'clients')!==false ) {
			$tax = 'clients_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'seafood_company_clients_is_taxonomy' ) ) {
	
	function seafood_company_clients_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('clients_group')!='' || is_tax('clients_group') ? 'clients_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'seafood_company_clients_query_add_filters' ) ) {
	
	function seafood_company_clients_query_add_filters($args, $filter) {
		if ($filter == 'clients') {
			$args['post_type'] = 'clients';
		}
		return $args;
	}
}


?>