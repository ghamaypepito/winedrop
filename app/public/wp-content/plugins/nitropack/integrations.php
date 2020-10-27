<?php

if (nitropack_is_wpe()) {
    define("NITROPACK_USE_MICROTIMEOUT", 20000);
}

function nitropack_check_and_init_integrations() {
    $siteConfig = nitropack_get_site_config();
    if ($siteConfig && !empty($siteConfig["hosting"])) {
        $hosting = $siteConfig["hosting"];
    } else {
        $hosting = nitropack_detect_hosting();
    }

    switch ($hosting) {
    case "cloudways":
        add_action('nitropack_integration_purge_url', 'nitropack_cloudways_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_cloudways_purge_all');
        break;
    case "flywheel":
        add_filter('nitropack_varnish_purger', 'nitropack_flywheel_varnish_instance');
        add_action('nitropack_integration_purge_url', 'nitropack_varnish_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_varnish_purge_all');
        break;
    case "wpengine":
        add_action('nitropack_integration_purge_url', 'nitropack_wpe_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_wpe_purge_all');
        break;
    case "siteground":
        add_action('nitropack_integration_purge_url', 'nitropack_siteground_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_siteground_purge_all');
        break;
    case "godaddy_wpaas":
        add_action('nitropack_integration_purge_url', 'nitropack_wpaas_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_wpaas_purge_all');
        break;
    case "kinsta":
        add_action('nitropack_integration_purge_url', 'nitropack_kinsta_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_kinsta_purge_all');
        break;
    default:
        break;
    }

    if (!empty($siteConfig["isNginxHelperActive"])) {
        add_action('nitropack_integration_purge_url', 'nitropack_nginx_helper_purge_url');
        add_action('nitropack_integration_purge_all', 'nitropack_nginx_helper_purge_all');
    }

    add_action('plugins_loaded', 'nitropack_init_late_integrations');
}

function nitropack_init_late_integrations() {
    if (defined('SHORTPIXEL_AI_VERSION')) { // ShortPixel
        if (nitropack_is_ajax()) {
            if (version_compare(SHORTPIXEL_AI_VERSION, "2", ">=")) { // ShortPixel AI 2.x
                remove_action('wp_enqueue_scripts', array(ShortPixelAI::_(), 'enqueue_script'));
                remove_action('init', array(ShortPixelAI::_(), 'init_ob'), 1);
                remove_filter('script_loader_tag', array(ShortPixelAI::_(), 'disable_rocket-Loader'), 10);
            } else { // ShortPixel AI 1.x
                remove_action('wp_enqueue_scripts', array(ShortPixelAI::instance(SHORTPIXEL_AI_PLUGIN_FILE), 'enqueue_script'), 11);
                remove_action('init', array(ShortPixelAI::instance(SHORTPIXEL_AI_PLUGIN_FILE), 'init_ob'), 1);
                remove_filter('rocket_css_content', array(ShortPixelAI::instance(SHORTPIXEL_AI_PLUGIN_FILE), 'parse_cached_css'), 10);
                remove_filter('script_loader_tag', array(ShortPixelAI::instance(SHORTPIXEL_AI_PLUGIN_FILE), 'disable_rocket-Loader'), 10);
            }
        }
    }
}

/** WP Engine **/
function nitropack_wpe_purge_url($url) {
    try {
        $handler = function($paths) use($url) {
            $wpe_path = parse_url($url, PHP_URL_PATH);
            $wpe_query = parse_url($url, PHP_URL_QUERY);
            $varnish_path = $wpe_path;
            if (!empty($wpe_query)) {
                $varnish_path .= '?' . $wpe_query;
            }
            if ($url && count($paths) == 1 && $paths[0] == ".*") {
                return array($varnish_path);
            }
            return $paths;
        };
        add_filter( 'wpe_purge_varnish_cache_paths', $handler );
        WpeCommon::purge_varnish_cache();
        remove_filter( 'wpe_purge_varnish_cache_paths', $handler );
    } catch (\Exception $e) {
        // WPE exception
    }
}

function nitropack_wpe_purge_all() {
    try {
        WpeCommon::purge_varnish_cache();
    } catch (\Exception $e) {
        // WPE exception
    }
}

/** Cloudways' Breeze plugin **/
function nitropack_cloudways_purge_url($url) {
    try {
        $purger = new \NitroPack\SDK\Integrations\Varnish(array("127.0.0.1"), "URLPURGE");
        $purger->purge($url);
    } catch (\Exception $e) {
        // Breeze exception
    }
}

function nitropack_cloudways_purge_all() {
    try {
        $homepage = home_url().'/.*';
        $purger = new \NitroPack\SDK\Integrations\Varnish(array("127.0.0.1"), "PURGE");
        $purger->purge($homepage);
    } catch (\Exception $e) {
        // Exception
    }
}

/** SiteGround - Even though they use Nginx we can communicate with it as if it was Varnish **/
function nitropack_siteground_purge_url($url) {
    $url = preg_replace("/^https?:\/\//", "", $url);
    $url = preg_replace("/^www\./", "", $url);
    $url = "http://" . $url;

    try {
        $hosts = ['127.0.0.1'];
        $purger = new \NitroPack\SDK\Integrations\Varnish($hosts, 'PURGE');
        $purger->purge($url);
    } catch (\Exception $e) {}

    return true;
}

function nitropack_siteground_purge_all() {
    $siteConfig = nitropack_get_site_config();
    if ($siteConfig && !empty($siteConfig["home_url"])) {
        return nitropack_siteground_purge_url($siteConfig["home_url"]);
    }
    return false;
}

/** GoDaddy WPaaS - Even though they use ApacheTrafficServer we can communicate with it as if it was Varnish **/
function nitropack_wpaas_purge_url($url) {
    if (class_exists('\WPaaS\Plugin')) {
        update_option( 'gd_system_last_cache_flush', time() );
        $hosts = [\WPaaS\Plugin::vip()];
        $url = preg_replace("/^https:\/\//", "http://", $url);
        $purger = new \NitroPack\SDK\Integrations\Varnish($hosts, 'BAN');
        $purger->purge($url);
        return true;
    }

    return false;
}

function nitropack_wpaas_purge_all() {
    $siteConfig = nitropack_get_site_config();
    if ($siteConfig && !empty($siteConfig["home_url"])) {
        return nitropack_wpaas_purge_url($siteConfig["home_url"]);
    }
    return false;
}

/** Kinsta **/
function nitropack_kinsta_purge_url($url) {
    try {
        $data = array(
            'single|nitropack' => preg_replace( '@^https?://@', '', $url)
        );
        $httpClient = new \NitroPack\HttpClient("https://localhost/kinsta-clear-cache/v2/immediate");
        $httpClient->setPostData($data);
        $httpClient->fetch(true, "POST");
        return true;
    } catch (\Exception $e) {
    }

    return false;
}

function nitropack_kinsta_purge_all() {
    try {
        $httpClient = new \NitroPack\HttpClient("https://localhost/kinsta-clear-cache-all");
        $httpClient->timeout = 5;
        $httpClient->fetch();
        return true;
    } catch (\Exception $e) {
    }

    return false;
}

/** Flywheel Varnish **/
function nitropack_flywheel_varnish_instance($type) {
    return new \NitroPack\SDK\Integrations\Varnish(array('127.0.0.1'), 'PURGE');
}

/** Generic Varnish **/
function nitropack_varnish_generic_instance($type) {
    $varnishConfig = nitropack_get_varnish_settings();
    $purgeMethod = ($type == 'single') ? $varnishConfig->PurgeSingleMethod : $varnishConfig->PurgeAllMethod;
    if (empty($purgeMethod)) $purgeMethod = 'PURGE';
    return new \NitroPack\SDK\Integrations\Varnish($varnishConfig->Servers, $purgeMethod);
}

function nitropack_varnish_purge_url($url) {
    try {
        $purger = apply_filters('nitropack_varnish_purger', 'single');
        $purger->purge($url);
    } catch (\Exception $e) {
        // Exception encountered while trying to purge varnish cache
    }
}

function nitropack_varnish_purge_all() {
    try {
        $purger = apply_filters('nitropack_varnish_purger', 'all');
        if (function_exists("get_home_url")) {
            $home = get_home_url();
        } else {
            $siteConfig = nitropack_get_site_config();
            $home = "/";
            if ($siteConfig && !empty($siteConfig["home_url"])) {
                $home = $siteConfig["home_url"];
            }
        }
        $purger->purge($home);
    } catch (\Exception $e) {
        // Exception encountered while trying to purge varnish cache
    }
}

function nitropack_get_varnish_settings() {
    if (null !== $nitro = get_nitropack_sdk()) {
        $config = $nitro->getConfig();
        return !empty($config->CacheIntegrations) && $empty($config->CacheIntegrations->Varnish) ? $config->CacheIntegrations->Varnish : null;
    }

    return null;
}

// Nginx Helper integration
function nitropack_is_nginx_helper_active() {
    return defined('NGINX_HELPER_BASEPATH');
}

function nitropack_nginx_helper_purge_url($url) {
    global $nginx_purger;
    $nginx_purger->purge_url($url);
    return true;
}

function nitropack_nginx_helper_purge_all() {
    global $nginx_purger;
    $nginx_purger->purge_all();
    return true;
}

// Ezoic integration
function nitropack_is_ezoic_active() {
    return defined('EZOIC_INTEGRATION_VERSION');
}

function nitropack_disable_ezoic() {
    global $wp_filter;
    $hook = "shutdown";

    if ( isset( $wp_filter[$hook]->callbacks ) ) {      
        array_walk( $wp_filter[$hook]->callbacks, function( $callbacks, $priority ) use ( &$hooks ) {           
            foreach ( $callbacks as $id => $callback ) {
                $cb = $callback["function"];
                if (is_callable($cb) && is_array($cb) && $cb[1] == "ez_buffer_end") {
                    remove_filter("shutdown", $cb, $priority);
                    register_shutdown_function('ob_end_flush');
                }
            }
        });         
    }
}

function nitropack_ezoic_home_url($url) {
    $siteConfig = nitropack_get_site_config();
    if ( $siteConfig && null !== $nitro = get_nitropack_sdk($siteConfig["siteId"], $siteConfig["siteSecret"]) ) {
        $nitroUrl = $nitro->getUrl();
        $queryStart = strpos($nitroUrl, "?");
        if ($queryStart !== false) {
            return substr($nitroUrl, 0, $queryStart);
        } else {
            return $nitroUrl;
        }
    }

    return $url;
}
