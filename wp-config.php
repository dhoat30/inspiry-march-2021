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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
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
define('AUTH_KEY',         'VkLIimMOYaxIutDBCw6OLXhKg+iRbi8fImDGFYlPuMno1chjfIxYYndvymf+EQwufG8Cn2GDAV1yv+4bhIfvlg==');
define('SECURE_AUTH_KEY',  'RghnKvaCAC7tHpqa5gKYwUCQFDAdgzSKUzSb7UADyaam9lYa/i6h8a6ZWDKolRvEFuRpxth6mrTXXbjdvfi0ZA==');
define('LOGGED_IN_KEY',    'quxtjnTFoCvvBQcCmc7xSUn7bURGF61ESJtUbO0uwjZwyDtQuv9f6MXt6Im96Kx3R4EE/zVNaAxnRCEmqsee8A==');
define('NONCE_KEY',        'K2DwYnw6aC3MoeNrAn7qlh0VyUhP82hd3JalSg0NCVj557XVCE3aJSLuw6tbKj/HXYnbL7nSSx28Xb1Xvnkyew==');
define('AUTH_SALT',        'oOtMSBT7jglFzC47nJIUcEcvojd8lY8gtsxO/FIfJYmh+s1h3JwvpVvfmCe0RlOnjf1K5KE0a9zd5liVhJprvw==');
define('SECURE_AUTH_SALT', 'UfsoCN9OYxWO+j4jz2A2jXnlhLD8DK4DPI2pHWxpRUrrpzm+amKNnY5APiFvMuBmmBU0XWuw1OFS2Wsb8tkNfQ==');
define('LOGGED_IN_SALT',   'zls/tb1CCVbejzdx1ZX8D+lRzymIh3iLzFRNr5nKL/gVYulri8WCa5UY+HHdjSSbMubyiXKjLEVgnJ/ZAhkd1g==');
define('NONCE_SALT',       'FJ5fpa++xU9yx2eFE0Kga3UgdnETRcm/IFOTkjhk5m2UIyTPdZEiQIodDHuOVa5gcGoqPuMM5hEV65WosKJNQA==');

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
