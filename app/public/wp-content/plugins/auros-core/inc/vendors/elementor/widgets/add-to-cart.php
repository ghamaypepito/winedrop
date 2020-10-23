<?php

namespace Elementor;

use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_woocommerce_activated()) {
    return;
}

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Add_To_Cart_Button extends Widget_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-add-to-cart';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Button Add To Cart', 'auros-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-button';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the widget keywords.
     *
     * @since  1.0.10
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['product', 'cart', 'button'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'auros-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'product_id',
            [
                'label'   => __('Product', 'auros-core'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_products_id(),
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label'        => __('Show Price', 'auros-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'auros-core'),
                'label_off'    => __('Hide', 'auros-core'),
                'default'      => '0',
                'return_value' => '1'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_price_style',
            [
                'label'     => __('Price', 'auros-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => '1'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_1',
                'scheme'   => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button .amount',
            ]
        );

        $this->start_controls_tabs('tabs_price_style');

        $this->start_controls_tab(
            'tab_price_normal',
            [
                'label' => __('Normal', 'auros-core'),
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .amount' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'price_padding',
            [
                'label'      => __('Padding', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-button .amount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_price_hover',
            [
                'label' => __('Hover', 'auros-core'),
            ]
        );

        $this->add_control(
            'price_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Button', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'scheme'   => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button a',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'auros-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_color',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'auros-core'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_color_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-button:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_hover',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => __('Padding', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_section();


    }


    protected function get_products_id() {
        $args = array(
            'limit' => -1,
        );
        $products = wc_get_products($args);
        $results = array();
        if (!is_wp_error($products)) {
            foreach ($products as $product) {
                $results[$product->get_id()] = $product->get_title();
            }
        }
        return $results;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ($settings['product_id'] == '') {
            return;
        }
        echo do_shortcode('[add_to_cart id="' . $settings['product_id'] . '" show_price="' . $settings['show_price'] . '" style="" class="elementor-button" ]');

    }
}
$widgets_manager->register_widget_type( new OSF_Elementor_Add_To_Cart_Button() );
