<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'seafood_company_template_header_2_theme_setup' ) ) {
	add_action( 'seafood_company_action_before_init_theme', 'seafood_company_template_header_2_theme_setup', 1 );
	function seafood_company_template_header_2_theme_setup() {
		seafood_company_add_template(array(
			'layout' => 'header_2',
			'mode'   => 'header',
			'title'  => esc_html__('Header 2', 'seafood-company'),
			'icon'   => seafood_company_get_file_url('templates/headers/images/2.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'seafood_company_template_header_2_output' ) ) {
	function seafood_company_template_header_2_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_2 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_2 top_panel_position_<?php echo esc_attr(seafood_company_get_custom_option('top_panel_position')); ?>">
			
			<?php if (seafood_company_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						seafood_company_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_info', 'open_hours', 'login', 'socials')
						));
						get_template_part(seafood_company_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php seafood_company_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><?php
						// Phone and email
						$contact_phone=trim(seafood_company_get_custom_option('contact_phone'));
						$contact_phone_label=trim(seafood_company_get_custom_option('contact_phone_label'));
						$address_1 = seafood_company_get_theme_option('contact_address_1');
						$address_2 = seafood_company_get_theme_option('contact_address_2');
						?><div class="column-1_6 contact_field contact_address">
							<?php if (!empty($address_1)||!empty($address_2)) {
								?>
								<span class="contact_icon icon-icon_1"></span>
								<span class="contact_label">
								<?php if (!empty($address_1)) echo esc_html($address_1) . '<br>'; ?>
								<?php if (!empty($address_2)) echo esc_html($address_2); ?>
								</span>
								<?php
							} ?>

						</div><div class="column-1_6 contact_field contact_phone">
							<?php if (!empty($contact_phone)) {
								?>
								<span class="contact_icon icon-icon_2"></span>
								<span class="contact_label"><?php
                                    echo !empty($contact_phone_label) ? $contact_phone_label . '<br>' :
                                        ''; $phone_href = preg_replace("/[^0-9]/", '', $contact_phone);
                                    echo   '<a href="tel:'.$phone_href.'">'. $contact_phone.'</a>'; ?></span>
								<?php
							} ?>
						</div><div class="column-1_3 contact_logo">
							<?php seafood_company_show_logo(); ?>
						</div><ul class="column-1_6 contact_field menu_user_nav">
							<li><span class="contact_icon icon-icon_3"></span></li>
							<?php
							if (seafood_company_get_custom_option('show_login')=='yes') {
								if ( !is_user_logged_in() ) {
									// Load core messages
									seafood_company_enqueue_messages();
									// Anyone can register ?
									?><li class="menu_user_login">
										<?php
										seafood_company_enqueue_popup();
										do_action('trx_utils_action_login');
									?>
									</li><?php
									if ( (int) get_option('users_can_register') > 0) {
										?><li class="menu_user_register"><?php
										seafood_company_enqueue_popup();
										do_action('trx_utils_action_register');?></li>
										<?php
									}
								} else {
									$current_user = wp_get_current_user();
									?>
									<li class="menu_user_controls">
										<span><?php
											?><span class="user_name"><?php seafood_company_show_layout($current_user->display_name); ?></span></span>
										<ul>
											<li><a href="<?php echo esc_url(get_edit_user_link()); ?>" class="icon icon-cog"><?php esc_html_e('Settings', 'seafood-company'); ?></a></li>
										</ul>
									</li>
									<li class="menu_user_logout"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Logout', 'seafood-company'); ?></a></li>
									<?php
								}
							}
							?>
						</ul><div class="column-1_6">
							<?php
							// Woocommerce Cart
							if (function_exists('seafood_company_exists_woocommerce') && seafood_company_exists_woocommerce() && (seafood_company_is_woocommerce_page() && seafood_company_get_custom_option('show_cart')=='shop' || seafood_company_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
								?><div class="contact_field contact_cart"><?php do_action('trx_utils_show_contact_info_cart'); ?></div><?php
							}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix"><div class="menu_main_wrap clearfix">
						<nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(seafood_company_get_theme_option('menu_hover')); ?>">
							<?php
							$menu_main = seafood_company_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = seafood_company_get_nav_menu();
							seafood_company_show_layout($menu_main);
							?>
						</nav>
					</div></div>
			</div>

			</div>
		</header>

		<?php
		seafood_company_storage_set('header_mobile', array(
				 'open_hours' => false,
				 'login' => false,
				 'socials' => false,
				 'bookmarks' => false,
				 'contact_address' => false,
				 'contact_phone_email' => false,
				 'woo_cart' => false,
				 'search' => false
			)
		);
	}
}
?>