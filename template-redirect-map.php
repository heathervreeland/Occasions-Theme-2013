<?php
/*
Template Name: Template Redirect To Map
*/
$url = flo_get_permalink('map');
wp_redirect($url);
exit;