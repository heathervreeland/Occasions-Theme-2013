<?php
/**
 * Get current theme options
 * 
 * @return array
 */
function flotheme_get_options() {

	$options = array();
		
	$options[] = array("name" => "Theme",
						"type" => "heading");
	
	$options[] = array( "name" => "Copyrights",
						"desc" => "Your copyright message.",
						"id" => "flo_copyrights",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "404 Error Message",
						"desc" => "Your error message.",
						"id" => "flo_error_message",
						"std" => "",
						"type" => "textarea");

	$options[] = array( "name" => "Sidebar",
						"type" => "heading");

	$options[] = array( "name" => "Sidebar Ads Count",
						"desc" => "",
						"id" => "flo_sidebar_ad_count",
						"std" => "10",
						"type" => "text");


	$options[] = array( "name" => "Subscribe Image",
						"desc" => "Dimensions: 300x175",
						"id" => "flo_subscribe_image",
						"std" => "",
						"type" => "upload");

	$options[] = array( "name" => "Subscribe Header",
						"desc" => "",
						"id" => "flo_subscribe_head",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Subscribe Text",
						"desc" => "",
						"id" => "flo_subscribe_text",
						"std" => "",
						"type" => "textarea");
	
	$options[] = array( "name" => "Social",
						"type" => "heading");
	
	$options[] = array( "name" => "Twitter",
						"desc" => "Your twitter username.",
						"id" => "flo_twi",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Pinterest",
						"desc" => "Your Pinterest profile URL.",
						"id" => "flo_pin",
						"std" => "",
						"type" => "text");

	$options[] = array( "name" => "Facebook",
						"desc" => "Your Facebook profile URL.",
						"id" => "flo_fb",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Facebook Application ID",
						"desc" => "If you have Application ID you can connect the blog to your Facebook Profile and monitor statistics there.",
						"id" => "flo_fb_id",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Enable Open Graph",
						"desc" => "The <a href=\"http://www.ogp.me/\">Open Graph</a> protocol enables any web page to become a rich object in a social graph.",
						"id" => "flo_og_enabled",
						"std" => "",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Advanced Settings",
						"type" => "heading");

	$options[] = array( "name" => "Google API Code",
						"desc" => "Please insert your Google API code here.",
						"id" => "flo_google_api",
						"std" => "",
						"type" => "text"); 

	$options[] = array( "name" => "Google Ad Service ID",
						"desc" => "Please insert your Google Ad Service ID here.",
						"id" => "flo_google_ad",
						"std" => "",
						"type" => "text"); 
	
	$options[] = array( "name" => "Google Analytics",
						"desc" => "Please insert your Google Analytics code here. Example: <strong>UA-22231623-1</strong>",
						"id" => "flo_ga",
						"std" => "",
						"type" => "text"); 

	$options[] = array( "name" => "Glam Media AD ID",
						"desc" => "Ad size: 300x250",
						"id" => "flo_glam_ad",
						"std" => "",
						"type" => "text"); 

	return $options;
}

/**
 * Add custom scripts to Options Page
 */
function flotheme_options_custom_scripts() {}

/**
 * Add Metaboxes
 * @param array $meta_boxes
 * @return array 
 */
function flotheme_metaboxes($meta_boxes) {

	$meta_boxes = array(
		array(
			'id'		=> 'venue_upgraded',
			'title'		=> 'Upgrade Type',
			'context'	=> 'side',
			'show_names'=> false,
			'fields'	=> array(
				array(
					'id'   => 'flo_upgrade_type',
					'type' => 'select',
					'options' => array(
						array(
							'name' => 'Simple',
							'value' => 'simple',
						),
						array(
							'name' => 'Upgraded',
							'value' => 'upgraded',
						),
					),
				),
	            array(
	                'name' => 'Upgraded until',
	                'desc' => 'upgraded until',
	                'id'   => 'flo_upgrade_until',
	                'type' => 'text_date_timestamp',
	            ),				
			),
			'pages'		=> array('venue'),
		),
		array(
			'id'		=> 'venue_links',
			'title'		=> 'Links',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_website',
					'type' => 'text',
					'name' => 'Website',
				),
				array(
					'id'   => 'flo_blog',
					'type' => 'text',
					'name' => 'Blog',
				),
			),
			'pages'		=> array('venue'),
		),
		array(
			'id'		=> 'venue_description',
			'title'		=> 'Description',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_short_info',
					'type' => 'textarea_small',
					'name' => 'Short Information',
				),
				array(
					'id'   => 'flo_description',
					'type' => 'wysiwyg',
					'name' => 'Profile Description',
					'desc' => 'Use this area to describe your services or business.',
				),
				array(
					'id'   => 'flo_promo',
					'type' => 'wysiwyg',
					'name' => 'Promotional Offer',
					'desc' => 'Enter an optional promotional offer or incentive you are currently offering. It is helpful for determining the effectiveness of your profile if you ask the client to mention Occasions Magazine when inquiring about your offer.',
				),

				array(
					'id'   => 'flo_video_url',
					'type' => 'text',
					'name' => 'Video URL',
				),
			),
			'pages'		=> array('venue'),
		),
		array(
			'id'		=> 'venue_socials',
			'title'		=> 'Social Services',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_facebook',
					'type' => 'text',
					'name' => 'Facebook',
				),
				array(
					'id'   => 'flo_twitter',
					'type' => 'text',
					'name' => 'Twitter',
				),
				array(
					'id'   => 'flo_tumblr',
					'type' => 'text',
					'name' => 'Tumblr',
				),
				array(
					'id'   => 'flo_vimeo',
					'type' => 'text',
					'name' => 'Vimeo',
				),
				array(
					'id'   => 'flo_youtube',
					'type' => 'text',
					'name' => 'Youtube',
				),
			),
			'pages'		=> array('venue'),
		),
		array(
			'id'		=> 'venue_preview',
			'title'		=> 'Venue Preview Image',
			'context'	=> 'side',
			'priority'	=> 'default',
			'show_names'=> false,
			'fields'	=> array(
				array(
					'id'   => 'flo_preview_image',
					'type' => 'file',
					'desc' => 'Image is used in preview listings',
				),
			),
			'pages'		=> array('venue'),
		),

		array(
			'id'		=> 'venue_contact',
			'title'		=> 'Venue Contact Information',
			'context'	=> 'normal',
			'priority'	=> 'default',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_contact_name',
					'type' => 'text',
					'name' => 'Contact Name',
				),
				array(
					'id'   => 'flo_contact_title',
					'type' => 'text',
					'name' => 'Contact Title',
				),
				array(
					'id'   => 'flo_contact_email',
					'type' => 'text',
					'name' => 'Contact Email',
					'desc' => 'ex. "name@domain.com"',
				),
				array(
					'id'   => 'flo_contact_address_title',
					'type' => 'title',
					'name' => 'Address',
				),
				array(
					'id'   => 'flo_contact_address_show',
					'type' => 'checkbox',
					'name' => 'Show Address in Profile',
					'desc' => 'If checked, the address you specify below will appear in your public profile.',
				),
				array(
					'id'   => 'flo_contact_address',
					'type' => 'text',
					'name' => 'Address',
				),
				array(
					'id'   => 'flo_contact_address_city',
					'type' => 'text',
					'name' => 'City',
				),
				array(
					'id'   => 'flo_contact_address_state',
					'type' => 'text_small',
					'name' => 'State',
				),
				array(
					'id'   => 'flo_contact_address_zip',
					'type' => 'text_small',
					'name' => 'Zip Code',
				),
				array(
					'id'   => 'flo_contact_address_county',
					'type' => 'text',
					'name' => 'County',
				),

				array(
					'id'   => 'flo_contact_address_travel_policy',
					'type' => 'select',
					'name' => 'Travel Policy',
					'options' => flo_travel_policies(),
				),

				array(
					'id'   => 'flo_contact_address_phone1',
					'type' => 'text',
					'name' => 'Phone 1',
				),
				array(
					'id'   => 'flo_contact_address_phone1_type',
					'type' => 'select',
					'name' => 'Phone 1 Type',
					'options' => flo_phone_types(),
				),

				array(
					'id'   => 'flo_contact_address_phone2',
					'type' => 'text',
					'name' => 'Phone 2',
				),
				array(
					'id'   => 'flo_contact_address_phone2_type',
					'type' => 'select',
					'name' => 'Phone 2 Type',
					'options' => flo_phone_types(),
				),

				array(
					'id'   => 'flo_contact_address_phone3',
					'type' => 'text',
					'name' => 'Phone 3',
				),
				array(
					'id'   => 'flo_contact_address_phone3_type',
					'type' => 'select',
					'name' => 'Phone 3 Type',
					'options' => flo_phone_types(),
				),
				array(
					'id'   => 'flo_contact_qr_title',
					'type' => 'title',
					'name' => 'QR code',
				),
				array(
					'id'   => 'flo_contact_qr_content',
					'type' => 'title',
					'name' => flo_qr_codes(),
				),				


			),
			'pages'		=> array('venue'),
		),

		array(
			'id'		=> 'venue_additional',
			'title'		=> 'Additional Information',
			'context'	=> 'normal',
			// 'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_additional_spaces',
					'type' => 'text_small',
					'name' => 'Number of Spaces Available',
					'desc' => 'Enter the number of spaces your venue has available.',
				),
				array(
					'id'   => 'flo_additional_capacity',
					'type' => 'text_small',
					'name' => 'Capacity',
					'desc' => 'Enter the service capacity for your venue(s).',
				),
				array(
					'id'   => 'flo_additional_footage',
					'type' => 'text_small',
					'name' => 'Square Footage',
					'desc' => 'Enter the square footage of your venue(s).',
				),
				array(
					'id'   => 'flo_additional_cathering',
					'type' => 'text',
					'name' => 'Catering Policy',
					'desc' => 'Enter your venue(s) catering policy.',
				),
				array(
					'id'   => 'flo_additional_alcohool',
					'type' => 'checkbox',
					'name' => 'Alcohol Policy',
					'desc' => 'Yes, outside alcohol vendors are permitted.',
				),
				array(
					'id'   => 'flo_additional_accomodations',
					'type' => 'checkbox',
					'name' => 'Onsite Accommodations',
					'desc' => 'Yes, onsite accommodations are available at this venue',
				),
				array(
					'id'   => 'flo_additional_handicap',
					'type' => 'checkbox',
					'name' => 'Handicap Accessible',
					'desc' => 'Yes, this venue is handicap accessible',
				),
				array(
					'id'   => 'flo_additional_accepted_payments',
					'type' => 'multicheck',
					'name' => 'Payment Acceptance',
					'desc' => 'Check all forms of payment you accept for service.',
					'options' => flo_accepted_payments(),
				),
			),
			'pages'		=> array('venue'),
		),


		array(
			'id'		=> 'issue_information',
			'title'		=> 'General Information',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_info',
					'type' => 'textarea_small',
					'name' => 'Issue Information',
				),
				array(
					'id'   => 'flo_region',
					'type' => 'text',
					'name' => 'Issue Region',
				),
				array(
					'id'   => 'flo_premier',
					'type' => 'checkbox',
					'name' => 'Premier Issue',
				),
				array(
					'id'   => 'flo_soldout',
					'type' => 'checkbox',
					'name' => 'Sold Out',
				),
			),
			'pages'		=> array('issue'),
		),
		array(
			'id'		=> 'issue_products',
			'title'		=> 'Products Info',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_single',
					'type' => 'text',
					'name' => 'Single Product ID',
					'desc' => 'You can find your Product ID <a href="' . admin_url('/admin.php?page=cart66-products') .'" target="_blank">here</a>',
				),
				array(
					'id'   => 'flo_box',
					'type' => 'text',
					'name' => 'Box Product ID',
					'desc' => 'You can find your Product ID <a href="' . admin_url('/admin.php?page=cart66-products') .'" target="_blank">here</a>',
				),
			),
			'pages'		=> array('issue'),
		),


		array(
			'id'		=> 'event_information',
			'title'		=> 'General Information',
			'context'	=> 'normal',
			'priority'	=> 'high',
			'show_names'=> true,
			'fields'	=> array(
				array(
					'id'   => 'flo_start_date',
					'type' => 'text_date',
					'name' => 'Start Date',
				),
				array(
					'id'   => 'flo_end_date',
					'type' => 'text_date',
					'name' => 'End Date',
				),
				array(
					'id'   => 'flo_hours',
					'type' => 'text_small',
					'name' => 'Hours',
				),
				array(
					'id'   => 'flo_cost',
					'type' => 'text_small',
					'name' => 'Event Cost',
				),
				array(
					'id'   => 'flo_phone',
					'type' => 'text',
					'name' => 'Phone Number',
				),
				array(
					'id'   => 'flo_event_location',
					'type' => 'text',
					'name' => 'Location',
				),
				array(
					'id'   => 'flo_event_address',
					'type' => 'text',
					'name' => 'Address',
				),
				array(
					'id'   => 'flo_event_address_city',
					'type' => 'text',
					'name' => 'City',
				),
				array(
					'id'   => 'flo_event_address_state',
					'type' => 'text_small',
					'name' => 'State',
				),
				array(
					'id'   => 'flo_event_address_zip',
					'type' => 'text_small',
					'name' => 'Zip Code',
				),
				array(
					'id'   => 'flo_more_url',
					'type' => 'text',
					'name' => 'More Information URL',
				),
				array(
					'id'   => 'flo_description',
					'type' => 'textarea',
					'name' => 'Event Description',
				),
			),
			'pages'		=> array('event'),
		),

		array(
			'id'		=> 'event_user',
			'title'		=> 'Event Creator',
			'context'	=> 'side',
			// 'priority'	=> 'high',
			'show_names'=> false,
			'fields'	=> array(
				array(
					'id'   		=> 'flo_author',
					'type' 		=> 'select',
					'options'	=> flo_metabox_vendors_select(),
				),
			),
			'pages'		=> array('event'),
		),

	);
	
	return $meta_boxes;
}

/**
 * Get image sizes for images
 * 
 * @return array
 */
function flotheme_get_images_sizes() {
	return array(
		'post' => array(
			array(
				'name'		=> 'post-gthumbnail',
				'width'		=> 75,
				'height'	=> 75,
				'crop'		=> true,
			),
			array(
				'name'		=> 'post-thumbnail',
				'width'		=> 200,
				'height'	=> 110,
				'crop'		=> true,
			),
			array(
				'name'		=> 'post-preview',
				'width'		=> 660,
				'height'	=> 400,
				'crop'		=> false,
			),
			array(
				'name'		=> 'post-cover',
				'width'		=> 430,
				'height'	=> 516,
				'crop'		=> true,
			),
			array(
				'name'		=> 'post-cat-cover',
				'width'		=> 430,
				'height'	=> 230,
				'crop'		=> true,
			),
		),

		'venue' => array(
			array(
				'name'		=> 'venue-gthumbnail',
				'width'		=> 75,
				'height'	=> 75,
				'crop'		=> true,
			),
			array(
				'name'		=> 'venue-thumbnail',
				'width'		=> 200,
				'height'	=> 200,
				'crop'		=> true,
			),
			array(
				'name'		=> 'venue-preview',
				'width'		=> 660,
				'height'	=> 9999,
				'crop'		=> false,
			),
		),
		'event' => array(
			array(
				'name'		=> 'event-preview',
				'width'		=> 430,
				'height'	=> 230,
				'crop'		=> false,
			),
		),
		'issue' => array(
			array(
				'name'		=> 'issue-preview',
				'width'		=> 600,
				'height'	=> 9999,
				'crop'		=> false,
			),
		),
	);
}

/**
 * Add post types that are used in the theme 
 * 
 * @return array
 */
function flotheme_get_post_types() {
	return array(
		'venue' => array(
			'config' => array(
				'public' => true,
				'exclude_from_search' => true,
				'menu_position' => 20,
				'has_archive'   => true,
				'supports'=> array(
					'title',
					'page-attributes',
					'thumbnail',
					'comments',
				),
				'capabilities' => array(
					'edit_post' => 'edit_venue',
					'edit_posts' => 'edit_venues',
					'edit_others_posts' => 'edit_others_venues',
					'publish_posts' => 'publish_venues',
					'read_post' => 'read_venues',
					'read_private_posts' => 'read_private_venues',
					'delete_post' => 'delete_venues'
				),
				'show_in_nav_menus'=> true,
				'rewrite' => array('slug' => 'profile'),
			),
			'singular' => 'Advertiser',
			'multiple' => 'Advertisers',
			'columns'	=> array(
				'featured',
			),
		),
		'event' => array(
			'config' => array(
				'public' => true,
				'exclude_from_search' => true,
				'menu_position' => 20,
				'has_archive'   => true,
				'supports'=> array(
					'title',
					'thumbnail',
				),
				'capabilities' => array(
					'edit_post' => 'edit_venue',
					'edit_posts' => 'edit_venues',
					'edit_others_posts' => 'edit_others_venues',
					'publish_posts' => 'publish_venues',
					'read_post' => 'read_venues',
					'read_private_posts' => 'read_private_venues',
					'delete_post' => 'delete_venues'
				),
				'show_in_nav_menus'=> false,
			),
			'singular' => 'Event',
			'multiple' => 'Events',
			'columns'	=> array(),
		),
		'issue' => array(
			'config' => array(
				'public' => true,
				'exclude_from_search' => true,
				'menu_position' => 20,
				'has_archive'   => true,
				'supports'=> array(
					'title',
					'page-attributes',
					'thumbnail',
				),
				'capabilities' => array(
					'edit_post' => 'edit_venue',
					'edit_posts' => 'edit_venues',
					'edit_others_posts' => 'edit_others_venues',
					'publish_posts' => 'publish_venues',
					'read_post' => 'read_venues',
					'read_private_posts' => 'read_private_venues',
					'delete_post' => 'delete_venues'
				),
				'show_in_nav_menus'=> false,
			),
			'singular' => 'Issue',
			'multiple' => 'Issues',
			'columns'	=> array(
				'featured',
			),
		),

		'featured-vendor' => array(
			'config' => array(
				'public' => true,
				'exclude_from_search' => true,
				'menu_position' => 20,
				'has_archive'   => true,
				'show_ui'		=> false,
				'show_in_menu'	=> false,
				'show_in_admin_bar'	=> false,
				'supports'=> array(),
				'show_in_nav_menus'=> false,
			),
		),
	);
}

/**
 * Add taxonomies that are used in theme
 * 
 * @return array
 */
function flotheme_get_taxonomies() {
	return array(
		'service'	=> array(
			'for'		=> array('venue'),
			'config'	=> array(
				'sort'			=> true,
				'hierarchical' 	=> true,
				'args'			=> array('orderby' => 'term_order'),
				'rewrite'		=> array('slug' => 'services', 'with_front' => false, 'hierarchical' => true),
			),
			'singular'	=> 'Service',
			'multiple'	=> 'Services',
		),
		'venue-type' => array(
			'for'		=> array('venue'),
			'config'	=> array(
				'sort'			=> true,
				'hierarchical' 	=> true,
				'args'			=> array('orderby' => 'term_order'),
				'rewrite'		=> array('slug' => 'venues', 'with_front' => false, 'hierarchical' => true),
			),
			'singular'	=> 'Type',
			'multiple'	=> 'Types',
		),

		'region'	=> array(
			'for'		=> array('venue', 'event', 'post'),
			'config'	=> array(
				'sort'			=> true,
				'hierarchical' 	=> true,
				'args'			=> array('orderby' => 'term_order'),
				'rewrite'		=> array('with_front' => false, 'hierarchical' => true),
			),
			'singular'	=> 'Region',
			'multiple'	=> 'Regions',
		),
	);
}

/**
 * Add post formats that are used in theme
 * 
 * @return array
 */
function flotheme_get_post_formats() {
	return array('gallery', 'video');
}

/**
 * Get sidebars list
 * 
 * @return array
 */
function flotheme_get_sidebars() {
	return array(
		'Homepage',
		'Blog',
		'About',
		'General Pages',
		'Subscribe',
		'Advertisers',
		'Upper',
		'Middle',
		'Lower'
	);
}

/**
 * Predefine custom sliders
 * @return array
 */
function flotheme_get_sliders() {
	return array(
		'sneak-peek' => array(
			'title'		=> 'Sneak Peek',
		),
	);
}

/**
 * Post types where metaboxes should show
 * 
 * @return array
 */
function flotheme_get_post_types_with_gallery() {
	return array('post', 'venue');
}

/**
 * Add custom fields for media attachments
 * @return array
 */
function flotheme_media_custom_fields() {
	return array(
		array(
			"label" => 'Credits',
			"type" 	=> "textarea",
			"name"	=> "credits"
		),
	);
}
