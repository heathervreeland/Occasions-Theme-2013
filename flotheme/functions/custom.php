<?php
function give_user_edit() {
	if(current_user_can('manage_options')) {
		$role = get_role('administrator');
		$role->add_cap("edit_venue");
		$role->add_cap("edit_venues");
		$role->add_cap("edit_others_venues");
		$role->add_cap("publish_venues");
		$role->add_cap("read_venues");
		$role->add_cap("read_private_venues");
		$role->add_cap("delete_venues");
	}
}
add_action('admin_init', 'give_user_edit', 10, 0);

function flo_no_user_dashboard() {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}
	if (!current_user_can('edit_posts')) {
		if (current_user_can('advertiser')) {
			wp_redirect(site_url('advertisers/dashboard'));
		} else {
			wp_redirect(home_url());
		}
		exit;
	}
}
add_action('admin_init', 'flo_no_user_dashboard');

function flo_deregister_scripts() {
	wp_dequeue_style('cart66-css');
}
add_action('wp_enqueue_scripts', 'flo_deregister_scripts', 1000);

function flo_hide_admin_bar($content) {
	return (current_user_can('administrator')) ? $content : false;
}
add_filter( 'show_admin_bar' , 'flo_hide_admin_bar');

function flo_custom_posts_per_page($query)
{
	if (isset($query->query_vars['ignore_filter_changes']) && $query->query_vars['ignore_filter_changes']) {
		return;
	}
	if (isset($query->query_vars['service']) && $query->query_vars['service']) {
		$query->set('post_type', 'venue');
	}

	if (isset($query->query_vars['venue-type']) && $query->query_vars['venue-type']) {
		$query->set('post_type', 'venue');

		$query->set('service', 'venues');


		// // search only for venues
		// $query->tax_query->queries[] = array(
		// 	'taxonomy' 			=> 'service',
		// 	'terms'	   			=> array('venues'),
		// 	'include_children'	=> 1,
		// 	'field'				=> 'slug',
		// 	'operator'			=> 'IN',
		// );
	}

	if (isset($query->query_vars['region']) && $query->query_vars['region']) {
		if (!in_array($query->query_vars['post_type'], array('venue', 'event'))) {
			$query->set('post_type', 'venue');
		}
	}

	if (isset($query->query_vars['post_type'])) {
	    switch ($query->query_vars['post_type']) {
	        case 'event':
	        	if (!$query->query_vars['posts_per_page']) {
	        		$query->query_vars['posts_per_page'] = 3;
	        	}
	            break;
	        case 'venue':
	        	if (!$query->query_vars['posts_per_page']) {
	        		$query->query_vars['posts_per_page'] = 20;
	        	}
	            break;
	        default:
	            break;
	    }
	}

    return $query;
}
if(!is_admin()) {
    add_filter('pre_get_posts', 'flo_custom_posts_per_page');
}

function flo_query_post_types($query) {
	if (isset($query->query_vars['norewrite'])) {
		return;
	}
	if ($query->is_tax('region') || $query->is_tax('service') || $query->is_tax('venue-type')) {
		if (!in_array($query->query_vars['post_type'], array('venue', 'event'))) {
			$query->set('post_type', array('venue'));
		}
	}
	return $query;
}
add_filter('pre_get_posts', 'flo_query_post_types');

function flo_add_rewrite_rules() {
	global $wp_rewrite;
//vardump($wp_rewrite->preg_index(2)); 
	$new_rules = array(
		'(florida|georgia)/?$' 					=> 'index.php?post_type=post&region=' . $wp_rewrite->preg_index(1) . '&paged=' . $wp_rewrite->preg_index(2),
	
	/* custom services override */
	
		'(florida|georgia)/(bands-and-musicians|cakes|caterers|ceremony|djs|dresses|favors|flowers-and-decor|hair-makeup|hotels|invitations|lighting|photobooth|photographers|planners|registries|rehearsal|rentals|resources|rings|tuxedos|videographers)/?$' 					=> 'index.php?post_type=service&region=' . $wp_rewrite->preg_index(1) . '&service=' . $wp_rewrite->preg_index(2),
		'(florida|georgia)/(bands-and-musicians|cakes|caterers|ceremony|djs|dresses|favors|flowers-and-decor|hair-makeup|hotels|invitations|lighting|photobooth|photographers|planners|registries|rehearsal|rentals|resources|rings|tuxedos|videographers)/page/([0-9]{1,})/?$' 	=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&service=' . $wp_rewrite->preg_index(2) . '&paged=' . $wp_rewrite->preg_index(4),
	
		'(florida|georgia)/([\w\d\-]+)/(bands-and-musicians|cakes|caterers|ceremony|djs|dresses|favors|flowers-and-decor|hair-makeup|hotels|invitations|lighting|photobooth|photographers|planners|registries|rehearsal|rentals|resources|rings|tuxedos|videographers)/?$' 					=> 'index.php?post_type=service&region=' . $wp_rewrite->preg_index(2) . '&service=' . $wp_rewrite->preg_index(3),
		'(florida|georgia)/([\w\d\-]+)/(bands-and-musicians|cakes|caterers|ceremony|djs|dresses|favors|flowers-and-decor|hair-makeup|hotels|invitations|lighting|photobooth|photographers|planners|registries|rehearsal|rentals|resources|rings|tuxedos|videographers)/page/([0-9]{1,})/?$' 	=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&service=' . $wp_rewrite->preg_index(3) . '&paged=' . $wp_rewrite->preg_index(5),

	
	'(florida|georgia)/([\w\d\-]+)/?$' 					=> 'index.php?post_type=post&region=' . $wp_rewrite->preg_index(2) . '&paged=' . $wp_rewrite->preg_index(3),
		
			
	/* must move venues into the servies category */
		'(florida|georgia)/([\w\d\-]+)-weddings/([\w\d\-]+)/?$' 					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&service=' . $wp_rewrite->preg_index(3),
		
	/* end custom services override */
	
    //'local/([\w\d\-]+)/([\w\d\-]+)/services/?$'=>'index.php?post_type=venue&term-name=service&region=' . $wp_rewrite->preg_index(2), //dded by jhaun@handbrewed.com - 9/30/2013
		'(florida|georgia)/venues/([\w\d\-]+)/?$' 					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&service=' . $wp_rewrite->preg_index(2),
		'(florida|georgia)/venues/([\w\d\-]+)/page/([0-9]{1,})/?$' 	=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&service=' . $wp_rewrite->preg_index(2) . '&paged=' . $wp_rewrite->preg_index(4),

    //'local/([\w\d\-]+)/services/?$'=>'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1), //dded by jhaun@handbrewed.com - 9/30/2013

		'services/([\w\d\-]+)/?$' 								=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(0) . '&service=' . $wp_rewrite->preg_index(1),
		'services/([\w\d\-]+)/page/([0-9]{1,})/?$' 				=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(0) . '&service=' . $wp_rewrite->preg_index(1) . '&paged=' . $wp_rewrite->preg_index(2),

    //'local/([\w\d\-]+)/([\w\d\-]+)/venues/?$'=>'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2), //dded by jhaun@handbrewed.com - 9/30/2013
		'(florida|georgia)/venues/([\w\d\-]+)/?$'   					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&venue-type=' . $wp_rewrite->preg_index(2),
		'(florida|georgia)/venues/([\w\d\-]+)/page/([0-9]{1,})/?$' 		=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&venue-type=' . $wp_rewrite->preg_index(2) . '&paged=' . $wp_rewrite->preg_index(3),


		'(florida|georgia)/([\w\d\-]+)/venues/([\w\d\-]+)/?$'   					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&venue-type=' . $wp_rewrite->preg_index(3),
		'(florida|georgia)/([\w\d\-]+)/venues/([\w\d\-]+)/page/([0-9]{1,})/?$' 		=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&venue-type=' . $wp_rewrite->preg_index(3) . '&paged=' . $wp_rewrite->preg_index(4),

		'(florida|georgia)/([\w\d\-]+)/services/([\w\d\-]+)/?$'   					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&&service=' . $wp_rewrite->preg_index(3),
		'(florida|georgia)/([\w\d\-]+)/services/([\w\d\-]+)/page/([0-9]{1,})/?$' 		=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(2) . '&&service=' . $wp_rewrite->preg_index(3) . '&paged=' . $wp_rewrite->preg_index(4),

    //'local/([\w\d\-]+)/venues/?$'=>'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1), //this line and next one added by jhaun@handbrewed.com - 9/30/2013
    // '(florida|georgia)/venues/page/([0-9]{1,})/?$'          => 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&venue-type=' . '&paged=' . $wp_rewrite->preg_index(2),
// 
		// '(florida|georgia)/venues/([\w\d\-]+)/?$'   								=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&venue-type=' . $wp_rewrite->preg_index(2),
		// '(florida|georgia)/venues/([\w\d\-]+)/page/([0-9]{1,})/?$' 					=> 'index.php?post_type=venue&region=' . $wp_rewrite->preg_index(1) . '&venue-type=' . $wp_rewrite->preg_index(2) . '&paged=' . $wp_rewrite->preg_index(3),

		'(florida|georgia)/([\w\d\-]+)/events/?$'					   				=> 'index.php?post_type=event' . '&region=' . $wp_rewrite->preg_index(1) . '&norewrite=1',
		'(florida|georgia)/([\w\d\-]+)/events/page/([0-9]{1,})/?$' 					=> 'index.php?post_type=event&paged=' . $wp_rewrite->preg_index(3) . '&region=' . $wp_rewrite->preg_index(2) . '&norewrite=1', // . '&type=' . $wp_rewrite->preg_index(3),

		'(florida|georgia)/events/?$'					   							=> 'index.php?post_type=event'. '&region=' . $wp_rewrite->preg_index(1) . '&norewrite=1',
		'(florida|georgia)/events/page/([0-9]{1,})/?$' 								=> 'index.php?post_type=event&paged=' . $wp_rewrite->preg_index(2) . '&region=' . $wp_rewrite->preg_index(1) . '&norewrite=1', // . '&type=' . $wp_rewrite->preg_index(3),

		'(florida|georgia)/([\w\d\-]+)/cat/([\w\d\-]+)/?$'					   		=> 'index.php?post_type=post&category_name=' . $wp_rewrite->preg_index(3),
		'(florida|georgia)/([\w\d\-]+)/cat/([\w\d\-]+)/page/([0-9]{1,})/?$'			=> 'index.php?post_type=post&category_name=' . $wp_rewrite->preg_index(3) .'&paged=' . $wp_rewrite->preg_index(4),
		
		/* vendors */
		
		'vendors/([\w\d\-]+)/?$' 													=> 'index.php?pagename=vendors-in-city&tag=' . $wp_rewrite->preg_index(1),
		
		
		'venues/?$' 																=> 'index.php?post_type=venue',
		'venues/page/([0-9]{1,})/?$' 												=> 'index.php?post_type=venue&paged=' . $wp_rewrite->preg_index(1),

		'events/?$' 																=> 'index.php?post_type=event',

		'featured-vendor/([\w\d\-\=]+)/?$' 											=> 'index.php?post_type=featured-vendor&track=' . $wp_rewrite->preg_index(1)
	

	);

	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	
}
add_action( 'generate_rewrite_rules', 'flo_add_rewrite_rules' );


/* NEW */

add_filter('post_link', 'region_permalink', 10, 3);
add_filter('post_type_link', 'region_permalink', 10, 3);
 
function region_permalink($permalink, $post_id, $leavename) {
    if (strpos($permalink, '%region%') === FALSE) return $permalink;
     
        // Get post
        $post = get_post($post_id);
        if (!$post) return $permalink;
 
        // Get taxonomy terms
        $terms = wp_get_object_terms($post->ID, 'region');   
        if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
        else $taxonomy_slug = 'no-region';
 
    return str_replace('%region%', $taxonomy_slug, $permalink);
}   

/* *** */


function flo_append_query_vars($vars) {
    array_push($vars, 'track');
    return $vars;
}
add_filter('query_vars','flo_append_query_vars');

function flo_multi_taxonomy_template()
{
	global $wp_query;
	$templates = array();

	if(is_tax()) {
		$mytaxs = $wp_query->query_vars;

		// redirect if the events by region selected
		if (is_tax('region') && get_post_type() == 'event') {
			set_query_var('posts_per_page', 2);
			return STYLESHEETPATH.'/archive-event.php';
		}

		// redirect if the top region (state) is selected
		if (is_tax('region')) {
			$term = get_term_by('slug', $mytaxs['region'], 'region');
			if (!$term->parent) {
				return STYLESHEETPATH.'/taxonomy-region-level-top.php';
			}
		}

		// find the right template for two taxonomies
		$temp = "taxonomy";
		foreach ($mytaxs as $taxname=>$taxval) {
			if ($taxname=='service' || $taxname=='region' || $taxname=='venue-type') {
				$temp .= "-{$taxname}";
			}
		}
		$templates[] = $temp;
		$templates[] = "taxonomy";
		$located = flo_find_template($templates);

		if($located) {
			return $located;
		}
	}

	return '';
}
add_filter('taxonomy_template',   'flo_multi_taxonomy_template', 1000);

function flo_find_template($templates, $extension = 'php'){
	$located = '';
	// find the first available
	foreach((array)$templates as $template){
		$fn = "{$template}.{$extension}";
		// highest priority - child theme 'templates' folder / or parent theme (if a child theme is not active)
		if(file_exists(STYLESHEETPATH.'/templates/'.$fn)) {
			$located = STYLESHEETPATH.'/templates/'.$fn;
			break;
		// child/parent theme root folder
		} elseif(file_exists(STYLESHEETPATH.'/'.$fn)) {
			$located = STYLESHEETPATH.'/'.$fn;
			break;
		// lowest priority - parent theme 'templates' folder
		} elseif(file_exists(TEMPLATEPATH.'/templates/'.$fn)) {
			$located = TEMPLATEPATH.'/templates/'.$fn;
			break;
		}
	}
	return $located;
}

function flo_get_region_venue_permalink($city, $venue, $type = 'services') {
	return str_replace('region/','', get_term_link($city, 'region')) . $type . '/' . $venue . '/';
}
function flo_region_venue_permalink($city, $venue, $type = 'services') {
	echo flo_get_region_venue_permalink($city, $venue, $type);
}

function flo_region_events_permalink($city) {
	echo flo_get_region_events_permalink($city);
}
function flo_get_region_events_permalink($city) {
	return get_term_link($city, 'region') . 'events/';
}


// Puts link in excerpts more tag
function flo_excerpt_more($more) {
	global $post;
	return '<span class="more"><a class="moretag" href="'. get_permalink($post->ID) . '">Read More</a></span>';
}
add_filter('excerpt_more', 'flo_excerpt_more');


function flo_add_twitter_contactmethod( $contactmethods ) {
	// Add Twitter
	if (!isset( $contactmethods['twitter'])) {
		$contactmethods['twitter'] = 'Twitter';
	}

	if ( isset( $contactmethods['aim'] ) ) {
		unset( $contactmethods['aim'] );
	}
	if ( isset( $contactmethods['yim'] ) ) {
		unset( $contactmethods['yim'] );
	}
	if ( isset( $contactmethods['jabber'] ) ) {
		unset( $contactmethods['jabber'] );
	}
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'flo_add_twitter_contactmethod', 10, 1 );

function flo_add_custom_user_profile_fields( $user ) {
	global $wpdb;
	// admin / contributor fields
	if ($user->allcaps['administrator'] || $user->allcaps['contributor']) {
	?>
	<h3><?php _e('Extra Profile Information', 'flotheme'); ?></h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="position"><?php _e('Position', 'flotheme'); ?>
			</label></th>
			<td>
				<input type="text" name="position" id="flo_position" value="<?php echo esc_attr( get_the_author_meta( 'position', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your position.', 'flotheme'); ?></span>
			</td>
		</tr>
	</table>
	<?php
	}

	// advertiser advanced fields
	if ($user->allcaps['advertiser']) {

		$venue_list = $wpdb->get_results("SELECT ID AS id, post_title AS name FROM {$wpdb->posts} WHERE post_type='venue' AND post_status IN ('publish', 'draft') ORDER BY post_title ASC");

		$advertiser_venue = get_usermeta($user->ID, 'venue_id');

	?>
	<h3><?php _e('Extra Profile Information', 'flotheme'); ?></h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="venue_id"><?php _e('Venue', 'flotheme'); ?>
			</label></th>
			<td>
				<select name="venue_id" id="venue_id">
					<option value="">none</option>
					<?php foreach ($venue_list as $venue): ?>
						<option value="<?php echo $venue->id ?>" <?php echo $advertiser_venue == $venue->id ? 'selected="selected"' : '' ?>><?php echo $venue->name ?></option>
					<?php endforeach ?>
				</select>
				<span class="description"><?php _e('Select a venue ID for advertiser.', 'flotheme'); ?></span>
			</td>
		</tr>
	</table>
	<?php
	}


}
function flo_save_custom_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	if (isset($_POST['position'])) {
		update_usermeta( $user_id, 'position', $_POST['position'] );
	}

	if (isset($_POST['venue_id'])) {
		update_usermeta( $user_id, 'venue_id', $_POST['venue_id'] );
	}

}
add_action( 'show_user_profile', 'flo_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'flo_add_custom_user_profile_fields' );
add_action( 'personal_options_update', 'flo_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'flo_save_custom_user_profile_fields' );


function flo_modify_user_table( $column ) {
	if (isset($_GET['role']) && $_GET['role'] == 'advertiser') {
		$column['venue'] = 'Venue';
		unset($column['posts']);
	}

    return $column;
}
add_filter( 'manage_users_columns', 'flo_modify_user_table' );

function test_modify_user_table_row( $val, $column_name, $user_id ) {

    switch ($column_name) {
        case 'venue' :
        	$venue_id = get_usermeta($user_id, 'venue_id');
        	$venue = get_post($venue_id);
        	if ($venue) {
        		return '<a href="' . get_edit_post_link($venue_id) . '">' . $venue->post_title . '</a>';
        	} else {
        		return '<span style="color:#c00;">---</span>';
        	}
            break;
        default:
    }
}
add_filter( 'manage_users_custom_column', 'test_modify_user_table_row', 10, 3 );


//Gets an array of the available authors
function flo_all_authors() {
	global $wpdb;

	$users = get_users( array(
		'role' => 'contributor',
	));

	return $users;

	// $order = 'user_nicename';
	// $user_ids = $wpdb->get_col("SELECT ID FROM {$wpdb->users} ORDER BY $order");

	// foreach($user_ids as $user_id) :
	// 	$user = get_userdata($user_id);
	// 	$all_authors[$user_id] = $user->display_name;
	// endforeach;
	// return $all_authors;
}

function flo_get_nav_section($section = 'weddings') {

	$entry = array(
		'section' => get_category_by_slug($section),
	);

	$tax_images = get_option('taxonomy_image_plugin');


	if (isset($tax_images[$entry['section']->term_taxonomy_id])) {
		$src = wp_get_attachment_image_src( $tax_images[$entry['section']->term_taxonomy_id], 'thumbnail' );
		if (count($src)) {
			$entry['section']->image_src = $src[0];
		}
	}

	$entry['permalink'] = get_category_link($entry['section']);

	$entry['children'] = get_categories(array(
		'parent' 		=> $entry['section']->cat_ID,
		'hierarchical' 	=> 0,
		'order'			=> 'ASC',
		'orderby'		=> 'term_order',
		'hide_empty'	=> false,
	));

	foreach ($entry['children'] as $id => $child) {
		if (isset($tax_images[$child->term_taxonomy_id])) {
			$src = wp_get_attachment_image_src( $tax_images[$child->term_taxonomy_id], 'thumbnail');
			if (count($src)) {
				$entry['children'][$id]->image_src = $src[0];
			}
		}
	}

	$entry['featured'] = get_posts(array(
		'numberposts'		=> 3,
		'category'			=> $entry['section']->cat_ID,
		// 'meta_key'			=>	'featured_story',
		// 'meta_value'		=>	1,
	));

	return $entry;
}

function flo_get_post_section($post_id = NULL) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}
	$categories = wp_get_post_categories($post_id, array(
		'fields' => 'all'
	));
	$section = null;
	foreach ($categories as $cat) {
		if (!$cat->parent) {
			$section = $cat;
			break;
		}
	}

	return $section;
}

function flo_post_section($post_id = null, $link = true) {
	$section = flo_get_post_section($post_id);
	if ($link) {
		echo '<a href="' . get_category_link($section->term_id) . '">' . $section->name . '</a>';
	} else {
		echo $section->name;
	}
}

function flo_get_post_first_category($post_id = NULL) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}
	$categories = wp_get_post_categories($post_id, array(
		'fields' => 'all'
	));
	$cat = null;
	foreach ($categories as $cat) {
		if ($cat->parent) {
			$cat = $cat;
			break;
		}
	}
	return $cat;
}

function flo_post_first_category($post_id = null, $link = true) {
	$cat = flo_get_post_first_category($post_id);
	if ($link) {
		echo '<a href="' . get_category_link($cat) . '">' . $cat->name . '</a>';
	} else {
		echo $cat->name;
	}
}



function flo_get_post_state($post_id = NULL) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}
	$states = wp_get_post_terms($post_id, 'region', array(
		'fields' => 'all'
	));
	$state = null;
	foreach ($states as $state) {
		if (!$state->parent) {
			$state = $state;
			break;
		}
	}
	return $state;
}
function flo_post_state($post_id = null, $link = true) {
	$state = flo_get_post_state($post_id);

	if ($link) {
		echo '<a href="' . get_term_link($state) . '">' . $state->name . '</a>';
	} else {
		echo $state->name;
	}
}

function flo_get_post_city($post_id = NULL) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}
	$cities = wp_get_post_terms($post_id, 'region', array(
		'fields' => 'all'
	));
	$city = null;
	foreach ($cities as $city) {
		if ($city->parent) {
			$city = $city;
			break;
		}
	}
	return $city;
}
function flo_post_city($post_id = null, $link = true) {
	$city = flo_get_post_city($post_id);
	if ($link) {
		echo '<a href="' . get_term_link($city) . '">' . $city->name . '</a>';
	} else {
		echo $city->name;
	}
}



function flo_get_post_category_cover($size = 'full', $post_id = NULL, $src = true) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}

	$cover = get_post_meta($post_id, 'top_cat_cover_story_image', true);

	if ($src) {
		$src = wp_get_attachment_image_src($cover['ID'], $size);
		return count($src) ? $src[0] : '';
	} else {
		$image = wp_get_attachment_image($cover['ID'], $size);
		return $image;
	}
}

function flo_post_category_cover($size = 'full') {
	$cover = flo_get_post_category_cover($size, get_the_ID(), false);

	echo $cover;
}


function flo_get_sections() {

	global $wpdb;

	$top_categories = flo_get_top_categories();

	$ids = array();
	foreach ($top_categories as $cat) {
		$ids[] = $cat->id;
	}

	$sql = "
		SELECT t.term_id AS id, name, slug, description, term_order
		FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
		WHERE t.term_id IN (" . implode(', ', array_fill(0, count($ids), '%d')) . ") ORDER BY term_order ASC
	 ";

	$query = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($sql), $ids));

	return $wpdb->get_results($query);
}

function flo_get_local_sections() {

	global $wpdb;

	$top_categories = flo_get_local_top_categories();

	$ids = array();
	foreach ($top_categories as $cat) {
		$ids[] = $cat->id;
	}

	if (!count($ids)) {
		return array();
	}

	$sql = "
		SELECT t.term_id AS id, name, slug, description, term_order
		FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
		WHERE t.term_id IN (" . implode(', ', array_fill(0, count($ids), '%d')) . ") ORDER BY term_order ASC
	 ";

	$query = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($sql), $ids));

	return $wpdb->get_results($query);
}

function get_weddings_top_categories() {
	return flo_get_categories_by_slug(array('real-weddings', 'destination-weddings', 'colors-and-themes'));
}

function get_parties_top_categories() {
	return flo_get_categories_by_slug(array('birthday-party-ideas', 'themes-and-ideas', 'diy-and-tutorials'));
}

function get_entertaining_top_categories() {
	return flo_get_categories_by_slug(array('seasonal-settings', 'holiday-party-ideas', 'recepies-and-cocktails'));
}

function flo_get_categories_by_slug($slugs) {
	global $wpdb;
	$sql = "
		SELECT DISTINCT t.term_id AS id, name, slug, description, term_order
		FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
		WHERE t.slug IN (" . implode(', ', array_fill(0, count($slugs), '%s')) . ") ORDER BY term_order ASC
	 ";
	$query = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($sql), $slugs));

	return $wpdb->get_results($query);
}


function flo_get_regions_links($include_services = true) {
	global $wpdb;

	$states = get_terms('region', array(
		'parent' 		=> 0,
		'hide_empty' 	=> 0,
		'orderby'		=> 'term_order',
		'order' 		=> 'ASC',
	));

	foreach ($states as $k => $state) {
		$states[$k]->cities = get_terms('region', array(
			'parent' 		=> $state->term_id,
			'hide_empty' 	=> 0,
			'orderby'		=> 'term_order',
			'order' 		=> 'ASC',
		));

		if ($include_services) {
			foreach ($states[$k]->cities as $kk => $city) {
				if ($city->count) {
					$query = $wpdb->prepare("
						SELECT DISTINCT terms2.*, t2.count, t2.parent, t2.taxonomy, t2.term_taxonomy_id
						FROM
							{$wpdb->posts} as p1
							LEFT JOIN {$wpdb->term_relationships} as r1 ON p1.ID = r1.object_ID
							LEFT JOIN {$wpdb->term_taxonomy} as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
							LEFT JOIN {$wpdb->terms} as terms1 ON t1.term_id = terms1.term_id,

							{$wpdb->posts} as p2
							LEFT JOIN {$wpdb->term_relationships} as r2 ON p2.ID = r2.object_ID
							LEFT JOIN {$wpdb->term_taxonomy} as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
							LEFT JOIN {$wpdb->terms} as terms2 ON t2.term_id = terms2.term_id
						WHERE
							t1.taxonomy = 'region' AND p1.post_status = 'publish' AND terms1.term_id = %d AND
							t2.taxonomy = 'service' AND p2.post_status = 'publish'
							AND p1.ID = p2.ID
					 ", $city->term_id);
				}
				$states[$k]->cities[$kk]->services = $wpdb->get_results($query);
			}
		}
	}

	return $states;
}

function get_state_cities($state) {

	if (!is_object($state)) {
		$state = get_term_by('slug', $state, 'region');
	}

	$cities = get_terms('region', array(
		'parent' => $state->term_id,
		'order'	 		=> 'ASC',
		'orderby'	 	=> 'term_order',
		'hide_empty' 	=> false,
	));

	return $cities;
}


function flo_get_top_categories() {

	$slugs = array(
		'weddings',
		'parties-and-celebrations',
		'entertaining-and-holidays',
	);

	return flo_get_categories_by_slug($slugs);
}

function flo_get_local_top_categories() {

	$slugs = array(
		'local-experts',
		'local-news-and-announcements',
		'local-things-to-do',
	);

	return flo_get_categories_by_slug($slugs);
}


function flo_get_vendor_geoaddress() {
	$lat = flo_get_meta('geolat');
	$lng = flo_get_meta('geolng');

	if ($lat && $lng) {
		return array(
			'lng' => $lng,
			'lat' => $lat,
		);
	} else {
		return false;
	}
}

function flo_vendor_geoaddress() {
	$address = flo_get_vendor_geoaddress();

	if ($address) {
		echo 'data-geolng="' . $address['lng'] . '" data-geolat="' . $address['lat'] . '"';
	}
}

function flo_get_venue_city($id = null) {
	if (null === $id) {
		$id = get_the_ID();
	}
	$regions = wp_get_post_terms($id, 'region');

	$city = null;

	foreach ($regions as $region) {
		if ($region->parent) {
			$city = $region;
			break;
		}
	}
	return $city;
}

function flo_get_venue_state($id = null) {
	if (null === $id) {
		$id = get_the_ID();
	}
	$regions = wp_get_post_terms($id, 'region');

	$state = null;

	foreach ($regions as $region) {
		if (!$region->parent) {
			$state = $region;
			break;
		}
	}
	return $state;
}

function flo_get_venue_service($id = null) {
	if (null === $id) {
		$id = get_the_ID();
	}
	$services = wp_get_post_terms($id, 'service');

	if (count($services)) {
		return $services[0];
	} else {
		return null;
	}
}



add_action( 'comment_form_logged_in_after', 'flo_additional_fields' );
add_action( 'comment_form_after_fields', 'flo_additional_fields' );

function flo_additional_fields () {
	echo '<p class="comment-form-title">'.
	'<label for="title">' . __( 'Comment Title' ) . '</label>'.
	'<input id="title" name="title" type="text" size="30"  tabindex="5" /></p>';

	echo '<p class="comment-form-rating">'.
	'<label for="rating">'. __('Rating') . '<span class="required">*</span></label>
	<span class="commentratingbox">';

		//Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
		for( $i=1; $i <= 5; $i++ )
		echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"/>'. $i .'</span>';

	echo'</span></p>';

}




// Save the review rating
add_action( 'comment_post', 'flo_save_review_meta_data' );
function flo_save_review_meta_data($comment_id) {
	if (isset( $_POST['rating']) && $_POST['rating'] != '') {
		$rating = (int) $_POST['rating'];
		if ($rating > 5 || $rating < 1) {
			$rating = 5;
		}
		add_comment_meta($comment_id, 'rating', $rating);
	}
}





// Review callback
function flotheme_review($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<div id="review-<?php comment_ID(); ?>" class="review-container">
			<header class="review-author vcard cf">
				<?php printf(__('<cite class="fn">%s</cite>', 'flotheme'), get_comment_author_link()); ?>
				<time datetime="<?php echo comment_date('Y-m-d'); ?>"><?php printf(__('Posted on %1$s', 'flotheme'), get_comment_date(),  get_comment_time()); ?></time>

				<span class="stars stars<?php echo get_comment_meta($comment->comment_ID, 'rating', true) ?>">

				</span>

			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<p class="waiting"><?php _e('Your review is awaiting moderation.', 'flotheme'); ?></p>
			<?php endif; ?>
			<section class="review-body"><?php comment_text() ?></section>
		</div>
<?}

function flo_venue_rating($id = null) {
	if (null === $id) {
		$id = get_the_ID();
	}
	echo flo_get_venue_rating($id);
}

function flo_get_venue_rating($id = null) {
	global $wpdb;

	if (null === $id) {
		$id = get_the_ID();
	}

	$sql = 'SELECT ROUND(AVG(meta.meta_value)) FROM ' . $wpdb->comments . ' comments '
                    . ' INNER JOIN ' . $wpdb->commentmeta . ' meta ON comments.comment_ID = meta.comment_id '
                    . ' WHERE comment_post_ID=%d AND comment_approved=%d AND meta.meta_key = %s GROUP BY meta.meta_key';

    return $wpdb->get_var($wpdb->prepare($sql, $id, 1, 'rating'));

}


// Add an edit option to comment editing screen
add_action( 'add_meta_boxes_comment', 'flo_extend_comment_add_meta_box' );
function flo_extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Review Ratings' ), 'flo_extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function flo_extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
			<span class="commentratingbox">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
				if ( $rating == $i ) echo ' checked="checked"';
				echo ' />'. $i .' </span>';
				}
			?>
			</span>
    </p>
    <?php
}

// Update comment meta data from comment editing screen
add_action( 'edit_comment', 'flo_extend_comment_edit_metafields' );
function flo_extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

	if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
	$rating = wp_filter_nohtml_kses($_POST['rating']);
	update_comment_meta( $comment_id, 'rating', $rating );
	else :
	delete_comment_meta( $comment_id, 'rating');
	endif;

}

// Add the filter to check whether the comment meta data has been filled

add_filter( 'preprocess_comment', 'flo_verify_comment_meta_data' );
function flo_verify_comment_meta_data( $commentdata ) {
	global $post;
	if ( ! isset( $_POST['rating'] ) && get_post_type($post->ID) == 'venue' )
	wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
	return $commentdata;
}

/**
 * Issue cart form
 * @param  integer $product_id
 * @return html
 */
function flo_issue_cart_form($product_id = 'OOANNUAL', $ajax = false) {
	if (null === $product_id) {
		$product_id = "OOANNUAL";
	}
	$product = new Cart66Product();
	$product->loadFromShortcode(array(
		'item' => $product_id,
	));

	$id = (int) $product->id;

	if (!$id) {
		return;
	}

	$trackInventory = Cart66Setting::getValue('track_inventory');

	if($product->isAvailable()) {

		?>
		<div class="buy-now">
			<form action="<?php echo Cart66Common::getPageLink('store/cart'); ?>" method="post" id="issue-order-form-<?php echo $id ?>">
				<span class="price">
					<?php echo Cart66Common::currency($product->price, true, true); ?>
					<?php if ($product->price_description): ?>
						<span class="descr">/ <?php echo $product->price_description ?></span>
					<?php endif ?>
				</span>
				<span>
					<input type="submit" value="Buy Now" id="issue-addtocart-<?php echo $id ?>" />
					<input name="item_quantity" id="issue-quantity-<?php echo $id ?>" type="hidden" value="1" />
				    <input type='hidden' name='task' id="issue-task-<?php echo $id ?>" value='addToCart' />
				    <input type='hidden' name='cart66ItemId' value='<?php echo $id; ?>' />
				    <input type='hidden' name='product_url' value='<?php echo Cart66Common::getCurrentPageUrl(); ?>' />
				</span>
			</form>
		</div>
		<?php if ($ajax): ?>

			<script type="text/javascript">
				/* <![CDATA[ */
				(function($){
					<?php
						$url = Cart66Common::appendWurlQueryString('cart66AjaxCartRequests');
						if(Cart66Common::isHttps()) {
							$url = preg_replace('/http[s]*:/', 'https:', $url);

						} else {
							$url = preg_replace('/http[s]*:/', 'http:', $url);
						}
						$product_name = str_replace("'", "\'", $product->name);
					?>
					$(document).ready(function(){
						$('.Cart66AjaxWarning').hide();
						$('#issue-addtocart-<?php echo $id ?>').click(function() {
							$('#issue-task-<?php echo $id ?>').val('ajax');
							<?php if($trackInventory): ?>
								inventoryCheck('<?php echo $id ?>', '<?php echo $url ?>', '<?php echo $data["ajax"] ?>', '<?php echo $product_name; ?>', '<?php echo Cart66Common::getCurrentPageUrl(); ?>', '<?php _e( "Adding..." , "cart66" ); ?>');
							<?php else: ?>
								$.issue_button_transform(
									'<?php echo $id ?>',
									'<?php echo $url ?>',
									'<?php echo $product_name; ?>',
									'<?php echo Cart66Common::getCurrentPageUrl(); ?>',
									'<?php _e( "Adding..." , "cart66" ); ?>'
								);
							<?php endif; ?>
							return false;
						});
					})
				})(jQuery);
				/* ]]> */
			</script>
		<?php endif ?>


		<?php
	} else {
		?>
		<p class="soldout">Sold Out</p>
		<?php
	}
}




function flo_custom_excerpt_length($length) {
	return 22;
}


function flo_accepted_payments() {
	return array(
		'Visa' => 'Visa',
		'Mastercard' => 'Mastercard',
		'Amex' => 'American Express',
		'Discover' => 'Discover',
		'Checks' => 'Checks',
		'Bank Drafts' => 'Bank Drafts',
		'Paypal' => 'Paypal',
	);
}
function flo_qr_codes() {
	$vid = (int) $_REQUEST['post'];
	$oldid = get_post_meta($vid,'flo_oldid', true);

	if (is_numeric($oldid)) $vid = $oldid;

	$link = urlencode('http://maglink.us/p'.$vid);
	$mlink = urlencode('http://maglink.us/m'.$vid);

	$result = '<h4>Below is a small and large QR Code for your Occasions profile page:</h4>';
	$result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$link.'&chld=H|0" />';
	$result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl='.$link.'&chld=H|0" />';


	$result .= '<h4>Below is a small and large QR Code for your Occasions profile page <strong>designed for mobile devices</strong>:</h4>';
	$result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$mlink.'&chld=H|0" />';
	$result .= '<img src="http://chart.apis.google.com/chart?cht=qr&chs=500x500&chl='.$mlink.'&chld=H|0" />';

	return $result;
}

function flo_phone_types() {
	return array(
		array(
			'name'  => '',
			'value' => '',
		),
		array(
			'name'  => 'Mobile',
			'value' => 'Mobile',
		),
		array(
			'name'  => 'Toll-Free',
			'value' => 'Toll-Free',
		),
		array(
			'name'  => 'Work',
			'value' => 'Work',
		),
		array(
			'name'  => 'Work FAX',
			'value' => 'Work FAX',
		),
		array(
			'name'  => 'Home',
			'value' => 'Home',
		),
		array(
			'name'  => 'Home FAX',
			'value' => 'Home FAX',
		),
		array(
			'name'  => 'Sales',
			'value' => 'Sales',
		),
		array(
			'name'  => 'Management',
			'value' => 'Management',
		),
	);
}

function flo_travel_policies() {
	return array(
		array(
			'name' => 'none',
			'value' => '<none>',
		),
		array(
			'name' => 'Locally',
			'value' => 'Locally',
		),
		array(
			'name' => 'State Wide',
			'value' => 'State Wide',
		),
		array(
			'name' => 'Regionally',
			'value' => 'Regionally',
		),
		array(
			'name' => 'Nationally',
			'value' => 'Nationally',
		),
		array(
			'name' => 'Internationally',
			'value' => 'Internationally',
		),
	);
}




function flo_get_regions_hierarchial() {
	$regions = flo_get_regions_by_parent();

	foreach ($regions as $key => $region) {
		$regions[$key]->cities = flo_get_regions_by_parent($region->term_id);
	}

	return $regions;
}

function flo_get_regions_by_parent($parent = 0) {
	return get_terms('region', array(
		'parent'		=> $parent,
		'hide_empty' 	=> false,
	));
}




function flo_get_event_date($type = 'start', $format = 'F d, Y', $id = null) {
	if (null === $id) {
		$id = get_the_ID();
	}
	$date = flo_get_meta($type . '_date', true, $id);

	return date($format, strtotime($date));
}

function flo_get_event_venue_featured_image_src($id = null, $size = 'full') {

	if (null === $id) {
		$id = get_the_ID();
	}

	$user_id = (int) flo_get_meta('author', true, $id);

	$venue = flo_get_venue_by_user($user_id);

	if (!$venue) {
		return;
	}

	$attachment_id = get_post_thumbnail_id($venue->ID);

	if (!$attachment_id) {
		return;
	}

	$src = wp_get_attachment_image_src($attachment_id, $size);

	if (count($src)) {
		return $src[0];
	} else {
		return;
	}
}

function flo_get_venue_by_user($user_id) {
	if (!$user_id) {
		return false;
	}

	$venue_id = get_usermeta($user_id, 'venue_id');

	if (!$venue_id) {
		return;
	}

	$venue = get_post($venue_id);

	return $venue;
}

function flo_local_geoprofiles() {

	$region_id = (int) $_REQUEST['region_id'];
	if (!$region_id) {
		exit;
	}
	$region = get_term($region_id, 'region');
	if (!$region) {
		exit;
	}

	$_query = new WP_Query(array(
		'post_type'	=> 'venue',
		'posts_per_page' => 50,
		'tax_query' => array(
			array(
				'taxonomy'	=> 'region',
				'field'		=> 'id',
				'terms'		=> $region_id,
			),
		),
	));

	if (!$_query->have_posts()) {
		exit;
	}

	$data = array();
	while ($_query->have_posts()) {
		$_query->the_post();

		$html  = '<div style="width:220px;">';
		$html .= '<h3><a href="' . get_permalink() . '">' . get_the_title() .  '</a></h3>';
		//$html .= '<div>' . get_the_post_thumbnail(get_the_ID(), 'venue-thumbnail', array('style' => 'width:60px;height:60px;')) . '</div>';
		$html .= '<p>' . flo_get_meta('short_info') . '</p>';
		$html .= '</div>';

		$lng = flo_get_meta('geolng');
		$lat = flo_get_meta('geolat');
		if ($lng && $lat) {
			$data['markers'][] = array(
				'lng'	=> $lng,
				'lat'	=> $lat,
				'html'	=> $html,
			);
		}
	}

	echo json_encode($data);exit;
}
add_action('wp_ajax_nopriv_flo_local_geoprofiles', 'flo_local_geoprofiles');
add_action('wp_ajax_flo_local_geoprofiles', 'flo_local_geoprofiles');


function flo_metabox_vendors_select() {

	$users = get_users(array(
		'role' => 'advertiser',
	));

	$options = array();
	foreach ($users as $user) {
		$options[] = array(
			'value' => $user->ID,
			'name'	=> $user->display_name,
		);
	}

	return $options;
}


/**
 * Get all attached images. Filter by hide_form_gallery meta key
 * @param integer $id
 * @param boolean $show_hidden
 * @return array
 */
function flo_get_attached_files($id = null, $show_hidden = true) {
    if (!$id) {
        $id = get_the_ID();
    }

	$attrs = array(
        'post_parent' => $id,
        'post_status' => null,
        'post_type' => 'attachment',
        'order' => 'ASC',
        'numberposts' => -1,
        'orderby' => 'menu_order',
	);

	if (!$show_hidden) {
		$attrs['meta_query'] = array(
			array(
				'key'		=> '_flo_hide_from_gallery',
				'value'		=> 0,
				'type'		=> 'DECIMAL',
			),
		);
	}

    return get_children($attrs);
}

function flo_get_vendor_attached_files($id = null) {
	if (!$id) {
		$id = get_the_ID();
	}

	$attrs = array(
        'post_parent' => $id,
        'post_status' => null,
        'post_type' => 'attachment',
        'order' => 'ASC',
        'numberposts' => -1,
        'orderby' => 'menu_order',
	);

	$downloads = get_children($attrs);

	foreach ($downloads as $key => $file) {
		if (in_array($file->post_mime_type, array('image/jpeg'))) {
			unset($downloads[$key]);
		}
	}

	return $downloads;
}

// add div.image and pinterest button
function flo_wrap_image_credits($content = null)
{
    if (!$content) {
        $content = get_the_content();
    }

	preg_match_all("/(<img[^>]+>)/sim", $content, $matches);

	$imgs=$matches[1];

	foreach($imgs as $k=>$img)
	{
		preg_match('~(src="([^"]+)")~simU', $img, $src);
		$img_md5 = md5($src[2]);
		$replace = '<div class="image '.$class[2].'" id="'.$img_md5.'"><img';
		$pinit = "javascript:void(showPinterest('".$img_md5."'))";
		$bottom_info = '<a href="'.$pinit.'" class="pinit"></a>';
		$after = '>'.$bottom_info.'</div>';
		$res=str_replace(array('>','<img'),array($after,$replace),$img);

		$content=str_replace($img,$res,$content);
	}

	return $content;
}

/**
 * Get image SRC.
 */
function flotheme_get_src($image) {
	preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $image, $matches);

	return $matches[1];
}


function flo_handle_venue_search( $query ) {

	if (isset($query->query_vars['post_type'])) {
		if ((is_array($query->query_vars['post_type']) && in_array('venue', $query->query_vars['post_type'])) || $query->query_vars['post_type'] == 'venue') {
			$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
			$rating = isset($_GET['rating']) ? (int) $_GET['rating'] : 0;

			if ($keyword) {
				set_query_var('s', $keyword);
			}
			if ($rating) {
				set_query_var('meta_key', 'rating');
				set_query_var('meta_value', $rating);
			}
		}
	}

	return $query;
}
add_action( 'pre_get_posts', 'flo_handle_venue_search' );



function flo_get_post_thumbnail_src($size, $post_id = null) {

	$src = '';
	if (has_post_thumbnail($post_id)) {
		$thumb_id = get_post_thumbnail_id($post_id);
		$thumb = wp_get_attachment_image_src($thumb_id, $size);
		if (is_array($thumb) && count($thumb)) {
			$src = $thumb[0];
		}
	}

	if (!$src) {
		$src = flo_get_first_attached_image_src($post_id, $size);
	}
	if (!$src) {
		$src = flo_get_post_cover($size, $post_id);
	}

	return $src;
}
function flo_post_thumbnail_src($size, $post_id = null) {
	echo flo_get_post_thumbnail_src($size, $post_id);
}

function flo_get_post_thumbnail($size, $post_id = null) {
	$img = '';
	if (has_post_thumbnail($post_id)) {
		$img = get_the_post_thumbnail($post_id, $size);
	}
	if (!$img) {
		$image = flo_get_first_attached_image($post_id);
		$img = wp_get_attachment_image($image->ID, $size);
	}
	if (!$img) {
		global $post;
		$img = flo_parse_first_image($post->post_content);
	}

	return $img;
}
function flo_post_thumbnail($size, $post_id = null)
{
	echo flo_get_post_thumbnail($size, $post_id);
}




function flo_get_post_cover($size = 'full', $post_id = NULL, $src = true) {
	if (null === $post_id) {
		$post_id = get_the_ID();
	}

	$cover = get_post_meta($post_id, 'cover_story_image', true);

	if ($cover) {
		if ($src) {
			$src = wp_get_attachment_image_src($cover['ID'], $size);
			return $src[0];
		} else {
			$image = wp_get_attachment_image($cover['ID'], $size);
			return $image;
		}
	} else {
		$img = flo_get_first_attached_image($post_id,$size);
		if ($img) {
			$cover = wp_get_attachment_image($img->ID, $size);
		} else {
			$content = get_the_content($post_id);
			$cover = flo_parse_first_image($content);
		}
	}

	if ($src) {
		$cover = flotheme_get_src($image);
	}

	return $cover;
}

function flo_post_cover($size = 'full') {
	$cover = flo_get_post_cover($size, get_the_ID(), false);

	echo $cover;
}



function flo_post_image_thumbnail($html, $post_id, $post_image_id, $size) {
	if (!$html) {
		$image = flo_get_first_attached_image($post_id);
		$html = wp_get_attachment_image($image->ID, $size);
	}
	if (!$html) {
		$html = flo_get_post_cover($size, $post_id, false);
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'flo_post_image_thumbnail', 999, 4);

function flo_vendor_profile_view($vid=0) {
	global $wpdb;

	if ($vid == 0) $vid = get_the_ID();

	$ip = flo_get_real_ip();
	$ua = getenv("HTTP_USER_AGENT");
	$ua = htmlspecialchars($ua);
	$tblname = $wpdb->prefix . "logs";

	$sql = "INSERT INTO $tblname VALUES(NULL, NULL, '$ip', $vid, 'view', '$ua')";

	$result = $wpdb->query($wpdb->prepare($sql));

	return $result;
}

function flo_get_real_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

// Business Profile 
// ----------------
define('FLO_ADVERTISER_SUBSCRIPTION_ID', 3);
function flo_get_advertiser_subscription() {
	$subscriptions = RGFormsModel::get_leads(FLO_ADVERTISER_SUBSCRIPTION_ID,0,'DESC');

	$subscribers = '';

	// ["payment_status"]=> string(8) "Canceled"/"Active", 
	// ["created_by"]=> string(2) "11"
	foreach ($subscriptions as $lead) {
		if ($lead['payment_status'] == 'Active') $subscribers .= $lead['created_by'].',';
	}

	return $subscribers;
}

// check if upgraded profile have subscription\expiration
function flo_profile_is_upgraded($profile) { 
	$expdate = (int) get_post_meta($profile->ID, 'flo_upgrade_until', true);	
	$subscribed_users = flo_get_advertiser_subscription(); $subscribed_users = explode(',', $subscribed_users);

	$_user = get_users(array('meta_key' => 'venue_id', 'meta_value' => $profile->ID)); 

	if (empty($_user)) return false;
	$user = $_user[0];

	// is subscribed
	if ( in_array($user->ID, $subscribed_users) ) {
		return true;
	}

	// expiration
	if ( is_numeric($expdate) && $expdate > time() ) {
		return true;
	}

	return false;
}

function flo_check_upgraded_profiles() {
	// get all upgraded profiles
	$pArgs = array(
		'post_type' => 'venue',
		'post_status' => 'publish',
		'numberposts' => -1,
		'meta_key' => 'flo_upgrade_type',
		'meta_value' => 'upgraded',
	);	

	$upgradedProfiles = get_posts($pArgs);

	// check 'flo_upgrade_until' user meta
	if (!empty($upgradedProfiles)) :
		foreach ($upgradedProfiles as $up) :
			if ( !flo_profile_is_upgraded($up) ) {
				// downgrade
				update_post_meta($up->ID, 'flo_upgrade_type', 'simple', '');
			}
		endforeach;
	endif;

	// die;
}
// flo_check_upgraded_profiles();


// Cron stuff
// ----------
function flo_more_reccurences($schedules) {
	$schedules['hours_6'] 	= array('interval' => 21600, 'display' => __('Every 6 Hours'));
	$schedules['hours_2'] 	= array('interval' => 7200, 'display' => __('Every 2 Hours'));
	$schedules['minutes_5'] = array('interval' => 300, 'display' => __('Every 5 Minutes'));
	return $schedules;
}
add_filter('cron_schedules', 'flo_more_reccurences');

//remove schedule
// wp_clear_scheduled_hook('flo_cron_hook'); 
if (!wp_next_scheduled('flo_cron_hook')) {
	wp_schedule_event(time(), 'hours_2', 'flo_cron_hook');
}
add_action('flo_cron_hook', 'flo_check_upgraded_profiles');


/* 
 * attachment_image_link_remove_filter()
 * filters out anchor tags around images that have been uploaded to a post
 ******************************************/
add_filter( 'the_content', 'attachment_image_link_remove_filter' );
function attachment_image_link_remove_filter( $content ) {
 $content =
  preg_replace(array('{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}','{ wp-image-[0-9]*" /></a>}'),array('<img','" />'),$content);
  return $content;
}


?>
