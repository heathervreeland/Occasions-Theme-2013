<?php

function insert_search_result($loop) {
  $posts = $loop;
  $output = '';
  $num = $posts->found_posts?$posts->found_posts:"0";
  $output .= "<h3>We found ".$num." articles matching your search.</h3>";
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
      $output .= "<article class=\"search-item cf\">";
      $output .= $thumblink;
      $output .= "  <h2><a href=\"$permalink\">".$post->post_title."</a></h2>";
      $output .= "  <p>";
      $output .= strip_tags(substr(strip_shortcodes($post->post_content),0,150)) . ' ... <a href="' . $permalink . '">Read More &rarr;</a>';
      $output .= "  </p>";
      $output .= "</article>";
      $i++;
    endwhile;
    $output .= ($i<$num)?"<h3 class=\"search-more\"><a href=\"/search/page/1/?q={$s}&type=post\" title=\"View more article search results\">View more article search results</a></h3>":"";
  else :
    $output .= "<p>No Posts were found</p>";
    wp_reset_postdata();                  
  endif;

  return $output;
}

?>
