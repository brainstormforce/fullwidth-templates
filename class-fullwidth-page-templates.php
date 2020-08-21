<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 *
 */
class Fullwidth_Page_Templates {

	private $templates;

	function __construct() {

		$this->includes();

		$this->templates = array(
			'template-page-builder-no-sidebar.php' => esc_html__( 'FW No Sidebar', 'fullwidth-templates' ),
			'template-page-builder.php' => esc_html__( 'FW Fullwidth', 'fullwidth-templates' ),
			'template-page-builder-no-header-footer.php' => esc_html__( 'FW Fullwidth No Header Footer', 'fullwidth-templates' ),
		);

		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'fpt_register_project_templates' )
				);
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			add_action( 'init', array( $this, 'post_type_template' ), 999 );
		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', array( $this, 'fpt_register_project_templates' ) );
		add_filter( 'template_include', array( $this, 'fpt_view_project_template' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'wp', array( $this, 'theme_support' ) );
	}

	public function body_class( $body_Class ) {

		$template = get_page_template_slug();

		if ( false !== $template && $this->is_template_active() ) {
		 	$body_Class[] = 'fpt-template';
		}

		$body_Class[] 	= 'fpt-template-' . get_template();

		return $body_Class;
	}

	public function theme_support() {

		if ( $this->is_template_active() ) {
			add_filter( 'primer_the_page_title', '__return_false' );
		}

	}

	public function is_template_active() {

		$template = get_page_template_slug();
		
		if ( false !== $template && array_key_exists( $template, $this->templates ) ) {
			return true;
		}

		return false;
	}

	public function enqueue() {
		if ( is_page_template( 'template-page-builder.php' ) ) {
			wp_register_style( 'fullwidth-template', plugins_url( 'assets/css/fullwidth-template.css', __FILE__ ) );
			wp_enqueue_style( 'fullwidth-template' );
		}

		if ( is_page_template( 'template-page-builder-no-sidebar.php' ) ) {
			wp_register_style( 'fullwidth-template-no-sidebar', plugins_url( 'assets/css/fullwidth-template-no-sidebar.css', __FILE__ ) );
			wp_enqueue_style( 'fullwidth-template-no-sidebar' );
		}

		if( is_page_template( 'template-page-builder-no-header-footer.php' ) ) {
			wp_register_style( 'fullwidth-template-no-header-footer', plugins_url( 'assets/css/fullwidth-template-no-header-footer.css', __FILE__ ) );
			wp_enqueue_style( 'fullwidth-template-no-header-footer' );
		}
	}

	private function includes() {
		require_once FPT_DIR . '/templates/default/template-helpers.php';
		// Astra Notices.
		require_once FPT_DIR . '/admin/notices/class-astra-notices.php';
		// BSF Analytics.
		if ( ! class_exists( 'BSF_Analytics_Loader' ) ) {
			require_once FPT_DIR . 'admin/bsf-analytics/class-bsf-analytics-loader.php';
		}
		
		$bsf_analytics = BSF_Analytics_Loader::get_instance();
		
		$bsf_analytics->set_entity(
			array(
				'bsf' => array(
					'product_name'    => 'Fullwidth Templates for Any Theme & Page Builder',
					'path'            => FPT_DIR . 'admin/bsf-analytics',
					'author'          => 'Brainstorm Force',
					'time_to_display' => '+24 hours',
				),
			)
		);
	}

	public function post_type_template() {
		$args = array(
		   'public'   => true
		);

		$post_types = get_post_types( $args, 'names', 'and' );

		// Disable some of the known unwanted post types.
		unset( $post_types['attachment'] );

		if ( ! empty( $post_types ) ) {

			foreach ( $post_types as $post_type ) {
				add_filter( 'theme_' . $post_type . '_templates', array( $this, 'add_new_template' ) );
			}

		}
	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	function fpt_register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		wp_cache_delete( $cache_key, 'themes' );

		$templates = array_merge( $templates, $this->templates );
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;
	}

	function fpt_view_project_template( $template ) {

		global $post;

		// If it is nont a single post/page/post-type, don't apply the template from the plugin.
		if ( ! is_singular() ) {
			return $template;
		}

		if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {

			return $template;
		}

		$file = FPT_DIR . '/templates/default/' . get_post_meta( $post->ID, '_wp_page_template', true );

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		return $template;
	}

}