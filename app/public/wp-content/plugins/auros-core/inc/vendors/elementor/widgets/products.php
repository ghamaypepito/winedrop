<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products extends OSF_Elementor_Carousel_Base
{


    public function get_categories()
    {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'opal-products';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Opal Products', 'auros-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-tabs';
    }


    public static function get_button_sizes()
    {
        return [
            'xs' => __('Extra Small', 'auros-core'),
            'sm' => __('Small', 'auros-core'),
            'md' => __('Medium', 'auros-core'),
            'lg' => __('Large', 'auros-core'),
            'xl' => __('Extra Large', 'auros-core'),
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
    protected function _register_controls()
    {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'auros-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'limit',
            [
                'label' => __('Posts Per Page', 'auros-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label' => __('columns', 'auros-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'auros-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'auros-core'),
                    'id' => __('Post ID', 'auros-core'),
                    'menu_order' => __('Menu Order', 'auros-core'),
                    'popularity' => __('Number of purchases', 'auros-core'),
                    'rating' => __('Average Product Rating', 'auros-core'),
                    'title' => __('Product Title', 'auros-core'),
                    'rand' => __('Random', 'auros-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => __('ASC', 'auros-core'),
                    'desc' => __('DESC', 'auros-core'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => __('Categories', 'auros-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_product_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => __('Category Operator', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => [
                    'AND' => __('AND', 'auros-core'),
                    'IN' => __('IN', 'auros-core'),
                    'NOT IN' => __('NOT IN', 'auros-core'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'product_type',
            [
                'label' => __('Product Type', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest' => __('Newest Products', 'auros-core'),
                    'on_sale' => __('On Sale Products', 'auros-core'),
                    'best_selling' => __('Best Selling', 'auros-core'),
                    'top_rated' => __('Top Rated', 'auros-core'),
                    'featured' => __('Featured Product', 'auros-core'),
                ],
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label' => __('Paginate', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'auros-core'),
                    'pagination' => __('Pagination', 'auros-core'),
                ],
                'condition' => [
                    'ajax_show!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'product_layout',
            [
                'label' => __('Product Layout', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'auros-core'),
                    'list' => __('List', 'auros-core'),
                ],
                'condition' => [
                    'ajax_show!' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'product_gutter',
            [
                'label' => __('Gutter', 'auros-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}}.elementor-product-style-2 ul.products li.product' => 'padding-top: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} ul.products' => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                    '{{WRAPPER}}.elementor-product-style-2 ul.products' => 'margin-left: calc(({{SIZE}}{{UNIT}} / -2) - 1px); margin-right: calc(({{SIZE}}{{UNIT}} / -2) - 1px);',
                    '{{WRAPPER}}.elementor-product-style-4 ul.products li.product, {{WRAPPER}}.elementor-product-style-5 ul.products li.product' => 'padding-top: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: 0;',
                ],
                'condition' => [
                    'product_style!' => 'style-3'
                ]
            ]
        );

        $this->add_control(
            'product_style',
            [
                'label' => __('Product Style', 'auros-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => __('Style 1', 'auros-core'),
                    'style-2' => __('Style 2', 'auros-core'),
                    'style-3' => __('Style 3', 'auros-core'),
                    'style-4' => __('Style 4', 'auros-core'),
                    'style-5' => __('Style 5', 'auros-core'),
                ],
                'prefix_class' => 'elementor-product-'
            ]
        );

        $this->end_controls_section();
        // End Section Query

        // Carousel Option
        $this->add_control_carousel(array(
            'product_layout' => 'grid'
        ));

        // Ajax load more
        if (otf_is_ajax_load_more_activated()) {
            $ajax = new OSF_Ajax_Load_More;
            $ajax->add_control_ajax_load_more($this);
        }

    }


    protected function get_product_categories()
    {
        $categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }

    protected function get_product_type($atts, $product_type)
    {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            case 'on_sale':
                $atts['on_sale'] = true;
                break;

            case 'best_selling':
                $atts['best_selling'] = true;
                break;

            case 'top_rated':
                $atts['top_rated'] = true;
                break;

            default:
                break;
        }

        return $atts;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (otf_is_ajax_load_more_activated() && ($settings['ajax_show'] === 'yes') && !is_admin()) {
            $atts = [
                'posts_per_page' => $settings['limit'],
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
                'container_type' => 'ul',
                'post_type' => 'product',
                'css_classes' => 'products',
                'transition_container' => 'false',
                'images_loaded' => 'true',
                'transition' => 'masonry',
            ];

            if (empty($settings['ajax_scroll'])) {
                $atts['scroll'] = 'false';
            }

            if (!empty($settings['button_label'])) {
                $atts['button_label'] = $settings['button_label'];
            }

            if (!empty($settings['button_loading_label'])) {
                $atts['button_loading_label'] = $settings['button_loading_label'];
            }

            if (!empty($settings['categories'])) {
                $atts['taxonomy'] = 'product_cat';
                $atts['taxonomy_terms'] = implode(',', $settings['categories']);
                $atts['taxonomy_operator'] = $settings['cat_operator'];
            }
            // Best seller
            if ($settings['product_type'] === 'best_selling') {
                $atts['meta_key'] = 'total_sales';
                $atts['order'] = 'DESC';
                $atts['orderby'] = 'meta_value_num';
            }
            // On Sale
            if ($settings['product_type'] === 'on_sale') {
                $atts['post__in'] = implode(',', wc_get_product_ids_on_sale());
            }
            // Featured
            if ($settings['product_type'] === 'featured') {
                $post_in = '';
                foreach (wc_get_featured_product_ids() as $key => $value) {
                    $post_in .= $value . ',';
                }
                $atts['post__in'] = $post_in;

            }
            // Top Rate
            if ($settings['product_type'] === 'top_rated') {
                $atts['meta_key'] = '_wc_average_rating';
                $atts['order'] = 'DESC';
                $atts['orderby'] = 'meta_value_num';
            }

            $code = '';
            foreach ($atts as $key => $value) {
                $code .= $key . '="' . $value . '" ';
            }

            echo "<div class='columns-" . esc_attr($settings['column']) . "'>";
            echo str_replace('data-post-type',
                'data-theme-repeater="woocommerce.php" data-post-type',
                do_shortcode('[ajax_load_more ' . $code . ' ]')
            );
            echo "<div>";

        } else {
            $this->woocommerce_default($settings);
        }

    }

    private function woocommerce_default($settings)
    {
        $type = 'products';
        $atts = [
            'limit' => $settings['limit'],
            'columns' => $settings['column'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'product_layout' => $settings['product_layout'],
        ];

        $atts = $this->get_product_type($atts, $settings['product_type']);
        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }

        if (!empty($settings['categories'])) {
            $atts['category'] = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }

        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['carousel_settings'] = json_encode(wp_slash($this->get_carousel_settings()));
            $atts['product_layout'] = 'carousel';
        } else {

            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }
            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }
        }

        if ($settings['paginate'] === 'pagination') {
            $atts['paginate'] = 'true';
        }

        $shortcode = new WC_Shortcode_Products($atts, $type);

        ?>
        <div <?php echo $this->get_render_attribute_string('row') ?>>
            <?php
            echo $shortcode->get_content();
            ?>
        </div>
        <?php

        if (otf_is_ajax_load_more_activated() && ($settings['ajax_show'] === 'yes') && is_admin()) {
            $options = get_option('alm_settings');
            $btn_color = '';
            if (isset($options['_alm_btn_color'])) {
                $btn_color = ' ' . $options['_alm_btn_color'];
            }
            if (alm_do_inline_css('_alm_inline_css') && !alm_css_disabled('_alm_disable_css')) {
                $file = ALM_PATH . '/core/dist/css/' . ALM_SLUG . '.min.css'; // Core Ajax Load More
                echo ALM_ENQUEUE::alm_inline_css(ALM_SLUG, $file, ALM_URL);
            }
            echo '<div class="ajax-load-more-wrap' . $btn_color . '"><div class="alm-btn-wrap" style="visibility: visible;"><button class="alm-load-more-btn more loading" rel="next">Older Posts</button></div></div>';
        }
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Products());