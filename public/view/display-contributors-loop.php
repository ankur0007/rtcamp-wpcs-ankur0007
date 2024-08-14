<?php
/**
 * Display Contributors Template
 *
 * @link              https://profiles.wordpress.org/the-ank/
 * @since             1.0.0
 * @package           Rtcamp_Assignment/public/view
 */

$article_id   = get_the_ID();
$contributors = rtca_get_contributors( $article_id );

if ( ! empty( $contributors ) && is_array( $contributors ) ) {
	echo '<div class="rtca-post-contributors"><h4>' . esc_html__( 'Contributors:', 'rtca' ) . '</h4><ul>';
	foreach ( $contributors as $contributor_id ) {

		if ( intval( $contributor_id ) <= 0 ) {
			continue;
		}

		include 'single-contributor.php';
	}
	echo '</ul></div>';
}
