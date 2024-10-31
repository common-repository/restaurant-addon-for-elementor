<?php
namespace RestaurantAddonForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Restaurant Menu widget.
 *
 * Elementor widget that displays a restaurant menu with name, price and description.
 *
 * @since 1.0.0
 */
class Restaurant_Menu_Widget extends Widget_Base {

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
		return 'restaurant-menu-widget';
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
		return __( 'Restaurant Menu', 'restaurant-addon-for-elementor' );
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
		return 'eicon-menu-card';
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
			'content_section',
			[
				'label' => __( 'Menu Items', 'restaurant-addon-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'restaurant-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'restaurant-addon-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'menu_item_name', [
				'label' => __( 'Item Name', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your item name here' , 'restaurant-addon-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'menu_item_price', [
				'label' => __( 'Price', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( '123' , 'restaurant-addon-for-elementor' ),
			]
		);

		$repeater->add_control(
			'menu_item_description', [
				'label' => __( 'Description (optional)', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type your description here', 'restaurant-addon-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'restaurant-addon-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'menu_item_name' => __( 'Item #1', 'restaurant-addon-for-elementor' ),
						'menu_item_price' => __( '10', 'restaurant-addon-for-elementor' ),
					],
					[
						'menu_item_name' => __( 'Item #2', 'restaurant-addon-for-elementor' ),
						'menu_item_price' => __( '20', 'restaurant-addon-for-elementor' ),
					],
				],
				'title_field' => '{{{ menu_item_name }}} - {{{ menu_item_price }}}',
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
		if ( $settings['title'] ) {
			echo '<h3 class="elementor-heading-title">' .  $settings['title'] . '</h3>';
		}
		if ( $settings['list'] ) {
			echo '<div class="elementor-restaurant-menu-widget">';
			foreach (  $settings['list'] as $item ) {
				echo '<div class="menu-item">';
					echo '<div class="menu-item-title-row">';
						echo '<div class="menu-item-title">' . $item['menu_item_name'] . '</div>';
						echo '<span class="price">' . $item['menu_item_price'] . '</span>';
					echo '</div>';
					if ( $item['menu_item_description'] ) {
					echo '<div class="menu-item-description">' . $item['menu_item_description'] . '</div>';
					}
				echo '</div>';
			}
			echo '</div>';
		}
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
		<# if ( settings.title ) { #>
		<h3 class="elementor-heading-title">{{{ settings.title }}}</h3>
		<# } #>
		<# if ( settings.list.length ) { #>
		<div class="elementor-restaurant-menu-widget">
			<# _.each( settings.list, function( item ) { #>
				<div class="menu-item">
					<div class="menu-item-title-row">
						<div class="menu-item-title">{{{ item.menu_item_name }}}</div>
						<span class="price">{{{ item.menu_item_price }}}</span>
					</div>
					<# if ( item.menu_item_description ) { #>
					<div class="menu-item-description">{{{ item.menu_item_description }}}</div>
					<# } #>
				</div>
			<# }); #>
		</div>
		<# } #>
		<?php
	}

}
