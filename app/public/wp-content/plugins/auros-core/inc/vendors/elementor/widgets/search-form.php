<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Search_Form extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-search-form';
    }

    public function get_title() {
        return __('Opal Search Form', 'auros-core');
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'search_content',
            [
                'label' => __('Search Form', 'auros-core'),
            ]
        );

        if (osf_is_woocommerce_activated()):
            $this->add_control(
                'search_product_only',
                [
                    'label'   => __('Search only products', 'auros-core'),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes'

                ]);
        endif;

        $this->add_control(
            'skin',
            [
                'label'              => __('Skin', 'auros-core'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'classic',
                'options'            => [
                    'classic'     => __('Classic', 'auros-core'),
                    'minimal'     => __('Minimal', 'auros-core'),
                    'full_screen' => __('Full Screen', 'auros-core'),
                ],
                'prefix_class'       => 'elementor-search-form--skin-',
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label'   => __('Placeholder', 'auros-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Search', 'auros-core') . '...',
            ]
        );

        $this->add_control(
            'heading_button_content',
            [
                'label'     => __('Button', 'auros-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'auros-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'icon',
                'options'      => [
                    'icon'      => __('Icon', 'auros-core'),
                    'text'      => __('Text', 'auros-core'),
                    'text_icon' => __('Text & Icon', 'auros-core'),
                ],
                'prefix_class' => 'elementor-search-form--button-type-',
                'render_type'  => 'template',
                'condition'    => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => __('Text', 'auros-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Search', 'auros-core'),
                'condition' => [
                    'button_type!' => 'icon',
                    'skin'         => 'classic',
                ],
            ]
        );

        $this->add_control(
            'size_minimal',
            [
                'label'     => __('Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container'                                                                                 => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-search-form__submit'                                                                                    => 'min-width: {{SIZE}}{{UNIT}}',
                    'body:not(.rtl) {{WRAPPER}} .elementor-search-form__icon'                                                                       => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
                    'body.rtl {{WRAPPER}} .elementor-search-form__icon'                                                                             => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                    '{{WRAPPER}} .elementor-search-form__input, {{WRAPPER}}.elementor-search-form--button-type-text .elementor-search-form__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                ],
                'separator' => 'before',
                'condition' => [
                    'skin' => 'minimal',
                ],
            ]
        );

        $this->add_control(
            'toggle_button_content',
            [
                'label'     => __('Toggle', 'auros-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'icon_skin',
            [
                'label'     => __('Choose Icon', 'auros-core'),
                'type'      => Controls_Manager::ICON,
                'default'   => 'opal-icon-search3',
                'condition' => [
                    'button_type!' => 'text',
                ],
            ]
        );

        $this->add_control(
            'toggle_align',
            [
                'label'       => __('Alignment', 'auros-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default'     => 'center',
                'options'     => [
                    'flex-start' => [
                        'title' => __('Left', 'auros-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => __('Center', 'auros-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __('Right', 'auros-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'display: flex; justify-content: {{VALUE}}',
                ],
                'condition'   => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'toggle_size',
            [
                'label'     => __('Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 33,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __('Input', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size_minimal',
            [
                'label'     => __('Icon Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'minimal',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'overlay_background_color',
            [
                'label'     => __('Overlay Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen .elementor-search-form__container' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} input[type="search"].elementor-search-form__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_input_colors');

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __('Normal', 'auros-core'),
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'input_background_color',
                'selector'  => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'skin!' => 'full_screen',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'input_box_shadow',
                'selector'       => '{{WRAPPER}} .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => __('Focus', 'auros-core'),
            ]
        );

        $this->add_control(
            'input_text_color_focus',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'input_background_color_focus',
                'selector'  => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'skin!' => 'full_screen',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border_focus',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'input_box_shadow_focus',
                'selector'       => '{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label'     => __('Button', 'auros-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'heading_style_button',
            [
                'label' => __('Style', 'auros-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'     => __('Button Width', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'selector'  => '{{WRAPPER}} .elementor-search-form__submit span',
                'scheme'    => Schemes\Typography::TYPOGRAPHY_3,
                'condition' => [
                    'button_type!' => 'icon',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_colors');

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
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'background-color: {{VALUE}}',
                ],
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
            'button_text_color_hover',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label'     => __('Background Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'     => __('Border Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'        => 'border_button_search',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-search-form__submit',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_search_border_radius',
            [
                'label'      => __('Border Radius', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_search_padding',
            [
                'label'      => __('Padding', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_search_margin',
            [
                'label'      => __('Margin', 'auros-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_icon',
            [
                'label'     => __('Icon', 'auros-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_type!' => 'text',
                    'skin!'        => 'full_screen',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type!' => 'text',
                    'skin!'        => 'full_screen',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'     => __('Icon Spacing', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit i' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type!' => 'text',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style',
            [
                'label'     => __('Toggle', 'auros-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_toggle_color');

        $this->start_controls_tab(
            'tab_toggle_normal',
            [
                'label' => __('Normal', 'auros-core'),
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label'     => __('Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color',
            [
                'label'     => __('Background Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_toggle_hover',
            [
                'label' => __('Hover', 'auros-core'),
            ]
        );

        $this->add_control(
            'toggle_color_hover',
            [
                'label'     => __('Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color_hover',
            [
                'label'     => __('Background Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'toggle_icon_size',
            [
                'label'     => __('Icon Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:before' => 'font-size: calc({{SIZE}}em / 100)',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_width',
            [
                'label'     => __('Border Width', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_radius',
            [
                'label'      => __('Border Radius', 'auros-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $this->add_render_attribute(
            'input', [
                'placeholder' => $settings['placeholder'],
                'class'       => 'elementor-search-form__input',
                'type'        => 'search',
                'name'        => 's',
                'title'       => __('Search', 'auros-core'),
                'value'       => get_search_query(),
            ]
        );

        // Set the selected icon.
        if ('icon' == $settings['button_type']) {
            $icon_class = 'search';

            if ('arrow' == $settings['icon_skin']) {
                $icon_class = is_rtl() ? 'arrow-left' : 'arrow-right';
            }

            $this->add_render_attribute('icon', [
                'class' => 'fa fa-' . $icon_class,
            ]);
        }

        ?>
        <form class="elementor-search-form" role="search" action="<?php echo home_url(); ?>" method="get">
            <?php if ('full_screen' === $settings['skin']) : ?>
                <div class="elementor-search-form__toggle">
                    <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                </div>
            <?php endif; ?>

            <div class="elementor-search-form__container">
                <?php if ('minimal' === $settings['skin']) : ?>
                    <div class="elementor-search-form__icon">
                        <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
                <input <?php echo $this->get_render_attribute_string('input'); ?>>
                <?php if (osf_is_woocommerce_activated() && $settings['search_product_only'] == 'yes'): ?>
                    <input type="hidden" name="post_type" value="product"/>
                <?php endif; ?>
                <?php if ('classic' === $settings['skin']) : ?>
                    <button class="elementor-search-form__submit" type="submit">
                        <?php if ('icon' === $settings['button_type']) : ?>
                            <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                        <?php elseif ('text' === $settings['button_type']) : ?>
                            <span><?php echo $settings['button_text']; ?></span>
                        <?php elseif ('text_icon' === $settings['button_type']) : ?>
                            <i class="<?php echo $settings['icon_skin']; ?> align-middle" aria-hidden="true"></i>
                            <span class="align-middle"><?php echo $settings['button_text']; ?></span>
                        <?php endif; ?>
                    </button>
                <?php endif; ?>
                <?php if ('full_screen' === $settings['skin']) : ?>
                    <div class="dialog-lightbox-close-button dialog-close-button">
                        <i class="eicon-close" aria-hidden="true"></i>
                        <span class="elementor-screen-only"><?php esc_html_e('Close', 'auros-core'); ?></span>
                    </div>
                <?php endif ?>
            </div>
        </form>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Search_Form());
