<?php

/**
 *
 */
class Dynamic_Header_Footer {

	private $templates;

	function __construct() {

		$this->includes();

		$this->templates = array(
			'template-page-builder-no-sidebar.php' => 'No Sidebar Page Template',
			'template-page-builder.php' => 'Fullwidth Page Template',
			'template-page-builder-no-header-footer.php' => 'Fullwidth No Header Footer Page Template'
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
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
				);
		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', array( $this, 'fpt_register_project_templates' ) );
		add_filter( 'template_include', array( $this, 'fpt_view_project_template' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	public function body_class( $body_Class ) {
		$template = get_template();
		$body_Class[] = 'fpt-template-' . $template;

		return $body_Class;
	}

	public function enqueue() {
		if ( is_page_template( 'template-page-builder.php' ) ) {
			wp_register_style( 'fullwidth-template', plugins_url( 'assets/css/fullwidth-template.css', __FILE__ ) );
			wp_enqueue_style( 'fullwidth-template' );
		}
	}

	private function includes() {
		require_once FPT_DIR . '/templates/default/template-helpers.php';
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