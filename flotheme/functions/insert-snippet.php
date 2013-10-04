<?php
function insert_snippet( $n ) {

    $i = $n;

    if ( $i == 1 ) {

      flo_part('featured-vendors-home'); 

    } elseif ( $i == 2 ) {

      flo_part('latest-blog-posts-home-insert'); 

    } elseif ( $i == 3 ){

      flo_part('subscribe-home-insert'); 

    } else {

      $x = rand(1,3);

      if ( $x == 1 ) {

        flo_part('featured-vendors-home'); 

      } elseif ( $x == 2 ) {

        flo_part('latest-blog-posts-home-insert'); 

      } elseif ( $x == 3 ){

        flo_part('subscribe-home-insert'); 

      } 

    }
}
?>
