<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'zGBbRgnhZMXodXSTJY1uUw8ubejEkpz0/qRweicxjcWdsImkrmlwGq1oJzAgyaqWvXpdyOmypzbEf+4k85B71Q==');
define('SECURE_AUTH_KEY',  '2EUDJguT62J2k9rqka5ZAIxWs+vXw2Kt7OozbvC/wAlL4c8LaUvSHjnBJJf8DUIXUOeuwKwHXHU4rVsxVigtQg==');
define('LOGGED_IN_KEY',    'PSdMUIPpUHOJKJT2MGEti6jzXAuc0+/4Ln/oceG6HyYWBHKOtAn6SlkmOQ/jjKVb6m5BC76f1eQLqPCiMeDJTg==');
define('NONCE_KEY',        'z31Q7aDErP3rb109OPgFWcvJv6M0VcrwyI6yrVE7zqbAM0uf/A+31JenkR0cxFc+NporMYVO6OTDgTE2yAifEw==');
define('AUTH_SALT',        'oEO+gchqoJtOKrvXaY3zDTE2O21pxPh3fGha7ocXw4UUoX+gPsA7DdrHK9HvrVQ5xUC4rSgZbKeSNFE99nqLdg==');
define('SECURE_AUTH_SALT', 'Yh+NMTvYyWmek5eEqxyzf0WKc7xX2Rw7rC5XOoQ3O4Vwv7G9WFn3Sq87kKEsPEAjChgwn9GhKKVeL4lpns7ngA==');
define('LOGGED_IN_SALT',   'BoiA4NwfQ7roKR5jPhqDwt1Ekrbxis8UqZbWelj6A1+AmlrNdD04jT41wLpVXjO61eyvnl6tO+sGO8PryazYlQ==');
define('NONCE_SALT',       'mjynlTZLDjr3OXYbSCJyZBqumV1HqSp35uxe2XNyqZndwwnyVlXq4KnbMYr48IxAaNkpgD3CEINPxHzV0ybzsQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
