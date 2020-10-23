<?php
namespace Elementor;


use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_mailchimp_activated()) {
    return;
}


class OSF_Elementor_Button_Mailchimp extends Widget_Button {

    public function get_name() {
        return 'opal-button-mailchimp';
    }

    public function get_title() {
        return __('Opal Button MailChimp Sign-Up Form', 'auros-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_script_depends() {
        return [ 'magnific-popup' ];
    }

    public function get_style_depends(){
        return ['magnific-popup'];
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'mailchmip',
            [
                'label' => __('General', 'auros-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hide_text',
            [
                'label'        => __( 'Hide Text', 'auros-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __( 'Off', 'auros-core' ),
                'label_on'     => __( 'On', 'auros-core' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields span' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hide_icon',
            [
                'label'        => __( 'Hide Icon', 'auros-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __( 'Off', 'auros-core' ),
                'label_on'     => __( 'On', 'auros-core' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields i' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing_icon',
            [
                'label'     => __( 'Icon Spacing', 'auros-core' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => __( 'Form name', 'auros-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Newsletter', 'auros-core' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'auros-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Stay up to date with our latest news and products', 'auros-core' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'setting_mailchmip',
            [
                'label' => __( 'Setting', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'setting_block',
            [
                'label'     => __( 'Style Block', 'auros-core' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'auros-core' ),
                'label_on'  => __( 'On', 'auros-core' ),
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields ' => 'display: flex; flex-direction: column;',
                ],
            ]
        );

        $this->add_responsive_control(
            'setting_align',
            [
                'label'     => __( 'Alignment', 'auros-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => __( 'Left', 'auros-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => __( 'Center', 'auros-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __( 'Right', 'auros-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'condition' => [
                    'setting_block' => 'yes',
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_input',
            [
                'label'      => __( 'Input Size', 'auros-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_button',
            [
                'label'      => __( 'Buton Size', 'auros-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        parent::_register_controls();


        $this->start_controls_section(
            'section_form_title',
            [
                'label' => __( 'Title', 'auros-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __('Title Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .form-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '#opal-mailchimp-popup-{{ID}} .form-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __( 'Spacing', 'auros-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_form_subtitle',
            [
                'label' => __( 'Subtitle', 'auros-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => __('Subtitle Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'selector' => '#opal-mailchimp-popup-{{ID}} .subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_spacing',
            [
                'label'      => __( 'Spacing', 'auros-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        //Form Style
        $this->start_controls_section(
            'form_style',
            [
                'label' => __( 'Form Style', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color_form',
            [
                'label' => __( 'Background Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_4,
                ],
                'default' => '#fff',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_form',
            [
                'label'      => __( 'Width', 'auros-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 700,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}}' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'padding_form',
            [
                'label'      => __( 'Padding', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_align',
            [
                'label' => __( 'Text Alignment', 'auros-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'auros-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'auros-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'auros-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'auros-core' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        //Input Form
        $this->start_controls_section(
            'mailchip_style_input',
            [
                'label' => __( 'Form Input', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_bacground',
            [
                'label'     => __( 'Background Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __( 'Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label'     => __( 'Placeholder Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields ::-moz-placeholder'          => 'color: {{VALUE}};',
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields ::-ms-input-placeholder'     => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_input',
            [
                'label'     => __( 'Alignment', 'auros-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'auros-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'auros-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'auros-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label'      => __( 'Border Radius', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __( 'Padding', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'input_margin',
            [
                'label'      => __( 'Margin', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Button Form
        $this->start_controls_section(
            'mailchip_style_button',
            [
                'label' => __( 'Button Form', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_mailchip_button',
                'scheme'   => Typography::TYPOGRAPHY_3,
                'selector' => '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]',
            ]
        );

        $this->start_controls_tabs( 'tabs_mailchip_button_style' );

        $this->start_controls_tab(
            'tab_mailchip_button_normal',
            [
                'label' => __( 'Normal', 'auros-core' ),
            ]
        );

        $this->add_control(
            'mailchip_button_bacground',
            [
                'label'     => __( 'Background Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_button_color',
            [
                'label'     => __( 'Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_mailchip_button_hover',
            [
                'label' => __( 'Hover', 'auros-core' ),
            ]
        );

        $this->add_control(
            'mailchip_button_bacground_hover',
            [
                'label'     => __( 'Background Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_button_color_hover',
            [
                'label'     => __( 'Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_button_border_hover',
            [
                'label'     => __( 'Border Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_mailchip_button_focus',
            [
                'label' => __( 'Focus', 'auros-core' ),
            ]
        );

        $this->add_control(
            'mailchip_button_bacground_focus',
            [
                'label'     => __( 'Background Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:forcus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_button_color_focus',
            [
                'label'     => __( 'Button Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_button_border_focus',
            [
                'label'     => __( 'Border Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_mailchip_button',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'mailchip_button_border_radius',
            [
                'label'      => __( 'Border Radius', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_button_padding',
            [
                'label'      => __( 'Padding', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mailchip_button_margin',
            [
                'label'      => __( 'Margin', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '#opal-mailchimp-popup-{{ID}} .mc4wp-form-fields button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-button-mailchimp' );

        $this->add_render_attribute( 'button', 'href', '#opal-mailchimp-popup-'.esc_attr( $this->get_id() ) );
        $this->add_render_attribute( 'button', 'class', 'elementor-button' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( $settings['hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php

        ?>

        <div id="opal-mailchimp-popup-<?php echo esc_attr( $this->get_id()); ?>" class="mfp-hide mailchimp-content">
            <div class="heading-form">
                <div class="form-title"><?php echo esc_html($settings['form_name']);?></div>
                <div class="subtitle"><?php echo esc_html($settings['sub_title']);?></div>
            </div>
            <div class="form-style"><?php mc4wp_show_form(); ?></div>
        </div>
        <?php
    }

    protected function _content_template() {
        return;
    }
}
$widgets_manager->register_widget_type(new OSF_Elementor_Button_Mailchimp());
