<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;



    class OSF_Elementor_Cart extends Elementor\Widget_Base {

        public function get_name() {
            return 'opal-cart';
        }

        public function get_title() {
            return __('Opal WooCommerce Cart', 'auros-core');
        }

        public function get_icon() {
            return 'eicon-woocommerce';
        }

        public function get_categories() {
            return ['opal-addons'];
        }

        protected function _register_controls() {
            $this->start_controls_section(
                'cart_content',
                [
                    'label' => __('WooCommerce Cart', 'auros-core'),
                ]
            );

            $this->add_control(
                'icon',
                [
                    'label'   => __('Choose Icon', 'auros-core'),
                    'type'    => Controls_Manager::ICON,
                    'default' => 'fa fa-shopping-cart',
                ]
            );

            $this->add_control(
                'title',
                [
                    'label'       => __('Title', 'auros-core'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => __('Cart', 'auros-core'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title_hover',
                [
                    'label'       => __('Title Hover', 'auros-core'),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => __('View your shopping cart', 'auros-core'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'show_items',
                [
                    'label' => __('Show Count Text', 'auros-core'),
                    'type'  => Controls_Manager::SWITCHER,
                ]
            );

            $this->add_control(
                'show_subtotal',
                [
                    'label' => __('Show Amount', 'auros-core'),
                    'type'  => Controls_Manager::SWITCHER,
                ]
            );

            $this->add_control(
                'show_count',
                [
                    'label' => __('Show Count', 'auros-core'),
                    'type'  => Controls_Manager::SWITCHER,
                ]
            );

            $this->add_control(
                'cart_align',
                [
                    'label'   => __('Align', 'auros-core'),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'Right',
                    'options' => array(
                        'justify-content-start'  => esc_html__('Left', 'auros-core'),
                        'justify-content-center' => esc_html__('Center', 'auros-core'),
                        'justify-content-end'    => esc_html__('Right', 'auros-core'),
                    ),
                ]
            );

            $this->end_controls_section();


            //Style
            $this->start_controls_section(
                'section_lable_style',
                [
                    'label' => __('Style', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'cart_background_color',
                [
                    'label'     => __('Cart Background Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart > a' => 'background-color: {{VALUE}};',
                    ],

                ]
            );


            $this->add_control(
                'cart_background_hover_color',
                [
                    'label'     => __('Cart Background Hover Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart > a:hover' => 'background-color: {{VALUE}};',
                    ],

                ]
            );

            $this->add_responsive_control(
                'text_padding_cart',
                [
                    'label'      => __('Padding', 'auros-core'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .site-header-cart > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            $this->end_controls_section();


            //Icon
            $this->start_controls_section(
                'section_lable_icon',
                [
                    'label' => __('Icon', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => __('Color', 'auros-core'),
                    'type'  => Controls_Manager::COLOR,

                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .fa' => 'color: {{VALUE}};',
                    ],

                ]
            );

            $this->add_responsive_control(
                'icon_size',
                [
                    'label'     => __('Size', 'auros-core'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .fa' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'icon_spacing',
                [
                    'label'     => __('Spacing', 'auros-core'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .fa' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            //Tilte
            $this->start_controls_section(
                'section_lable_title',
                [
                    'label' => __('Title', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cart_title_typography',
                    'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                    'selector' => '{{WRAPPER}} .site-header-cart .title',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label'     => __('Title Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .title' => 'color: {{VALUE}};',
                    ],

                ]
            );

            $this->add_responsive_control(
                'title_spacing',
                [
                    'label'     => __('Spacing', 'auros-core'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .title' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            //Amount
            $this->start_controls_section(
                'section_lable_amount',
                [
                    'label' => __('Amount', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cart_amount_typography',
                    'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                    'selector' => '{{WRAPPER}} .site-header-cart .amount',
                ]
            );

            $this->add_control(
                'amount_color',
                [
                    'label'     => __('Amount Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .amount' => 'color: {{VALUE}};',
                    ],

                ]
            );

            $this->end_controls_section();

            //Count Text
            $this->start_controls_section(
                'section_lable_count_text',
                [
                    'label' => __('Count Text', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cart_count_text_typography',
                    'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                    'selector' => '{{WRAPPER}} .site-header-cart .count-text',
                ]
            );

            $this->add_control(
                'count_text_color',
                [
                    'label'     => __('Count Text Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .count-text' => 'color: {{VALUE}};',
                    ],

                ]
            );

            $this->end_controls_section();

            //Count
            $this->start_controls_section(
                'section_lable_count',
                [
                    'label' => __('Count', 'auros-core'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'count_color',
                [
                    'label'     => __('Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .count' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'count_background_color',
                [
                    'label'     => __('Background Color', 'auros-core'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .count' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'count_font_size',
                [
                    'label'     => __('Font Size', 'auros-core'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .count' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );


            $this->add_responsive_control(
                'count_size',
                [
                    'label'     => __('Size', 'auros-core'),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .site-header-cart .count' => 'line-height: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );


            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'        => 'border',
                    'placeholder' => '1px',
                    'default'     => '1px',
                    'selector'    => '{{WRAPPER}} .site-header-cart .count',
                    'separator'   => 'before',
                ]
            );

            $this->add_control(
                'border_radius',
                [
                    'label'      => __('Border Radius', 'auros-core'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .site-header-cart .count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .site-header-cart .count',
                ]
            );

            $this->add_responsive_control(
                'text_padding',
                [
                    'label'      => __('Padding', 'auros-core'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .site-header-cart .count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings(); ?>
            <div class="site-header-cart menu d-flex <?php echo esc_attr($settings['cart_align']); ?>">
                <a data-toggle="toggle" class="cart-contents header-button d-flex align-items-center"
                   href="<?php echo esc_url(wc_get_cart_url()); ?>"
                   title="<?php echo esc_attr($settings['title_hover']); ?>">
                    <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                    <span class="title"><?php echo esc_html($settings['title']); ?></span>
                    <?php if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart): ?>
                        <?php if ($settings['show_subtotal']): ?>
                            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span>
                        <?php endif; ?>
                        <?php if ($settings['show_count']): ?>
                            <span class="count d-inline-block text-center"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
                        <?php endif; ?>
                        <?php if ($settings['show_items']): ?>
                            <span class="count-text"><?php echo wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "auros-core")); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>

                <ul class="shopping_cart">
                    <li><?php the_widget('WC_Widget_Cart', 'title='); ?></li>
                </ul>
            </div>
            <?php
        }
    }

    $widgets_manager->register_widget_type(new OSF_Elementor_Cart());

