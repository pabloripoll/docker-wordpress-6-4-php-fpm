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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

/** Database hostname */
define( 'DB_HOST', '192.168.1.41:8889' );

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
define( 'AUTH_KEY',         'SiQ3Eyof[myIGEvJ@6n$6D<R]nYBtZr?B=bb^JLK&(dK6IB*G8V3#L)bjF7!O1}I' );
define( 'SECURE_AUTH_KEY',  'V4(ONY@2`;>yw.n(4,0q)[~@>~$o:C48v5pXYby0:GqA7DU@U>c,/7r9 OQ~OBJ:' );
define( 'LOGGED_IN_KEY',    'BYs|eWQ#XS y:&n::zgz<8%fuv@Rc=Azo+CrzjSuON.]OZahJKvcrQU#7+(Yt49Q' );
define( 'NONCE_KEY',        'h,:aR4@Km5s!KZ9+RbsxSH5UMgEen{rTHT*kS8fH]{=]7,RX5u s1wqW4EWT`]&M' );
define( 'AUTH_SALT',        '5Y7Sjy/xuBJAwA4wLp]oReu)K2O+*2TPq8I=6T[[$,@(]BK=G@N>j}#!7dZy$ v-' );
define( 'SECURE_AUTH_SALT', 'teq&Ox2E_LoN-o]:_0LMX]I#x7M.G{q*k$~nTDyc:sd~)=UuETGzAJcX}Aay>y<d' );
define( 'LOGGED_IN_SALT',   '<Z=2+b0M/B,d=T#?F!,S2a4O4U21bUVMd!Cpa:X(x0[`XMXE,]4Myv8BDe~Tpx>7' );
define( 'NONCE_SALT',       'pT%M+GV9VOvH4]:J;h-lU>&F~GmbELrw@GH%^WzMT7@zR&ByE_f8MxTKQ;Hn(?sV' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
