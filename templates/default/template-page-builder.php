<?php 
/* Template Name: BSF Fullwidth */ 

get_header();

do_action( 'page_builder_before_content_wrapper' );

    while ( have_posts() ) : the_post();
	    do_action( 'page_builder_page_elements' ); // Give your elements priorities so that they hook in the right place.
	endwhile;

do_action( 'page_builder_after_content_wrapper' );

get_footer();