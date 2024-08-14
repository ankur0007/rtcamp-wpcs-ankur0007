<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/the-ank/
 * @since      1.0.0
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/public
 * @author     Ankur Vishwakarma <ankurvishwakarma45@gmail.com>
 */
class Rtcamp_Assignment_Public {



	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Use the post_content filter to display contributors in the single post view on the front end.
	 *
	 * @param string $content The content of the post to which contributors will be appended.
	 * @return string The modified content with contributors included, in HTML format.
	 */
	public function display_contributors( $content ) {

		$html = '';
		if ( is_single() && 'post' === get_post_type() ) {

			ob_start();
			include 'view/display-contributors-loop.php';
			$html .= ob_get_clean();
		}

		return $content . $html;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rtcamp_Assignment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rtcamp_Assignment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rtcamp-assignment-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rtcamp_Assignment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rtcamp_Assignment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtcamp-assignment-public.js', array( 'jquery' ), $this->version, false );
	}
}
