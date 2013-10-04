      </div><!-- /content-inner-wrap -->
      <?php show_fixed_left_nav(); ?>
		</div><!-- /#content -->
	</div>
	<div id="responsive-footer">
		
	</div>
	<div class="footer-main-wrapper">
		<footer id="footer-main" class="w" role="contentinfo">
			<div class="follow cf">
				<span>Follow Us</span>
        <?php flo_part('social-media-icons') ?>
				<?php //get_search_form(); ?>
			</div>

			<div id="signup">
				<?php $subscription = 'OccasionsMagazine'; ?>
                <form method="post" action="https://app.icontact.com/icp/signup.php" name="icpsignup" id="icpsignup3939" accept-charset="UTF-8" onsubmit="return verifyRequired3939();" >
                <input type="hidden" name="redirect" value="http://www.occasionsonline.com/newsletter/thank-you/">
                <input type="hidden" name="errorredirect" value="http://www.icontact.com/www/signup/error.html">
	            	<label for="subscription_email">NEWSLETTER</label>
                <input class="subscription_email" id="sub_email"  type="text" name="fields_email" placeholder="your email" >
                <input type="hidden" name="listid" value="79427">
                <input type="hidden" name="specialid:79427" value="SSDD">
                <input type="hidden" name="clientid" value="1194751">
                <input type="hidden" name="formid" value="3939">
                <input type="hidden" name="reallistid" value="1">
                <input type="hidden" name="doubleopt" value="0">

	        		<input type="submit" value="subscribe" id="sub_submit" />
	        	</form>							
			</div>

			<a href="#" id="to-top">To Top</a>

			<div class="cf"></div>

			<div id="footer-nav">
				<div class="block weddings">
					<?php
						$section = flo_get_nav_section('weddings');
					?>		
					<h3>Weddings</h3>					
					<ul>
						<?php foreach ($section['children'] as $term): ?>
							<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
						<?php endforeach ?>						
					</ul>
				</div>

				<div class="block parties">
					<?php
						$section = flo_get_nav_section('parties-and-celebrations');
					?>
					<h3>Parties &amp; Celebrations</h3>					
					<ul>
						<?php foreach ($section['children'] as $term): ?>
							<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
						<?php endforeach ?>
					</ul>
				</div>

				<div class="block entertaining">
					<?php
						$section = flo_get_nav_section('entertaining-and-holidays');
					?>
					<h3>Entertaining &amp; Holidays</h3>					
					<ul>
						<?php foreach ($section['children'] as $term): ?>
							<li><a href="<?php echo get_category_link($term); ?>"><?php echo $term->name; ?></a></li>
						<?php endforeach ?>
					</ul>
				</div>

				<div class="block local">
					<h3>Local Editions</h3>					
					<ul>
						<?php foreach (array('florida', 'georgia') as $state): ?>
							<li><a href="<?php echo site_url('local/'.$state); ?>"><?php echo $state; ?></a></li>
						<?php endforeach; ?>							
					</ul>
				</div>	

				<div class="block main">
					<h3>Occasions</h3>			

					<ul>		
					<?php wp_nav_menu(array(
						'theme_location'=> 'footer_menu',
						'items_wrap'	=> '%3$s',
						'depth'			=> 1,
						'walker'		=> new Flotheme_Nav_Walker(),
						'container'		=> '',
					)); ?>
					<?php wp_nav_menu(array(
						'menu'=> 'header',
						'items_wrap'	=> '%3$s',
						'depth'			=> 1,
						'walker'		=> new Flotheme_Nav_Walker(),
						'container'		=> '',
					)); ?>
						<li>&nbsp;</li>
						<li>
						<?php if (flo_get_option('copyrights')) : ?>
							<?php echo flo_option('copyrights'); ?>
						<?php else: ?>
							&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
						<?php endif; ?>							
						</li>
						<li>&nbsp;</li>
						<li><?php //_e('Made By', 'flotheme'); ?> <a href="http://flosites.com" rel="external"><?php //_e('Flosites', 'flotheme'); ?></a></li>
					</ul>
				</div>	

				<div class="cf"></div>

			</div>
		</footer>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
