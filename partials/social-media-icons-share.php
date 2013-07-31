<ul>
  <li><a href="#" onclick="window.open( 'https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>', 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="icon-facebook icon-large"></i></a></li>
  <li><a onclick="window.open('https://twitter.com/share?url=<?php the_permalink(); ?>', 'twitter-share', 'width=626,height=436'); return false;" href="#" data-text="<?php the_title(); ?>" data-count="none"><i class="icon-twitter icon-large"></i></a></li>
  <li><a onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>&media=<?php the_permalink(); ?>', 'google-plus-share', 'width=626,height=436'); return false;" href="#" target="_blank"><i class="icon-google-plus  icon-large"></i></a></li>
  <li><a href="<?php flo_rss();?>" rel="external"  target="_blank"><i class="icon-rss icon-large"></i></a></li>
</ul>


