<?php
/*
Template Name: Template Redirect To First Child
*/
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$pagekids = get_pages("child_of=" . get_the_ID() . "&sort_column=menu_order");
		$firstchild = $pagekids[0];
		wp_redirect(get_permalink($firstchild->ID));
	}
}
exit;