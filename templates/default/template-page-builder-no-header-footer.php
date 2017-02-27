<?php 
/* Template Name: BSF Fullwidth No Header Footer */ 

no_content_get_header();

do_action( 'page_builder_before_content_wrapper' );

    while ( have_posts() ) : the_post();
	    do_action( 'page_builder_page_elements' ); // Give your elements priorities so that they hook in the right place.
	endwhile;

do_action( 'page_builder_after_content_wrapper' );

no_content_get_footer();