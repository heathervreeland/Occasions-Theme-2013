<!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes('html'); ?> class="no-js ie ie6 oldie" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes('html'); ?> class="no-js ie ie7 oldie" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes('html'); ?> class="no-js ie ie8 oldie" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes('html'); ?> class="no-js ie ie9" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><![endif]-->
<!--[if gt IE 9 ]><html <?php language_attributes('html'); ?> class="no-js ie" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><![endif]-->
<!--[if !IE ]><!--> <html <?php language_attributes('html'); ?> class="no-js" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"> <!--<![endif]-->
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title('|', true, 'right'); ?></title>
	<link href='http://fonts.googleapis.com/css?family=Libre+Baskerville:400italic' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<!--[if lt IE 8]><p class="chromeframe">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
		<header id="header-main">
			<div class="nav-top-wrapper">
				<nav id="nav-top" class="w cf" role="navigation">
					<a href="<?php echo home_url('/') ?>" class="pinapple">Home</a>
					<div id="search-form">
						<label for="">Search</label>
						<?php get_search_form(true); ?>	
					</div>

					<?php if (is_user_logged_in()) : ?>
						<?php if (current_user_can('manage_options')): ?>
							<!--a href="<?php //echo admin_url() ?>" class="register">Dashboard</a-->	
						<?php else: ?>
							<!--a href="<?php //echo home_url('advertisers/dashboard'); ?>" class="register">Dashboard</a-->
						<?php endif ?>
					<?php else: ?>
						<!--a href="<?php //echo home_url('advertisers/login'); ?>" class="register">Sign In / Register</a-->
					<?php endif; ?>

					<div class="local-edition">
						<a href="#">Local Editions</a>
						<ul class="submenu">
							<?php //$regions = flo_get_regions_links(false); ?>
							<?php foreach (array('florida', 'georgia') as $state): ?>
							<?php //foreach ($regions as $state) : ?>
								<li><a href="<?php echo site_url($state); ?>"><?php echo $state; ?></a></li>
							<?php endforeach; ?>							
						</ul>
					</div>

							
          <div class="follow cf">
            <?php flo_part('social-media-icons') ?>
          </div>
          <div class="mediakit-link"><a href="http://mediakit.occasionsonline.com/">ADVERTISE</a></div>
				</nav>
			</div>

			

			<div id="head-main" class="w cf">
				<h1><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
				
        <div id="subscribe-banner-head">
          <ul>
					<?php wp_nav_menu(array(
						'menu'=> 'header',
						'items_wrap'	=> '%3$s',
						'depth'			=> 1,
						'walker'		=> new Flotheme_Nav_Walker(),
						'container'		=> '',
					)); ?>
          </ul>
        </div>

				<div id="services-venues" class="services-venues">
					<span class="label"></span>
					<div class="regions">
						<span class="select">In your area</span>
						<?php $regions = flo_get_regions_links(false); ?>
						<div class="list">
							<ul>
								<?php foreach($regions as $state):?>
									<?php if(count($state->cities)) : ?>
										<li>
											<span><?php echo $state->name ?></span>
											<ol>
												<?php foreach($state->cities as $city):?>
													<li>
														<a href="<?php echo get_term_link($city) ?>"><?php echo $city->name ?></a>
													</li>
												<?php endforeach;?>
											</ol>
										</li>
									<?php endif;?>
								<?php endforeach;?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php flo_part('nav-main') ?>
      
      <?php show_secondary_nav(); ?>
      
		</header>
		<div class="content-main-wrapper">
		<div id="content-main" role="main" class="cf w">

      <div class="content-inner-wrap cf">
