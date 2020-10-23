<?php
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class OSF_Elementor_Parallax {
	public function __construct() {
//		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 3 );

		// Fix Parallax granular-controls-for-elementor
		if ( function_exists( 'granular_get_options' ) ) {
			$parallax_on = granular_get_options( 'granular_editor_parallax_on', 'granular_editor_settings', 'no' );
			if ( 'yes' === $parallax_on ) {
				add_action( 'elementor/frontend/section/after_render', [
					$this,
					'granular_editor_after_render'
				], 10, 1 );
			}
		}
	}
	public function granular_editor_after_render( $element ) {
		$settings = $element->get_settings();
		if ( $element->get_settings( 'section_parallax_on' ) == 'yes' ) {
			$type        = $settings['parallax_type'];
			$and_support = $settings['android_support'];
			$ios_support = $settings['ios_support'];
			$speed       = $settings['parallax_speed'];
			?>

			<script type="text/javascript">
                (function ($) {
                    "use strict";
                    var granularParallaxElementorFront = {
                        init      : function () {
                            elementorFrontend.hooks.addAction('frontend/element_ready/global', granularParallaxElementorFront.initWidget);
                        },
                        initWidget: function ($scope) {
                            $('.elementor-element-<?php echo $element->get_id(); ?>').jarallax({
                                type       : '<?php echo $type; ?>',
                                speed      : <?php echo $speed; ?>,
                                keepImg    : true,
                                imgSize    : 'cover',
                                imgPosition: '50% 0%',
                                noAndroid  : <?php echo $and_support; ?>,
                                noIos      : <?php echo $ios_support; ?>
                            });
                        }
                    };
                    $(window).on('elementor/frontend/init', granularParallaxElementorFront.init);
                }(jQuery));
			</script>

		<?php }
	}

//	public function register_controls( $element, $section_id, $args ) {
//		static $sections = [
//			'layout', /* Column */
//			'section_layout', /* Section */
//		];
//
//		if ( ! in_array( $section_id, $sections ) ) {
//			return;
//		}
//
//		$element->start_controls_section(
//			'section_sticky',
//			[
//				'label' => __( 'Sticky ', 'auros-core' ),
//				'tab'   => Controls_Manager::TAB_LAYOUT,
//			]
//		);
//
//		$element->add_control(
//			'sticky_show',
//			[
//				'label'        => __( 'Enable Sticky', 'auros-core' ),
//				'type'         => Controls_Manager::SWITCHER,
//				'default'      => '',
//				'label_on'     => 'Yes',
//				'label_off'    => 'No',
//				'return_value' => 'active',
//				'prefix_class' => 'osf-sticky-',
//			]
//		);
//
//		$element->end_controls_section();
//
//	}
}
new OSF_Elementor_Parallax();