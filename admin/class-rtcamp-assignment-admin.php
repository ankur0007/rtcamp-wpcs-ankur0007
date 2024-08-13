<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/the-ank/
 * @since      1.0.0
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/admin
 * @author     Ankur Vishwakarma <ankurvishwakarma45@gmail.com>
 */
class Rtcamp_Assignment_Admin {



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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * endpoint_get_authors_callback function
	 * Register REST custom endpoint get authors
	 * NOTE - v2/users may result the authors but only who have published
	 *
	 * @return void
	 */
	public function endpoint_get_authors_callback() {

		register_rest_route(
			'rtca/v1',
			'/authors',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_authors_callback' ),
				'permission_callback' => array( $this, 'check_permissions' ), // Optional: Adjust as per your security needs
			)
		);

		register_rest_route(
			'rtca/v1',
			'/contributor',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_contributor_callback' ),
				'permission_callback' => array( $this, 'check_permissions' ), // Optional: Adjust as per your security needs
			)
		);

		register_rest_route(
			'rtca/v1',
			'/contributors',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_contributors_callback' ),
				'permission_callback' => array( $this, 'check_permissions' ), // Optional: Adjust as per your security needs
			)
		);
	}

	public function get_contributors_callback( WP_REST_Request $request ) {
		$results = array();
		$post_id = intval( $request->get_param( 'post_id' ) );
		$post    = get_post( $post_id );
		if ( $post ) {
			$existing_contributors = rtca_get_contributors( $post_id );

			if ( ! empty( $existing_contributors ) ) {
				foreach ( $existing_contributors as $user_id ) {
					if ( intval( $user_id ) <= 0 ) {
						continue;
					}
					$user = get_user_by( 'id', $user_id );
					if ( $user ) {
						$results[] = array(
							'id'          => $user->ID,
							'name'        => $user->display_name,
							'avatar'      => get_avatar_url( $user->ID, array( 'size' => 30 ) ),
							'avatar_2x'   => get_avatar_url( $user->ID, array( 'size' => 60 ) ),
							'is_selected' => ( in_array( $user->ID, $existing_contributors ) ? true : false ),
						);
					}
				}
			}
		}

		return $results;
	}
	/**
	 * Save the selected contributor
	 *
	 * @since    1.0.0
	 */
	public function save_contributor_callback( WP_REST_Request $request ) {
		$results = array();
		$action  = sanitize_text_field( $request->get_param( 'trigger' ) );
		$user_id = intval( $request->get_param( 'user_id' ) );
		$post_id = intval( $request->get_param( 'post_id' ) );

		$user = get_user_by( 'id', $user_id );
		$post = get_post( $post_id );

		if ( $user && $post ) {
			$existing_contributors = rtca_get_contributors( $post_id );
			if ( $action == 'add' && is_array( $existing_contributors ) && ! in_array( $user_id, $existing_contributors ) ) {
				$existing_contributors[] = $user_id;
			} elseif ( $action == 'remove' && is_array( $existing_contributors ) && in_array( $user_id, $existing_contributors ) ) {
				$key = array_search( $user_id, $existing_contributors );
				unset( $existing_contributors[ $key ] );
			}

			update_post_meta( $post_id, 'rtca_contributors', $existing_contributors );

			$results['success'] = array(
				'id'          => $user->ID,
				'name'        => $user->display_name,
				'avatar'      => get_avatar_url( $user->ID, array( 'size' => 30 ) ),
				'avatar_2x'   => get_avatar_url( $user->ID, array( 'size' => 60 ) ),
				'is_selected' => ( in_array( $user->ID, $existing_contributors ) ? true : false ),
			);
		} else {
			$results['error'] = __( 'Invalid user or post.', 'rtca' );
		}

		return rest_ensure_response( $results );
	}

	/**
	 * Parse the result and return
	 *
	 * @since    1.0.0
	 */
	public function get_authors_callback( WP_REST_Request $request ) {
		$search_term           = sanitize_text_field( $request->get_param( 'search' ) );
		$post_id               = intval( $request->get_param( 'post_id' ) );
		$args['search']        = $search_term;
		$authors               = rtca_get_users( $args );
		$existing_contributors = rtca_get_contributors( $post_id );

		$results = array();
		if ( ! empty( $authors ) ) {
			foreach ( $authors as $author ) {
				$results[] = array(
					'id'          => $author->ID,
					'name'        => $author->display_name,
					'avatar'      => get_avatar_url( $author->ID, array( 'size' => 30 ) ),
					'avatar_2x'   => get_avatar_url( $author->ID, array( 'size' => 60 ) ),
					'is_selected' => ( in_array( $author->ID, $existing_contributors ) ? true : false ),
				);
			}
		}
		return rest_ensure_response( $results );
	}

	/**
	 * Set who can access this endpoint
	 *
	 * @since    1.0.0
	 */
	public function check_permissions( WP_REST_Request $request ) {
		$nonce = $request->get_param( '_wpnonce' );

		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot perform this action.', 'rtca' ), array( 'status' => 403 ) );
		}

		if ( current_user_can( 'manage_options' ) || current_user_can( 'edit_others_posts' ) || current_user_can( 'publish_posts' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Initialized custom meta box
	 *
	 * @since    1.0.0
	 */
	public function init_meta_box() {

		add_meta_box(
			'contributors_meta_box',              // Unique ID for the meta box.
			__( 'Contributors', 'textdomain' ),  // Title of the meta box.
			array( $this, 'contributors_meta_box_callback' ),        // Callback function.
			'post',                                // Post type where the meta box appears (e.g., 'post', 'page').
			'side',                                // Context (e.g., 'normal', 'side').
			'high'                                 // Priority (e.g., 'default', 'high').
		);
	}

	/**
	 * Contributors meta box callback
	 *
	 * @since    1.0.0
	 */
	public function contributors_meta_box_callback( $post ) {

		// We are not using nonce for now, Contributors are saved with AJAX.
		// Add a nonce field for security.
		// wp_nonce_field('secure_contributors_save_data', 'contributors_meta_box_nonce');

		include 'view/authors-meta-box-view.php';
	}
	/**
	 * Register the output template in footer
	 *
	 * @since    1.0.0
	 */
	public function output_template() {
		include 'view/authors-list-util.php';
		include 'view/single-author-util.php';
	}
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rtcamp-assignment-admin.css', array(), $this->version, 'all' );
	}


	/**
	 * Register the JavaScript for the admin area.
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

		// Enqueue wp-util for templating
		wp_enqueue_script( 'wp-util' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtcamp-assignment-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'RTCA_OBJECT',
			array(
				'postID' => get_the_ID(),
				// 'rtca_endpoint_nonce' => wp_create_nonce( 'rtca_endpoints_nonce_action' ),
				'nonce'  => wp_create_nonce( 'wp_rest' ),
			)
		);
	}
}
