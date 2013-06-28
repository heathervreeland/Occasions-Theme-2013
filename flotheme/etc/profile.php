<?php
define('FLO_ADV_SOMETHING_WRONG', 'Something went wrong. Please reload the page and try again.');

class Flotheme_Advertiser
{
	protected $userId = null;

	protected $venueId = null;

	protected $user = null;

	protected $profile = null;

	protected $errors = array();

	public function __construct($userId = null, $register = false) {

		if ($register) {
			return;
		}

		// load logged user
		if (null === $userId) {
			// check if user logged in
			if (is_user_logged_in()) {
				global $current_user;
	      		get_currentuserinfo();
	      		$this->loadUser($current_user->ID);
			}
  		// load user by id
		} else {
			$this->loadUser($userId);
		}
	}

	public function isUserLoaded() {
		return $this->userId ? true : false;
	}

	/**
	 * Load user by ID
	 *
	 * @param  int $userId
	 * @return Flotheme_Advertiser
	 */
	public function loadUser($userId, $loadProfile = true) {
		$this->userId = (int) $userId;

		$this->user = get_userdata($userId);

		$this->venueId = $this->getMeta('venue_id');

		if ($loadProfile) {
			$this->profile = new Flotheme_Advertiser_Profile($this->venueId);
		}

		return $this;
	}

	/**
	 * Get current user
	 * @return mixed
	 */
	public function user() {
		return $this->user;
	}

	/**
	 * Get current user profile (venue)
	 * @return mixed
	 */
	public function profile() {
		return $this->profile;
	}

	/**
	 * After registration hook. Add post & needed meta
	 * @param  object $userObj
	 * @return bool
	 */
	public function afterRegister($userObj) {

		$this->loadUser($userObj->ID, false);

		$venue_id = $this->getMeta('venue_id');
		if ($venue_id) {
			return;
		}

		$post_id = wp_insert_post(array(
			'menu_order' 		=> -1,
			'comment_status' 	=> 'open',
			'ping_status'		=> 'open',
			'post_author'		=> 1,
			'post_content'		=> '',
			'post_excerpt'		=> '',
			'post_title'		=> $userObj->company_name,
			'post_name'			=> $userObj->company_name,
			'post_status'		=> 'draft',
			'post_type'			=> 'venue',
		));

		update_usermeta($userObj->ID, 'venue_id', $post_id);

		add_post_meta($post_id, 'flo_contact_name', $userObj->contact_name);
		add_post_meta($post_id, 'flo_contact_title', $userObj->contact_title);
		add_post_meta($post_id, 'flo_contact_address_phone1', $userObj->contact_phone);
		add_post_meta($post_id, 'flo_contact_address_phone1_type', '');

		add_post_meta($post_id, 'flo_contact_email', $userObj->user_email);

		delete_usermeta($userObj->ID, 'contact_name');
		delete_usermeta($userObj->ID, 'contact_title');
		delete_usermeta($userObj->ID, 'contact_phone');

		$this->loadUser($userObj->ID);

		return true;
	}

	public function getMeta($meta) {
		return get_usermeta($this->userId, $meta);
	}

	public static function url($url) {
		return site_url('advertisers/' . $url);
	}

	public static function isUrl($url) {
		return is_page($url);
	}

	public function saveProfileData($data)
	{
		try {
			$this->clearErrors();

			/**
			 * Filtering POST data
			 */

			$data['flo_profile_name'] = wp_filter_kses($data['flo_profile_name']);
			$data['flo_profile_slug'] = sanitize_title($data['flo_profile_name']);
			$data['flo_profile_category'] = (int) $data['flo_profile_category'];

			foreach ($data['flo_profile_types'] as $key => $value) {
				$data['flo_profile_types'][$key] = (int) $value;
			}

			$data['flo_profile_region'] = (int) $data['flo_profile_region'];
			$city = get_term($data['flo_profile_region'], 'region');
			if ($city) {
				$state = get_term($city->parent, 'region');
				$data['flo_profile_region'] = array(
					$city->term_id,
					$state->term_id,
				);
			}

			foreach(array(
				'flo_description',
				'flo_promo'
			) as $value) {
				$data[$value] = wp_filter_kses($data[$value]);
			}

			foreach(array(
				'flo_contact_address',
				'flo_contact_address_city',
				'flo_contact_address_state',
				'flo_contact_address_zip',
				'flo_contact_address_county',
			) as $value) {
				$data[$value] = wp_filter_nohtml_kses($data[$value]);
			}

			for ($i = 1; $i <=3; $i++) {
				$data['flo_contact_address_phone' . $i] = wp_filter_nohtml_kses($data['flo_contact_address_phone' . $i]);
				$data['flo_contact_address_phone' . $i . '_type'] = wp_filter_nohtml_kses($data['flo_contact_address_phone' . $i . '_type']);
			}

			foreach(array(
				'flo_additional_spaces',
				'flo_additional_capacity',
				'flo_additional_footage',
				'flo_additional_cathering',
			) as $value) {
				$data[$value] = wp_filter_nohtml_kses($data[$value]);
			}

			foreach(array(
				'flo_contact_name',
				'flo_contact_title',
			) as $value) {
				$data[$value] = wp_filter_nohtml_kses($data[$value]);
			}

			$data['flo_contact_email'] = sanitize_email($data['flo_contact_email']);

			foreach(array(
				'flo_facebook',
				'flo_twitter',
				'flo_tumblr',
				'flo_vimeo',
				'flo_youtube',
				'flo_website',
				'flo_blog',
				'flo_video_url',
			) as $value) {
				$data[$value] = sanitize_url($data[$value]);
			}

			$payments = flo_accepted_payments();
			$payments_keys = array_keys($payments);
			foreach ($data['flo_additional_accepted_payments'] as $key => $value) {

				if (in_array($value, $payments_keys)) {
					$data['flo_additional_accepted_payments'][$key] = $payments[$value];
				} else {
					unset($data['flo_additional_accepted_payments'][$key]);
				}
			}

			foreach(array(
				'flo_contact_address_show',
				'flo_additional_alcohool',
				'flo_additional_accomodations',
				'flo_additional_handicap',
			) as $value) {
				$data[$value] = (int) $data[$value];
			}



			/**
			 * Checking POST data
			 * add errors if needed
			 */

			if (!$data['flo_profile_name'] || !$data['flo_profile_slug']) {
				$this->errors['flo_profile_name'] = 'Please provide your company name';
			}

			if (!$data['flo_profile_category']) {
				$this->errors['flo_profile_category'] = 'Please provide service category for your company';
			}

			if (!is_array($data['flo_profile_types']) || !count($data['flo_profile_types'])) {
				$this->errors['flo_profile_services'] = 'Please provide venue types for your company';
			}

			$this->profile()->saveData($data);

			return true;

			if (count($this->errors)) {
				throw new Exception ('Some errors occured');
			}
		} catch (Exception $e) {
			vardump($e);
			return false;
		}
	}

	public function events() {
		$events = get_posts( array(
			'numberposts'		=>	-1,
			'orderby'			=>	'post_date',
			'order'				=>	'DESC',
			'meta_key'			=>	'flo_author',
			'meta_value'		=>	$this->userId,
			'post_type'			=>	'event',
			'post_status'		=>	'any')
		);
		return $events;
	}


	public function getEvent($eid) {
		$event = get_post($eid);

		if ( $this->userId == flo_get_meta('author', true, $event->ID) ) :
			return $event;
		else :
			return false;
		endif;

	}

	public function saveEventData($data)
	{
		try {
			$this->clearErrors();

			/**
			 * Filtering POST data
			 */

			$data['flo_author'] = $this->userId;
			$data['flo_event_title'] = wp_filter_kses($data['flo_event_title']);
			$data['flo_event_slug'] = sanitize_title($data['flo_event_title']);

			foreach(array(
				'flo_description',
				'flo_hours',
				'flo_location',
				'flo_cost'
			) as $value) {
				$data[$value] = wp_filter_kses($data[$value]);
			}

			foreach(array(
				'flo_more_url',
				'flo_start_date',
				'flo_end_date',
				'flo_event_address',
				'flo_event_address_city',
				'flo_event_address_state',
				'flo_event_address_zip',
				'flo_event_address_county',
			) as $value) {
				$data[$value] = wp_filter_nohtml_kses($data[$value]);
			}

			/**
			 * Checking POST data
			 * add errors if needed
			 */


			if (!$data['flo_event_id'] == '') {
				$this->errors['flo_event_title'] = 'Something is wrong here...';
			}

			if ( ( $this->userId != flo_get_meta('author', true, $data['flo_event_id']) ) && $data['flo_event_id'] != 0 ) {
				$this->errors['flo_event_title'] = 'Trying to edit someone else\'s event ?';
			}

			if (!$data['flo_event_title'] || !$data['flo_event_title']) {
				$this->errors['flo_event_title'] = 'Please provide title for your event';
			}

			if (!$data['flo_start_date']) {
				$this->errors['flo_start_date'] = 'Please provide start date for your event';
			}

			if (!$data['flo_end_date']) {
				$this->errors['flo_end_date'] = 'Please provide end date for your event';
			}

			$this->profile()->saveEvent($data);

			return true;

			if (count($this->errors)) {
				throw new Exception ('Some errors occured');
			}
		} catch (Exception $e) {
			vardump($e);
			return false;
		}
	}

	public function removeEvent($data)
	{
		try {
			$this->clearErrors();

			/**
			 * Filtering POST data
			 */

			$data['flo_author'] = $this->userId;
			$data['flo_event_id'] = (int) $_GET['remove'];

			if ( $data['flo_author'] == flo_get_meta('author', true, $data['flo_event_id']) ) {
				wp_update_post(array(
					'ID'			=> $data['flo_event_id'],
					'post_status'	=> 'trash'
				));
			}

			return true;

			if (count($this->errors)) {
				throw new Exception ('Some errors occured');
			}
		} catch (Exception $e) {
			vardump($e);
			return false;
		}
	}

	public function clearErrors() {
		$this->errors = array();

		return $this;
	}

	public function hasErrors() {
		return count($this->errors);
	}

	public function errors() {
		return $this->errors;
	}

	public function activate() {
		$this->profile()->activate();
	}

	public function deactivate() {
		$this->profile()->deactivate();
	}

	public function live() {
		return $this->hasSubscription();
	}

	public function hasSubscription() {
		return $this->profile()->active();
	}
}

class Flotheme_Advertiser_Profile
{
	protected $id = null;

	protected $venue = null;

	protected $types = null;

	protected $service = null;

	protected $city = null;

	protected $state = null;

	public function __construct($id) {

		$this->id = (int) $id;

		$this->venue = get_post($this->id);

		if (null == $this->venue) {
			throw new Exception('No venue found.');
		}
	}

	public function id() {
		return $this->id;
	}

	public function field($field, $single = true, $default = '') {
		$meta =  get_post_meta($this->id, 'flo_' . $field, $single);
		return null === $meta ? $default : $meta;
	}

	public function saveField($field, $data, $prevValue = '') {
		update_post_meta($this->id, $field, $data, $prevValue);
		return $this;
	}

	public function saveEventField($eid, $field, $data, $prevValue = '') {
		update_post_meta($eid, $field, $data, $prevValue);

		return $this;
	}

	public function saveMultipleField($field, $data) {
		delete_post_meta($this->id, $field);
		if (is_array($data) && count($data)) {
			foreach ($data as $value) {
				add_post_meta($this->id, $field, $value);
			}
		}

		return $this;
	}

	public function name() {
		return $this->venue->post_title;
	}

	public function service() {
		if (null === $this->service) {
			$terms = wp_get_post_terms($this->id, 'service', array("fields" => "all"));
			if (count($terms)) {
				$this->service = $terms[0];
			}
		}

		return $this->service;
	}

	public function types() {
		if (null === $this->types) {
			$terms = wp_get_post_terms($this->id, 'venue-type', array("fields" => "all"));
			if (count($terms)) {
				$this->types = $terms;
			}
		}

		return $this->types;
	}

	public function state() {
		if (null == $this->state) {
			foreach (wp_get_post_terms($this->id, 'region') as $region) {
				if (!$region->parent) {
					$this->city = $region;
					break;
				}
			}
		}
	}

	public function city() {
		if (null == $this->city) {
			foreach (wp_get_post_terms($this->id, 'region') as $region) {
				if ($region->parent) {
					$this->city = $region;
					break;
				}
			}
		}
		return $this->city;
	}

	public function paymentTypes() {
		$types = get_post_meta($this->id, 'flo_additional_accepted_payments', false);
		return is_array($types) ? $types : array();
	}


	public function saveData($data) {

		wp_update_post(array(
			'ID'			=> $this->id,
			'post_title'	=> $data['flo_profile_name'],
			'post_name'		=> $data['flo_profile_slug'],
		));

		wp_set_post_terms($this->id, $data['flo_profile_category'], 'service');
		wp_set_post_terms($this->id, $data['flo_profile_types'], 'venue-type');
		wp_set_post_terms($this->id, $data['flo_profile_region'], 'region');

		$this->saveField('flo_short_info', $data['flo_short_info'])
			->saveField('flo_description', $data['flo_description'])
			->saveField('flo_promo', $data['flo_promo'])
			->saveField('flo_facebook', $data['flo_facebook'])
			->saveField('flo_video_url', $data['flo_video_url'])
			->saveField('flo_twitter', $data['flo_twitter'])
			->saveField('flo_tumblr', $data['flo_tumblr'])
			->saveField('flo_vimeo', $data['flo_vimeo'])
			->saveField('flo_youtube', $data['flo_youtube'])
			->saveField('flo_contact_name', $data['flo_contact_name'])
			->saveField('flo_contact_title', $data['flo_contact_title'])
			->saveField('flo_contact_email', $data['flo_contact_email'])
			->saveField('flo_website', $data['flo_website'])
			->saveField('flo_blog', $data['flo_blog'])
			->saveMultipleField('flo_additional_accepted_payments', $data['flo_additional_accepted_payments'])

			->saveField('flo_contact_address', $data['flo_contact_address'])
			->saveField('flo_contact_address_city', $data['flo_contact_address_city'])
			->saveField('flo_contact_address_state', $data['flo_contact_address_state'])
			->saveField('flo_contact_address_zip', $data['flo_contact_address_zip'])
			->saveField('flo_contact_address_county', $data['flo_contact_address_county'])

			->saveField('flo_contact_address_phone1', $data['flo_contact_address_phone1'])
			->saveField('flo_contact_address_phone1_type', $data['flo_contact_address_phone1_type'])
			->saveField('flo_contact_address_phone2', $data['flo_contact_address_phone2'])
			->saveField('flo_contact_address_phone2_type', $data['flo_contact_address_phone2_type'])
			->saveField('flo_contact_address_phone3', $data['flo_contact_address_phone3'])
			->saveField('flo_contact_address_phone3_type', $data['flo_contact_address_phone3_type'])

			->saveField('flo_additional_spaces', $data['flo_additional_spaces'])
			->saveField('flo_additional_capacity', $data['flo_additional_capacity'])
			->saveField('flo_additional_footage', $data['flo_additional_footage'])
			->saveField('flo_additional_cathering', $data['flo_additional_cathering'])

			->saveField('flo_contact_address_show', $data['flo_contact_address_show'])
			->saveField('flo_additional_alcohool', $data['flo_additional_alcohool'])
			->saveField('flo_additional_accomodations', $data['flo_additional_accomodations'])
			->saveField('flo_additional_handicap', $data['flo_additional_handicap']);

		$lat = $lng = '';
		if ($data['flo_contact_address'] && $data['flo_contact_address_city']) {
			$apiKey = flo_get_option('google_api');

			$q = $data['flo_contact_address'] . ', ' . $data['flo_contact_address_city'];
			if ($data['flo_contact_address_state']) {
				$q .= ', ' . $data['flo_contact_address_state'];
			}
			if ($data['flo_contact_address_zip']) {
				$q .= ', ' . $data['flo_contact_address_zip'];
			}
			if ($data['flo_contact_address_county']) {
				$q .= ', ' . $data['flo_contact_address_county'];
			}
			$q = urlencode($q);

			$url = 'http://maps.google.com/maps/geo?q=' . $q . '&key=' . $apiKey . '&output=csv';

			$response = wp_remote_get($url);

			list($status, $point, $lat, $lng) = explode(',', $response['body']);

			if ($status != '200') {
				$lng = $lat = '';
			}
		}

		if (!$lat || !$lng) {
			$lat = $lng = '';
		}

		$this->saveField('flo_geolat', $lat)
			->saveField('flo_geolng', $lng);

		return $this;
	}

	public function saveEvent($data) {
		$eid = $data['flo_event_id'];

		if ($eid == 0) {
			$eid = wp_insert_post(array(
				'post_type' => 'event',
				'post_status' => 'pending',
				'post_title' => $data['flo_event_title'],
				'post_name' => $data['flo_event_slug']
			));

			$this->saveEventField($eid, 'flo_author', $data['flo_author']);
		} else {
			wp_update_post(array(
				'ID'			=> $eid,
				'post_title'	=> $data['flo_event_title'],
				'post_name'		=> $data['flo_event_slug'],
				'post_status'	=> 'pending'
			));

		}

		$this->saveEventField($eid, 'flo_description', $data['flo_description'])
			->saveEventField($eid, 'flo_start_date', $data['flo_start_date'])
			->saveEventField($eid, 'flo_end_date', $data['flo_end_date'])
			->saveEventField($eid, 'flo_hours', $data['flo_hours'])

			->saveEventField($eid, 'flo_event_address', $data['flo_event_address'])
			->saveEventField($eid, 'flo_event_address_city', $data['flo_event_address_city'])
			->saveEventField($eid, 'flo_event_address_state', $data['flo_event_address_state'])
			->saveEventField($eid, 'flo_event_address_zip', $data['flo_event_address_zip'])

			->saveEventField($eid, 'flo_location', $data['flo_location'])
			->saveEventField($eid, 'flo_contact_email', $data['flo_contact_email'])
			->saveEventField($eid, 'flo_cost', $data['flo_cost'])
			->saveEventField($eid, 'flo_more_url', $data['flo_more_url']);

		return $this;
	}

	public function deleteImage($imageId) {
		$imageId = (int) $imageId;
		$image = get_post($imageId);
		if (!$image) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}
		if ($image->post_parent != $this->id) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		wp_delete_post($image->ID, true);

		return true;
	}

	public function setMainImage($imageId) {
		$imageId = (int) $imageId;
		$image = get_post($imageId);
		if (!$image) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}
		if ($image->post_parent != $this->id) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		set_post_thumbnail($this->id, $image->ID);

		return true;
	}

	public function activate() {
		wp_update_post(array(
			'ID' 			=> $this->id,
			'post_status'		=> 'publish',
		));
		return $this;
	}

	public function deactivate() {
		wp_update_post(array(
			'ID' 			=> $this->id,
			'post_status'		=> 'draft',
		));
		return $this;
	}

	public function active() {
		return $this->venue->post_status == 'publish';
	}
}

function flo_check_advertiser_logged_in() {

	if (!is_user_logged_in()) {
		return false;
	}

	$user = wp_get_current_user();

	if (user_can($user, 'advertiser') && !user_can($user, 'administrator')) {
		return true;
	}

	return false;
}

function flo_advertiser_logged_in() {
	if (!flo_check_advertiser_logged_in()) {
		wp_redirect(Flotheme_Advertiser::url('login'));
		exit;
	} else {
		return true;
	}
}

function flo_advertiser_load_uploader() {
	if (!is_page('business-profile')) {
		return;
	}

    wp_enqueue_script('browserplus');
    wp_enqueue_script('flo_plupload');
    wp_enqueue_script('flo_plupload_queue');
    wp_enqueue_style('flo_plupload');
}
add_action('wp_enqueue_scripts', 'flo_advertiser_load_uploader');


function flo_advertiser_delete_image() {
	$advertiser = new Flotheme_Advertiser();

	try {
		if (!$advertiser->isUserLoaded()) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		$id = (int) $_REQUEST['id'];

		$success = $advertiser->profile()->deleteImage($id);

		if (!$success) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		$data = array(
			'error'	=> 0,
			'msg'	=> 'Image deleted successfully',
		);


	} catch (Exception $e) {
		$data = array(
			'error' => '1',
			'msg' => $e->getMessage(),
		);
	}
	echo json_encode($data);exit;
}
add_action('wp_ajax_flo_adv_delete_image', 'flo_advertiser_delete_image');
add_action('wp_ajax_nopriv_flo_adv_delete_image', 'flo_advertiser_delete_image');



function flo_advertiser_set_main_image() {
	$advertiser = new Flotheme_Advertiser();

	try {
		if (!$advertiser->isUserLoaded()) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		$id = (int) $_REQUEST['id'];

		$success = $advertiser->profile()->setMainImage($id);

		if (!$success) {
			throw new Exception(FLO_ADV_SOMETHING_WRONG);
		}

		$data = array(
			'error'	=> 0,
			'msg'	=> 'Image deleted successfully',
		);

	} catch (Exception $e) {
		$data = array(
			'error' => '1',
			'msg' => $e->getMessage(),
		);
	}
	echo json_encode($data);exit;
}
add_action('wp_ajax_flo_adv_set_main_image', 'flo_advertiser_set_main_image');
add_action('wp_ajax_nopriv_flo_adv_set_main_image', 'flo_advertiser_set_main_image');


function flo_user_meta_after_user_register($userObj) {
	$profile = new Flotheme_Advertiser(null, true);
	$profile->afterRegister($userObj);
}
add_action('user_meta_after_user_register', 'flo_user_meta_after_user_register', 999);
