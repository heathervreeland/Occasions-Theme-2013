<?php
/* 

This file has some logic that tests to see if we are looking at an archive search of venues nationally or by State/City

*/
	if (substr_count($_SERVER['REQUEST_URI'], '/profile')) {
		wp_redirect(site_url('/venues'));
	}

get_header(); ?>
<?php 
  // these term pulls are for if we are looking at a national search
	$cat = get_term_by('slug', get_query_var('service'), 'service');
  $cat_name = $cat->name;
	$type = get_term_by('slug', get_query_var('venue-type'), 'venue-type');
?>
<div id="main">
	<div class="region-full">
    <?php 
      // logic to determine if we are looking at a national or state/city search
			$region = get_term_by('slug', get_query_var('region'), 'region');
      if ( $region ) :

        // if a state/city search, then show the top-region.php file
        flo_part('top-region'); 

      else:

      // else show the national output
    ?>
		<header class="page-title top-region">
			<hgroup>
        <?php echo insert_venue_header_content(false); ?>
			</hgroup>
		</header>

    <?php

        flo_part('top-no-region'); 

      endif; 

      // back to normal output

      flo_part('featured-vendors-venue') 
    ?>

		<section class="vendors-list">
			<?php flo_part('venueshead') ?>
			<div class="list">
				<?php if (have_posts()): ?>
					<ul id="vendors-list">
						<?php while (have_posts()): the_post(); ?>
							<?php flo_part('venue-loop') ?>
						<?php endwhile; ?>
					</ul>
				<?php endif ?>
			</div>
			<?php flo_part('venuesfoot') ?>
		</section>
	</div>
</div>
<?php get_sidebar('region'); ?>
<?php get_footer(); ?>
