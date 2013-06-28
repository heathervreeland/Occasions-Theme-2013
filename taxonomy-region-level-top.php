<?php 
	// wp_redirect(flo_get_permalink('map'));
	// exit;
?>

<?php get_header(); ?>
<?php 
	$region = get_term_by('slug', get_query_var('region'), 'region');
	if ($region->parent) {
		$state = get_term($region->parent, 'region');
	} else {
		$state = $region;
		$region = false;
	}
?>

<div id="main">
	<div id="region" class="region-full region-level-top" data-place="<?php echo $state->name ?>">
		<header class="page-title">
			<ul>
				<li class="head">
					<span><?php echo $state->name ?></span>
				</li>
				<li>
					<a href="#">City Guides</a>
					<ul class="sub">
						<li class="top"><a href="#"><?php echo $state->name ?></a></li>
						<?php $cities = get_state_cities($state); //var_dump($cities); ?>
						<?php foreach ($cities as $city) : ?>
						<li><a href="<?php echo get_term_link( $city ); ?>"><?php echo $city->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li>
					<a href="#">Venues</a>
					<ul class="sub">
						<?php 
							$venues = get_terms('venue-type', array(
								'hide_empty' => false,
							));
						?>
						<?php foreach ($venues as $venue): ?>
							<li>
								<a href="<?php echo flo_region_venue_permalink($state, $venue->slug, 'venues') ?>"><?php echo $venue->name ?></a>
							</li>
						<?php endforeach ?>						
					</ul>					
				</li>
				<li>
					<a href="#">Vendors</a>
					<ul class="sub">
						<?php 
							$vendors = get_terms('service', array(
								'hide_empty' => false,
							));
						?>
						<?php foreach ($vendors as $vendor): ?>
							<li>
								<a href="<?php echo flo_region_venue_permalink($state, $vendor->slug, 'services') ?>"><?php echo $vendor->name ?></a>
							</li>
						<?php endforeach ?>						
					</ul>						
				</li>					
				<li>
					<a href="<?php echo flo_region_events_permalink($state); ?>">Events</a>
				</li>							
			</ul>
		</header>

		<?php
			$rargs = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'norewrite' => true,
				'tax_query' => array(
					array(
						'taxonomy' => 'region',
						'field' => 'slug',
						'terms' => $state->slug
					),
				),
			);		
		?>			
		<?php $posts_query = new WP_Query($rargs); ?>
		<?php if (count($posts_query->posts)) : ?>
		<section class="recent">
			<?php while($posts_query->have_posts()): $posts_query->the_post(); ?>
				
			<article <?php post_class(); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
				<header class="preview">
					<div class="title cf">
						<span class="by-author">
							<a href="<?php echo get_author_posts_url(get_the_author_ID()) ?>" rel="author"><?php echo get_avatar(get_the_author_meta('email'), 58 ); ?></a>
						</span>
						<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title();?></a></h2>
						<div class="meta">
							Posted 
							<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format'));?></time>
							by 
							<a href="<?php echo get_author_posts_url(get_the_author_ID()) ?>" rel="author"><?php the_author() ?></a>
							|
							<span class="categories"><?php the_category(', '); ?></span>
							|
							<a href="<?php comments_link(); ?>"><?php comments_number( 'Post the First Comment', 'One Comment' );?></a>
						</div>
					</div>
				</header>				
				<section class="story cf">
					<?php if ($_REQUEST['nggpage'] == '') : ?>
						<?php add_filter('the_content','flo_wrap_image_credits'); ?>
						<?php the_content(); ?>
						<?php remove_filter('the_content','flo_wrap_image_credits'); ?>
					<?php else: ?>
						<?php preg_match('/\[nggallery.+id=\d+\]/i', $post->post_content, $ngg); ?>
						<?php echo do_shortcode( $ngg[0] ); ?>
					<?php endif; ?>
				</section>
				<?php if (has_post_format('gallery')) : ?>
					<?php flo_part('post-gallery') ?>
				<?php endif; ?>
				<?php wp_link_pages(array(
					'before' => '<section class="story-pages"><p>' . __('Pages:', 'flotheme'),
					'after'	 => '</p></section>',
				)) ?>
				<div class="share">
					<span>Share This Post</span>
					<div class="fb-like" data-href="<?php the_permalink()?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
					<div class="plus1"><g:plusone size="medium" href="<?php the_permalink()?>"></g:plusone></div>
					<div class="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink()?>" data-count="horizontal">Tweet</a></div>
					<div class="pin"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php flo_og_meta_image() ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>
				</div>
				<?php comments_template(); ?>
			</article>


			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</section>
		<?php endif; ?>
		
	</div>
</div>
<?php get_sidebar('region-top'); ?>
<?php get_footer(); ?>
