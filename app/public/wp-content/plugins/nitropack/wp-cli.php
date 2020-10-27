<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
* Connects a website to NitroPack
*
* ## OPTIONS
*
* <siteID>
* : The site ID obtained from https://nitropack.io/user/connect
*
* <siteSecret>
* : The site secret obtained from https://nitropack.io/user/connect
*
* ## EXAMPLES
*
*     wp nitropack connect siteID siteSecret
*/

function nitropack_cli_connect($args, $assocArgs) {
    $siteId = !empty($args[0]) ? $args[0] : "";
    $siteSecret = !empty($args[1]) ? $args[1] : "";
    nitropack_verify_connect($siteId, $siteSecret);
}

/**
* Disconnects a website from NitroPack
*
* ## EXAMPLES
*
*     wp nitropack disconnect
*/

function nitropack_cli_disconnect($args, $assocArgs) {
    nitropack_disconnect();
}

/**
* Purges a website's cache
*
* ## EXAMPLES
*
*     wp nitropack purge
*/

function nitropack_cli_purge($args, $assocArgs) {
    nitropack_purge_cache();
}

/**
* Invalidate a website's cache
*
* ## EXAMPLES
*
*     wp nitropack invalidate
*/

function nitropack_cli_invalidate($args, $assocArgs) {
    nitropack_invalidate_cache();
}

/**
* Start a warmup process for a website
*
* ## EXAMPLES
*
*     wp nitropack warmup
*/

function nitropack_cli_warmup($args, $assocArgs) {
    nitropack_run_warmup();
}

WP_CLI::add_command("nitropack connect", "nitropack_cli_connect");
WP_CLI::add_command("nitropack disconnect", "nitropack_cli_disconnect");
WP_CLI::add_command("nitropack purge", "nitropack_cli_purge");
WP_CLI::add_command("nitropack invalidate", "nitropack_cli_invalidate");
WP_CLI::add_command("nitropack warmup", "nitropack_cli_warmup");
