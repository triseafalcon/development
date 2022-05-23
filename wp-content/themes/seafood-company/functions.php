<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'seafood_company_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_theme_setup', 1 );
	function seafood_company_theme_setup() {

		// Register theme menus
		add_filter( 'seafood_company_filter_add_theme_menus',		'seafood_company_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'seafood_company_filter_add_theme_sidebars',	'seafood_company_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'seafood_company_filter_importer_options',		'seafood_company_set_importer_options' );

		// Add theme required plugins
		add_filter( 'seafood_company_filter_required_plugins',		'seafood_company_add_required_plugins' );
		
		// Add preloader styles
		add_filter('seafood_company_filter_add_styles_inline',		'seafood_company_head_add_page_preloader_styles');

		// Init theme after WP is created
		add_action( 'wp',									'seafood_company_core_init_theme' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 							'seafood_company_body_classes' );
		add_filter( 'comment_form_fields', 'seafood_company_move_comment_field_to_bottom' );


		// Add data to the head and to the beginning of the body
		add_action('wp_head',								'seafood_company_head_add_page_meta', 1);
		add_action('before',								'seafood_company_body_add_toc');
		add_action('before',								'seafood_company_body_add_page_preloader');

		// Add data to the footer (priority 1, because priority 2 used for localize scripts)
		add_action('wp_footer',								'seafood_company_footer_add_views_counter', 1);
		add_action('wp_footer',								'seafood_company_footer_add_theme_customizer', 1);
		add_action('wp_footer',								'seafood_company_footer_add_custom_html', 1);

		// Set list of the theme required plugins
		seafood_company_storage_set('required_plugins', array(
			'essgrids',
			'revslider',
			'trx_utils',
			'visual_composer',
			'woocommerce',
            'contact_form_7',
            'elegro-payment',
            'product-delivery-date-for-woocommerce-lite',
            'trx-updater',
            'cooked',
			)
		);

		// Set list of the theme required custom fonts from folder /css/font-faces
		// Attention! Font's folder must have name equal to the font's name
		seafood_company_storage_set('required_custom_fonts', array(
			'Amadeus'
			)
		);

		if (is_dir(SEAFOOD_COMPANY_THEME_PATH . 'demo/')) {
            seafood_company_storage_set('demo_data_url', SEAFOOD_COMPANY_THEME_PATH . 'demo/');
        } else {
            seafood_company_storage_set('demo_data_url',seafood_company_get_protocol() . '://demofiles.themerex.net/seafood-company/'); // Demo-site domain
        }
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'seafood_company_add_theme_menus' ) ) {
	
	function seafood_company_add_theme_menus($menus) {
		return $menus;
	}
}

if ( !function_exists( 'seafood_company_move_comment_field_to_bottom' ) ) {
	function seafood_company_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'seafood_company_add_theme_sidebars' ) ) {
	
	function seafood_company_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'seafood-company' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'seafood-company' )
			);
			if (function_exists('seafood_company_exists_woocommerce') && seafood_company_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'seafood-company' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'seafood_company_add_required_plugins' ) ) {
	
	function seafood_company_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__('SeaFood Company Utilities', 'seafood-company'),
			'version'	=> '3.2.1',					// Minimal required version
			'slug' 		=> 'trx_utils',
			'source'	=> seafood_company_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}


// Add data to the head and to the beginning of the body
//------------------------------------------------------------------------

// Add theme specified classes to the body tag
if ( !function_exists('seafood_company_body_classes') ) {
	
	function seafood_company_body_classes( $classes ) {

		$classes[] = 'seafood_company_body';
		$classes[] = 'body_style_' . trim(seafood_company_get_custom_option('body_style'));
		$classes[] = 'body_' . (seafood_company_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'article_style_' . trim(seafood_company_get_custom_option('article_style'));
		
		$blog_style = seafood_company_get_custom_option(is_singular() && !seafood_company_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(seafood_company_get_template_name($blog_style));
		
		$body_scheme = seafood_company_get_custom_option('body_scheme');
		if (empty($body_scheme)  || seafood_company_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = seafood_company_get_custom_option('top_panel_position');
		if (!seafood_company_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = seafood_company_get_sidebar_class();

		if (seafood_company_get_custom_option('show_video_bg')=='yes' && (seafood_company_get_custom_option('video_bg_youtube_code')!='' || seafood_company_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (!seafood_company_param_is_off(seafood_company_get_theme_option('page_preloader')))
			$classes[] = 'preloader';

		return $classes;
	}
}


// Add page meta to the head
if (!function_exists('seafood_company_head_add_page_meta')) {
	
	function seafood_company_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1<?php if (seafood_company_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
		<meta name="format-detection" content="telephone=no">
	
		<link rel="profile" href="//gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
	}
}

// Add page preloader styles to the head
if (!function_exists('seafood_company_head_add_page_preloader_styles')) {
	
	function seafood_company_head_add_page_preloader_styles($css) {
		if (($preloader=seafood_company_get_theme_option('page_preloader'))!='none') {
			$image = seafood_company_get_theme_option('page_preloader_image');
			$bg_clr = seafood_company_get_scheme_color('bg_color');
			$link_clr = seafood_company_get_scheme_color('text_link');
			$css .= '
				#page_preloader {
					background-color: '. esc_attr($bg_clr) . ';'
					. ($preloader=='custom' && $image
						? 'background-image:url('.esc_url($image).');'
						: ''
						)
				    . '
				}
				.preloader_wrap > div {
					background-color: '.esc_attr($link_clr).';
				}';
		}
		return $css;
	}
}

// Add TOC anchors to the beginning of the body
if (!function_exists('seafood_company_body_add_toc')) {
	
	function seafood_company_body_add_toc() {
		// Add TOC items 'Home' and "To top"
		if (seafood_company_get_custom_option('menu_toc_home')=='yes' && function_exists('seafood_company_sc_anchor'))
			seafood_company_show_layout(seafood_company_sc_anchor(array(
				'id' => "toc_home",
				'title' => esc_html__('Home', 'seafood-company'),
				'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'seafood-company'),
				'icon' => "icon-home",
				'separator' => "yes",
				'url' => esc_url(home_url('/'))
				)
			)); 
		if (seafood_company_get_custom_option('menu_toc_top')=='yes' && function_exists('seafood_company_sc_anchor'))
			seafood_company_show_layout(seafood_company_sc_anchor(array(
				'id' => "toc_top",
				'title' => esc_html__('To Top', 'seafood-company'),
				'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'seafood-company'),
				'icon' => "icon-double-up",
				'separator' => "yes")
				)); 
	}
}

// Add page preloader to the beginning of the body
if (!function_exists('seafood_company_body_add_page_preloader')) {
	
	function seafood_company_body_add_page_preloader() {
		if ( ($preloader=seafood_company_get_theme_option('page_preloader')) != 'none' && ( $preloader != 'custom' || ($image=seafood_company_get_theme_option('page_preloader_image')) != '')) {
			?><div id="page_preloader"><?php
				if ($preloader == 'circle') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_circ1"></div><div class="preloader_circ2"></div><div class="preloader_circ3"></div><div class="preloader_circ4"></div></div><?php
				} else if ($preloader == 'square') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_square1"></div><div class="preloader_square2"></div></div><?php
				}
			?></div><?php
		}
	}
}


// Add data to the footer
//------------------------------------------------------------------------

// Add post/page views counter
if (!function_exists('seafood_company_footer_add_views_counter')) {
	
	function seafood_company_footer_add_views_counter() {
		// Post/Page views counter
		get_template_part(seafood_company_get_file_slug('templates/_parts/views-counter.php'));
	}
}

// Add theme customizer
if (!function_exists('seafood_company_footer_add_theme_customizer')) {
	
	function seafood_company_footer_add_theme_customizer() {
		// Front customizer
		if (seafood_company_get_custom_option('show_theme_customizer')=='yes') {
			require_once SEAFOOD_COMPANY_FW_PATH . 'core/core.customizer/front.customizer.php';
		}
	}
}

// Add custom html
if (!function_exists('seafood_company_footer_add_custom_html')) {
	
	function seafood_company_footer_add_custom_html() {
		?><div class="custom_html_section"><?php
			echo seafood_company_get_custom_option('custom_code');
		?></div><?php
	}
}

//------------------------------------------------------------------------ 
// One-click import support 
//------------------------------------------------------------------------ 

// Set theme specific importer options 
if ( ! function_exists( 'seafood_company_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'seafood_company_importer_set_options', 9 );
    function seafood_company_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file 
            $options['debug'] = false;
            // Prepare demo data 
            if ( is_dir( SEAFOOD_COMPANY_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = SEAFOOD_COMPANY_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( seafood_company_get_protocol().'://demofiles.themerex.net/seafood-company/' ); // Demo-site domain
            }

            // Required plugins 
            $options['required_plugins'] =  array(
                'essential-grid',
                'revslider',
                'trx_utils',
                'js_composer',
                'contact_form_7',
                'woocommerce',
                'cooked',
                'product-delivery-date-for-woocommerce-lite',
            );

            $options['theme_slug'] = 'seafood_company';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images) 
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images) 
            $options['regenerate_thumbnails'] = 3;
            // Default demo 
            $options['files']['default']['title'] = esc_html__( 'Seafood_company Demo', 'seafood-company' );
            $options['files']['default']['domain_dev'] = esc_url(seafood_company_get_protocol().'://seafood-company.dv.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url(seafood_company_get_protocol().'://seafood-company.themerex.net'); // Demo-site domain

        }
        return $options;
    }
}

// Add theme required plugins
if ( !function_exists( 'seafood_company_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'seafood_company_add_trx_utils' );
    function seafood_company_add_trx_utils($enable=true) {
        return true;
    }
}

// Gutenberg support
add_theme_support( 'align-wide' );


// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'seafood_company_trx_utils_privacy_text' ) ) {
    add_filter( 'trx_utils_filter_privacy_text', 'seafood_company_trx_utils_privacy_text' );
    function seafood_company_trx_utils_privacy_text( $text='' ) {
        return seafood_company_get_privacy_text();
    }
}

/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
}

// Include framework core files
//-------------------------------------------------------------------
require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
?>