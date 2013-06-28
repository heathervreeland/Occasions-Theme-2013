<?php
get_header(); ?>
<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="advertisers">
			<?php flo_page_title(get_the_title()) ?>
			<div class="upgrade">
				<div class="story">
					<?php the_content()?>
				</div>

				<?php 
				//gravity_form($id_or_title, $display_title=true, $display_description=true, $display_inactive=false, $field_values=null, $ajax=false, $tabindex); 
				?>
				<?php
					gravity_form('Advertiser Subscription', false, false);
				?>

				<div class="notes">
					<?php $page = get_page_by_path('advertisers/upgrade/upgrade-notes'); ?>
					<?php echo apply_filters('the_content', $page->post_content); ?>
				</div>
			</div>
		</div>
	<?php endwhile; else: ?>
		<?php flo_part('notfound')?>
	<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>