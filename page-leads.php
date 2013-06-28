<?php get_header(); ?>
<div id="main" class="leads">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="page">
		<?php flo_page_title(get_the_title()) ?>
		<article <?php post_class(); ?>>
			<section class="story">
				<?php the_content();?>
			</section>

			<ul>
				<?php
					$advertiser = new Flotheme_Advertiser();
					$term = $advertiser->profile()->service();
					$services = array($term->term_taxonomy_id);
				?>
				<?php 
				    $leads = flo_get_leads_by_services($services);
				    if (count($leads)) : foreach ($leads as $lead) : 
				?>
				<li class="lead">
					<dl class="cf">
					    <dt>Name:</dt> 
				    	<dd><?php echo $lead[1]; ?></dd>
					    <dt>E-mail:</dt> 
				    	<dd><?php echo $lead[2]; ?></dd>
					    <dt>Address:</dt> 
				    	<dd>
				    		<?php $i=6; while($i>=1) { ?>
				    			<?php if ($lead['3.'.$i] != '') echo $lead['3.'.$i].' '; ?>
				    		<?php $i--; } ?>
				    	</dd>
					    <dt>Phone:</dt> 
				    	<dd><?php echo $lead[4]; ?></dd>
					    <dt>Event Date:</dt> 
				    	<dd><?php echo $lead[5]; ?></dd>
					    <dt>Referer:</dt> 
				    	<dd><?php echo $lead[7]; ?></dd>
					    <dt>Notes\Comments:</dt> 
				    	<dd><?php echo $lead[8]; ?></dd>
					</dl>
				</li>
				<?php endforeach; else: ?>
					<p>No leads currently.</p>
				<?php endif; ?>
			</ul>
		</article>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>