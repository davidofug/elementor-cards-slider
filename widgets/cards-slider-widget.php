<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Cards Slider Widget.
 *
 * @since 1.0.0
 */
class Elementor_Cards_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve cards slider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'cards_slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve cards slider widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Cards Slider', 'elementor-cards slider-control' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve cards slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-cart-medium';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://shineafrika.com/extensions/elementor-cards-slider/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the cards slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the cards slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'card', 'cards', 'slide', 'sliders' ];
	}

	/**
	 * Register cards slider widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'elementor-cards-slider' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cards',
			[
				'label' => esc_html__( 'Cards', 'elementor-cards-slider' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

        $args = array(
            'public' => true,
            '_builtin' => false
        );
        $post_types = get_post_types( $args, 'objects' );

        $options = [];
        foreach ( $post_types as $post_type ) :
            $labels = get_post_type_labels( $post_type );
            $options[esc_attr( $post_type->name )] = esc_html( $labels->name );
        endforeach;
		$this->add_control(
			'from',
			[
				'label' => esc_html__( 'From', 'elementor-cards-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'safari',
                'options' => $options,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render cards slider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		require_once( 'slider-template.php' );
		require_once( 'card-template.php' );
		$slider_template = return_slider_template();
		$card_template = return_card_template();
		$cardStr = '';

		$settings = $this->get_settings_for_display();
		$args = array(
			'post_type' => $settings['from'],
			'posts_per_page' => -1,
		);

		$posts = get_posts($args);

		if(empty($posts)) {
			echo 'Posts not found';
			return;
		}
        // echo  $settings['cards'];
		$next = 0;
		$groups = ceil(count($posts)/$settings['cards']);
		for($position = 0; $position < $groups; $position++) {
			$cards = array_slice($posts, $next, $settings['cards']);

			for($i = 0; $i < $settings['cards']; $i++) :
				$id = @$cards[$i]->ID;
				if(!$id) break;

				$title = $cards[$i]->post_title;
				$thumb_url = get_the_post_thumbnail_url($id) || 'https://via.placeholder.com/300x200';
				$content = $cards[$i]->post_content;
				$excerpt = wp_trim_words( $content, 20, '...' );
				$cardStr .= sprintf($card_template, $thumb_url, $title, $excerpt);
			endfor;
			$next += $settings['cards'];
		}
		echo sprintf($slider_template,$cardStr);
	}

}