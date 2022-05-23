<?php

/* Theme setup section
-------------------------------------------------------------------- */

// ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// Framework settings

seafood_company_storage_set('settings', array(
	
	'less_compiler'		=> 'lessc',								// no|lessc|less|external - Compiler for the .less
																// lessc	- fast & low memory required, but .less-map, shadows & gradients not supprted
																// less		- slow, but support all features
																// external	- used if you have external .less compiler (like WinLess or Koala)
																// no		- don't use .less, all styles stored in the theme.styles.php
	'less_nested'		=> false,								// Use nested selectors when compiling less - increase .css size, but allow using nested color schemes
	'less_prefix'		=> '',									// any string - Use prefix before each selector when compile less. For example: 'html '
	'less_split'		=> false,								// If true - load each file into memory, split it (see below) and compile separate.
																// Else - compile each file without loading to memory
	'less_separator'	=> '/*---LESS_SEPARATOR---*/',			// string - separator inside .less file to split it when compiling to reduce memory usage
																// (compilation speed gets a bit slow)
	'less_map'			=> 'no',								// no|internal|external - Generate map for .less files. 
																// Warning! You need more then 128Mb for PHP scripts on your server! Supported only if less_compiler=less (see above)
	
	'customizer_demo'	=> true,								// Show color customizer demo (if many color settings) or not (if only accent colors used)

	'allow_fullscreen'	=> false,								// Allow fullscreen and fullwide body styles

	'socials_type'		=> 'icons',								// images|icons - Use this kind of pictograms for all socials: share, social profiles, team members socials, etc.
	'slides_type'		=> 'bg',								// images|bg - Use image as slide's content or as slide's background

	'add_image_size'	=> false,								// Add theme's thumb sizes into WP list sizes. 
																// If false - new image thumb will be generated on demand,
																// otherwise - all thumb sizes will be generated when image is loaded

	'use_list_cache'	=> true,								// Use cache for any lists (increase theme speed, but get 15-20K memory)
	'use_post_cache'	=> true 								// Use cache for post_data (increase theme speed, decrease queries number, but get more memory - up to 300K)
	)
);



// Default Theme Options
if ( !function_exists( 'seafood_company_options_settings_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_options_settings_theme_setup', 2 );	// Priority 1 for add seafood_company_filter handlers
	function seafood_company_options_settings_theme_setup() {
		
		// Clear all saved Theme Options on first theme run
		add_action('after_switch_theme', 'seafood_company_options_reset');

		// Settings 
		$socials_type = seafood_company_get_theme_setting('socials_type');
				
		// Prepare arrays 
		seafood_company_storage_set('options_params', apply_filters('seafood_company_filter_theme_options_params', array(
			'list_fonts'				=> array('$seafood_company_get_list_fonts' => ''),
			'list_fonts_styles'			=> array('$seafood_company_get_list_fonts_styles' => ''),
			'list_socials' 				=> array('$seafood_company_get_list_socials' => ''),
			'list_icons' 				=> array('$seafood_company_get_list_icons(true)' => ''),
			'list_posts_types' 			=> array('$seafood_company_get_list_posts_types' => ''),
			'list_categories' 			=> array('$seafood_company_get_list_categories' => ''),
			'list_menus'				=> array('$seafood_company_get_list_menus(true)' => ''),
			'list_sidebars'				=> array('$seafood_company_get_list_sidebars' => ''),
			'list_positions' 			=> array('$seafood_company_get_list_sidebars_positions' => ''),
			'list_color_schemes'		=> array('$seafood_company_get_list_color_schemes' => ''),
			'list_bg_tints'				=> array('$seafood_company_get_list_bg_tints' => ''),
			'list_body_styles'			=> array('$seafood_company_get_list_body_styles' => ''),
			'list_header_styles'		=> array('$seafood_company_get_list_templates_header' => ''),
			'list_blog_styles'			=> array('$seafood_company_get_list_templates_blog' => ''),
			'list_single_styles'		=> array('$seafood_company_get_list_templates_single' => ''),
			'list_article_styles'		=> array('$seafood_company_get_list_article_styles' => ''),
			'list_blog_counters' 		=> array('$seafood_company_get_list_blog_counters' => ''),
			'list_menu_hovers' 			=> array('$seafood_company_get_list_menu_hovers' => ''),
			'list_button_hovers'		=> array('$seafood_company_get_list_button_hovers' => ''),
			'list_input_hovers'			=> array('$seafood_company_get_list_input_hovers' => ''),
			'list_search_styles'		=> array('$seafood_company_get_list_search_styles' => ''),
			'list_animations_in' 		=> array('$seafood_company_get_list_animations_in' => ''),
			'list_animations_out'		=> array('$seafood_company_get_list_animations_out' => ''),
			'list_filters'				=> array('$seafood_company_get_list_portfolio_filters' => ''),
			'list_hovers'				=> array('$seafood_company_get_list_hovers' => ''),
			'list_hovers_dir'			=> array('$seafood_company_get_list_hovers_directions' => ''),
			'list_alter_sizes'			=> array('$seafood_company_get_list_alter_sizes' => ''),
			'list_sliders' 				=> array('$seafood_company_get_list_sliders' => ''),
			'list_bg_image_positions'	=> array('$seafood_company_get_list_bg_image_positions' => ''),
			'list_popups' 				=> array('$seafood_company_get_list_popup_engines' => ''),
			'list_gmap_styles'		 	=> array('$seafood_company_get_list_googlemap_styles' => ''),
			'list_yes_no' 				=> array('$seafood_company_get_list_yesno' => ''),
			'list_on_off' 				=> array('$seafood_company_get_list_onoff' => ''),
			'list_show_hide' 			=> array('$seafood_company_get_list_showhide' => ''),
			'list_sorting' 				=> array('$seafood_company_get_list_sortings' => ''),
			'list_ordering' 			=> array('$seafood_company_get_list_orderings' => ''),
			'list_locations' 			=> array('$seafood_company_get_list_dedicated_locations' => '')
			)
		));


		// Theme options array
        seafood_company_storage_set('options', apply_filters('seafood_company_filter_options', array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'seafood-company'),
					"start" => "partitions",
					"override" => "category,services_group,post,page,custom",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'seafood-company'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-picture',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_body_1' => array(
					"title" => esc_html__('Body parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select body style and color scheme for entire site. You can override this parameters on any page, post or category', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'body_style' => array(
					"title" => esc_html__('Body style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select body style:', 'seafood-company') )
								. ' <br>' 
								. wp_kses_data( __('<b>boxed</b> - if you want use background color and/or image', 'seafood-company') )
								. ',<br>'
								. wp_kses_data( __('<b>wide</b> - page fill whole window with centered content', 'seafood-company') )
								. (seafood_company_get_theme_setting('allow_fullscreen') 
									? ',<br>' . wp_kses_data( __('<b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings)', 'seafood-company') )
									: '')
								. (seafood_company_get_theme_setting('allow_fullscreen') 
									? ',<br>' . wp_kses_data( __('<b>fullscreen</b> - page content fill whole window without any paddings', 'seafood-company') )
									: ''),
					"info" => true,
					"override" => "category,services_group,post,page,custom",
					"std" => "wide",
					"options" => seafood_company_get_options_param('list_body_styles'),
					"dir" => "horizontal",
					"type" => "radio"
					),
		
		'body_paddings' => array(
					"title" => esc_html__('Page paddings', 'seafood-company'),
					"desc" => wp_kses_data( __('Add paddings above and below the page content', 'seafood-company') ),
					"override" => "post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"body_scheme" => array(
					"title" => esc_html__('Color scheme', 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the entire page', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'seafood-company'),
					"desc" => wp_kses_data( __('Fill the page background with the solid color or leave it transparend to show background image (or video background)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'info_body_2' => array(
					"title" => esc_html__('Background color and image', 'seafood-company'),
					"desc" => wp_kses_data( __('Color and image for the site background', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'bg_custom' => array(
					"title" => esc_html__('Use custom background',  'seafood-company'),
					"desc" => wp_kses_data( __("Use custom color and/or image as the site background", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'seafood-company'),
					"desc" => wp_kses_data( __('Body background color',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "#ffffff",
					"type" => "color"
					),

		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'seafood-company'),
					"desc" => wp_kses_data( __('Select theme background pattern (first case - without pattern)',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"options" => array(
						0 => seafood_company_get_file_url('images/spacer.png'),
						1 => seafood_company_get_file_url('images/bg/pattern_1.jpg'),
						2 => seafood_company_get_file_url('images/bg/pattern_2.jpg'),
						3 => seafood_company_get_file_url('images/bg/pattern_3.jpg'),
						4 => seafood_company_get_file_url('images/bg/pattern_4.jpg'),
						5 => seafood_company_get_file_url('images/bg/pattern_5.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_pattern_custom' => array(
					"title" => esc_html__('Background custom pattern',  'seafood-company'),
					"desc" => wp_kses_data( __('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'seafood-company'),
					"desc" => wp_kses_data( __('Select theme background image (first case - without image)',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						0 => seafood_company_get_file_url('images/spacer.png'),
						1 => seafood_company_get_file_url('images/bg/image_1_thumb.jpg'),
						2 => seafood_company_get_file_url('images/bg/image_2_thumb.jpg'),
						3 => seafood_company_get_file_url('images/bg/image_3_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_image_custom' => array(
					"title" => esc_html__('Background custom image',  'seafood-company'),
					"desc" => wp_kses_data( __('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image_custom_position' => array( 
					"title" => esc_html__('Background custom image position',  'seafood-company'),
					"desc" => wp_kses_data( __('Select custom image position',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "left_top",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'bg_image_load' => array(
					"title" => esc_html__('Load background image', 'seafood-company'),
					"desc" => wp_kses_data( __('Always load background images or only for boxed body style', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "boxed",
					"size" => "medium",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'boxed' => esc_html__('Boxed', 'seafood-company'),
						'always' => esc_html__('Always', 'seafood-company')
					),
					"type" => "switch"
					),

		
		'info_body_3' => array(
					"title" => esc_html__('Video background', 'seafood-company'),
					"desc" => wp_kses_data( __('Parameters of the video, used as site background', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'seafood-company'),
					"desc" => wp_kses_data( __("Show video as the site background", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'seafood-company'),
					"desc" => wp_kses_data( __("Youtube code of video", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "",
					"type" => "text"
					),

		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'seafood-company'),
					"desc" => wp_kses_data( __("URL to video-file (uploaded on your site)", 'seafood-company') ),
					"readonly" =>false,
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"before" => array(	'title' => esc_html__('Choose video', 'seafood-company'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'seafood-company'),
															'update' => esc_html__( 'Select Video', 'seafood-company')
														)
								),
					"std" => "",
					"type" => "media"
					),

		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'seafood-company'),
					"desc" => wp_kses_data( __('Use overlay texture for the video background', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		
		
		
		
		// Customization -> Header
		//-------------------------------------------------
		
		'customization_header' => array(
					"title" => esc_html__("Header", 'seafood-company'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		"info_header_1" => array(
					"title" => esc_html__('Top panel', 'seafood-company'),
					"desc" => wp_kses_data( __('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"top_panel_style" => array(
					"title" => esc_html__('Top panel style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired style of the page header', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "header_3",
					"options" => seafood_company_get_options_param('list_header_styles'),
					"style" => "list",
					"type" => "images"),

		"top_panel_image" => array(
					"title" => esc_html__('Top panel image', 'seafood-company'),
					"desc" => wp_kses_data( __('Select default background image of the page header (if not single post or featured image for current post is not specified)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'seafood-company'),
					"desc" => wp_kses_data( __('Select position for the top panel with logo and main menu', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'seafood-company'),
						'above' => esc_html__('Above slider', 'seafood-company'),
						'below' => esc_html__('Below slider', 'seafood-company'),
						'over'  => esc_html__('Over slider', 'seafood-company')
					),
					"type" => "checklist"),

		"top_panel_scheme" => array(
					"title" => esc_html__('Top panel color scheme', 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the top panel', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"pushy_panel_scheme" => array(
					"title" => esc_html__('Push panel color scheme', 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the push panel (with logo, menu and socials)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'top_panel_style' => array('header_8')
					),
					"std" => "dark",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'seafood-company'),
					"desc" => wp_kses_data( __('Show post/page/category title', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'seafood-company'),
					"desc" => wp_kses_data( __('Show path to current category (post, page)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'seafood-company'),
					"desc" => wp_kses_data( __("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'seafood-company') ),
					"dependency" => array(
						'show_breadcrumbs' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),

		
		
		
		"info_header_2" => array( 
					"title" => esc_html__('Main menu style and position', 'seafood-company'),
					"desc" => wp_kses_data( __('Select the Main menu style and position', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'seafood-company'),
					"desc" => wp_kses_data( __('Select main menu for the current page',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"options" => seafood_company_get_options_param('list_menus'),
					"type" => "select"),
		
		"menu_attachment" => array( 
					"title" => esc_html__('Main menu attachment', 'seafood-company'),
					"desc" => wp_kses_data( __('Attach main menu to top of window then page scroll down', 'seafood-company') ),
					"std" => "fixed",
					"options" => array(
						"fixed"=>esc_html__("Fix menu position", 'seafood-company'), 
						"none"=>esc_html__("Don't fix menu position", 'seafood-company')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_hover" => array( 
					"title" => esc_html__('Main menu hover effect', 'seafood-company'),
					"desc" => wp_kses_data( __('Select hover effect for the main menu items', 'seafood-company') ),
					"std" => "fade",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_menu_hovers')),

		"menu_animation_in" => array( 
					"title" => esc_html__('Submenu show animation', 'seafood-company'),
					"desc" => wp_kses_data( __('Select animation to show submenu ', 'seafood-company') ),
					"std" => "fadeIn",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_animations_in')),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'seafood-company'),
					"desc" => wp_kses_data( __('Select animation to hide submenu ', 'seafood-company') ),
					"std" => "fadeOut",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_animations_out')),
		
		"menu_mobile" => array( 
					"title" => esc_html__('Main menu responsive', 'seafood-company'),
					"desc" => wp_kses_data( __('Allow responsive version for the main menu if window width less then this value', 'seafood-company') ),
					"std" => 1024,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'seafood-company'),
					"desc" => wp_kses_data( __('Width for dropdown menus in main menu', 'seafood-company') ),
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),
		
		
		
		"info_header_3" => array(
					"title" => esc_html__("User's menu area components", 'seafood-company'),
					"desc" => wp_kses_data( __("Select parts for the user's menu area", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_top_panel_top" => array(
					"title" => esc_html__('Show user menu area', 'seafood-company'),
					"desc" => wp_kses_data( __('Show user menu area on top of page', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'seafood-company'),
					"desc" => wp_kses_data( __('Select user menu for the current page',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "default",
					"options" => seafood_company_get_options_param('list_menus'),
					"type" => "select"),
		
		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'seafood-company'),
					"desc" => wp_kses_data( __('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'seafood-company') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_login" => array( 
					"title" => esc_html__('Show Login/Logout buttons', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Login and Logout buttons in the user menu area', 'seafood-company') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'seafood-company'),
					"desc" => wp_kses_data( __('Show bookmarks selector in the user menu', 'seafood-company') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Social icons in the user menu area', 'seafood-company') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		

		
		"info_header_4" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'seafood-company'),
					"desc" => wp_kses_data( __("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'seafood-company'),
					"desc" => wp_kses_data( __('Show TOC for the current page', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'seafood-company'),
						'fixed' => esc_html__('Fixed', 'seafood-company'),
						'float' => esc_html__('Float', 'seafood-company')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'seafood-company'),
					"desc" => wp_kses_data( __('Automatically add "Home" item into table of contents - return to home page of the site', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'seafood-company'),
					"desc" => wp_kses_data( __('Automatically add "To Top" item into table of contents - scroll to top of the page', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		
		
		
		'info_header_5' => array(
					"title" => esc_html__('Main logo', 'seafood-company'),
					"desc" => wp_kses_data( __("Select or upload logos for the site's header and select it position", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'logo' => array(
					"title" => esc_html__('Logo image', 'seafood-company'),
					"desc" => wp_kses_data( __('Main logo image', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_retina' => array(
					"title" => esc_html__('Logo image for Retina', 'seafood-company'),
					"desc" => wp_kses_data( __('Main logo image used on Retina display', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'seafood-company'),
					"desc" => wp_kses_data( __('Logo image for the header (if menu is fixed after the page is scrolled)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'seafood-company'),
					"desc" => wp_kses_data( __('Logo text - display it after logo image', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'seafood-company'),
					"desc" => wp_kses_data( __('Height for the logo in the header area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'seafood-company'),
					"desc" => wp_kses_data( __('Top offset for the logo in the header area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),
		
		
		
		
		
		
		
		// Customization -> Slider
		//-------------------------------------------------
		
		"customization_slider" => array( 
					"title" => esc_html__('Slider', 'seafood-company'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_slider_1" => array(
					"title" => esc_html__('Main slider parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select parameters for main slider (you can override it in each category and page)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
					
		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want to show slider on each page (post)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_display" => array(
					"title" => esc_html__('Slider display', 'seafood-company'),
					"desc" => wp_kses_data( __('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "fullwide",
					"options" => array(
						"boxed"=>esc_html__("Boxed", 'seafood-company'),
						"fullwide"=>esc_html__("Fullwide", 'seafood-company'),
						"fullscreen"=>esc_html__("Fullscreen", 'seafood-company')
					),
					"type" => "checklist"),
		
		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'seafood-company'),
					"desc" => wp_kses_data( __("Slider height (in pixels) - only if slider display with fixed height.", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'seafood-company'),
					"desc" => wp_kses_data( __('What engine use to show slider?', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "swiper",
					"options" => seafood_company_get_options_param('list_sliders'),
					"type" => "radio"),

		"slider_over_content" => array(
					"title" => esc_html__('Put content over slider',  'seafood-company'),
					"desc" => wp_kses_data( __('Put content below on fixed layer over this slider',  'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "editor"),

		"slider_over_scheme" => array(
					"title" => esc_html__('Color scheme for content above', 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the content over the slider', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "dark",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'seafood-company'),
					"desc" => wp_kses_data( __('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "",
					"options" => seafood_company_array_merge(array(0 => esc_html__('- Select category -', 'seafood-company')), seafood_company_get_options_param('list_categories')),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),
		
		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'seafood-company'),
					"desc" => wp_kses_data( __("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "5",
					"type" => "text"),
		
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'seafood-company'),
					"desc" => wp_kses_data( __("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "date",
					"options" => seafood_company_get_options_param('list_sorting'),
					"type" => "select"),
		
		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'seafood-company'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "desc",
					"options" => seafood_company_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
					
		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'seafood-company'),
					"desc" => wp_kses_data( __("Interval (in ms) for slides change in slider", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),
		
		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'seafood-company'),
					"desc" => wp_kses_data( __("Choose pagination style for the slider", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'seafood-company'),
						'yes'  => esc_html__('Dots', 'seafood-company'), 
						'over' => esc_html__('Titles', 'seafood-company')
					),
					"type" => "checklist"),
		
		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'seafood-company'),
					"desc" => wp_kses_data( __("Do you want to show post's title, reviews rating and description on slides in slider", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'seafood-company'),
						'slide' => esc_html__('Slide', 'seafood-company'), 
						'fixed' => esc_html__('Fixed', 'seafood-company')
					),
					"type" => "checklist"),
					
		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'seafood-company'),
					"desc" => wp_kses_data( __("Do you want to show post's category on slides in slider", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'seafood-company'),
					"desc" => wp_kses_data( __("Do you want to show post's reviews rating on slides in slider", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'seafood-company'),
					"desc" => wp_kses_data( __("How many characters show in the post's description in slider. 0 - no descriptions", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'seafood-company'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_sidebars_1" => array( 
					"title" => esc_html__('Custom sidebars', 'seafood-company'),
					"desc" => wp_kses_data( __('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'seafood-company') ),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'seafood-company'),
					"desc" => wp_kses_data( __('Manage custom sidebars. You can use it with each category (page, post) independently',  'seafood-company') ),
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_sidebars_2" => array(
					"title" => esc_html__('Main sidebar', 'seafood-company'),
					"desc" => wp_kses_data( __('Show / Hide and select main sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'seafood-company'),
					"desc" => wp_kses_data( __('Select position for the main sidebar or hide it',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "right",
					"options" => seafood_company_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "checklist"),

		"sidebar_main_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the main sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'seafood-company'),
					"desc" => wp_kses_data( __('Select main sidebar content',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "sidebar_main",
					"options" => seafood_company_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"info_sidebars_3" => array(
					"title" => esc_html__('Outer sidebar', 'seafood-company'),
					"desc" => wp_kses_data( __('Show / Hide and select outer sidebar (sidemenu, logo, etc.', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden"),
		
		'show_sidebar_outer' => array( 
					"title" => esc_html__('Show outer sidebar',  'seafood-company'),
					"desc" => wp_kses_data( __('Select position for the outer sidebar or hide it',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "hide",
					"options" => seafood_company_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "hidden"),

		"sidebar_outer_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the outer sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "hidden"),
		
		"sidebar_outer_show_logo" => array( 
					"title" => esc_html__('Show Logo', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Logo in the outer sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"sidebar_outer_show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Social icons in the outer sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"sidebar_outer_show_menu" => array( 
					"title" => esc_html__('Show Menu', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Menu in the outer sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"menu_side" => array(
					"title" => esc_html__('Select menu',  'seafood-company'),
					"desc" => wp_kses_data( __('Select menu for the outer sidebar',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right'),
						'sidebar_outer_show_menu' => array('yes')
					),
					"std" => "default",
					"options" => seafood_company_get_options_param('list_menus'),
					"type" => "hidden"),
		
		"sidebar_outer_show_widgets" => array( 
					"title" => esc_html__('Show Widgets', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Widgets in the outer sidebar', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "hidden"),

		"sidebar_outer" => array( 
					"title" => esc_html__('Select outer sidebar',  'seafood-company'),
					"desc" => wp_kses_data( __('Select outer sidebar content',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'sidebar_outer_show_widgets' => array('yes'),
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "sidebar_outer",
					"options" => seafood_company_get_options_param('list_sidebars'),
					"type" => "hidden"),
		
		
		
		
		// Customization -> Footer
		//-------------------------------------------------
		
		'customization_footer' => array(
					"title" => esc_html__("Footer", 'seafood-company'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Footer components", 'seafood-company'),
					"desc" => wp_kses_data( __("Select components of the footer, set style and put the content for the user's footer area", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'seafood-company'),
					"desc" => wp_kses_data( __('Select style for the footer sidebar or hide it', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"sidebar_footer_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the footer', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'seafood-company'),
					"desc" => wp_kses_data( __('Select footer sidebar for the blog page',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "sidebar_footer",
					"options" => seafood_company_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'seafood-company'),
					"desc" => wp_kses_data( __('Select columns number for the footer sidebar',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),
		
		
		"info_footer_2" => array(
					"title" => esc_html__('Testimonials in Footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Select parameters for Testimonials in the Footer', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"testimonials_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the testimonials area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'seafood-company'),
					"desc" => wp_kses_data( __('Number testimonials to show', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		
		"info_footer_3" => array(
					"title" => esc_html__('Twitter in Footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"twitter_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the twitter area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"twitter_count" => array( 
					"title" => esc_html__('Twitter count', 'seafood-company'),
					"desc" => wp_kses_data( __('Number twitter to show', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),


		"info_footer_4" => array(
					"title" => esc_html__('Google map parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select parameters for Google map (you can override it in each category and page)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want to show Google map on each page (post)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'seafood-company'),
					"desc" => wp_kses_data( __("Map height (default - in pixels, allows any CSS units of measure)", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'seafood-company'),
					"desc" => wp_kses_data( __("Enter address to show on map center", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longitude to show on map',  'seafood-company'),
					"desc" => wp_kses_data( __("Enter coordinates (separated by comma) to show on map center (instead of address)", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_title" => array(
					"title" => esc_html__('Title to show on map',  'seafood-company'),
					"desc" => wp_kses_data( __("Enter title to show on map center", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_description" => array(
					"title" => esc_html__('Description to show on map',  'seafood-company'),
					"desc" => wp_kses_data( __("Enter description to show on map center", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'seafood-company'),
					"desc" => wp_kses_data( __("Enter desired initial zoom for Google map", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'seafood-company'),
					"desc" => wp_kses_data( __("Select style to show Google map", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 'style1',
					"options" => seafood_company_get_options_param('list_gmap_styles'),
					"type" => "select"),
		
		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'seafood-company'),
					"desc" => wp_kses_data( __("Select or upload png-image with Google map marker", 'seafood-company') ),
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => '',
					"type" => "media"),
		
		
		
		"info_footer_5" => array(
					"title" => esc_html__("Contacts area", 'seafood-company'),
					"desc" => wp_kses_data( __("Show/Hide contacts area in the footer", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Show contact information area in footer: site logo, contact info and large social icons', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"contacts_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the contacts area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),

		'logo_footer_retina' => array(
					"title" => esc_html__('Logo image for footer for Retina', 'seafood-company'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area) used on Retina display', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'seafood-company'),
					"desc" => wp_kses_data( __('Height for the logo in the footer area (in the contacts area)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		"info_footer_6" => array(
					"title" => esc_html__("Copyright and footer menu", 'seafood-company'),
					"desc" => wp_kses_data( __("Show/Hide copyright area in the footer", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'seafood-company'),
					"desc" => wp_kses_data( __('Show area with copyright information, footer menu and small social icons in footer', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "plain",
					"options" => array(
						'none' => esc_html__('Hide', 'seafood-company'),
						'text' => esc_html__('Text', 'seafood-company'),
						'menu' => esc_html__('Text and menu', 'seafood-company'),
						'socials' => esc_html__('Text and Social icons', 'seafood-company')
					),
					"type" => "checklist"),

		"copyright_scheme" => array(
					"title" => esc_html__("Color scheme", 'seafood-company'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the copyright area', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => seafood_company_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"menu_footer" => array( 
					"title" => esc_html__('Select footer menu',  'seafood-company'),
					"desc" => wp_kses_data( __('Select footer menu for the current page',  'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"dependency" => array(
						'show_copyright_in_footer' => array('menu')
					),
					"options" => seafood_company_get_options_param('list_menus'),
					"type" => "select"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'seafood-company'),
					"desc" => wp_kses_data( __("Copyright text to show in footer area (bottom of site)", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"allow_html" => true,
					"std" => "ThemeREX &copy; {Y}. All rights reserved. ",
					"rows" => "10",
					"type" => "editor"),




		// Customization -> Other
		//-------------------------------------------------
		
		'customization_other' => array(
					"title" => esc_html__('Other', 'seafood-company'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-cog',
					"type" => "tab"
					),

		'info_other_1' => array(
					"title" => esc_html__('Theme customization other parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Animation parameters and responsive layouts for the small screens', 'seafood-company') ),
					"type" => "info"
					),

		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'seafood-company'),
					"desc" => wp_kses_data( __('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'seafood-company') ),
					"dependency" => array(
						'show_theme_customizer' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want use extended animations effects on your site?', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'animation_on_mobile' => array(
					"title" => esc_html__('Allow CSS animations on mobile', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you allow extended animations effects on mobile devices?', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"button_hover" => array( 
					"title" => esc_html__("Buttons hover", 'seafood-company'),
					"desc" => wp_kses_data( __("Select hover effect for all theme's buttons (and buttons from the thirdparty plugins if possible)", 'seafood-company') ),
					"std" => "fade",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_button_hovers')),

		"input_hover" => array( 
					"title" => esc_html__("Input fileds style", 'seafood-company'),
					"desc" => wp_kses_data( __("Select style for all theme's input fields (and fields from the thirdparty plugins if possible)", 'seafood-company') ),
					"std" => "default",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_input_hovers')),

		'remember_visitors_settings' => array(
					"title" => esc_html__("Remember visitor's settings", 'seafood-company'),
					"desc" => wp_kses_data( __('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want use responsive layouts on small screen or still use main layout?', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"page_preloader" => array( 
					"title" => esc_html__("Show page preloader", 'seafood-company'),
					"desc" => wp_kses_data( __("Select one of predefined styles for the page preloader or upload preloader image", 'seafood-company') ),
					"std" => "none",
					"type" => "select",
					"options" => array(
						'none'   => esc_html__('Hide preloader', 'seafood-company'),
						'circle' => esc_html__('Circle', 'seafood-company'),
						'square' => esc_html__('Square', 'seafood-company'),
						'custom' => esc_html__('Custom', 'seafood-company'),
					)),
        'privacy_text' => array(
                        "title" => esc_html__("Text with Privacy Policy link", 'seafood-company'),
                        "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'seafood-company') ),
                        "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'seafood-company') ),
                        "type"  => "text"
                    ),


            'page_preloader_image' => array(
					"title" => esc_html__('Upload preloader image',  'seafood-company'),
					"desc" => wp_kses_data( __('Upload animated GIF to use it as page preloader',  'seafood-company') ),
					"dependency" => array(
						'page_preloader' => array('custom')
					),
					"std" => "",
					"type" => "media"
					),


		'info_other_2' => array(
					"title" => esc_html__('Google fonts parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Specify additional parameters, used to load Google fonts', 'seafood-company') ),
					"type" => "info"
					),
		
		"fonts_subset" => array(
					"title" => esc_html__('Characters subset', 'seafood-company'),
					"desc" => wp_kses_data( __('Select subset, included into used Google fonts', 'seafood-company') ),
					"std" => "latin,latin-ext",
					"options" => array(
						'latin' => esc_html__('Latin', 'seafood-company'),
						'latin-ext' => esc_html__('Latin Extended', 'seafood-company'),
						'greek' => esc_html__('Greek', 'seafood-company'),
						'greek-ext' => esc_html__('Greek Extended', 'seafood-company'),
						'cyrillic' => esc_html__('Cyrillic', 'seafood-company'),
						'cyrillic-ext' => esc_html__('Cyrillic Extended', 'seafood-company'),
						'vietnamese' => esc_html__('Vietnamese', 'seafood-company')
					),
					"size" => "medium",
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),

		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'seafood-company'),
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'seafood-company'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired blog streampage parameters (you can override it in each category)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired blog style', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "excerpt",
					"options" => seafood_company_get_options_param('list_blog_styles'),
					"type" => "select"),
		
		"hover_style" => array(
					"title" => esc_html__('Hover style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired hover style (only for Blog style = Portfolio)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "square effect_shift",
					"options" => seafood_company_get_options_param('list_hovers'),
					"type" => "select"),
		
		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'seafood-company'),
					"desc" => wp_kses_data( __('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored'),
						'hover_style' => array('square','circle')
					),
					"std" => "left_to_right",
					"options" => seafood_company_get_options_param('list_hovers_dir'),
					"type" => "select"),
		
		"article_style" => array(
					"title" => esc_html__('Article style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select article display method: boxed or stretch', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "stretch",
					"options" => seafood_company_get_options_param('list_article_styles'),
					"size" => "medium",
					"type" => "switch"),
		
		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'seafood-company'),
					"desc" => wp_kses_data( __('Select location for the dedicated content or featured image in the "excerpt" blog style', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"std" => "default",
					"options" => seafood_company_get_options_param('list_locations'),
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'seafood-company'),
					"desc" => wp_kses_data( __('What taxonomy use for filter buttons', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "hide",
					"options" => seafood_company_get_options_param('list_filters'),
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'seafood-company'),
					"desc" => wp_kses_data( __('Select the desired sorting method for posts', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "date",
					"options" => seafood_company_get_options_param('list_sorting'),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'seafood-company'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "desc",
					"options" => seafood_company_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'seafood-company'),
					"desc" => wp_kses_data( __('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'seafood-company'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt', 'portfolio', 'grid', 'square', 'related')
					),
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'seafood-company'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('masonry', 'classic')
					),
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'seafood-company'),
					"icon" => "iconadmin-doc",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		
		"info_single_1" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select desired style for single page', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "single-standard",
					"options" => seafood_company_get_options_param('list_single_styles'),
					"dir" => "horizontal",
					"type" => "radio"),

		"icon" => array(
					"title" => esc_html__('Select post icon', 'seafood-company'),
					"desc" => wp_kses_data( __('Select icon for output before post/category name in some layouts', 'seafood-company') ),
					"override" => "services_group,post,page,custom",
					"std" => "",
					"options" => seafood_company_get_options_param('list_icons'),
					"style" => "select",
					"type" => "icons"
					),

		"alter_thumb_size" => array(
					"title" => esc_html__('Alter thumb size (WxH)',  'seafood-company'),
					"override" => "page,post",
					"desc" => wp_kses_data( __("Select thumb size for the alternative portfolio layout (number items horizontally x number items vertically)", 'seafood-company') ),
					"class" => "",
					"std" => "1_1",
					"type" => "radio",
					"options" => seafood_company_get_options_param('list_alter_sizes')
					),
		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'seafood-company'),
					"desc" => wp_kses_data( __("Show featured image (if selected) before post content on single pages", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'seafood-company'),
					"desc" => wp_kses_data( __('Show area with post title on single pages', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'seafood-company'),
					"desc" => wp_kses_data( __('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'seafood-company'),
					"desc" => wp_kses_data( __('Show area with post info on single pages', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'seafood-company'),
					"desc" => wp_kses_data( __('Show text before "Read more" tag on single pages', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'seafood-company'),
					"desc" => wp_kses_data( __("Show post author information block on single post page", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'seafood-company'),
					"desc" => wp_kses_data( __("Show tags block on single post page", 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'seafood-company'),
					"desc" => wp_kses_data( __("Show related posts block on single post page", 'seafood-company') ),
					"override" => "category,services_group,post,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'seafood-company'),
					"desc" => wp_kses_data( __("How many related posts showed on single post page", 'seafood-company') ),
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"override" => "category,services_group,post,custom",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'seafood-company'),
					"desc" => wp_kses_data( __("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'seafood-company') ),
					"override" => "category,services_group,post,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'seafood-company'),
					"desc" => wp_kses_data( __('Select the desired sorting method for related posts', 'seafood-company') ),
		
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "date",
					"options" => seafood_company_get_options_param('list_sorting'),
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'seafood-company'),
					"desc" => wp_kses_data( __('Select the desired ordering method for related posts', 'seafood-company') ),
		
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "desc",
					"options" => seafood_company_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_other' => array(
					"title" => esc_html__('Other parameters', 'seafood-company'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_blog_other_1" => array(
					"title" => esc_html__('Other Blog parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select excluded categories, substitute parameters, etc.', 'seafood-company') ),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'seafood-company'),
					"desc" => wp_kses_data( __('Select categories, which posts are exclude from blog page', 'seafood-company') ),
					"std" => "",
					"options" => seafood_company_get_options_param('list_categories'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'seafood-company'),
					"desc" => wp_kses_data( __('Select type of the pagination on blog streampages', 'seafood-company') ),
					"std" => "pages",
					"override" => "category,services_group,page,custom",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'seafood-company'),
						'slider'   => esc_html__('Slider with page numbers', 'seafood-company'),
						'viewmore' => esc_html__('"View more" button', 'seafood-company'),
						'infinite' => esc_html__('Infinite scroll', 'seafood-company')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'seafood-company'),
					"desc" => wp_kses_data( __('Select counters, displayed near the post title', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "views",
					"options" => seafood_company_get_options_param('list_blog_counters'),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'seafood-company'),
					"desc" => wp_kses_data( __('What category display in announce block (over posts thumb) - original or nearest parental', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "parental",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'seafood-company'),
						'original' => esc_html__("Original post's category", 'seafood-company')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'seafood-company'),
					"desc" => wp_kses_data( __('Show post date after N days (before - show post age)', 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'seafood-company'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,services_group",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'seafood-company'),
					"desc" => wp_kses_data( __('Set up list of reviews criterias. You can override it in any category.', 'seafood-company') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'seafood-company'),
					"desc" => wp_kses_data( __("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'seafood-company') ),
					"override" => "category,services_group,services_group",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'seafood-company'),
					"desc" => wp_kses_data( __("Maximum level for reviews marks", 'seafood-company') ),
					"std" => "5",
					"options" => array(
						'5'=>esc_html__('5 stars', 'seafood-company'), 
						'10'=>esc_html__('10 stars', 'seafood-company'), 
						'100'=>esc_html__('100%', 'seafood-company')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'seafood-company'),
					"desc" => wp_kses_data( __("Show rating marks as text or as stars/progress bars.", 'seafood-company') ),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'seafood-company'), 
						'stars' => esc_html__('As stars or bars', 'seafood-company')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'seafood-company'),
					"desc" => wp_kses_data( __('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'seafood-company') ),
					"std" => esc_html__("bad,poor,normal,good,great", 'seafood-company'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'seafood-company'),
					"desc" => wp_kses_data( __("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'seafood-company') ),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'seafood-company'),
						'users' => esc_html__('By visitors', 'seafood-company')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'seafood-company'),
					"desc" => wp_kses_data( __("Do you want hide second reviews tab in widgets and single posts?", 'seafood-company') ),
					"std" => "show",
					"options" => seafood_company_get_options_param('list_show_hide'),
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'seafood-company'),
					"desc" => wp_kses_data( __("What visitors can vote: all or only registered", 'seafood-company') ),
					"std" => "all",
					"options" => array(
						'all'=>esc_html__('All visitors', 'seafood-company'), 
						'registered'=>esc_html__('Only registered', 'seafood-company')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'seafood-company'),
					"desc" => wp_kses_data( __('Add default reviews criterias.',  'seafood-company') ),
					"override" => "category,services_group,services_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		// Don't remove this parameter - it used in admin for store marks
		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		





		//###############################
		//#### Media                #### 
		//###############################
		"partition_media" => array(
					"title" => esc_html__('Media', 'seafood-company'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		"info_media_1" => array(
					"title" => esc_html__('Media settings', 'seafood-company'),
					"desc" => wp_kses_data( __('Set up parameters to show images, galleries, audio and video posts', 'seafood-company') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'seafood-company'),
					"desc" => wp_kses_data( __('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'seafood-company') ),
					"std" => "1",
					"size" => "medium",
					"options" => array(
						"1" => esc_html__("Original", 'seafood-company'), 
						"2" => esc_html__("Retina", 'seafood-company')
					),
					"type" => "switch"),
		
		"images_quality" => array(
					"title" => esc_html__('Quality for cropped images', 'seafood-company'),
					"desc" => wp_kses_data( __('Quality (1-100) to save cropped images', 'seafood-company') ),
					"std" => "70",
					"min" => 1,
					"max" => 100,
					"type" => "spinner"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'seafood-company'),
					"desc" => wp_kses_data( __('Substitute standard Wordpress gallery with our slider on the single pages', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'seafood-company'),
					"desc" => wp_kses_data( __('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'seafood-company'),
					"desc" => wp_kses_data( __('Maximum images number from gallery into slider', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'gallery_instead_image' => array('yes')
					),
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Popup engine to zoom images', 'seafood-company'),
					"desc" => wp_kses_data( __('Select engine to show popup windows with images and galleries', 'seafood-company') ),
					"std" => "magnific",
					"options" => seafood_company_get_options_param('list_popups'),
					"type" => "select"),
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'seafood-company'),
					"desc" => wp_kses_data( __('Substitute audio tag with source from soundcloud to embed player', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'seafood-company'),
					"desc" => wp_kses_data( __('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'seafood-company') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'seafood-company'),
					"desc" => wp_kses_data( __('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'seafood-company'),
					"icon" => "iconadmin-users",
					"override" => "category,services_group,page,custom",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'seafood-company'),
					"desc" => wp_kses_data( __("Social networks list for site footer and Social widget", 'seafood-company') ),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'seafood-company'),
					"desc" => wp_kses_data( __('Select icon and write URL to your profile in desired social networks.',  'seafood-company') ),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? seafood_company_get_options_param('list_socials') : seafood_company_get_options_param('list_icons'),
					"type" => "socials"),
		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'seafood-company'),
					"desc" => wp_kses_data( __("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'seafood-company'),
					"desc" => wp_kses_data( __("Show social share buttons block", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'seafood-company'),
						'vertical'	=> esc_html__('Vertical', 'seafood-company'),
						'horizontal'=> esc_html__('Horizontal', 'seafood-company')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'seafood-company'),
					"desc" => wp_kses_data( __("Show share counters after social buttons", 'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'seafood-company'),
					"desc" => wp_kses_data( __('Caption for the block with social share buttons',  'seafood-company') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => esc_html__('Share:', 'seafood-company'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'seafood-company'),
					"desc" => wp_kses_data( __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'seafood-company') ),
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? seafood_company_get_options_param('list_socials') : seafood_company_get_options_param('list_icons'),
					"type" => "socials"),
		
		
		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'seafood-company'),
					"desc" => wp_kses_data( __("Put to this section Twitter API 1.1 keys.<br>You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'seafood-company') ),
					"type" => "info"),
		
		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'seafood-company'),
					"desc" => wp_kses_data( __('Your login (username) in Twitter',  'seafood-company') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'seafood-company'),
					"desc" => wp_kses_data( __('Twitter API Consumer key',  'seafood-company') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'seafood-company'),
					"desc" => wp_kses_data( __('Twitter API Consumer secret',  'seafood-company') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'seafood-company'),
					"desc" => wp_kses_data( __('Twitter API Token key',  'seafood-company') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'seafood-company'),
					"desc" => wp_kses_data( __('Twitter API Token secret',  'seafood-company') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"info_socials_4" => array(
					"title" => esc_html__('Google API Keys', 'seafood-company'),
					"desc" => wp_kses_data( __('API Keys for some Web services', 'seafood-company') ),
					"type" => "info"),
		'api_google' => array(
					"title" => esc_html__('Google API Key for browsers', 'seafood-company'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps. Please note that this option will only work with the active TRX Utils/Addons plugin.", 'seafood-company') ),
					"std" => "",
					"type" => "text"),
		
		"info_socials_5" => array(
					"title" => esc_html__('Login via Socials', 'seafood-company'),
					"desc" => wp_kses_data( __('Settings for the Login via Social networks', 'seafood-company') ),
					"type" => "info"),
		
		"social_login" => array(
					"title" => esc_html__('Shortcode or any HTML/JS code',  'seafood-company'),
					"desc" => wp_kses_data( __('Specify shortcode from your Social Login Plugin or any HTML/JS code to make Social Login section',  'seafood-company') ),
					"std" => "",
					"type" => "textarea"),
		
		
		
		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'seafood-company'),
					"icon" => "iconadmin-mail",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'seafood-company'),
					"desc" => wp_kses_data( __('Company address, phones and e-mail', 'seafood-company') ),
					"type" => "info"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in the header', 'seafood-company'),
					"desc" => wp_kses_data( __('String with contact info in the left side of the site header', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_open_hours" => array(
					"title" => esc_html__('Open hours in the header', 'seafood-company'),
					"desc" => wp_kses_data( __('String with open hours in the site header', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-clock'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'seafood-company'),
					"desc" => wp_kses_data( __('E-mail for send contact form and user registration data', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'seafood-company'),
					"desc" => wp_kses_data( __('Company country, post code and city', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'seafood-company'),
					"desc" => wp_kses_data( __('Street and house number', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
        "contact_phone_label" => array(
                    "title" => esc_html__('Text before phone', 'seafood-company'),
                    "desc" => wp_kses_data( __('Text before phone number', 'seafood-company') ),
                    "std" => "",
                    "before" => array('icon'=>'iconadmin-phone'),
                    "allow_html" => true,
                    "type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'seafood-company'),
					"desc" => wp_kses_data( __('Phone number', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'seafood-company'),
					"desc" => wp_kses_data( __('Fax number', 'seafood-company') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'seafood-company'),
					"desc" => wp_kses_data( __('Maximum length of the messages in the contact form shortcode and in the comments form', 'seafood-company') ),
					"type" => "info"),
		
		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'seafood-company'),
					"desc" => wp_kses_data( __("Message's maxlength in the contact form shortcode", 'seafood-company') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'seafood-company'),
					"desc" => wp_kses_data( __("Message's maxlength in the comments form", 'seafood-company') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'seafood-company'),
					"desc" => wp_kses_data( __('What function use to send mail: the built-in Wordpress wp_mail or standard PHP mail function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'seafood-company') ),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'seafood-company'),
					"desc" => wp_kses_data( __("What function use to send mail? Attention! Only wp_mail support attachment in the mail!", 'seafood-company') ),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'seafood-company'),
						'mail' => esc_html__('PHP mail', 'seafood-company')
					),
					"type" => "switch"),
		
		
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'seafood-company'),
					"icon" => "iconadmin-search",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'seafood-company'),
					"desc" => wp_kses_data( __('Enable/disable AJAX search and output settings for it', 'seafood-company') ),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'seafood-company'),
					"desc" => wp_kses_data( __('Show search field in the top area and side menus', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"search_style" => array( 
					"title" => esc_html__('Select search style', 'seafood-company'),
					"desc" => wp_kses_data( __('Select style for the search field', 'seafood-company') ),
					"std" => "default",
					"type" => "select",
					"options" => seafood_company_get_options_param('list_search_styles')),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'seafood-company'),
					"desc" => wp_kses_data( __('Use incremental AJAX search for the search field in top of page', 'seafood-company') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand')
					),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'seafood-company'),
					"desc" => wp_kses_data( __('The minimum length of the search string',  'seafood-company') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'seafood-company'),
					"desc" => wp_kses_data( __('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'seafood-company') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'seafood-company'),
					"desc" => wp_kses_data( __('Select post types, what will be include in search results. If not selected - use all types.', 'seafood-company') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => "",
					"options" => seafood_company_get_options_param('list_posts_types'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'seafood-company'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __('Number of the posts to show in search results',  'seafood-company') ),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'seafood-company'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's thumbnail in the search results", 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'seafood-company'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's publish date in the search results", 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'seafood-company'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's author in the search results", 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'seafood-company'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's counters (views, comments, likes) in the search results", 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'seafood-company'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'seafood-company'),
					"desc" => wp_kses_data( __('Basic theme functionality settings', 'seafood-company') ),
					"type" => "info"),

		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'seafood-company'),
					"desc" => wp_kses_data( __('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'seafood-company'),
					"desc" => wp_kses_data( __("Allow authors to edit their posts in frontend area", 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'seafood-company'),
					"desc" => wp_kses_data( __('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'seafood-company'),
					"desc" => wp_kses_data( __('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'seafood-company'),
					"desc" => wp_kses_data( __('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'seafood-company'),
					"desc" => wp_kses_data( __('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'seafood-company') ),
					"std" => "yes",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'seafood-company'),
					"desc" => wp_kses_data( __('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'seafood-company') ),
					"std" => 120,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),

                    "disable_widgets_block_editor" => array(
                        "title" => esc_html__('Disable new Widgets Block Editor', 'seafood-company'),
                        "desc" => wp_kses_data( __('Attention! If after the update to WordPress 5.8+ you are having trouble editing widgets or working in Customizer - disable new Widgets Block Editor (used in WordPress 5.8+ instead of a classic widgets panel)', 'seafood-company') ),
                        "std" => "yes",
                        "options" => seafood_company_get_options_param('list_yes_no'),
                        "type" => "switch"),
		
		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'seafood-company'),
					"desc" => wp_kses_data( __('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services or utilities', 'seafood-company') ),
					"std" => "no",
					"options" => seafood_company_get_options_param('list_yes_no'),
					"type" => "switch")
                )
            )
        );

    }
}


// Update all temporary vars (start with $seafood_company_) in the Theme Options with actual lists
if ( !function_exists( 'seafood_company_options_settings_theme_setup2' ) ) {
	add_action( 'seafood_company_action_after_init_theme', 'seafood_company_options_settings_theme_setup2', 1 );
	function seafood_company_options_settings_theme_setup2() {
		if (seafood_company_options_is_used()) {
			// Replace arrays with actual parameters
			$lists = array();
			$tmp = seafood_company_storage_get('options');
			if (is_array($tmp) && count($tmp) > 0) {
				$prefix = '$seafood_company_';
				$prefix_len = seafood_company_strlen($prefix);
				foreach ($tmp as $k=>$v) {
					if (isset($v['options']) && is_array($v['options']) && count($v['options']) > 0) {
						foreach ($v['options'] as $k1=>$v1) {
							if (seafood_company_substr($k1, 0, $prefix_len) == $prefix || seafood_company_substr($v1, 0, $prefix_len) == $prefix) {
								$list_func = seafood_company_substr(seafood_company_substr($k1, 0, $prefix_len) == $prefix ? $k1 : $v1, 1);
								$inherit = strpos($list_func, '(true)')!==false;
								$list_func = str_replace('(true)', '', $list_func);
								unset($tmp[$k]['options'][$k1]);
								if (isset($lists[$list_func]))
									$tmp[$k]['options'] = seafood_company_array_merge($tmp[$k]['options'], $lists[$list_func]);
								else {
									if (function_exists($list_func)) {
										$tmp[$k]['options'] = $lists[$list_func] = seafood_company_array_merge($tmp[$k]['options'], $list_func($inherit));
								   	} else
								   		dfl(sprintf(esc_html__('Wrong function name %s in the theme options array', 'seafood-company'), $list_func));
								}
							}
						}
					}
				}
				seafood_company_storage_set('options', $tmp);
			}
		}
	}
}



// Reset old Theme Options while theme first run
if ( !function_exists( 'seafood_company_options_reset' ) ) {

    function seafood_company_options_reset($clear=true) {
        $theme_slug = str_replace(' ', '_', trim(seafood_company_strtolower(get_stylesheet())));
        $option_name = seafood_company_storage_get('options_prefix') . '_' . trim($theme_slug) . '_options_reset';
        if ( get_option($option_name, false) === false ) {
            if ($clear) {
                // Remove Theme Options from WP Options
                global $wpdb;
                $wpdb->query( $wpdb->prepare(
                    "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                    seafood_company_storage_get('options_prefix').'_%'
                )
                );
                // Add Templates Options
                $txt = seafood_company_fgc(seafood_company_storage_get('demo_data_url') . 'default/templates_options.txt');
                if (!empty($txt)) {
                    $data = seafood_company_unserialize($txt);
                    // Replace upload url in options
                    if (is_array($data) && count($data) > 0) {
                        foreach ($data as $k=>$v) {
                            if (is_array($v) && count($v) > 0) {
                                foreach ($v as $k1=>$v1) {
                                    $v[$k1] = seafood_company_replace_uploads_url(seafood_company_replace_uploads_url($v1, 'uploads'), 'imports');
                                }
                            }
                            add_option( $k, $v, '', 'yes' );
                        }
                    }
                }
            }
            add_option($option_name, 1, '', 'yes');
        }
    }
}


// Reset old Theme Options while theme first run
if ( !function_exists( 'seafood_company_options_reset' ) ) {
    function seafood_company_options_reset($clear=true) {
        $theme_data = wp_get_theme();
        $slug = str_replace(' ', '_', trim(seafood_company_strtolower((string) $theme_data->get('Name'))));
        $option_name = 'seafood_company_'.strip_tags($slug).'_options_reset';

        // Prepare demo data
        if ( is_dir( SEAFOOD_COMPANY_THEME_PATH . 'demo/' ) ) {
            $demo_url = SEAFOOD_COMPANY_THEME_PATH . 'demo/';
        } else {
            $demo_url = esc_url( seafood_company_get_protocol().'://demofiles.themerex.net/seafood-company/' ); // Demo-site domain
        }
        $txt = seafood_company_fgc( $demo_url . 'default/templates_options.txt');

        if ( get_option($option_name, false) === false ) {
            if ($clear) {
                // Remove Theme Options from WP Options
                global $wpdb;
                $wpdb->query('delete from '.esc_sql($wpdb->options).' where option_name like "seafood_company_%"');
                // Add Templates Options

                if ($txt) {
                    $data = seafood_company_unserialize($txt);
                    // Replace upload url in options
                    if (is_array($data) && count($data) > 0) {
                        foreach ($data as $k=>$v) {
                            if (is_array($v) && count($v) > 0) {
                                foreach ($v as $k1=>$v1) {
                                    $v[$k1] = seafood_company_replace_uploads_url(seafood_company_replace_uploads_url($v1, 'uploads'), 'imports');
                                }
                            }
                            add_option( $k, $v, '', 'yes' );
                        }
                    }
                }
            }
            add_option($option_name, 1, '', 'yes');
        }
    }
}

?>