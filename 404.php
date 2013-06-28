<?php get_header(); ?>
	<div id="main">
		<div id="page404">
			<header class="page-title">
				<h2>404<span>&nbsp;&nbsp;|&nbsp;&nbsp;Page not found</span></h2>
			</header>
			<?php echo apply_filters('the_content', flo_get_option('error_message')) ?>
			<p>&nbsp;</p>
			<p><a href="<?php echo home_url(); ?>" title="Back to Homepage" class="btn">back to HOMEPAGE</a></p>
			<?php
				// global $wp_query;
				// global $wp_pod_tbl_vendors, $wp_pod_tbl_vendor_profiles, $wp_pod_tbl_vendor_imagesv2;

				// function saveField($vid, $field, $data, $prevValue = '') {
				// 	//var_dump($vid,$field,$data);
				// 	update_post_meta($vid, $field, $data, $prevValue);
				// }

				// function search($array, $key, $value)
				// {
				//     $results = array();

				//     if (is_array($array))
				//     {
				//         if (isset($array[$key]) && $array[$key] == $value)
				//             $results[] = $array;

				//         foreach ($array as $subarray)
				//             $results = array_merge($results, search($subarray, $key, $value));
				//     }

				//     return $results;
				// }

				// include(TEMPLATEPATH . '/image_sideload.php');


				// if ($_REQUEST['import'] == 'true') {
				// 	// import_vendor_profile_description();
				// 	// import_vendor_comments(); int(1045) int(1046) int(1047) int(1048) int(1049) int(1050) int(1051) int(1052) int(1053) int(1054) int(1055) int(1056) int(1057) int(1058) int(1059) int(1060) int(1061) int(1062) int(1063) int(1064) int(1065) int(1066) int(1067) int(1068) int(1069) int(1070) int(1071) int(1072) int(1073) int(1074) int(1075) int(1076) int(1077) int(1078) int(1079) int(1080) int(1081) int(1082) int(1083) int(1084) int(1085) int(1086) int(1087) int(1088) int(1089) int(1090) int(1091) int(1092) int(1093) int(1094) int(1095) int(1096) int(1097) int(1098) int(1099) int(1100) int(1101) int(1102) int(1103) int(1104) int(1105) int(1106) int(1107) int(1108) int(1109) int(1110) int(1111) int(1112) int(1113) int(1114) int(1115) int(1116) int(1117) int(1118) int(1119) int(1120) int(1121) int(1122) int(1123) int(1124) int(1125) int(1126) int(1127) int(1128) int(1129) int(1130) int(1131) int(1132) int(1133) int(1134) int(1135) int(1136) int(1137) int(1138) int(1139) int(1140) int(1141) int(1142) int(1143) int(1144) int(1145) int(1146) int(1147) int(1148) int(1149) int(1150) int(1151) int(1152) int(1153) int(1154) int(1155) int(1156) int(1157)
				// 	// import_vendor_images();
				// 	// import_vendor_main_image();
				// 	// import_vendors();
				// 	// import_vendor_profiles();
				// }

				// function import_vendor_comments() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_comments.php';
				// 	include($path);
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendors.php';
				// 	include($path);
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendor_profiles.php';
				// 	include($path);

				// 	set_time_limit(0);
				// 	$i=0;
				// 	foreach($wp_pod_tbl_comments as $key => $comment) {
				// 		//$comment = $wp_pod_tbl_comments[81];
				// 		// var_dump($comment);

				// 		if (!is_null($comment['ao2_companyguid']) && !empty($comment['ao2_companyguid']) ) {
				// 			$key = search($wp_pod_tbl_vendors, 'ao2_guid', $comment['ao2_companyguid']);
				// 			$vendor = $key[0]; //$wp_pod_tbl_vendors[$key];
				// 		} elseif(!is_null($comment['vendor']) && !empty($comment['vendor'])) {
				// 			$profile = search($wp_pod_tbl_vendor_profiles, 'id', $comment['vendor']);
				// 			$key = search($wp_pod_tbl_vendors, 'name', $profile[0]['name']);
				// 			$vendor = $key[0];
				// 		}
				// 			//var_dump($comment['vendor'],$comment['ao2_companyguid']);
				// 			//$vendor_profile = search($wp_pod_tbl_vendor_profiles, 'id', $comment['vendor']);
				// 			//var_dump($comment['vendor'],$vendor,$vendor_profile[0]);
				// 		if ($vendor) {
				// 			$user = get_user_by('login',$vendor['user_name']);

				// 			$venue = false;
				// 			$venue_id = get_user_meta($user->ID,'venue_id');
				// 			if ($venue_id) $venue = get_post($venue_id[0]);

				// 			//var_dump($venue);

				// 			if ($venue) {
				// 				//echo "<BR>";
				// 				//var_dump($user->ID,$comment['ao2_companyguid'],$comment['vendor']);
				// 				$i++;

				// 				$review_args = array(
				// 				    'comment_post_ID' => $venue->ID,
				// 				    'comment_author' => $comment['name'],
				// 				    'comment_author_email' => $comment['email'],
				// 				    'comment_content' => $comment['comment'],
				// 				    'comment_date' => $comment['comment_date'],
				// 				    'comment_approved' => 1,
				// 				    'rating' => round($comment['rating'])
				// 				    // 'comment_author_url' => 'http://',
				// 				    // 'comment_type' => '',
				// 				    // 'comment_parent' => 0,
				// 				    // 'user_id' => 1,
				// 				    // 'comment_author_IP' => $comment->comment_date,
				// 				    // 'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				// 				);

				// 				// var_dump($review_args);

				// 				$review_id = wp_insert_comment($review_args);
				// 				add_comment_meta($review_id, 'rating', round($comment['rating']));

				// 				var_dump($review_id);
				// 			}
				// 		}

				// 	}

				// 	echo "<br/>Total records: ".count($wp_pod_tbl_comments)." imported: ".$i;
				// }

				// function import_vendor_main_image() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendor_profiles.php';
				// 	include($path);

				// 	set_time_limit(0);

				// 	$i=0;
				// 	foreach ($wp_pod_tbl_vendor_profiles as $index => $profile) {
				// 		// $profile = $wp_pod_tbl_vendor_profiles[0];
				// 		// if ($i == 10) exit;

				// 		// get venue
				// 		$args = array(
				// 			'post_type'  => 'venue',
				// 			'meta_key'   => 'flo_olduser',
				// 			'meta_value' => $profile['vendor']
				// 		);
				// 		$venue = get_posts($args);
				// 		$venue = $venue[0];


				// 		// check image
				// 		if ($profile['v2_profile_image_lg'] != '') {
				// 			if (!get_the_post_thumbnail($venue->ID)) {

				// 				$filename = 'http://occasionsonline.com'.$profile['v2_profile_image_lg'];

				// 				// upload image as attach to $venue->ID
				// 				$sideload = media_sideload_image($filename, $venue->ID);

				// 				// get last attached image
				// 				$imgs = flo_get_attached_images($venue->ID);
				// 				$last_image = end($imgs);

				// 				var_dump($last_image->ID, $venue->ID);

				// 				// set as post thumbnail
				// 		  	  	set_post_thumbnail($venue->ID,$last_image->ID);
				// 		  	  	$i++;
				// 			}
				// 		}

				// 	}
				// 	echo "<BR>".$i." images set";

				// 	//var_dump($wp_pod_tbl_vendor_profiles[0]);
				// }


				// function import_vendor_images() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendor_imagesv2.php';
				// 	include($path);
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendors.php';
				// 	include($path);

				// 	set_time_limit(0);

				// 	$i=0;
				// 	foreach ($wp_pod_tbl_vendor_imagesv2 as $index => $image) {
				// 		// $image = $wp_pod_tbl_vendor_imagesv2[159];
				// 		// if ($i == 20) exit;
				// 		$key = search($wp_pod_tbl_vendors, 'ao2_guid', $image['ao2_companyid']);
				// 		$vendor = $key[0]; //$wp_pod_tbl_vendors[$key];

				// 		$user = get_user_by('login',$vendor['user_name']);

				// 		$venue = get_user_meta($user->ID,'venue_id');
				// 		$venue = get_post($venue[0]);

				// 		//var_dump($vendor);

				// 		if ($venue) {

				// 			$filename = 'http://occasionsonline.com'.$image['filename'];

				// 			$sideload = media_sideload_image($filename, $venue->ID);

				// 			var_dump($sideload);

				// 			$i++;
				// 		}
				// 		//print_r($venue,false);
				// 		//$wp_pod_tbl_vendor_imagesv2[180];

				// 	}
				// }

				// function import_vendors() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendors.php';
				// 	include($path);

				// 	foreach ($wp_pod_tbl_vendors as $data) {
				// 		//$data = $wp_pod_tbl_vendors[0];

				// 		$userdata = array(
				// 			'user_login' 	=> $data['user_name'],
				// 			'user_nicename' => $data['admin_contact'],
				// 			'user_email'	=> $data['admin_email'],
				// 			'description'	=> $data['admin_title'].' : '.$data['name'],
				// 		);

				// 		//var_dump($userdata);

				// 		$uid = wp_insert_user($userdata);

				// 		$args = array(
				// 			'post_type'  => 'venue',
				// 			'meta_key'   => 'flo_olduser',
				// 			'meta_value' => $data['id']
				// 		);

				// 		$venue = get_posts($args);

				// 		add_user_meta($uid, 'venue_id', $venue[0]->ID);

				// 		var_dump($uid);
				// 	}

				// }

				// function import_vendor_profile_description() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendor_profiles.php';
				// 	include($path);

				// 	foreach ($wp_pod_tbl_vendor_profiles as $data) {
				// 		// $data = $wp_pod_tbl_vendor_profiles[51];
				// 		// get venue
				// 		$args = array(
				// 			'post_type'  => 'venue',
				// 			'meta_key'   => 'flo_olduser',
				// 			'meta_value' => $data['vendor']
				// 		);
				// 		$venue = get_posts($args);
				// 		$venue = $venue[0];
				// 		$current_description = get_post_meta($venue->ID, 'flo_description', true);

				// 		var_dump(wpautop(strip_tags(htmlspecialchars_decode($current_description))),htmlspecialchars_decode($data['description']));

				// 		//$vid = wp_insert_post($args);
				// 		//$vid = 5;

				// 		// saveField($vid, 'flo_oldid', $data['id']);
				// 		// saveField($vid, 'flo_olduser', $data['vendor']);
				// 		// saveField($vid, 'flo_description', $data['description']);

				// 		//var_dump($args);

				// 		// var_dump($vid);
				// 	}
				// }


				// function import_vendor_profiles() {
				// 	$path = TEMPLATEPATH . '/wp_pod_tbl_vendor_profiles1.php';
				// 	include($path);

				// 	foreach ($wp_pod_tbl_vendor_profiles as $data) {
				// 		//var_dump($wp_pod_tbl_vendor_profiles[0]);
				// 		//$data = $wp_pod_tbl_vendor_profiles[0];

				// 		$args = array(
				// 		  'post_author'		=> 1,
				// 		  'post_type'		=> 'venue',
				// 		  'post_title'		=> $data['name'],
				// 		  'post_name'		=> $data['slug'],
				// 		  'post_status'		=> 'publish'
				// 		);

				// 		$vid = wp_insert_post($args);

				// 		//$vid = 5;

				// 		//saveField($vid, 'flo_short_info', $data['flo_short_info']);
				// 		//saveField($vid, 'flo_promo', $data['flo_promo']);
				// 		saveField($vid, 'flo_oldid', $data['id']);
				// 		saveField($vid, 'flo_olduser', $data['vendor']);
				// 		saveField($vid, 'flo_description', $data['description']);
				// 		saveField($vid, 'flo_facebook', $data['facebook_url']);
				// 		saveField($vid, 'flo_twitter', $data['twitter_url']);
				// 		saveField($vid, 'flo_linkedin', $data['linkedin_url']);
				// 		saveField($vid, 'flo_contact_name', $data['contact_name']);
				// 		saveField($vid, 'flo_contact_title', $data['contact_title']);
				// 		saveField($vid, 'flo_contact_email', $data['contact_email']);
				// 		saveField($vid, 'flo_website', $data['web_url']);
				// 		saveField($vid, 'flo_blog', $data['blog_url']);
				// 		saveField($vid, 'flo_contact_address', $data['address']);
				// 		saveField($vid, 'flo_contact_address_city', $data['city']);
				// 		saveField($vid, 'flo_contact_address_state', $data['state']);
				// 		saveField($vid, 'flo_contact_address_zip', $data['zipcode']);
				// 		saveField($vid, 'flo_contact_address_county', $data['county']);
				// 		saveField($vid, 'flo_contact_address_phone1', $data['contact_phone1']);
				// 		saveField($vid, 'flo_contact_address_phone1_type', $data['contact_phone1_type']);
				// 		saveField($vid, 'flo_contact_address_phone2', $data['contact_phone2']);
				// 		saveField($vid, 'flo_contact_address_phone2_type', $data['contact_phone2_type']);
				// 		saveField($vid, 'flo_contact_address_phone3', $data['contact_phone3']);
				// 		saveField($vid, 'flo_contact_address_phone3_type', $data['contact_phone3_type']);
				// 		saveField($vid, 'flo_additional_spaces', $data['spaces_available']);
				// 		saveField($vid, 'flo_additional_capacity', $data['capacity']);
				// 		saveField($vid, 'flo_additional_cathering', $data['catering']);
				// 		saveField($vid, 'flo_additional_footage', $data['square_footage']);

				// 		if ($data['show_address']) saveField($vid, 'flo_contact_address_show', 'on');
				// 		if ($data['alcohol_permitted']) saveField($vid, 'flo_additional_alcohool', 'on');
				// 		if ($data['onsite_accomodations']) saveField($vid, 'flo_additional_accomodations', 'on');
				// 		if ($data['show_address']) saveField($vid, 'flo_additional_handicap', 'on');

				// 		saveField($vid, 'flo_geolat', $data['latitude']);
				// 		saveField($vid, 'flo_geolng', $data['longitude']);

				// 		delete_post_meta($vid, 'flo_additional_accepted_payments');

				// 		if ($data['accepts_visa'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Visa');
				// 		if ($data['accepts_paypal'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Paypal');
				// 		if ($data['accepts_checks'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Checks');
				// 		if ($data['accepts_amex'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Amex');
				// 		if ($data['accepts_mc'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Mastercard');
				// 		if ($data['accepts_discover'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Discover');
				// 		if ($data['accepts_bank'] == 1) add_post_meta($vid, 'flo_additional_accepted_payments', 'Bank Drafts');
				// 		//var_dump($args);
				// 		var_dump($vid);
				// 	}
				// }
			?>
		</div>
	</div>
<?php get_footer(); ?>