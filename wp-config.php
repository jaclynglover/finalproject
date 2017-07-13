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
define('DB_NAME', 'finalproject');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'd3[KKWJtS9dB>uOsQQVU*cJj[a{^/!q0Ohk>(d4Fb?mRr=es`*7mSHq*.EUPb=jO');
define('SECURE_AUTH_KEY',  'yupy X/s+n>|t9zCt`kDlf`HLzQ!;qoEZ/tOf,8(.-go[ndN.4cmjEP%03]Ujj{$');
define('LOGGED_IN_KEY',    'R3>6u_F=DLMJykt1XJDJJ{%727?2] YCYJ62i{KIhuakol~S)CdBQ=z>pUV)y6:1');
define('NONCE_KEY',        '3R(mY>v3=TK{~7u{k~~P$ZRg9.;H3]QM{-q>g@mK|<A|i<z^0lQ6_l)f(u4y?FS-');
define('AUTH_SALT',        '`9k|)>Pa0R{To:Zsa[J.c3 nV4u~aFx3D:N0_]1F/;ja(cbQ8{L&gBPoJ~z:ZP8L');
define('SECURE_AUTH_SALT', 'ad0 n0!Sx5|afRU=uLTcS<id7!d9-TH`_(_jiPD/5id#oZm`m7!Xa;EtUz}<s513');
define('LOGGED_IN_SALT',   '6/7:`!1Ih:ZXX_!v{Q:$uv{mX%SQPi5M*xZMZXR(Sb(sS-*?L:PH.w]PDMNTh2_/');
define('NONCE_SALT',       'p+oE|l^-k!sb5>Ut8UTJ+$0tt1oZ=jVd3NCkRF_%Abw~g7(I;$E>QJv5Adf`/7_H');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
