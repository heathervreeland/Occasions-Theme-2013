<?php
/****************************************************************
 * DO NOT DELETE
 ****************************************************************/
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('FLOTHEME_PATH', TEMPLATEPATH . '/flotheme');
	define('FLOTHEME_URL', get_bloginfo('template_directory') . '/flotheme');
} else {
	
	define('FLOTHEME_PATH', STYLESHEETPATH . '/flotheme');
	define('FLOTHEME_URL', get_bloginfo('stylesheet_directory') . '/flotheme');
}

require_once FLOTHEME_PATH . '/init.php';

/****************************************************************
 * You can add your functions here.
 * 
 * BE CAREFULL! Functions will dissapear after update.
 * If you want to add custom functions you should do manual
 * updates only.
 ****************************************************************/



// function _import_events()
// {
// 	global $wpdb;
// 	if (!isset($_GET['blablabla'])) {
// 		return;
// 	}
// 	require_once('wp_pod_tbl_events.php');

// 	$vendor_query = 'SELECT occasionsmag_posts.*, occasionsmag_postmeta.meta_value AS old_id FROM occasionsmag_posts INNER JOIN occasionsmag_postmeta ON ( occasionsmag_posts.ID = occasionsmag_postmeta.post_id ) WHERE (occasionsmag_postmeta.meta_key = %s AND occasionsmag_postmeta.meta_value = %d) GROUP BY occasionsmag_posts.ID';


// 	foreach ($wp_pod_tbl_events as $e) {
// 		$vendor = $wpdb->get_row($wpdb->prepare($vendor_query, 'flo_oldid', $e['vendor']));
// 		if (!$vendor) {
// 			continue;
// 		}

// 		$post_id = wp_insert_post(array(
// 			'menu_order' 		=> -1,
// 			'comment_status' 	=> 'open',
// 			'ping_status'		=> 'open',
// 			'post_author'		=> $vendor->ID,
// 			'post_content'		=> '',
// 			'post_excerpt'		=> '',
// 			'post_title'		=> $e['name'],
// 			'post_name'			=> $e['slug'],
// 			'post_status'		=> 'publish',
// 			'post_type'			=> 'event',
// 		));

// 		add_post_meta($post_id, 'flo_author', $vendor->ID);
// 		add_post_meta($post_id, 'flo_start_date', date('m/d/Y', strtotime($e['date_start'])));
// 		add_post_meta($post_id, 'flo_end_date', date('m/d/Y', strtotime($e['date_end'])));

// 		if ($e['hours']) {
// 			add_post_meta($post_id, 'flo_hours', $e['hours']);
// 		}
// 		if ($e['cost']) {
// 			add_post_meta($post_id, 'flo_cost', $e['cost']);
// 		}

// 		if ($e['phone']) {
// 			add_post_meta($post_id, 'flo_phone', $e['phone']);
// 		}
// 		if ($e['location']) {
// 			add_post_meta($post_id, 'flo_event_location', $e['location']);
// 		}
// 		if ($e['address']) {
// 			add_post_meta($post_id, 'flo_event_address', $e['address']);
// 		}
// 		if ($e['city']) {
// 			add_post_meta($post_id, 'flo_event_address_city', $e['city']);
// 		}
// 		if ($e['state']) {
// 			add_post_meta($post_id, 'flo_event_address_state', $e['state']);
// 		}
// 		if ($e['zipcode']) {
// 			add_post_meta($post_id, 'flo_event_address_zip', $e['zipcode']);
// 		}
// 		if ($e['web_url']) {
// 			add_post_meta($post_id, 'flo_more_url', $e['web_url']);
// 		}
// 		if ($e['description']) {
// 			add_post_meta($post_id, 'flo_description', $e['description']);
// 		}
// 	}

// 	exit('all done');
	
// }
// add_action('admin_init', '_import_events');

