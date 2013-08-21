<?php get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="subscribe">
		<?php flo_page_title(get_the_title()) ?>

		<section class="annual">
			<figure>
				<?php the_post_thumbnail('full') ?>
			</figure>
			<div class="detail">
				<h2>Annual Print Subscription</h2> 
				<p class="descr">
					Occasions Magazine IS the magazine for celebrating in style. The tri-annual publication showcases the best of the best in Atlanta weddings, mitzvahs, parties and celebrations. 
				</p>

				<div class="select-box">
					<select name="annual-region" id="subscribe-annual-region">
						<option value="flo">Florida</option>
						<option value="ga">Georgia</option>
					</select>
				</div>

				<div class="flo">
					<?php flo_issue_cart_form('OOANNUALFLO', true); ?>
				</div>
				<div class="ga">
					<?php flo_issue_cart_form('OOANNUALGA', true); ?>
				</div>
				<?php //echo do_shortcode('[add_to_cart item="' . $annual_product_id . '" showprice="yes" text="' . __('Buy Now', 'flotheme') . '"]'); ?>
			</div>
		</section>

		<?php $issues_query = new WP_Query(array(
			'post_type' 		=> 'issue',
			'order'				=> 'DESC',
			'orderby'			=> 'rank',
			'posts_per_page' 	=> -1,
		)); ?>
		<?php if ($issues_query->have_posts()): ?>
			<section class="issues">
				<ul>
					<?php while($issues_query->have_posts()): $issues_query->the_post(); ?>
						<li class="cf">
							<?php if (flo_get_meta('premier')): ?>
								<span class="premier">Premier Issue</span>
							<?php endif ?>
							<figure>
								<?php the_post_thumbnail('issue-preview'); ?>
							</figure>
							<div class="detail">
								<h2><?php the_title(); ?></h2>
								<p class="region">Region: <?php flo_meta('region') ?></p>
								<p class="descr">
									<?php echo nl2br(flo_get_meta('info')) ?>
								</p>
								<?php if (flo_get_meta('soldout')): ?>
									<p class="soldout">Sold Out</p>
								<?php else: ?>
									<?php
										$copy = flo_get_meta('single');
										$box = flo_get_meta('box');
									?>
									<?php if ($copy): ?>
										<?php flo_issue_cart_form($copy, true); ?>
									<?php endif ?>
									<?php if ($box): ?>
										<?php flo_issue_cart_form($box, true); ?>
									<?php endif ?>
								<?php endif ?>
							</div>
						</li>
					<?php endwhile;?>
				</ul>
			</section>
		<?php endif ?>

		<?php flo_part('featured-vendors') ?>

	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('subscribe'); ?>
<?php get_footer(); ?>
