<?php
	// do not load hidden images
	$_attached = flo_get_attached_images(get_the_ID(), false);
	$attached = array();
	foreach ($_attached as $attachment) {
		$attached[] = $attachment;
	}
	unset($_attached);

	$current = isset($_GET['slide']) ? (int) $_GET['slide'] : 0;
	if (!$attached[$current]) {
		$keys = array_keys($attached);
		$current = $keys[0];
	}
	$image = $attached[$current];

	if (!count($attached)) {
		return;
	}
?>

<div class="gallery-image">
	<figure>
		<?php echo wp_get_attachment_image($image->ID, 'post-preview')?>
		<?php if ($image->post_content): ?>
			<figcaption>
				<?php echo nl2br($image->post_content) ?>
			</figcaption>
		<?php endif ?>
	</figure>
	<?php if (flo_get_media_meta('credits', $image->ID)): ?>
		<p class="credits">
			<?php flo_media_meta('credits', $image->ID) ?>
		</p>
	<?php endif ?>
	<div class="arrows cf">
		<?php if (isset($attached[$current - 1])): ?>
			<a href="<?php the_permalink() ?>?slide=<?php echo $current - 1 ?>" class="prev">Previous</a>
		<?php endif ?>
		<?php if (isset($attached[$current + 1])): ?>
			<a href="<?php the_permalink() ?>?slide=<?php echo $current + 1 ?>" class="next">Next</a>
		<?php endif ?>
	</div>
</div>
<?php if (count($attached > 1)): ?>
	<div class="thumbs">
		<div id="post-thumbnails" class="flexslider cf" data-current="<?php echo $current; ?>">
			<ul class="slides">
				<?php foreach($attached as $k => $image):?>
					<li <?php echo $k == $current ? 'class="flex-active-slide"' : ''?>><a href="<?php the_permalink() ?>?slide=<?php echo $k ?>"><?php echo wp_get_attachment_image($image->ID, 'post-gthumbnail')?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
<?php endif ?>