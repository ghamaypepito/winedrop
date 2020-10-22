<?php

namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Wavify extends Widget_Base {

	public function get_categories() {
		return array( 'opal-addons' );
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
		return 'opal-wavify';
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
		return __( 'Opal Wavify', 'auros-core' );
	}

	public function get_script_depends() {
		return [
			'tweenmax',
			'wavify',
			'jquery-wavify'
		];
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
			'section_wavify',
			[
				'label' => __( 'Wavify', 'auros-core' ),
			]
		);
		$this->add_responsive_control(
			'wave_wrap_height',
			[
				'label'     => __( 'Wrap Height', 'auros-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'   => [
					'size' => 100,
					'unit' => 'px'
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .wavify-wraper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'wave_color',
			[
				'label'              => __( 'Wavify Color', 'auros-core' ),
				'type'               => Controls_Manager::COLOR,
				'description'        => __( 'Number of articulations in the wave', 'auros-core' ),
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'wave_bones',
			[
				'label'              => __( 'Bones', 'auros-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 3,
				'description'        => __( 'Number of articulations in the wave', 'auros-core' ),
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'wave_animate',
			[
				'label'              => __( 'Speed', 'auros-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0.25,
				'description'        => __( 'Number of articulations in the wave', 'auros-core' ),
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'wave_height',
			[
				'label'              => __( 'Height', 'auros-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 60,
				'frontend_available' => true,
			]
		);
		$repeater->add_control(
			'wave_amplitude',
			[
				'label'              => __( 'Amplitude', 'auros-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 40,
				'description'        => __( 'Vertical distance wave travels', 'auros-core' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'repeater_item',
			[
				'label'  => __( 'Wave', 'auros-core' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
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
		$z_index  = 1;
		?>
        <div class="wavify-wraper">
			<?php
			foreach ( $settings['repeater_item'] as $index => $item ) :
				$z_index ++;
				$height = $settings['wave_wrap_height']['size'] - $item['wave_height'];
				?>
                <svg width="100%" height="100%" version="1.1"
                     style="display: block; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index:<?php echo esc_attr( $z_index ); ?> "
                     xmlns="http://www.w3.org/2000/svg">
                    <defs></defs>
                    <path class="wavify otf-<?php echo $item['_id']; ?>" d=""/>
                </svg>
                <script type="text/javascript">
                    (function ($) {
                        "use strict";
                        var Wavify = {
                            init      : function () {
                                elementorFrontend.hooks.addAction('frontend/element_ready/global', Wavify.initWidget);
                            },
                            initWidget: function ($scope) {
                                $('.otf-<?php echo $item['_id']; ?>').wavify({
                                    height   : <?php echo $height ?>,
                                    bones    : <?php echo $item['wave_bones']?>,
                                    amplitude: <?php echo $item['wave_amplitude']?>,
                                    color    : '<?php echo $item['wave_color']?>',
                                    speed    : <?php echo $item['wave_animate']?>,
                                });
                            }
                        };
                        $(window).on('elementor/frontend/init', Wavify.init);
                    }(jQuery));
                </script>
			<?php endforeach; ?>
        </div>
		<?php
	}
}
$widgets_manager->register_widget_type(new OSF_Elementor_Wavify());
