<header class="cf">
	<p class="count"><?php echo $wp_query->found_posts ?> Vendor<?php echo $wp_query->found_posts == 1 ? '' : 's' ?> Found</p>
	<div class="refine">
		<a href="#">Refine Search</a>
	</div>
	<div class="cf"></div>
	<div class="searchbox <?php echo isset($_GET['keyword']) ? 'visible' : '' ?>">
		<div class="search-wrap cf">
			<form action="" method="get">
				<fieldset class="cf">
					<span class="by">Find vendor by</span>
					<input type="text" value="<?php echo get_query_var('s') ?>" name="keyword" placeholder="Keyword" class="keyword" />
					<?php /*
					<select name="rating">
						<option value="">Select Rating</option>
						<?php for ($i = 1;$i <=5; $i++) :?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php endfor;?>
					</select>
					*/?>
					<input type="submit" value="Submit" />
				</fieldset>
			</form>
		</div>
	</div>
</header>