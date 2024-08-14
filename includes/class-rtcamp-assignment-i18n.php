<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/the-ank/
 * @since      1.0.0
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/includes
 * @author     Ankur Vishwakarma <ankurvishwakarma45@gmail.com>
 */
class Rtcamp_Assignment_I18n {



	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rtcamp-assignment',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
