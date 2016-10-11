<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

if (file_exists(dirname(__FILE__) . '/local-config.php')):
    include(dirname(__FILE__) . '/local-config.php');  // Your own settings, allows it all to be outside of SVN
else:
    die("No local-config.php found");
endif;

// ** Force SSL  ** //
if ($force_ssl) {
    define('FORCE_SSL_ADMIN', true);
    define('FORCE_SSL_LOGIN', true);
    if (!empty($_SERVER['HTTP_REMOTE_ADDR'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_REMOTE_ADDR'];
    }
    $_SERVER['HTTPS'] = 'on';
}

// ** MySQL settings - You can get this info from your web host ** //
define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_password);
define('DB_HOST', $db_host);
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         'Oc[9B;lP<Zc*gaxM^@PTi^E+oWUi#@#xY7T TV`_cjW-zdYGcLcizCvF;A>75Y!C');
define('SECURE_AUTH_KEY',  '9eTgPEm+O!U*4m~Ym+_@$:VYoJ9AC([[GM06f%E|VkEig;-2qQ*KzMS>1`S]zY[S');
define('LOGGED_IN_KEY',    'f<=M+AJ/tp}pBCn[(YOD^jX,^}H4GXBr9Fb26,jj~um+y%i=Z0l/|^#bt8onJDKN');
define('NONCE_KEY',        'Q.:C5%Gp`IQGYe%]4Z i>=+-)~4&smc!yk)PIJX&G(-HlzF{QrYKU3q^f|#xSQ?~');
define('AUTH_SALT',        't2&DsJ%jRk_@[|W<|oca4:]|s2Sh^r-#C`Au}9^N+DvmN*s_Gv&uBqghQ=L0(cks');
define('SECURE_AUTH_SALT', 's!|oM82@K?K5++R]@G8G6bT=IY|;_Y}Ei:7,7+^/k1npv&t(T%dAJKtb(._JL;8-');
define('LOGGED_IN_SALT',   '/k5klg-r]Uqy>QIlp~/q-O=g%~xTpY-BFoIg|*:XmE4%**M)osbFHh_@}4FXlz0X');
define('NONCE_SALT',       '*Mhi=ytv|]ETy4K;m>c/ EC0[j41o/YpO-]KA+$EesydAI!G+l7&*=$2s0&b0,N5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'zkp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'en_GB');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', $debug); // Shows PHP error messages and notices
define('SCRIPT_DEBUG', $debug); // Uses non-compressed Scripts

/* Multisite */
define('MULTISITE', false);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', preg_replace('/^(http:\/\/|https:\/\/)/', '', $domain));
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

// ==============================================================
// Additional custom definitions
// ==============================================================
// Idiot check as we don't automatically add the protocol, so local-config.php might not have it
if (!preg_match('/^(http:\/\/|https:\/\/)/', $domain)) {
    $domain = 'http://' . $domain;
}
// HTTP Protocol would normally be added at this point, but we want to switch between HTTP and HTTPS depending on environment
define( 'WP_SITEURL',                $domain . '/wp' );       // No overriding within Admin...
define( 'WP_HOME',                   $domain );               // ...of either setting

define( 'WP_CONTENT_DIR',            dirname( __FILE__ ) . '/custom' );   // Move all content (themes, plugins, uploads etc) to reside in a custom directory...
define( 'WP_CONTENT_URL',            $domain . '/custom' );               // ...with matching custom content URL

// Default to full blocking of updating/installation, unless WP_DEBUG is set (and as long as the server isn't Live). Never allow in-admin file editing
define('DISALLOW_FILE_EDIT', true); // Disable file editing within Admin, still allow plugin/theme/core install/update
define('DISALLOW_FILE_MODS', !$plugin_install); // Disable theme/plugin/core installation/updates & file editing within Admin


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');