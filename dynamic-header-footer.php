<?php
/**
 * Plugin Name:     Fullwidth Page Templates
 * Plugin URI:      https://www.brainnstormforce.com
 * Description:     Create Full width landing pages with any theme.
 * Author:          Brainstorm Force
 * Author URI:      https://www.brainnstormforce.com
 * Text Domain:     fullwidth-page-template
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Fullwidth_Page_Templates
 */

require_once 'class-fullwidth-page-templates.php';

define( 'FPT_VER', '0.1.0' );
define( 'FPT_DIR', plugin_dir_path( __FILE__ ) );
define( 'FPT_URL', plugins_url( '/', __FILE__ ) );
define( 'FPT_PATH', plugin_basename( __FILE__ ) );

/**
 * Load the Plugin Class.
 */
function init_fullwidth_template() {
	new Dynamic_Header_Footer();
}

add_action( 'plugins_loaded', 'init_fullwidth_template' );