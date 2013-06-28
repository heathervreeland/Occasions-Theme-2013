<footer class="page-foot page-foot-container cf">
	<div class="pagination">
		<?php wp_pagenavi(); ?>
	</div>
	<?php if (!is_author()): ?>
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
	<?php endif ?>
</footer>