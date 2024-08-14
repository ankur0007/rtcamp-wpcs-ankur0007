<?php
/**
 * Helper Functions
 *
 * @link              https://profiles.wordpress.org/the-ank/
 * @since             1.0.0
 * @package           Rtcamp_Assignment
 */

/**
 * Function rtca_get_users to fetch authors using WP_User_Query.
 *
 * @param array $user_args Arguments for WP_User_Query to fetch users.
 * @return WP_User[] Array of WP_User objects representing the fetched authors.
 */
function rtca_get_users( $user_args ) {

	// Set up the arguments for WP_User_Query.
	$default_args = array(
		'search'         => '',
		'search_columns' => array( 'user_login', 'user_email', 'display_name' ),
		'role__in'       => array( 'author', 'editor', 'administrator' ), // It might be possible that editors and administrator create posts.
		'orderby'        => 'ID',
		'order'          => 'ASC',
		'per_page'       => 20,
		'fields'         => array( 'ID', 'display_name', 'user_email' ),
		// 'cache_results'  => false, // Enable caching.
		// 'has_published_posts' => true //There can be non existing authors who has not published own posts but contributed to others.
	);

	// Merge user-provided arguments with default arguments.
	$args = wp_parse_args( $user_args, $default_args );

	if ( isset( $user_args['search'] ) ) {
		$args['search'] = '*' . esc_attr( $user_args['search'] ) . '*';
	}

	// Create the WP_User_Query object.
	$author_query = new WP_User_Query( $args );

	$authors = $author_query->get_results();

	return $authors;
}
/**
 * Get selected contributors from post ID.
 *
 * @param int $post_id The ID of the post to retrieve contributors from.
 * @return int[] Array of selected contributor IDs.
 */
function rtca_get_contributors( $post_id ) {

	if ( $post_id <= 0 ) {
		return array();
	}
	$existing_contributors = get_post_meta( $post_id, 'rtca_contributors', true );
	if ( empty( $existing_contributors ) ) {
		$existing_contributors = array();
	}
	$existing_contributors = array_map( 'intval', $existing_contributors );
	return $existing_contributors;
}
