
<?php 
	$blog_title = 'Blog'; 
	$has_top_category = false;
	
	if (is_author()) {
		$blog_title = '';
	} elseif (is_category()) {
		$cat_id = get_query_var('cat');
		$category = get_category($cat_id);
		$blog_title = $category->name;
		if ($category->parent) {
			$top_category = get_category($category->parent);
		}

	} elseif (is_search()) {
		$blog_title = sprintf( __( 'Results for: %s', 'flotheme' ),  get_search_query());
	} elseif (is_tag()) {
		$blog_title = single_tag_title( '', false );
	} elseif (is_archive()) {
		if (is_day()) {
			$blog_title = sprintf( __( '%s', 'flotheme' ), '<span>' . get_the_date() . '</span>' );
		} elseif (is_month()) {
			$blog_title = sprintf( __( '%s', 'flotheme' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'flotheme' ) ) . '</span>' );
		} elseif (is_year()) {
			$blog_title = sprintf( __( '%s', 'flotheme' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'flotheme' ) ) . '</span>' );
		} else {
			$blog_title = 'Archives';
		}
	}
?>

<?php if ($blog_title): ?>
<header class="page-title page-title-container cf">
	<hgroup>
		<?php if (is_single()): ?>
<?php /*
			<?php
				$regions = wp_get_post_terms(get_the_ID(), 'region');
				$categories = wp_get_post_categories(get_the_ID());
			?>
			<?php if (count($regions)): ?>
				<h2><?php flo_post_state(); ?></h2>	
				<span>»</span><h3><?php flo_post_city(); ?></h3>
			<?php else: ?>
				<h2><?php flo_post_section(); ?></h2>	
				<span>»</span><h3><?php flo_post_first_category(); ?></h3>
			<?php endif ?>
*/?>
			<h2><?php flo_post_section(); ?></h2>	
			<span>»</span><h3><?php flo_post_first_category(); ?></h3>


		<?php else: ?>

			<?php if ($top_category): ?>
				<h2><a href="<?php echo get_category_link($top_category); ?>"><?php echo $top_category->name; ?></a></h2>
				<span>&raquo;</span>
				<h3><?php echo $blog_title; ?></h3>	
			<?php else: ?>
				<h2><?php echo $blog_title; ?></h2>		
			<?php endif ?>

			
		<?php endif ?>
	</hgroup>
	<div class="box">
		<?php /*
		<div class="bottom-archives">
			<select name="archives">
				<option value="">Archives</option>
				<?php wp_get_archives(array('format' => 'option')) ?>
			</select>
		</div>
		*/?>
		<?php if (!is_single()): ?>
			<?php flo_part('category-dropdown'); ?>
		<?php endif ?>
	</div>
</header>
<?php endif ?>

<?php if (is_author() && have_posts()): the_post(); ?>
	<section class="author-box">
		<header class="page-title">
			<h2>
				<span class='vcard'><?php the_author() ?></span>
			</h2>
		</header>
		<div class="wrapper cf">
			<figure>
				<?php 
					echo get_avatar(get_the_author_ID(), 205);
					//the_author_image(); 
				?>
			</figure>
			<div class="detail">
				<div class="story">
					<?php echo apply_filters('the_content', get_the_author_description()) ?>
				</div>
				<ul class="social">
					<?php if (get_the_author_meta('url')): ?>
						<li>
							<a href="<?php the_author_meta('url') ?>" rel="external" class="url">Visit <?php the_author_firstname() ?>'s website</a>
						</li>
					<?php endif; ?>
					<?php if (get_the_author_meta('twitter')): ?>
						<li>
							<a href="http://twitter.com/<?php echo get_the_author_meta('twitter') ?>" rel="external" class="twi">Follow <?php the_author_firstname() ?> on Twitter</a>
						</li>
					<?php endif ?>
				</ul>
			</div>
		</div>
	</section>
<?php rewind_posts(); endif; ?>