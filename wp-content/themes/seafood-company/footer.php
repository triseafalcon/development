<?php
/**
 * The template for displaying the footer.
 */

				seafood_company_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (seafood_company_get_custom_option('body_style')!='fullscreen') seafood_company_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (seafood_company_get_custom_option('')=='yes' && function_exists('seafood_company_sc_testimonials')) {
				$count = max(1, seafood_company_get_custom_option('testimonials_count'));
				$data = seafood_company_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(seafood_company_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php seafood_company_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}
			
			// Footer sidebar
			$footer_show  = seafood_company_get_custom_option('show_sidebar_footer');
			$sidebar_name = seafood_company_get_custom_option('sidebar_footer');
			if (!seafood_company_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) { 
				seafood_company_storage_set('current_sidebar', 'footer');
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(seafood_company_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
                                if ( is_active_sidebar( $sidebar_name ) ) {
                                    dynamic_sidebar( $sidebar_name );
                                }
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							seafood_company_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out));
							?></div>	<!-- /.columns_wrap -->
						</div>	<!-- /.content_wrap -->
					</div>	<!-- /.footer_wrap_inner -->
				</footer>	<!-- /.footer_wrap -->
				<?php
			}


			// Footer Twitter stream
			if (seafood_company_get_custom_option('show_twitter_in_footer')=='yes' && function_exists('seafood_company_sc_twitter')) {
				$count = max(1, seafood_company_get_custom_option('twitter_count'));
				$data = seafood_company_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(seafood_company_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php seafood_company_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Google map
			if ( seafood_company_get_custom_option('show_googlemap')=='yes' ) { 
				$map_address = seafood_company_get_custom_option('googlemap_address');
				$map_latlng  = seafood_company_get_custom_option('googlemap_latlng');
				$map_zoom    = seafood_company_get_custom_option('googlemap_zoom');
				$map_style   = seafood_company_get_custom_option('googlemap_style');
				$map_height  = seafood_company_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					seafood_company_show_layout(seafood_company_sc_googlemap($args));
				}
			}

			// Footer contacts
			if (seafood_company_get_custom_option('show_contacts_in_footer')=='yes') { 
				$address_1 = seafood_company_get_theme_option('contact_address_1');
				$address_2 = seafood_company_get_theme_option('contact_address_2');
				$phone = seafood_company_get_theme_option('contact_phone');
				$fax = seafood_company_get_theme_option('contact_fax');
				if (!empty($address_1) || !empty($address_2) || !empty($phone) || !empty($fax)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(seafood_company_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
							<div class="content_wrap">
								<?php seafood_company_show_logo(false, false, true); ?>
								<div class="contacts_address">
									<address class="address_right">
										<?php if (!empty($phone)) echo esc_html__('Phone:', 'seafood-company') . ' ' . esc_html($phone) . '<br>'; ?>
										<?php if (!empty($fax)) echo esc_html__('Fax:', 'seafood-company') . ' ' . esc_html($fax); ?>
									</address>
									<address class="address_left">
										<?php if (!empty($address_2)) echo esc_html($address_2) . '<br>'; ?>
										<?php if (!empty($address_1)) echo esc_html($address_1); ?>
									</address>
								</div>
								<?php seafood_company_show_layout(seafood_company_sc_socials(array('size'=>"medium"))); ?>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.contacts_wrap_inner -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}

			// Copyright area
			$copyright_style = seafood_company_get_custom_option('show_copyright_in_footer');
			if (!seafood_company_param_is_off($copyright_style)) {
				?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(seafood_company_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (($menu = seafood_company_get_nav_menu('menu_footer'))!='') {
									seafood_company_show_layout($menu);
								}
							} else if ($copyright_style == 'socials') {
								seafood_company_show_layout(seafood_company_sc_socials(array('size'=>"tiny")));
							}
							?>
							<div class="copyright_text"><?php
                                $seafood_company_copyright = seafood_company_get_custom_option('footer_copyright');
                                $seafood_company_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $seafood_company_copyright);
                                echo wp_kses_post($seafood_company_copyright);
                                ?></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php if ( !seafood_company_param_is_off(seafood_company_get_custom_option('show_sidebar_outer')) ) { ?>
	</div>	<!-- /.outer_wrap -->
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>