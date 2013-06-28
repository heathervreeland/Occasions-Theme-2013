<?php $parent=0; if (is_category()) { $current_category = get_query_var('cat'); $current_category = get_category( $current_category ); $parent = $current_category->parent; } ?>
<?php if ($parent): ?>
	<div class="categories">
		<?php wp_dropdown_categories(array(
			'hide_empty' => false,
			'show_option_none' => 'Choose a Department',
			'exclude' => '1',
			'selected' => '-1',
			'hierarchical' => 1,
			'depth' => 1,
			'parent' => $parent,
			'walker' => new Flotheme_Walker_CategoryDropdown(),
		)); ?>
	</div>
<?php endif ?>