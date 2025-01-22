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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'f8GV!Rg.Y2|b!WVni=D@AkYBslGCc|3,L?iAxds/Je{O,:B>)KH3U+[G~}-{V6o8' );
define( 'SECURE_AUTH_KEY',   'ia~c[CFqeY2s+}&sNODMUaK^E, [}3PJl+-6[^Ol^y+ _u=zR2dFz0?-lXj^=+,A' );
define( 'LOGGED_IN_KEY',     'm#%lVZS%LG3Zt:mWtVx4!XXx*!}/kMu`#|X09Btk`JnH<rRU2CQln#VZk:0l,I1,' );
define( 'NONCE_KEY',         'VDql*c6f&7zc|MeRlAl^.umTQ^]&FR|1F/:AVC~=Qyl]X)Ty36X_otaqBOHPX}^Z' );
define( 'AUTH_SALT',         'y8)~Vz0&dhZzEt(veO2sNIfR=_0_V+{Fqd6q+27mjd:m]6g]LG;*RUC97F-LVe@y' );
define( 'SECURE_AUTH_SALT',  'p?-b,hQ{L!{v+^:vo0b&2Ec>S`Dk95i8irU<%=HQeoeoW]l1u&C2](!/9Q i0B,{' );
define( 'LOGGED_IN_SALT',    'JNKF&S$Wjl=8?Ug+g_g0dbqM>;1`8+?g6( +pxZV!V|cuPTR:Z]?,FqCNBzB67rm' );
define( 'NONCE_SALT',        '~-A#CwsH D!&,#M:(=,#PsL8k ]l[lVr<d)bpyg%Y#O}_F,w6Z eHCaJhr2fCf,<' );
define( 'WP_CACHE_KEY_SALT', 'it$m$|MlH:o{NDTW0?=ndTE7qsIAYVTv)O4^_SI$on%M{)=6+8Wf~I]AZ36|+co]' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
