<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define('ABSPATH', dirname(dirname(__FILE__)) . '/wordpress/');

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
define('WP_DEFAULT_THEME', 'default');

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define('WP_DEBUG', true);

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

define('DB_NAME', getenv('WP_DB_NAME') ?: 'wordpress_test');
define('DB_USER', getenv('WP_DB_USER') ?: 'test_user');
define('DB_PASSWORD', getenv('WP_DB_PASS') ?: 'test12345');
define('DB_HOST', getenv('WP_DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY',         'k_nFf.CH@U{=al-bVW]t?L%B: )5s^*BtXJmyAZ}9gam&+z.>sWW3fW0#5j5p,Hn');
define('SECURE_AUTH_KEY',  'wKg3L<UD<JC.H|$fTy,9i 8_{lV?h*{yEu$?y;F:}H:-onbAd0$RjhBU!/h4l!_x');
define('LOGGED_IN_KEY',    'zc/Vv/1<O%B[2|hEhr>s$juj_%-D(~Y,})-nym ADCfA@|g9l(#X;IIf*8YxNg^c');
define('NONCE_KEY',        'WmRb^}AaY:Z[Bu =eNsid2H9>N}[[@.PVwk>l +s*~+{U!& ^~s.K]gA.j;SUY,o');
define('AUTH_SALT',        ':tX]$8.:Nl7@x;N~|y+O1hGGZArZ7z}Bq7(16)rzlf)p] 1m-%<7[Zb$@}IAEy,L');
define('SECURE_AUTH_SALT', '0O&{)L3H_h(Ao %)Yi;S{L::V!fVJ3l!=-)qBG$_+#ffAK~kTDa|r?W=9C&tnq)]');
define('LOGGED_IN_SALT',   '|p}$-t>-/.`v##K++*K[OB*ZAO2Z:sxlBL94T3HK1U/}q698WU-.`5Ykc^x-UX5!');
define('NONCE_SALT',       'QT|D8JF+HYlEXzQAv9!WiTQXn80:{AIZ[&-w4ixJIlkx(twY_7{= -:q*e|Tk.Q2');

$table_prefix = 'tests_';   // Only numbers, letters, and underscores please!

define('WP_TESTS_DOMAIN', 'example.org');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Test Blog');

define('WP_PHP_BINARY', 'php');

define('WPLANG', '');
