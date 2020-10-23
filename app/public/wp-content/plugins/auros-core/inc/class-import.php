<?php

class OSF_Import {
    private $config, $path_rev, $homepage, $blogpage, $settings, $templates;

    public function __construct() {
        if (is_admin()) {
            $this->path_rev = trailingslashit(wp_upload_dir()['basedir']) . 'opal_rev_sliders_import/';
            add_action('after_setup_theme', array($this, 'init'));
        }
    }

    public function init() {
        $this->init_hooks();
        add_filter('pt-ocdi/disable_pt_branding', '__return_true');
    }

    public function init_hooks() {
        add_action('osf_before_import_customizer', array($this, 'reset_theme_mods'));
        if (get_option('otf-oneclick-first-import', 'yes') === 'yes') {
            add_filter('pt-ocdi/import_files', array($this, 'import_file_base'));
            add_action('pt-ocdi/after_import', array($this, 'after_import_setup'));
            add_action('pt-ocdi/after_import', array($this, 'after_import_setup_base'), 20);
        } else {
            add_filter('pt-ocdi/import_files', array($this, 'import_files'));
            add_action('pt-ocdi/after_import', array($this, 'after_import_setup'));
            add_filter('pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false');
            add_filter('otf-ocdi/reload_page', '__return_false');
        }
    }

    public function import_file_base() {
        $this->init_data();
        $imports   = array();
        $import    = array(
            'import_file_name'  => 'Home 1',
            'local_import_file' => trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'dummy-data/content.xml',
            'import_notice'     => 'Basic import includes default version from our demo and a few products, blog posts and portfolio projects. It is a required minimum to see how our theme built and to be able to import additional versions or pages.',
            'slug'              => '1',
            'customizer'        => esc_url('http://source.wpopal.com/auros/dummy_data/auros/customizer.json'),
            'elementor'         => esc_url('http://source.wpopal.com/auros/dummy_data/auros/elementor.json'),
            'settings'          => esc_url('http://source.wpopal.com/auros/dummy_data/auros/settings.json'),

        );
        $imports[] = $import;

        return $imports;
    }

    public function import_files() {
        $this->init_data();
        $imports = array();
        if (!empty($this->config) && $this->config) {
            foreach ($this->config as $key => $item) {
                $import = array(
                    'import_file_name'         => $item['name'],
                    'import_preview_image_url' => $item['screenshot'],
                    'slug'                     => $key,
                    'settings'                 => esc_url('http://source.wpopal.com/auros/dummy_data/auros/settings.json'),
                    'customizer'               => $item['customizer']
                );
                if (isset($item['xml'])) {
                    $import['import_file_url'] = $item['xml'];
                }

                $imports[] = $import;
            }
        }
        return $imports;
    }

    private function init_data() {
        $this->config   = $this->get_remote_json(trailingslashit(AUROS_CORE_PLUGIN_URL) . 'dummy-data/config.json', true);
        $this->blogpage = get_page_by_title('Blog ');
    }

    public function after_import_setup_base($selected_import) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (($this->homepage instanceof WP_Post) ? $this->homepage->ID : 0));
        update_option('page_for_posts', (($this->blogpage instanceof WP_Post) ? $this->blogpage->ID : 0));
        update_option('otf-oneclick-first-import', 'no');

        // Setup Customizer
        $this->reset_theme_mods();
        $thememods = $this->get_remote_json($selected_import['customizer'], true);
        foreach ($thememods as $mod => $value) {
            set_theme_mod($mod, $value);
        }

        // Setup Elementor
        $this->settings = $this->get_remote_json($selected_import['settings'], true);
        $elementor      = $this->get_remote_json($selected_import['elementor'], true);

        // Breadcrumb
        update_option('bcn_options', $this->settings['breadcrumb']);

        if (osf_is_elementor_activated()) {
            $this->updateElementor();
            foreach ($elementor as $key => $value) {
                update_option($key, $value);
            }
            $this->update_url_elementor();
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }

        // Update Logo
        set_theme_mod('custom_logo', 4309);
        set_post_thumbnail(1, 4243);
    }


    public function after_import_setup($selected_import) {
        if (isset($this->config[$selected_import['slug']])) {

            $this->homepage = get_page_by_title($selected_import['import_file_name']);

            $setup = $this->config[$selected_import['slug']];
            // REVSLIDER
            if ($sliders = $setup['rev_sliders']) {
                if (class_exists('RevSliderAdmin')) {
                    if (!file_exists($this->path_rev)) {
                        wp_mkdir_p($this->path_rev);
                    }
                    foreach ($sliders as $slider) {
                        $this->add_revslider($slider);
                    }
                }
            }

            // Setup Customizer
            remove_theme_mod('osf_theme_custom_style');
            $thememods = $this->get_remote_json($selected_import['customizer'], true);
            foreach ($thememods as $mod => $value) {
                set_theme_mod($mod, $value);
            }


            $this->setup_home_page($selected_import['slug']);

            $this->settings  = $this->get_remote_json($setup['settings'], true);
            $this->templates = $this->settings['templates'];


            // Setup Home page
            update_option('page_on_front', (($this->homepage instanceof WP_Post) ? $this->homepage->ID : 0));

            // Mailchimp
            $mailchimp = get_page_by_title('Opal MailChimp', OBJECT, 'mc4wp-form');
            if ($mailchimp) {
                update_option('mc4wp_default_form_id', $mailchimp->ID);
            }
        }
        set_theme_mod('osf_dev_mode', false);
    }

    private function add_revslider($slider) {
        $dest_rev = $this->path_rev . basename($slider);
        if (!file_exists($dest_rev)) {
            file_put_contents($dest_rev, fopen($slider, 'r'));
            $_FILES['import_file']['error']    = UPLOAD_ERR_OK;
            $_FILES['import_file']['tmp_name'] = $dest_rev;

            $revslider = new RevSlider();
            $revslider->importSliderFromPost(true, 'none');
        }
    }

    /**
     * @param $link
     *
     * @return object|boolean
     */
    private function get_remote_json($link, $assoc = false) {
        $content = file_get_contents($link);
        if (!$content) {
            return false;
        }

        return json_decode($content, $assoc);
    }

    public function reset_theme_mods() {
        $mods = json_decode(file_get_contents(trailingslashit(AUROS_CORE_PLUGIN_DIR) . 'reset-theme-mods.json'));
        foreach ($mods as $mod) {
            remove_theme_mod($mod);
        }
    }

    private function updateElementor() {
        $query = new WP_Query(array(
            'post_type'      => [
                'page',
                'elementor_library',
                'header',
                'footer'
            ],
            'posts_per_page' => -1
        ));
        while ($query->have_posts()): $query->the_post();
            $postid = get_the_ID();
            if (get_post_meta($postid, '_elementor_edit_mode', true) === 'builder') {
                $data = json_decode(get_post_meta($postid, '_elementor_data', true), true);
                $data = $this->updateElementorData($data);
                update_post_meta($postid, '_elementor_data', wp_slash(wp_json_encode($data)));
            }
        endwhile;
        wp_reset_postdata();
    }

    private function updateElementorData($datas) {
        if (count($datas) <= 0) {
            return $datas;
        }
        foreach ($datas as $key => $data) {

            // Contact Form
            if (!empty($data['widgetType']) && $data['widgetType'] === 'opal-contactform7') {
                $data['settings']['cf_id'] = $this->get_contact_form_id(absint($data['settings']['cf_id']));
            }

            if (!empty($data['elements'])) {
                $data['elements'] = $this->updateElementorData($data['elements']);
            }
            $datas[$key] = $data;
        }

        return $datas;
    }

    private function get_contact_form_id($id) {
        $contact = get_page_by_title($this->settings['contact'][$id], OBJECT, 'wpcf7_contact_form');
        if ($contact) {
            return $contact->ID;
        }
        return $id;
    }

    private function get_image_id($image_url) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

        return $attachment[0];
    }

    private function setup_home_page($slug) {
        if ($slug == '16') {
            set_theme_mod('osf_woocommerce_product_style', '5');
        } else {
            remove_theme_mod('osf_woocommerce_product_style');
        }
    }

    private function update_url_elementor() {
        $from          = 'http://source.wpopal.com/auros';
        $to            = site_url();
        $is_valid_urls = (filter_var($from, FILTER_VALIDATE_URL) && filter_var($to, FILTER_VALIDATE_URL));
        if (!$is_valid_urls) {
            return false;
        }

        if ($from === $to) {
            return false;
        }


        global $wpdb;

        // @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
        $rows_affected = $wpdb->query(
            "UPDATE {$wpdb->postmeta} " .
            "SET `meta_value` = REPLACE(`meta_value`, '" . str_replace('/', '\\\/', $from) . "', '" . str_replace('/', '\\\/', $to) . "') " .
            "WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;"); // meta_value LIKE '[%' are json formatted
        // @codingStandardsIgnoreEnd

    }
}

return new OSF_Import();