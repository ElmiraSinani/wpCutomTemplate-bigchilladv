<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'smaciego_wp359');

/** MySQL database username */
define('DB_USER', 'smaciego_wp359');

/** MySQL database password */
define('DB_PASSWORD', '8KkP3[)4sS');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'rzpukjzk9xy39ydcl4isfwgzffxoyzspo7px2uswwew6j9r7nh8tfa6qigru8ihd');
define('SECURE_AUTH_KEY',  'ngarbus8mioal7kxzftow25tn328xblhyqse6kq5ejzqs5xocfzdpyr5wvreed6k');
define('LOGGED_IN_KEY',    'c46xeshsypfeguejrc3zw33bmnooiirz3uaxqtc2y1c6ncyw6xuelpxwglpfp7ww');
define('NONCE_KEY',        'hcnnz89itmqs8bfuwyfifmdmr8mopjp1rsotbqnhhigos9vlvynhskewypaa7rn2');
define('AUTH_SALT',        'neszg69szrzcngchivg1drty6i3adfvehbqop1myyeqsc4m1yiioojev3gddxcm2');
define('SECURE_AUTH_SALT', '5yttwf3bc6jxhnpuvu8lnbupdskeft7usqn9qzho4qakk15wuruoa55wdchixfeq');
define('LOGGED_IN_SALT',   'wawjz5ag1ne88tqupbhatwtwljcwutcjmw4ws6g7w9rpibn7r2hoxdxmmzuriiyb');
define('NONCE_SALT',       'grkx8ksbkrlnyx0ycgqdfutugjif70pcbzn0g2cosym1kvraol9wcsqzsyughzse');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
