<?php

/**
 * Remove HTML attributes from comments 
 */
add_filter( 'comment_text', 'wp_filter_nohtml_kses' );
add_filter( 'comment_text_rss', 'wp_filter_nohtml_kses' );
add_filter( 'comment_excerpt', 'wp_filter_nohtml_kses' );

/**
 * Remove junk from head
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'feed_links_extra', 3 );

/**
 * This filter adds query for post search only.
 *
 * @param object $query
 * @return object
 */
function flo_exclude_search_pages($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}

	return $query;
}
if( !is_admin() ) add_filter('pre_get_posts', 'flo_exclude_search_pages');

/**
 * Load needed options & translations into template.
 */
function flo_init_js_vars() {
	wp_localize_script(
		'flo_scripts',
		'flo',
		array(
			'template_dir'      => THEME_URL,
			'site_url'      	=> site_url(),
			'ajax_load_url'     => site_url('/wp-admin/admin-ajax.php'),
		)
	);
}
add_action('wp_print_scripts', 'flo_init_js_vars');

/**
 * Enqueue Theme Styles
 */
function flo_enqueue_styles() {
	
	// add general css file
	wp_register_style( 'flotheme_general_css', THEME_URL . '/css/general.css', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('flotheme_general_css');


	wp_register_style( 'baskerville_font', 'http://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('baskerville_font');

	wp_register_style( 'raleway_font', 'http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('raleway_font');

	wp_register_style( 'oswald_font', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('oswald_font');

	wp_register_style( 'arvo_font', 'http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('arvo_font');

	wp_register_style( 'fontawsome', 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css', array(), FLOTHEME_THEME_VERSION, 'all');
	wp_enqueue_style('fontawsome');

	
}
add_action( 'wp_enqueue_scripts', 'flo_enqueue_styles' );

/**
 * Enqueue Theme Scripts
 */
function flo_enqueue_scripts() {
	
	// load jquery from google cdn
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	
	// add html5 for old browsers.
	wp_register_script( 'html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );
	// add modernizr
	wp_register_script( 'flo_modernizr', THEME_URL . '/js/libs/modernizr-2.5.3.min.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );
	
	if (FLOTHEME_MODE == 'production') {
		wp_register_script( 'flo_plugins', THEME_URL . '/js/plugins.min.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );
		//wp_register_script( 'flo_scripts', THEME_URL . '/js/scripts.min.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );
		wp_register_script( 'flo_scripts', THEME_URL . '/js/scripts.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );		
	} else {
		wp_register_script( 'flo_plugins', THEME_URL . '/js/plugins.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );
		wp_register_script( 'flo_scripts', THEME_URL . '/js/scripts.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );		
	}

	// pNotify
	wp_register_script( 'pnotify', THEME_URL . '/js/libs/jquery.pnotify.min.js', array( 'jquery' ), FLOTHEME_THEME_VERSION, false );

	$gcode = flo_get_option('google_api');
	wp_register_script('flo_googlemaps', 'http://maps.googleapis.com/maps/api/js?key=' . $gcode . '&sensor=false');
	wp_register_script('flo_geocode_js', THEME_URL . '/js/libs/maps.js', array('jquery'), FLOTHEME_THEME_VERSION, false);
	

    wp_register_script('browserplus', 'http://bp.yahooapis.com/2.4.21/browserplus-min.js', null, FLOTHEME_THEME_VERSION, false);
    wp_register_script('flo_plupload' ,THEME_URL . '/js/libs/plupload/js/plupload.full.js' ,'jquery' ,FLOTHEME_THEME_VERSION ,false);
    wp_register_script('flo_plupload_queue' ,THEME_URL . '/js/libs/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js' ,'jquery' ,FLOTHEME_THEME_VERSION ,false);
    wp_register_style('flo_plupload' ,THEME_URL . '/js/libs/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css' ,FLOTHEME_THEME_VERSION);


	if (is_singular('venue') || is_tax('service') || is_tax('region')) {
		wp_enqueue_script( 'flo_googlemaps' );
		wp_enqueue_script( 'flo_geocode_js' );
	}
	
	wp_enqueue_script( 'pnotify' );
	wp_enqueue_script( 'jquery-form' );
	wp_enqueue_script( 'flo_modernizr' );
	wp_enqueue_script( 'html5-shim' );
	wp_enqueue_script( 'flo_plugins' );
	wp_enqueue_script( 'flo_scripts' );
}
add_action( 'wp_enqueue_scripts', 'flo_enqueue_scripts');

/**
 * Add header information 
 */
function flo_head() {
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?php flo_favicon(); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php flo_rss(); ?>" />
	<?php
	if (flo_get_option('google_ad')) {
	?>
		<script type='text/javascript' src='http://partner.googleadservices.com/gampad/google_service.js'></script>
		<script type='text/javascript'>
			GS_googleAddAdSenseService("<?php flo_option('google_ad') ?>");
			GS_googleEnableAllServices();
		</script>
		<script type='text/javascript'>
			<?php for($i = 1; $i <= flo_get_option('sidebar_ad_count'); $i++): ?>
				GA_googleAddSlot("<?php flo_option('google_ad') ?>", "300x125_spot_<?php echo $i ?>");
			<?php endfor; ?>
			<?php if (is_front_page()) : ?>
				GA_googleAddSlot("<?php flo_option('google_ad') ?>", "660x90_spot_1");
			<?php endif; ?>
		</script>
		<script type='text/javascript'>
			GA_googleFetchAds();
		</script>
	<?php
	}
}
add_action('wp_head', 'flo_head');

/**
 * Comment callback function 
 * @param object $comment
 * @param array $args
 * @param int $depth 
 */
function flotheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> data-comment-id="<?php echo $comment->comment_ID?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-container">
			<header class="comment-author vcard cf">
				<?php echo get_avatar($comment, 40); ?>
				<?php printf(__('<cite class="fn">%s</cite>', 'flotheme'), get_comment_author_link()); ?>
				<time datetime="<?php echo comment_date('Y-m-d'); ?>"><?php printf(__('Posted on %1$s', 'flotheme'), get_comment_date(),  get_comment_time()); ?></time>
				<?php edit_comment_link(__('(Edit)', 'flotheme'), '', ''); ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<p class="waiting"><?php _e('Your comment is awaiting moderation.', 'flotheme'); ?></p>
			<?php endif; ?>
			<section class="comment-body"><?php comment_text() ?></section>
			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>
		</div>
<?php }

/**
 * Custom password form
 * @global object $post
 * @return string 
 */
function flotheme_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$html = '<form class="protected-post-form" action="' . site_url('wp-login.php?action=postpass') . '" method="post">
	<p>' . __( "This post is password protected. To view it please enter your password below:", 'flotheme') . '</p>
	<p><label for="' . $label . '">' . __( "Password:", 'flotheme' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'flotheme' ) . '" /><input type="hidden" name="_wp_http_referer" value="' . get_permalink() . '" /></p>
	</form>
	';
	return $html;
}
add_filter( 'the_password_form', 'flotheme_password_form' );

/**
 * Add footer information
 * Social Services Init 
 */
function flo_footer() {
	$info = trim(flo_get_option('footer_info'));
	if ($info) {
		echo $info;
	}
	?>
	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
	<?php
}

add_action('wp_footer', 'flo_footer');

/**
 * Add Google Analytics Code
 */
function flo_google_analytics() {
	$analytics_id = trim(flo_get_option('ga'));
	
	if ($analytics_id) {
		echo "\n\t<script>\n";
		echo "\t\tvar _gaq=[['_setAccount','$analytics_id'],['_trackPageview'],['_trackPageLoadTime']];\n";
		echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
		echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
		echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
		echo "\t</script>\n";
	}
}
add_action('wp_footer', 'flo_google_analytics');

/**
 * Add Open Graph Tags to <head> 
 */
function flo_og_meta() {
	if (flo_get_option('og_enabled')) {
		
	$og_type='article';
	$og_locale = get_locale();
	
	$og_image = '';
	
	// single page
	if (is_singular()) {
		global $post;
		$og_title = esc_attr(strip_tags(stripslashes($post->post_title)));
		$og_url = get_permalink();
		if (trim($post->post_excerpt) != '') {
			$og_desc = trim($post->post_excerpt);
		} else {
			$og_desc = flo_truncate(strip_tags($post->post_content), 240, '...');
		}
		
		$og_image = flo_get_og_meta_image();
		
		if (is_front_page()) {
			$og_type = 'website';
		}
		
	} else {
		global $wp_query;
		
		$og_title = get_bloginfo('name');
		$og_url = site_url();
		$og_desc = get_bloginfo('description');
		
		if (is_front_page()) {
			$og_type = 'website';
			
		} elseif (is_category()) {
			$og_title = esc_attr(strip_tags(stripslashes(single_cat_title('', false))));
			$term = $wp_query->get_queried_object();
			$og_url = get_term_link($term, $term->taxonomy);
			$cat_desc = trim(esc_attr(strip_tags(stripslashes(category_description()))));
			if ($cat_desc) {
				$og_desc = $cat_desc;
			}
			
		} elseif(is_tag()) {
			$og_title = esc_attr(strip_tags(stripslashes(single_tag_title('', false))));
			$term = $wp_query->get_queried_object();
			$og_url = get_term_link($term, $term->taxonomy);
			$tag_desc = trim(esc_attr(strip_tags(stripslashes(tag_description()))));
			if (trim($tag_desc) != '') {
				$og_desc = $tag_desc;
			}
			
		} elseif (is_tax()) {	
			$og_title = esc_attr(strip_tags(stripslashes(single_term_title('', false))));
			$term = $wp_query->get_queried_object();
			$og_url = get_term_link($term, $term->taxonomy);
			
		} elseif(is_search()) {
			$og_title = esc_attr(strip_tags(stripslashes(__('Search for', 'flotheme') . ' "' . get_search_query() . '"')));
			$og_url = get_search_link();
			
		} elseif (is_author()) {
			$og_title = esc_attr(strip_tags(stripslashes(get_the_author_meta('display_name', get_query_var('author')))));
			$og_url = get_author_posts_url(get_query_var('author'), get_query_var('author_name'));
			
		} elseif (is_archive()) {
			if (is_post_type_archive()) {
				$og_title = esc_attr(strip_tags(stripslashes(post_type_archive_title('', false))));
				$og_url = get_post_type_archive_link(get_query_var('post_type'));
			} elseif (is_day()) {
				$og_title = esc_attr(strip_tags(stripslashes(get_query_var('day') . ' ' . single_month_title(' ', false) . ' ' . __('Archives', 'flotheme'))));
				$og_url = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
			} elseif (is_month()) {
				$og_title = esc_attr(strip_tags(stripslashes(single_month_title(' ', false) . ' ' . __('Archives', 'flotheme'))));
				$og_url = get_month_link(get_query_var('year'), get_query_var('monthnum'));
			} elseif (is_year()) {
				$og_title = esc_attr(strip_tags(stripslashes(get_query_var('year') . ' ' . __('Archives', 'flotheme'))));
				$og_url = get_year_link(get_query_var('year'));
			}
			
		} else {
			// other situations
		}
	}
	
	if (!$og_desc) {
		$og_desc = $og_title;
	}
	?>
	
	<?php if (flo_get_option('fb_id')) : ?>
		<meta property="fb:app_id" content="<?php flo_option('fb_id')?>" />
	<?php endif; ?>
	<?php if ($og_image) : ?>
		<meta property="og:image" content="<?php echo $og_image ?>" />
	<?php endif; ?>
	<meta property="og:locale" content="<?php echo $og_locale ?> " />
	<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
	<meta property="og:title" content="<?php echo $og_title ?>" />
	<meta property="og:url" content="<?php echo $og_url ?>" />	
	<meta property="og:type" content="<?php echo $og_type ?>" />
	<meta property="og:description" content="<?php echo $og_desc ?>" />
	<?php }
}
add_action('wp_head', 'flo_og_meta');

/**
 * Add OpenGraph attributes to html tag
 * @param type $output
 * @return string 
 */
function flo_add_opengraph_namespace($output) {
	if (flo_get_option('og_enabled')) {
		if (!stristr($output, 'xmlns:og')) {
			$output = $output . ' xmlns:og="http://ogp.me/ns#"';
		}
		if (!stristr($output, 'xmlns:fb')) {
			$output = $output . ' xmlns:fb="http://ogp.me/ns/fb#"';
		}
	}
	
	return $output;
}
add_filter('language_attributes', 'flo_add_opengraph_namespace',9999);

/**
 * Get image for Open Graph Meta 
 * 
 * @return string
 */
function flo_og_meta_image() {
	echo flo_get_og_meta_image();
}
function flo_get_og_meta_image() {
	global $post;
	$thumbdone=false;
	$og_image='';
	
	//Featured image
	if (function_exists('get_post_thumbnail_id')) {
		$attachment_id = get_post_thumbnail_id($post->ID);
		if ($attachment_id) {
			$og_image = wp_get_attachment_url($attachment_id, false);
			$thumbdone = true;
		}
	}
	
	//From post/page content
	if (!$thumbdone) {
		$image = flo_parse_first_image($post->post_content);
		if ($image) {
			preg_match('~src="([^"]+)"~si', $image, $matches);
			if (isset($matches[1])) {
				$image = $matches[1];
				$pos = strpos($image, site_url());
				if ($pos === false) {
					if (stristr($image, 'http://') || stristr($image, 'https://')) {
						$og_image = $image;
					} else {
						$og_image = site_url() . $image;
					}
				} else {
					$og_image = $image;
				}
				$thumbdone=true;
			}
		}
	}
	
	//From media gallery
	if (!$thumbdone) {
		$image = flo_get_first_attached_image($post->ID);
		if ($image) {
			$og_image = wp_get_attachment_url($image->ID, false);
			$thumbdone = true;
		}
	}
	
	return $og_image;
}

/**
 * Load Post AJAX Hook
 */
function flo_load_post() {
	global $withcomments;
	$query = new WP_Query(array(
		'post_type'     => 'post',
		'p'             => (int) $_POST['id'],
		'post_status'   => 'publish',
	));
	while($query->have_posts()){
		$query->the_post();
		flo_part( 'postcontent', 'single');
		flo_part( 'postactions', 'single');
		# force inserting comments in index
		$withcomments = 1;
		comments_template();
	};
	exit;
}
add_action('wp_ajax_flotheme_load_post', 'flo_load_post');
add_action('wp_ajax_nopriv_flotheme_load_post', 'flo_load_post');



/**
 * AJAXify comments
 * @global object $user
 * @param int $comment_ID
 * @param int $comment_status 
 */
function flo_post_comment_ajax($comment_ID, $comment_status) {
	global $user;
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$comment = get_comment($comment_ID);
		
        switch($comment_status){  
            case '0':  
                //notify moderator of unapproved comment  
                wp_notify_moderator($comment_ID);  
            case '1': //Approved comment  
                $post=&get_post($comment->comment_post_ID); //Notify post author of comment  
                if ( get_option('comments_notify') && $comment->comment_approved && $post->post_author != $comment->user_id )  
                    wp_notify_postauthor($comment_ID, $comment->comment_type);  
                break;  
            default:  
                echo json_encode(array(
					'error' => 1,
					'msg'	=> __('Something went wrong. Please refresh page and try again.', 'flotheme'),
				));exit;				
        }
		// save cookie for non-logged user.
		if ( !$user->ID ) {
			$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
			setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
		}
		
		// load a comment to variable
		ob_start();
		flotheme_comment($comment, array('max_depth' => 1), 1);
		$html = ob_get_clean();
		
		echo json_encode(array(
			'html'		=> $html,
			'success'	=> 1,
		));
		exit;
    }  
}
if( !is_admin() ) {
	add_action('comment_post', 'flo_post_comment_ajax', 20, 2);
}

/**
 * Change Wordpress Login Logo 
 */
function flo_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
			background:#fff url(<?php echo get_template_directory_uri() ?>/img/admin-logo.png) 50% 50% no-repeat;
			height:100px;
			background-size: auto auto;
        }
		body.login div#login {
			background:#fff;
		}
		body.login {
			background:#fff
		}
		body.login #backtoblog {
			display:none;
		}
		body.login #nav {
			text-align:center;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'flo_login_logo' );

/**
 * Change login logo URL
 * @return string 
 */
function flo_login_logo_url() {
    return home_url('/');
}
add_filter( 'login_headerurl', 'flo_login_logo_url' );

/**
 * Change login logo title
 * @return string 
 */
function flo_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'flo_login_logo_url_title' );
