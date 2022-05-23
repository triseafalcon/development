<?php
// Get template args
extract(seafood_company_template_get_args('counters'));

$show_all_counters = false;
$counters_tag = is_single() ? 'span' : 'a';

// Views
if ($show_all_counters || seafood_company_strpos($post_options['counters'], 'views')!==false && function_exists('seafood_company_reviews_theme_setup')) {
	?>
	<<?php seafood_company_show_layout($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo esc_attr( sprintf(__('Views - %s', 'seafood-company'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php $post_data['post_views']>0?seafood_company_show_layout($post_data['post_views']):printf(0); ?></span><?php echo ' '.esc_html__('Views', 'seafood-company'); ?></<?php seafood_company_show_layout($counters_tag); ?>>
	<?php
}

// Likes
if ($show_all_counters || seafood_company_strpos($post_options['counters'], 'likes')!==false && function_exists('seafood_company_reviews_theme_setup')) {
	// Load core messages
	seafood_company_enqueue_messages();
	$likes = isset($_COOKIE['seafood_company_likes']) ? sanitize_text_field($_COOKIE['seafood_company_likes']) : '';
	$allow = seafood_company_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart-empty <?php echo !empty($allow) ? 'enabled' : 'disabled'; ?>" title="<?php echo !empty($allow) ? esc_attr__('Like', 'seafood-company') : esc_attr__('Dislike', 'seafood-company'); ?>" href="#"
	   data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
	   data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
	   data-title-like="<?php esc_attr_e('Like', 'seafood-company'); ?>"
	   data-title-dislike="<?php esc_attr_e('Dislike', 'seafood-company'); ?>"><span class="post_counters_number"><?php $post_data['post_likes']>0?seafood_company_show_layout($post_data['post_likes']):printf(0); ?></span><?php echo ' '.esc_html__('Likes', 'seafood-company'); ?></a>
	<?php
}

// Comments
if ($show_all_counters || seafood_company_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-comment" title="<?php echo esc_attr( sprintf(__('Comments - %s', 'seafood-company'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php $post_data['post_comments']>0?seafood_company_show_layout($post_data['post_comments']):printf(0); ?></span><?php echo ' '.esc_html__('Comments', 'seafood-company'); ?></a>
	<?php
}

// Rating
$rating = $post_data['post_reviews_'.(seafood_company_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || seafood_company_strpos($post_options['counters'], 'rating')!==false)) { 
	?>
	<<?php seafood_company_show_layout($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(__('Rating - %s', 'seafood-company'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php $rating>0?seafood_company_show_layout($rating):printf(0); ?></span></<?php seafood_company_show_layout($counters_tag); ?>>
	<?php
}

// Edit page link
if (seafood_company_strpos($post_options['counters'], 'edit')!==false) {
	edit_post_link( esc_html__( 'Edit', 'seafood-company' ), '<span class="post_edit edit-link">', '</span>' );
}

// Markup for search engines
if (is_single() && seafood_company_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(seafood_company_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(seafood_company_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>