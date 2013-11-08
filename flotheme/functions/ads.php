<?php
function flo_adrotate_block($block_slug, $tax = 0, $tax2 = 0, $block_count = 6) {
	global $wpdb;

	if($block_slug) {
		$now = current_time('timestamp');
		$prefix = $wpdb->prefix;
				
		// Get all ads in all groups and process them in an array

		if($block_slug == "venue")
		{
			$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM `".$prefix."adrotate` WHERE `type` = 'active' AND `show_type` = %s AND `show_tax` IS NOT NULL AND `show_tax2`=%d", $block_slug, $tax, $tax2));
		}
		else {
			$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM `".$prefix."adrotate` WHERE `type` = 'active' AND `show_type` = %s AND `show_tax`=%d AND `show_tax2`=%d", $block_slug, $tax, $tax2));
		}
		if($results) {
			foreach($results as $result) {
				$selected[$result->id] = $result->weight;
				$selected = adrotate_filter_schedule($selected, $result);

				if ($result->timeframe == 'hour' OR $result->timeframe == 'day' OR $result->timeframe == 'week' OR $result->timeframe == 'month') {
					$selected = adrotate_filter_timeframe($selected, $result);
				}
			}
		}

		$array_count = count($selected);
		$_block_count = $block_count;

		$output ='<ul class="cf">';
		if ($array_count > 0) {
			if($array_count < $block_count) $block_count = $array_count;

			for($i=0;$i<$block_count;$i++) {
				$banner_id = adrotate_pick_weight($selected);
				$output .='<li>';
				$output .= flo_adrotate_ad($banner_id, $block->id);
				$output .= '</li>';
				$selected = array_diff_key($selected, array($banner_id => 0));
			}
		}

		// show empty banners
		$empty_cols = $_block_count - $array_count;
		if ($empty_cols > 0) {
			for ($i=0; $i < $empty_cols; $i++) { 
				if (is_user_logged_in()) {
					$output .= '<li><a href="' . site_url('/advertisers/buy-featured-placement') . '"><span class="image empty"></span></a></li>';
				} else {
					$output .= '<li><span class="image empty"></span></li>';
				}
				
			}
		}
		$output .= '</ul>';
		unset($results, $selected);
	} else {
		$output = '';
	}

	return $output;
}

function flo_adrotate_ad($banner_id, $block = 0) {
	global $wpdb, $adrotate_config, $adrotate_crawlers;

	if (!$banner_id) {
		return;
	}

	$now 				= current_time('timestamp');
	$today 				= gmmktime(0, 0, 0, gmdate("n"), gmdate("j"), gmdate("Y"));
	$useragent 			= $_SERVER['HTTP_USER_AGENT'];
	$useragent_trim 	= trim($useragent, ' \t\r\n\0\x0B');

	

	$banner = $wpdb->get_row($wpdb->prepare("SELECT 
								`id`, 
								`bannercode`, 
								`tracker`, 
								`link`, 
								`image`, 
								`timeframe`, 
								`timeframelength`, 
								`timeframeclicks`, 
								`timeframeimpressions`,
								`advertiser_id`
							FROM 
								`".$wpdb->prefix."adrotate` 
							WHERE 
								`id` = '%s' 
								AND `type` = 'active'
							;", $banner_id));

	$venue = get_post($banner->advertiser_id);

	$output = flo_adrotate_ad_output($banner->id, $block, $venue, $banner->tracker);

	$remote_ip 	= adrotate_get_remote_ip();
	if(is_array($adrotate_crawlers)) $crawlers = $adrotate_crawlers;
		else $crawlers = array();

	$impression_timer = $now - $adrotate_config['impression_timer'];

	$nocrawler = true;
	foreach($crawlers as $crawler) {
		if(preg_match("/$crawler/i", $useragent)) $nocrawler = false;
	}
	$ip = $wpdb->get_var($wpdb->prepare("SELECT `timer` FROM `".$wpdb->prefix."adrotate_tracker` WHERE `ipaddress` = '%s' AND `stat` = 'i' AND `bannerid` = '%s' ORDER BY `timer` DESC LIMIT 1;", $remote_ip, $banner->id));
	if($ip < $impression_timer AND $nocrawler == true AND (strlen($useragent_trim) > 0 OR !empty($useragent))) {
		if($group > 0) $grouporblock = " AND `group` = '$group'";
		if($block > 0) $grouporblock = " AND `block` = '$block'";
		$stats = $wpdb->get_var("SELECT `id` FROM `".$wpdb->prefix."adrotate_stats_tracker` WHERE `ad` = '".$banner->id."'$grouporblock AND `thetime` = '$today';");
		if($stats > 0) {
			$wpdb->query($wpdb->prepare("UPDATE `".$wpdb->prefix."adrotate_stats_tracker` SET `impressions` = `impressions` + 1 WHERE `id` = '%s';", $stats));
		} else {
			$wpdb->insert($wpdb->prefix."adrotate_stats_tracker", array('ad' => $banner_id, 'group' => $group, 'block' => $block, 'thetime' => $today, 'clicks' => 0, 'impressions' => 1));
		}
		$wpdb->insert($wpdb->prefix."adrotate_tracker", array('ipaddress' => $remote_ip, 'timer' => $now, 'bannerid' => $banner_id, 'stat' => 'i', 'useragent' => ''));
	}

	unset($banner, $schedules);
		
	return $output;
}

function flo_adrotate_ad_output($id, $block, $venue, $tracker) {
	$title = $venue->post_title;
	$image = flo_get_post_thumbnail_src('venue-thumbnail', $venue->ID);

	$meta = base64_encode("$id,$block,$venue->ID");

	$now = time();

	$banner_output = "<a href=\"%link%\"><span class=\"image\"><img src=\"{$image}\" alt=\"{$title} Image\" /></span><span class=\"title\">{$title}</span></a>";
	if($tracker == "Y") {
		$url = site_url('/featured-vendor/' . $meta);
		$banner_output = str_replace('%link%', $url, $banner_output);
	} else {
		$banner_output = str_replace('%link%', get_permalink($venue->ID), $banner_output);
	}

	$banner_output = stripslashes(htmlspecialchars_decode($banner_output, ENT_QUOTES));

	return $banner_output;
}