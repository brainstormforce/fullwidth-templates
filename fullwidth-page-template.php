<?php
/**
 * Plugin Name:     Fullwidth Page Templates
 * Plugin URI:      https://www.brainstormforce.com
 * Description:     Create Full width landing pages with any theme.
 * Author:          Brainstorm Force
 * Author URI:      https://www.brainstormforce.com
 * Text Domain:     fullwidth-templates
 * Domain Path:     /languages
 * Version:         1.1.1
 *
 * @package         Fullwidth_Page_Templates
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'class-fullwidth-page-templates.php';

define( 'FPT_VER', '1.1.1' );
define( 'FPT_DIR', plugin_dir_path( __FILE__ ) );
define( 'FPT_URL', plugins_url( '/', __FILE__ ) );
define( 'FPT_PATH', plugin_basename( __FILE__ ) );

/**
 * Load the Plugin Class.
 */
function init_fullwidth_template() {

	// Load localization file
	load_plugin_textdomain( 'fullwidth-templates' );

	// Init dynamic header footer
	new Fullwidth_Page_Templates();

}

add_action( 'plugins_loaded', 'init_fullwidth_template' );