<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'triseafa_WPXJZ');

/** Database username */
define('DB_USER', 'triseafa_WPXJZ');

/** Database password */
define('DB_PASSWORD', 'fp3zXB51d:MmKk@NB');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'a2f970f30227fb98fb3343895338bfea474d6952318dce354fb6e1d981b1706e');
define('SECURE_AUTH_KEY', '92afa756e10abd78a146f14694927933fc45caf7c3c65ecf919fbe1a0c442407');
define('LOGGED_IN_KEY', '25c47fd6c404f8cffe01279704601f5e5381ec472329cbf84917f717222d8c23');
define('NONCE_KEY', '442414ebae24a9c8a0d0583ea505a620680eb4cb4aed4f7a77592fb2c42efb37');
define('AUTH_SALT', 'c8c3ce1f0c8872602ff46ca246e2551f67ad969b127371ea54c952dd80355887');
define('SECURE_AUTH_SALT', 'bb767e87acd3adf3a73df6385c98edef6c90781f50635283e25910d494b58e33');
define('LOGGED_IN_SALT', '0639381f9ae09a604607980e47f2e51b977b0a37e1008da0e915ec1a411504f0');
define('NONCE_SALT', '7262c21c450cf14d960f220c9482cc520bc4d0eb69271b96a6da7e228931e232');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'uWZ_';
define('WP_CRON_LOCK_TIMEOUT', 120);
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 7);
define('WP_AUTO_UPDATE_CORE', true);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
