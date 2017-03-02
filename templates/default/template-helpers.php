<?php

function no_content_get_header() {

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
do_action( 'page_builder_content_body_before' );

}

function no_content_get_footer() {
	do_action( 'page_builder_content_body_after' );
	wp_footer(); 
?>
</body>
</html>
<?php
}

function page_builder_page_elements() {
	the_content();
}

add_action( 'page_builder_page_elements', 'page_builder_page_elements' );