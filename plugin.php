<?php
namespace RestaurantAddonForElementor;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Register & Enqueue Scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_styles() {
		wp_register_style( 'restaurant-addon-for-elementor', plugins_url( '/assets/css/frontend.css', __FILE__ ) );
		wp_enqueue_style( 'restaurant-addon-for-elementor');
	}

	/**
	 * Register Categories
	 *
	 * Register new Elementor categories.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function register_categories() {
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'restaurant-addon',
			[
				'title' => __( 'Restaurant Addon', 'plugin-name' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/restaurant-menu-widget.php' );
		require_once( __DIR__ . '/widgets/opentable-reservation-widget.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// It is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Restaurant_Menu_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Opentable_Reservation_Widget() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register categories
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		
	}
}

// Instantiate Plugin Class
Plugin::instance();
