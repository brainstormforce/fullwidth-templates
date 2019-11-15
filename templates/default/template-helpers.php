<?php
/**
 * Template Helpers.
 * Get header and Footer content.
 *
 * @package Fullwidth_Page_Templates
 */

/**
 * No Content Get Header.
 *
 * @since 1.0.0
 */
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

/**
 * No Content Get Footer.
 *
 * @since 1.0.0
 */
function no_content_get_footer() {
	do_action( 'page_builder_content_body_after' );
	wp_footer();
	?>
</body>
</html>
	<?php
}

/**
 * Page builder page elements.
 *
 * @since 1.0.0
 */
function page_builder_page_elements() {
	the_content();
}

add_action( 'page_builder_page_elements', 'page_builder_page_elements' );
