<?php
define('FLO_USER_REGISTRATION_FORM_ID', 4);
define('FLO_FEATURED_SUBSCRIPTION_ID', 7);
define('FLO_USER_REGISTRATION_FORM_SERVICES_FIELD_ID', 6);

function flo_advertiser_subscription_after_submission($entry, $form) {

	$advertiser = new Flotheme_Advertiser();

	if (!$advertiser->isUserLoaded()) {
		return;
	}

	$advertiser->activate();
	$advertiser->profile()->saveField('flo_upgrade_type', 'upgraded');

	// check Month-to-Month
	if (substr_count($entry[1], 'Month-to-Month')) { 		
		
		// set expiration date 
		$upgrade_until = (int) $advertiser->profile()->field('upgrade_until');
		
		if ( $upgrade_until > time() ) { 
			$expdate = strtotime('+1 month', $upgrade_until);
		} else {
			$expdate = strtotime('+1 month');	
		}
		
		$advertiser->profile()->saveField('flo_upgrade_until', $expdate);
	}
}
add_action('gform_after_submission_3', 'flo_advertiser_subscription_after_submission', 10, 2);


// return $leads array id
function flo_get_leads_by_services($services) {
	global $wpdb;

	$query = "SELECT lead_id FROM " .$wpdb->prefix . "rg_lead_detail 
	WHERE field_number LIKE '6.%' 
	AND value IN ( " . implode(',',$services) . " )
	AND form_id = '" . FLO_USER_REGISTRATION_FORM_ID . "'
	GROUP BY lead_id";

	$leads = $wpdb->get_results($query);

	if (count($leads)) {
		foreach ($leads as $lead) {
			$result[] = RGFormsModel::get_lead($lead->lead_id);
		}
	}

	return $result;
}


// get active featured leads by 'section'
function flo_get_featured_vendors($where='homepage',$count=6) {
	$featured = RGFormsModel::get_leads(FLO_FEATURED_SUBSCRIPTION_ID,0,'DESC',$where);

	// randomizing and extracting leads to show
	shuffle($featured);
	$leads = array_slice($featured,0,$count-1);

	// updating entry_view + 1
	foreach ($leads as $lead) {
		$views = gform_get_meta($lead['id'],'entry_views');
		gform_update_meta($lead['id'], 'entry_views', $views+1);
	}

	return $leads;
}

// get featured leads by 'vendor'
function flo_get_featured_by_vendor($vid) {
	$leads = RGFormsModel::get_leads(FLO_FEATURED_SUBSCRIPTION_ID,0,'DESC',$vid);

	return $leads;
}


// function flo_user_registration_populate_services($value) {
// 	return 'Choice';
// }
//add_filter('gform_field_value_flo_services', 'flo_user_registration_populate_services');


// function flo_user_registration_pre_render_function($form) {


// 	if (FLO_USER_REGISTRATION_FORM_ID != $form['id']) {
// 		return $form;
// 	}

// 	$services = get_terms('service', array(
// 		'hide_empty' => 0,

// 	));

// 	$inputs = array();
// 	$choices = array();
// 	foreach ($form['fields'] as $key => $field) {
// 		if (FLO_USER_REGISTRATION_FORM_SERVICES_FIELD_ID == $field['id']) {

// 			$input_id = 1;
// 			foreach ($services as $service) {
// 				if($input_id % 10) {
// 					$input_id++;
// 				}
// 				$choices[] = array(
// 					'text' => $service->name, 
// 					"value" => $service->term_id,
// 				);
// 				$inputs[] = array(
// 					"label" => $service->name, 
// 					"id" => FLO_USER_REGISTRATION_FORM_SERVICES_FIELD_ID . '.' . $input_id,
// 				);
// 				$input_id++;
// 			}
// 			$form['fields'][$key]['choices'] = $choices;
// 			$form['fields'][$key]['inputs'] = $inputs;
// 		}
// 	}

// 	return $form;
// }
//add_filter("gform_pre_render", "flo_user_registration_pre_render_function");