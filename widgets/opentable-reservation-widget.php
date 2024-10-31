<?php
namespace RestaurantAddonForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * OpenTable Reservation widget.
 *
 * Elementor widget that displays a OpenTable reservation widget in different formats.
 *
 * @since 1.0.0
 */
class Opentable_Reservation_Widget extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'opentable-reservation-widget';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'OpenTable Reservation Widget', 'restaurant-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'restaurant-addon' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'options_section',
			[
				'label' => __( 'Options', 'restaurant-addon-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'restaurant_id',
			[
				'label' => __( 'Restaurant ID', 'restaurant-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '123456', 'restaurant-addon-for-elementor' ),
			]
		);

		$this->add_control(
			'widget_language',
			[
				'label' => __( 'Widget Language', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'en-US',
				'options' => [
					'en-US'  => __( 'English-US', 'restaurant-addon-for-elementor' ),
					'fr-CA' => __( 'Français-CA', 'restaurant-addon-for-elementor' ),
					'de-DE' => __( 'Deutsch-DE', 'restaurant-addon-for-elementor' ),
					'es-MX' => __( 'Español-MX', 'restaurant-addon-for-elementor' ),
					'ja-JP' => __( '日本語-JP', 'restaurant-addon-for-elementor' ),
					'nl-NL' => __( 'Nederlands-NL', 'restaurant-addon-for-elementor' ),
					'it-IT' => __( 'Italiano-IT', 'restaurant-addon-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'widget_type',
			[
				'label' => __( 'Widget Type', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard'  => __( 'Standard (224 x 301 pixels)', 'restaurant-addon-for-elementor' ),
					'tall'  => __( 'Tall (288 x 490 pixels)', 'restaurant-addon-for-elementor' ),
					'wide'  => __( 'Wide (840 x 350 pixels)', 'restaurant-addon-for-elementor' ),
					'button'  => __( 'Button (210 x 113 pixels)', 'restaurant-addon-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_options_section',
			[
				'label' => __( 'Advanced Options', 'restaurant-addon-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);		

		$this->add_control(
			'option_iframe',
			[
				'label' => __( 'Load widget in iFrame (recommended)', 'restaurant-addon-for-elementor' ),				
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => 'Widget will appear in an iFrame and prevent the restaurant website code from changing its styling.',
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}
	
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['restaurant_id'] ) {
			echo 'Please specify your OpenTable restaurant ID.';
		}

		if ( $settings['restaurant_id'] ) {
			$url = esc_url( add_query_arg( array(
				'rid'     => $settings['restaurant_id'],
				'type'    => 'standard',
				'theme'   => $settings['widget_type'],
				'iframe'  => $settings['option_iframe'] ? 'true' : 'false',
				'overlay' => 'false',
				'domain'  => 'com',
				'lang'    => $settings['widget_language'],		
			), '//www.opentable.com/widget/reservation/loader' ) );
		}

		echo "<script type='text/javascript' src='$url'></script>";
		
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>

		<div><p>Your OpenTable Reservation widget will be inserted here.</p></div>

		<?php
	}

}
