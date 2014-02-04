<div class="nav-main-wrapper">
	<nav id="nav-main" role="navigation" class="w cf">
		<ul>
			<?php
				$section = flo_get_nav_section('weddings');
			?>
			<li class="area">
				<a href="<?php flo_permalink('vendors') ?>">Vendors &amp; Venues</a>
			</li>
			<li class="weddings">
				<a href="<?php echo $section['permalink'] ?>">Weddings</a>
				<div class="submenu cf">
					<div class="sections">
						<h3>Departments</h3>
						<figure>
							<?php if (isset($section['section']->image_src)): ?>
								<img src="<?php echo $section['section']->image_src ?>" alt="" />
							<?php endif ?>
						</figure>
						<ul class="list">
							<?php foreach ($section['children'] as $term): ?>
								<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach ?>
							<li class="full"><a href="<?php echo $section['permalink'] ?>" class="btn">Go to weddings</a></li>
						</ul>
					</div>
					<div class="featured">
						<h3>Featured Posts</h3>
						<ul>
							<?php foreach ($section['featured'] as $entry): ?>
								<li>
									<a href="<?php echo get_permalink($entry->ID) ?>" class="cf">
										<span class="image">
											<?php flo_post_thumbnail('post-gthumbnail', $entry->ID); ?>
										</span>
										<span class="content">
											<span class="title"><?php echo $entry->post_title ?></span>
											<time  datetime="<?php echo get_the_time('Y-m-d', $entry) ?>"><?php echo get_the_time('F d, Y', $entry) ?></time>
										</span>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</li>
			<?php
				$section = flo_get_nav_section('parties-and-celebrations');
			?>
			<li class="parties">
				<a href="<?php echo $section['permalink'] ?>">Parties &amp; Celebrations</a>
				<div class="submenu cf">
					<div class="sections">
						<h3>Departments</h3>
						<figure>
							<?php if (isset($section['section']->image_src)): ?>
								<img src="<?php echo $section['section']->image_src ?>" alt="" />
							<?php endif ?>
						</figure>
						<ul class="list">
							<?php foreach ($section['children'] as $term): ?>
								<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach ?>
							<li class="full"><a href="<?php echo $section['permalink'] ?>" class="btn">Go to parties</a></li>
						</ul>
					</div>
					<div class="featured">
						<h3>Featured Posts</h3>
						<ul>
							<?php foreach ($section['featured'] as $entry): ?>
								<li>
									<a href="<?php echo get_permalink($entry->ID) ?>" class="cf">
										<span class="image">
											<?php flo_post_thumbnail('post-gthumbnail', $entry->ID); ?>
										</span>
										<span class="content">
											<span class="title"><?php echo $entry->post_title ?></span>
											<time datetime="<?php echo get_the_time('Y-m-d', $entry) ?>">
												<?php echo get_the_time('F d, Y', $entry) ?>
											</time>
										</span>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</li>
			<?php
				$section = flo_get_nav_section('entertaining-and-holidays');
			?>
			<li class="home">
				<a href="<?php echo $section['permalink'] ?>">Entertaining &amp; Holidays</a>
				<div class="submenu cf">
					<div class="sections">
						<h3>Departments</h3>
						<figure>
							<?php if (isset($section['section']->image_src)): ?>
								<img src="<?php echo $section['section']->image_src ?>" alt="" />
							<?php endif ?>
						</figure>
						<ul class="list">
							<?php foreach ($section['children'] as $term): ?>
								<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach ?>
							<li class="full"><a href="<?php echo $section['permalink'] ?>" class="btn">Go to entertaining</a></li>
						</ul>
					</div>
					<div class="featured">
						<h3>Featured Posts</h3>
						<ul>
							<?php foreach ($section['featured'] as $entry): ?>
								<li>
									<a href="<?php echo get_permalink($entry->ID) ?>" class="cf">
										<span class="image">
											<?php flo_post_thumbnail('post-gthumbnail', $entry->ID); ?>
										</span>
										<span class="content">
											<span class="title"><?php echo $entry->post_title ?></span>
											<time datetime="<?php echo get_the_time('Y-m-d', $entry) ?>">
												<?php echo get_the_time('F d, Y', $entry) ?>
											</time>
										</span>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</li>
			<li class="galleries"><a href="<?php flo_permalink('galleries') ?>">Galleries</a></li>
		</ul>
	</nav>
</div>
