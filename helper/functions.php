<?php

/*
 * Helper Functions
*/

/**
 * rtca_get_users function
 *
 * @param [type] $user_args
 * @return OBJECT
 */
function rtca_get_users( $user_args ) {

	// Set up the arguments for WP_User_Query.
	$default_args = array(
		'search'         => '',
		'search_columns' => array( 'user_login', 'user_email', 'display_name' ),
		'role__in'       => array( 'author', 'editor', 'administrator' ), // It might be possible that editors and administrator create posts
		'orderby'        => 'ID',
		'order'          => 'ASC',
		'per_page'       => 20,
		'fields'         => array( 'ID', 'display_name', 'user_email' ),
		'cache_results'  => false, // Enable caching
		// 'has_published_posts' => true //There can be non existing authors who has not published own posts but contributed to others
	);

	// Merge user-provided arguments with default arguments
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
 * Get selected contributors from post ID
 *
 * @param [type] $post_id
 * @return ARRAY of selected contributors
 */
function rtca_get_contributors( $post_id ) {

	if ( $post_id <= 0 ) {
		return array();
	}
	$existing_contributors = get_post_meta( $post_id, 'rtca_contributors', true );
	if ( empty( $existing_contributors ) ) {
		$existing_contributors = array();
	}

	return $existing_contributors;
}
