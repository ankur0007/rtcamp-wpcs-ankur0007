<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/the-ank/
 * @since             1.0.0
 * @package           Rtcamp_Assignment
 *
 * @wordpress-plugin
 * Plugin Name:       RTCamp Assignment
 * Plugin URI:        https://github.com/ankur0007/rt-wpcs-ankur0007
 * Description:       Metabox with search for contributors, add/remove and display them in each post.
 * Version:           1.0.0
 * Author:            Ankur Vishwakarma
 * Author URI:        https://profiles.wordpress.org/the-ank/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rtcamp-assignment
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define('RTCAMP_ASSIGNMENT_VERSION', '1.0.0');
define('RTCAMP_ASSIGNMENT_NAME', 'rtcamp-assignment');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rtcamp-assignment-activator.php
 */
function activate_rtcamp_assignment()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-rtcamp-assignment-activator.php';
	Rtcamp_Assignment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rtcamp-assignment-deactivator.php
 */
function deactivate_rtcamp_assignment()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-rtcamp-assignment-deactivator.php';
	Rtcamp_Assignment_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_rtcamp_assignment');
register_deactivation_hook(__FILE__, 'deactivate_rtcamp_assignment');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rtcamp-assignment.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rtcamp_assignment()
{

	$plugin = new Rtcamp_Assignment();
	$plugin->run();
}
run_rtcamp_assignment();
