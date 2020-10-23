<?php
/**
 * @return string
 */
function osf_theme_custom_css() {
    $a1root = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/a1root.php';
    $grid = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/grid.php';
    $main_menu = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/main-menu.php';
    $button = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/button.php';
    $error_404 = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/error-404.php';
    $heading = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/heading.php';
    $main_layout = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/main-layout.php';
    $page_bg = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/page-bg.php';
    $page_title = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/page-title.php';
    $sidebar = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/sidebar.php';
    $widget = include trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'inc/customize/widget.php';
    $css = <<<CSS
{$a1root}
{$grid}
{$main_menu}
{$error_404}
{$heading}
{$main_layout}
{$page_bg}
{$page_title}
{$sidebar}
{$widget}
{$button}
CSS;

    $css = apply_filters('osf_theme_customizer_css', $css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}

/**
 * @return string
 */
function osf_theme_custom_css_no_cache($css) {
    global $osf_header;
    if ($osf_header) {
        $header_css = get_post_meta($osf_header->ID, '_wpb_shortcodes_custom_css', true);
        $css .= $header_css;
        $bg_header = osf_get_metabox($osf_header->ID, 'osf_header_bg_color_mobile', '');
        if(!empty($bg_header)){
            $css .= '@media(max-width: 991px){.opal-header-absolute .site-header{background:'.$bg_header.';}}';
        }
    }

    // Footer Css
    $footer_id = get_theme_mod('osf_footer_layout');
    $page_id = get_the_ID();

    if (is_page() && osf_get_metabox(get_the_ID(), 'osf_enable_custom_footer', false)) {
        $footer_id = osf_get_metabox($page_id, 'osf_footer_layout', false);
        $footer_padding_top = osf_get_metabox(get_the_ID(), 'osf_footer_padding_top', 15);
        $css .= '.site-footer {padding-top:' . $footer_padding_top . 'px!important;}';
    }
    if ($footer_id) {
        $footer_css = get_post_meta($footer_id, '_wpb_shortcodes_custom_css', true);
        $css .= $footer_css;
    }

    // Padding Page
    if (is_page()) {
        $padding_top = osf_get_metabox($page_id, 'osf_padding_top', 0);
        $padding_bottom = osf_get_metabox($page_id, 'osf_padding_bottom', 0);
        if (is_front_page()) {
            $css .= '.panel-content .wrap{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.panel-content .wrap{padding-bottom:' . $padding_bottom . 'px!important;}';
        } else {
            $css .= '.site-content{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.site-content{padding-bottom:' . $padding_bottom . 'px!important;}';
        }

        $page_title_bar = $page_title_css_color = $breadcrumb_css = '';
        $page_title_bg_color = get_post_meta(get_the_ID(), 'osf_breadcrumb_bg_color', 1);
        $page_title_bg_image = get_post_meta(get_the_ID(), 'osf_breadcrumb_bg_image', 1);
        $breadcrumb_color = get_post_meta(get_the_ID(), 'osf_breadcrumb_text_color', 1);
        $page_title_color = get_post_meta(get_the_ID(), 'osf_heading_color', 1);
        if (!empty($page_title_bg_color) && $page_title_bg_color != '#fafafa') {
            $css .= '.page-title-bar {background-color: ' . $page_title_bg_color . ';}';
        }
        if (!empty($page_title_bg_image)) {
            $page_title_bar .= "background-image: url({$page_title_bg_image});";
            $css .= '.page-title-bar {' . $page_title_bar . '}';
        }
        if ($page_title_color && $page_title_color != '#666') {
            $page_title_css_color .= "color: {$page_title_color};";
            $css .= '.page-title{' . $page_title_css_color . '}';
        }
        if (!empty($breadcrumb_color)) {
            $breadcrumb_color = ariColor::new_color($breadcrumb_color);
            $breadcrumb_css .= "color: {$breadcrumb_color->toCSS()};";
            $css .= '.breadcrumb, .breadcrumb span, .breadcrumb * {' . $breadcrumb_css . '}';
        }
    }

    return $css;
}

add_filter('osf_theme_custom_inline_css', 'osf_theme_custom_css_no_cache');