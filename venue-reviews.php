<div class="reviews">
<section class="review-list">
	<header class="reviews-head cf">
		<h3>Customer Reviews</h3>
	</header>
	<?php if (have_comments()) : ?>
		<ol>
			<?php wp_list_comments(array('callback' => 'flotheme_review', 'max_depth' => 1)); ?>
		</ol>
	<?php else: ?>
		<p class="empty">No Reviews Yet</p>
	<?php endif; ?>

	<a href="#" class="btn" id="venue-leave-a-review">Leave a review</a>
</section>
<?php if (comments_open()) : ?>
	<section class="respond cf">
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="comment-form">

			<p class="error"></p>
			<div class="area1 cf">
				<p>
					<label for="author">*<?php _e('Name', 'flotheme'); ?></label>
				<input type="text" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> required="required">
				</p>
				<p>
					<label for="email">*<?php _e('Email', 'flotheme'); ?></label>
				<input type="email" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> required="required" email="true">
				</p>
			</div>
			<div class="area2">
				<label for="comment">*<?php _e('Your Review', 'flotheme'); ?></label>
				<textarea name="comment" id="comment" class="input-xlarge" tabindex="4" rows="5" cols="40" required="required"></textarea>
			</div>
			<div class="area3">
				<label>Rating</label>
				<p>
					<?php for($i=5;$i>=1;$i--): ?>
						<label class="opt"><input type="radio" <?php echo $i == 5 ? 'checked="checked"' : ''?> name="rating" value="<?php echo $i ?>" /> <span class="stars stars<?php echo $i ?>"></span></label>
					<?php endfor;?>
				</p>
			</div>	
			<div class="cf"></div>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			<div class="button">
				<input name="submit" class="submit" type="submit" tabindex="5" value="<?php _e('Submit Review', 'flotheme'); ?>" />
			</div>
		</form>
	</section>
<?php endif; ?>
</div>