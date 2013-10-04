<?php get_header(); ?>
<div id="main">
	<?php flo_part('bloghead') ?>
	<section class="blog">

<?php
$uri_array = explode( '/', $_SERVER['REQUEST_URI'] );
$paged = $uri_array[3] ? $uri_array[3] : 1;
if(!isset($_GET["type"])) { $_GET["type"] = "post"; }
  if($_GET["type"] == "post") {
    $s = isset($_GET["q"]) ? $_GET["q"] : "";
    $posts = new WP_Query("s=$s&post_type=post&posts_per_page=10&paged=$paged");
    $num = $posts->found_posts?$posts->found_posts:"0";
    if ( $posts->have_posts() ) :
      while ( $posts->have_posts() && $i < 5 ) : $posts->the_post();
        $permalink = get_permalink($post->ID);
        if(has_post_thumbnail($post->ID)) {
          //$attr = array('alt'=>$post->post_title,'align'=>'left','style'=>'padding-right:10px;padding-bottom:10px;');
          $attr = array('alt'=>$post->post_title,'class'=>'alignleft');
          $thumblink = "<a href=\"$permalink\">".get_the_post_thumbnail($post->ID,'thumbnail',$attr)."</a>";
        }
        echo $thumblink;
        echo " <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
        echo "<p>";
        echo substr(strip_shortcodes($post->post_content),0,150) . " ... <a href=\"" . $post->guid . "\">Read More &rarr;</a>";
        echo "</p>";
        echo '<br clear="left" />';
      endwhile;
    else :
      echo "<p>No Posts were found</p>";
      wp_reset_postdata();
  endif;

} else if($_GET["type"] == "venue") {

?>

<h1 style="padding-top:20px;">Vendors</h1>
<?php
  //vardump(explode( '/', $_SERVER['REQUEST_URI'] ));
//venues
  //$uri_array = explode( '/', $_SERVER['REQUEST_URI'] );
  //$paged = $uri_array[3] ? $uri_array[3] : 1;
  $s = isset($_GET["q"]) ? $_GET["q"] : "";
  $args = array(
    'post_type' => 'venue',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'paged' => $paged,
  );
  //search post_meta field 'flo_description' for venues.
  $args['meta_query'][] = array(
    'key' => 'flo_description',
    'value' => $s,
    'compare' => 'LIKE',
  );

  $posts = new WP_Query($args);
  $num = $posts->post_count?$posts->post_count:"0";
  //echo "<h3>We found ".$num." vendors matching your search.</h3>";
  if ( $posts->have_posts() ) :
    while ( $posts->have_posts() && $j < 5 ) : $posts->the_post();
      $permalink = get_permalink($post->ID);
      if(has_post_thumbnail($post->ID)) {
        $attr = array('alt'=>$post->post_title,'align'=>'left','style'=>'padding-right:10px;padding-bottom:10px;');
        $thumblink = "<a href=\"$permalink\">".get_the_post_thumbnail($post->ID,'thumbnail',$attr)."</a>";
      }
      echo $thumblink;
      echo " <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
      echo "<p>";
      echo substr(strip_shortcodes($post->flo_description),0,150)." ... ";
      echo "</p>";
      echo '<br clear="left" />';
    endwhile;
  else :
  echo "<p>No Vendors were found</p>";
  wp_reset_postdata();

  endif;
}
?>
<br />&nbsp;<br />
<footer class="page-foot page-foot-container cf">
  <div class="pagination">
    <?php wp_pagenavi(array( 'query' => $posts )); 
    wp_reset_query();
    ?>
  </div>
</footer>
<?php 
  /* $temp = $wp_query; 
    $wp_query = null; 
      $wp_query = new WP_Query(); 
        $wp_query->query('showposts=6&post_type=news'.'&paged='.$paged); 

          while ($wp_query->have_posts()) : $wp_query->the_post(); 
          ?>
            test<br />
            <!-- LOOP: Usual Post Template Stuff Here-->

            <?php endwhile; ?>

<nav>
    <?php previous_posts_link('&laquo; Newer') ?>
        <?php next_posts_link('Older &raquo;') ?>
        </nav>

        <?php 
          $wp_query = null; 
            $wp_query = $temp; 
           */  ?>

<!-- Put the following javascript before the closing </head> tag. -->
<?php /*		<script>
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
	<?php // flo_part('blogfoot') ?>
	<?php // flo_part('blogtop') ?>
</div>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>      
