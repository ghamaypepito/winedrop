<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Addons {
	public function __construct() {
		$this->include_addons();
		add_action( 'elementor/init', array( $this, 'add_category' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );

		add_action( 'wp', [ $this, 'regeister_scripts_frontend' ] );

		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts_frontend' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'add_scripts_editor' ] );
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

		add_action( 'widgets_init', array( $this, 'register_wp_widgets' ) );

		// Elementor Fix Noitice
		add_action('elementor/editor/before_enqueue_scripts', array($this, 'elementor_fix_notice'));

        // Custom Animation Scroll
        add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);
    }

    public function add_animations_scroll($animations) {
        $animations['Opal Animation'] = [
            'opal-move-up'    => 'Move Up',
            'opal-move-down'  => 'Move Down',
            'opal-move-left'  => 'Move Left',
            'opal-move-right' => 'Move Right',
            'opal-flip'       => 'Flip',
            'opal-helix'      => 'Helix',
            'opal-scale-up'   => 'Scale',
//            'opal-am-popup'   => 'Popup',
        ];
        return $animations;
    }

    public function enqueue_editor_icons() {
        wp_enqueue_style(
            'activ-academy-editor-icon',
            trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/css/elementor/icons.css',
            [],
            AUROS_CORE_VERSION
        );
    }

	public function elementor_fix_notice() {
		if (function_exists('WC')) {
			remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
			remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
		}
	}

	private function include_addons(){
		$files = glob(trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/addons/*.php');
		foreach ($files as $file){
			if(file_exists($file)){
				require_once $file;
			}
		}
	}

	public function register_wp_widgets() {
		require_once 'widgets/wp_template.php';
		register_widget( 'Opal_WP_Template' );
	}

	function regeister_scripts_frontend() {
		$dev_mode = get_theme_mod( 'osf_dev_mode', false );
		wp_register_style( 'magnific-popup', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/css/magnific-popup.css' );
		wp_register_style( 'tooltipster-bundle', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/css/tooltipster.bundle.min.css', array(), AUROS_CORE_VERSION, 'all' );

		wp_register_script( 'magnific-popup', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/js/libs/jquery.magnific-popup.min.js', array( 'jquery' ), AUROS_CORE_VERSION, true );
		wp_register_script( 'spritespin', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/js/libs/spritespin.js', array('jquery'),  AUROS_CORE_VERSION);

        wp_register_script('tweenmax', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/TweenMax.min.js', array('jquery'), AUROS_CORE_VERSION, true);
        wp_register_script('parallaxmouse', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/jquery-parallax.js', array('jquery'), AUROS_CORE_VERSION, true);
        wp_register_script('tilt', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/universal-tilt.min.js', array('jquery'), AUROS_CORE_VERSION, true);
        wp_register_script('waypoints', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.waypoints.js', array('jquery'), AUROS_CORE_VERSION, true);

		wp_register_script( 'smartmenus', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/js/libs/jquery.smartmenus.min.js', array( 'jquery' ), AUROS_CORE_VERSION, true );
		wp_register_script( 'tooltipster-bundle-js', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/js/libs/tooltipster.bundle.min.js', array(), AUROS_CORE_VERSION, true );

		wp_register_script('wavify', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/wavify.js', array( 'jquery' ), AUROS_CORE_VERSION, true);
		wp_register_script('jquery-wavify', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.wavify.js', array( 'jquery' ), AUROS_CORE_VERSION, true);

		wp_register_script('fullpage', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/fullpage.min.js', array( 'jquery' ), AUROS_CORE_VERSION, true);

        wp_register_script('pushmenu', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/mlpushmenu.js', array(), AUROS_CORE_VERSION, true);
        wp_register_script('pushmenu-classie', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/classie.js', array(), AUROS_CORE_VERSION, true);
        wp_register_script('modernizr', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/libs/modernizr.custom.js', array(), AUROS_CORE_VERSION, false);

		if ( osf_is_elementor_activated() && ! $dev_mode ) {
			wp_enqueue_style( 'osf-elementor-addons', trailingslashit( AUROS_CORE_PLUGIN_URL ) . 'assets/css/elementor/style.css', array(
				'auros-style'
			), AUROS_CORE_VERSION );
		}
    }

    public function add_scripts_editor() {
        wp_enqueue_script('opal-elementor-admin-editor', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/elementor/admin-editor.js', [], false, true);
    }


    public function enqueue_scripts_frontend() {
        wp_enqueue_script('opal-elementor-frontend', trailingslashit(AUROS_CORE_PLUGIN_URL) . 'assets/js/elementor/frontend.js', ['jquery'], false, true);
    }

    public function add_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-addons',
            array(
                'title' => __('Opal Addons', 'auros-core'),
                'icon'  => 'fa fa-plug',
            ),
            1);
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager) {
        require 'abstract/carousel.php';
        $files = glob(trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/widgets/*.php');
        foreach ($files as $file){
            if(file_exists($file)){
                require_once  $file;
            }
        }
	}
}

new OSF_Elementor_Addons();

