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
define( 'DB_NAME', 'nature' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '.2>,-MZy2`6g*}4q/K5UQ^OmSe<y9 UMS4dzNAa&i?CO8fSx :%Qpzx^bxH-{.^:' );
define( 'SECURE_AUTH_KEY',  'U_9MQ-j.n04swM1yo0E2fF`QMsb+)!WxNu^FxyI?#-t=+,Ftec;YvI-vx7p7hf6f' );
define( 'LOGGED_IN_KEY',    'G{K#7*n?)Q2y #JJ1D{EzlkKlY>lIKq)  @*i8O_!O{kQ0G =_+asV8%%2Ww[#=(' );
define( 'NONCE_KEY',        '~A4LAzyg^Ho:S<jB^.MFUb+)~=%XW9)[cnhiW+(IgL1VlFP~31|#;aK>pr}(8J#`' );
define( 'AUTH_SALT',        'XkcqW>-r&H67VLq$o;>26H7T}F@k(G0`4uLBeAqob`Ybsry9;:*0Yj-x:P;K8y!#' );
define( 'SECURE_AUTH_SALT', 'n$vYo4scW9izkhLq}.8SI~aGV9^Rpy26oI^71Zw|NC4zlpIoOTw6.CY/)rUL%6}(' );
define( 'LOGGED_IN_SALT',   ')`plbh7xo7jIhVD$H[>@+ 5<*4?>6yycI19)pRf:1A%rN8B0T5qUr<CXuI6?)@wL' );
define( 'NONCE_SALT',       'L7YjyN`EnhG(ODu,h!lJ.zHw$Wz40dN|>T:7_G-)dC!m[5D=Ws[:f:0k}|E?gmN)' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
