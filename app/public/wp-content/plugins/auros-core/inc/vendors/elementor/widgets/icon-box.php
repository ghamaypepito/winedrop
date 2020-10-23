<?php
namespace Elementor;

use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor icon box widget.
 *
 * Elementor widget that displays an icon, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Icon_Box extends Widget_Icon_Box {

    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'icon-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Icon Box', 'auros-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-icon-box';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    /**
     * Register icon box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __( 'Icon Box', 'auros-core' ),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Choose Icon', 'auros-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'auros-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'auros-core' ),
                    'stacked' => __( 'Stacked', 'auros-core' ),
                    'framed' => __( 'Framed', 'auros-core' ),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __( 'Shape', 'auros-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => __( 'Circle', 'auros-core' ),
                    'square' => __( 'Square', 'auros-core' ),
                ],
                'default' => 'circle',
                'condition' => [
                    'view!' => 'default',
                    'icon!' => '',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => __( 'Title & Description', 'auros-core' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'This is the heading', 'auros-core' ),
                'placeholder' => __( 'Enter your title', 'auros-core' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => '',
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'auros-core' ),
                'placeholder' => __( 'Enter your description', 'auros-core' ),
                'rows' => 10,
                'separator' => 'none',
                'show_label' => false,
            ]
        );

        $this->add_control(
            'hover_animation_wrapper',
            [
                'label' => __( 'Hover Wrapper Animation', 'auros-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'prefix_class' => 'elementor-animation-',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link to', 'auros-core' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'auros-core' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_download',
            [
                'label'       => __('Donload Link ?', 'auros-core'),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __( 'Icon Position', 'auros-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'auros-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'top' => [
                        'title' => __( 'Top', 'auros-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'auros-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => __( 'Title HTML Tag', 'auros-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => __( 'Icon', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => __( 'Primary Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => __( 'Secondary Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
				'condition' => [
					'view!' => 'default',
				],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => __( 'Margin', 'auros-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Size', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => __( 'Padding', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
				'condition' => [
					'view!' => 'default',
				],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => __( 'Border Width', 'auros-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => __( 'Border Color', 'auros-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'auros-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_hover',
            [
                'label' => __( 'Icon Hover', 'auros-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => __( 'Primary Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon, {{WRAPPER}}.elementor-view-default:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_secondary_color',
            [
                'label' => __( 'Secondary Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'auros-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __( 'Content', 'auros-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __( 'Alignment', 'auros-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label' => __( 'Vertical Alignment', 'auros-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top' => __( 'Top', 'auros-core' ),
                    'middle' => __( 'Middle', 'auros-core' ),
                    'bottom' => __( 'Bottom', 'auros-core' ),
                ],
                'default' => 'top',
                'prefix_class' => 'elementor-vertical-align-',
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Title', 'auros-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => __( 'Spacing', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => __( 'Hover Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-icon-box:hover .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title',
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => __( 'Description', 'auros-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label' => __( 'Hover Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-icon-box:hover .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'icon', 'class', [ 'elementor-icon', 'elementor-animation-' . $settings['hover_animation'] ] );

        $icon_tag = 'span';
        $has_icon = ! empty( $settings['icon'] );

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'link', 'href', $settings['link']['url'] );
            $icon_tag = 'a';

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( $settings['link']['nofollow'] ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }

            if($settings['link_download'] === 'yes'){
                $this->add_render_attribute( 'link', 'download' );
            }
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( 'icon' );
        $link_attributes = $this->get_render_attribute_string( 'link' );

        $this->add_render_attribute( 'description_text', 'class', 'elementor-icon-box-description' );

        $this->add_inline_editing_attributes( 'title_text', 'none' );
        $this->add_inline_editing_attributes( 'description_text' );
        ?>
        <div class="elementor-icon-box-wrapper">
        <?php if ( $has_icon ) : ?>
            <div class="elementor-icon-box-icon">
            <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
            <i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
            </<?php echo $icon_tag; ?>>
            </div>
        <?php endif; ?>
        <div class="elementor-icon-box-content">
        <<?php echo $settings['title_size']; ?> class="elementor-icon-box-title">
        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
        </<?php echo $settings['title_size']; ?>>
        <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
        </div>
        </div>
        <?php
    }
}
$widgets_manager->register_widget_type(new OSF_Widget_Icon_Box());