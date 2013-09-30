<?php get_header(); ?>
<div id="main" class="search">
  <header class="page-title page-title-container cf">
    <hgroup>
      <h1>Search Results</h1>
    </hgroup>
  </header>
	<section class="blog">
<section class="vendor results">
<h2 class="results-title">Vendors</h2>
<?php
  //venues
  $s = isset($_GET["q"]) ? $_GET["q"] : "";
  $args = array(
    'post_type' => 'venue',
    'post_status' => 'publish',
  );
  //search post_meta field 'flo_description' for venues.
  $args['meta_query'][] = array(
    'key' => 'flo_description',
    'value' => $s,
    'compare' => 'LIKE',
  );

  $posts = new WP_Query($args);
  $num = $posts->found_posts?$posts->found_posts:"0";
  echo "<h3>We found ".$num." vendors matching your search.</h3>";
if ( $posts->have_posts() ) :
    $j-1;
    while ( $posts->have_posts() && $j < 5 ) : $posts->the_post();
      $post_id = get_the_id();
      $permalink = get_permalink($post_id);
      if(has_post_thumbnail($post_id)) {
        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        $img_url = wp_get_attachment_url( $post_thumbnail_id  );
        $thumblink = '<a href="' . $permalink . '">' . '<img src="' . $img_url . '" class="alignleft" title="' . $post->title . '"></a>';
      }   
      echo "<article class=\"search-item cf\">";
      echo $thumblink;
      echo "  <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
      echo "  <p>";
      echo strip_tags(substr(strip_shortcodes($post->flo_description),0,150) ) . " ... <a href=\"" . $permalink . "\">Read More &rarr;</a>";
      echo "  </p>";
      echo "</article>";
      $j++;
    endwhile;
    echo ($j<$num)?"<h3><a href=\"/search/page/1/?q={$s}&type=venue\" title=\"View more venue search results\" style=\"float:right\">View more venue search results</a></h3>":"";
  else :
    echo "<p>No Vendors were found</p>";
    wp_reset_postdata();
  endif;

  ?>

</section>
<section class="blog-search results">
<h2 class="results-title">Posts</h2>
<?php
  //posts
  $s = isset($_GET["q"]) ? $_GET["q"] : ""; 
  $posts = new WP_Query("s=$s&post_type=post&posts_per_page=10");
  $num = $posts->found_posts?$posts->found_posts:"0";
  echo "<h3>We found ".$num." articles matching your search.</h3>";
  if ( $posts->have_posts() ) :
    $i-1;
    while ( $posts->have_posts() && $i < 5 ) : $posts->the_post();
      $post_id = get_the_id();
      $permalink = get_permalink($post_id);
      if(has_post_thumbnail($post_id)) {
        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        $img_url = wp_get_attachment_url( $post_thumbnail_id  );
        $thumblink = '<a href="' . $permalink . '">' . '<img src="' . $img_url . '" class="alignleft" title="' . $post->title . '"></a>';
      }
      echo "<article class=\"search-item cf\">";
      echo $thumblink;
      echo "  <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
      echo "  <p>";
      echo strip_tags(substr(strip_shortcodes($post->post_content),0,150)) . ' ... <a href="' . $permalink . '">Read More &rarr;</a>';
      echo "  </p>";
      echo "</article>";
      $i++;
    endwhile;
    echo ($i<$num)?"<h3 class=\"search-more\"><a href=\"/search/page/1/?q={$s}&type=post\" title=\"View more article search results\">View more article search results</a></h3>":"";
  else :
  echo "<p>No Posts were found</p>";
    wp_reset_postdata();              
  endif;
?>
</section>
  <?php /* <!-- Put the following javascript before the closing </head> tag. -->
		<script>
		(function() {
			var cx = '006251671436250040014:02mnuelawn0';
			var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
			gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			    '//www.google.com/cse/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
		})();
		</script>

		<!-- Place this tag where you want both of the search box and the search results to render -->
		<gcse:search></gcse:search>
		  */ ?>
	</section>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>      
