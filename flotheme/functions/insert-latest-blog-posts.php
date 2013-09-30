<?php

function insert_latest_blog_posts($n) {

  $latest_args = array(
    'post_type' => 'post',
    'posts_per_page' => $n,
    'orderby' => 'post_date',
    'order' => 'desc'
  );

  $latest_loop = get_posts( $latest_args );

  if ( $latest_loop ) {
    
    $i = 1;
    foreach( $latest_loop as $item ) {
      
      $post_id = $item->ID;
      $img;
      $class = 'cf';
      if ( $i == 3 ) {
      $class = 'class="cf last"';
      }
      
      if ( has_post_thumbnail( $post_id ) ) {
        $img = get_the_post_thumbnail( $post_id );
      }
      echo '<article ' . $class . '>';
      echo '<figure><a href="' . $item->guid . '">' . $img . '</a></figure>';
      echo '<a href="' . $item->guid . '">' . $item->post_title . '</a>';
      echo '</article>';

      $i++;

    }  // foreach $loop
    $i = 1;

  } // if $loop
  wp_reset_postdata();
  
}
?>
