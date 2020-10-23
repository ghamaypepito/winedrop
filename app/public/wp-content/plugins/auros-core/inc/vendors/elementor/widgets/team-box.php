<?php

use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Team_Box extends Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-team-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Team Box', 'auros-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_team',
            [
                'label' => __('Team', 'auros-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __('Style', 'auros-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => array(
                    'style-1' => esc_html__('Style 1', 'auros-core'),
                    'style-2' => esc_html__('Style 2', 'auros-core'),
                ),
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'auros-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'teams',
            [
                'label'       => __('Team Item', 'auros-core'),
                'type'        => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'name',
            [
                'label'   => __('Name', 'auros-core'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'      => __('Choose Image', 'auros-core'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'job',
            [
                'label'   => __('Job', 'auros-core'),
                'default' => 'Designer',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __('Description', 'auros-core'),
                'default' => 'Description',
                'type'    => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'auros-core'),
                'placeholder' => __('https://your-link.com', 'auros-core'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $this->add_control(
             'facebook',
            [
                'label'   => __('Facebook', 'auros-core'),
                'default' => 'www.facebook.com/opalwordpress',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'twitter',
            [
                'label'   => __('Twitter', 'auros-core'),
                'default' => 'https://twitter.com/opalwordpress',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'youtube',
            [
                'label'   => __('Youtube', 'auros-core'),
                'default' => 'https://www.youtube.com/user/WPOpalTheme',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'google',
            [
                'label'   => __('Google', 'auros-core'),
                'default' => 'https://plus.google.com/u/0/+WPOpal',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_responsive_control(
            'team_align',
            [
                'label'     => __('Alignment', 'auros-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __('Left', 'auros-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'auros-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'auros-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-align-',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Image
        $this->start_controls_section(
            'section_style_team_image_team',
            [
                'label' => __('Image', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label'     => __('Spacing', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => __( 'Normal', 'auros-core' ),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => __( 'Opacity', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .elementor-team-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => __( 'Hover', 'auros-core' ),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label' => __( 'Opacity', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-teams-wrapper:hover img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => __( 'Transition Duration', 'auros-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper img' => 'transition-duration: {{SIZE}}s',
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

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_team_name',
            [
                'label' => __('Name', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'name_space',
            [
                'label'     => __('Spacing', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-name, {{WRAPPER}} .elementor-team-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-team-name',
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_team_job',
            [
                'label' => __('Job', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'job_space',
            [
                'label'     => __('Spacing', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-job' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_2,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-team-job',
            ]
        );

        $this->end_controls_section();

        // Description.
        $this->start_controls_section(
            'section_style_team_description',
            [
                'label' => __('Description', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'description_space',
            [
                'label'     => __('Spacing', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_text_color',
            [
                'label'     => __('Text Color', 'auros-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-team-description',
            ]
        );

        $this->end_controls_section();


        // Social.
        $this->start_controls_section(
            'section_style_team_social',
            [
                'label' => __('Social', 'auros-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'social_font_size',
            [
                'label'     => __('Font Size', 'auros-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 16,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_size',
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
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_social_style' );

        $this->start_controls_tab(
            'tab_social_normal',
            [
                'label' => __( 'Normal', 'auros-core' ),
            ]
        );

        $this->add_control(
            'background_social',
            [
                'label' => __( 'Background', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_social',
            [
                'label' => __( 'Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_social_hover',
            [
                'label' => __( 'Hover', 'auros-core' ),
            ]
        );

        $this->add_control(
            'background_social_hover',
            [
                'label' => __( 'Background', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_social_hover',
            [
                'label' => __( 'Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_socail_hover',
            [
                'label' => __( 'Border Color', 'auros-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name' => 'border_social',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-team-socials li.social a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'social_border_radius',
            [
                'label' => __('Border Radius', 'auros-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_padding',
            [
                'label' => __('Padding', 'auros-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'social_margin',
            [
                'label' => __('Margin', 'auros-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-teams-wrapper');
        $this->add_render_attribute('wrapper', 'class', $settings['style']);


        // Item
        $this->add_render_attribute('item', 'class', 'elementor-team-item');

        $this->add_render_attribute('meta', 'class', 'elementor-team-meta');

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('item'); ?>>
                <?php $this->render_style( $settings)?>
            </div>
        </div>
    <?php
    }

    protected function render_style( $settings){ ?>
        <div class="elementor-team-meta-inner">
            <div class="elementor-team-image">
                <?php
                if (!empty($settings['image']['url'])) :
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
                    echo $image_html;
                endif;
                ?>
            </div>
            <div class="elementor-team-details">
                <?php
                $team_name_html = $settings['name'];
                if (!empty($settings['link']['url'])) :
                    $team_name_html = '<a href="' . esc_url($settings['link']['url']) . '">' . $team_name_html . '</a>';
                endif;
                ?>
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $settings['job']; ?></div>
                <div class="elementor-team-description"><?php echo $settings['description']; ?></div>
                <div class="elementor-team-socials">
                    <ul class="socials">
                        <?php foreach ($this->get_socials() as $key => $social): ?>
                            <?php if (!empty($settings[$key])) : ?>
                                <li class="social">
                                    <a href="<?php echo esc_url($settings[$key]) ?>">
                                        <i class="fa <?php echo esc_attr($social); ?>"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_socials(){
        return array(
            'facebook'  => 'fa-facebook',
            'twitter'   => 'fa-twitter',
            'youtube'   => 'fa-youtube',
            'google'    => 'fa-google-plus',
        );
    }

}
$widgets_manager->register_widget_type(new OSF_Elementor_Team_Box());
