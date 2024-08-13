<?php
/* Display Selected Contributors */

$post_id      = get_the_ID();
$contributors = rtca_get_contributors( $post_id );

if ( ! empty( $contributors ) && is_array( $contributors ) ) {
	echo '<div class="rtca-post-contributors"><h4>' . __( 'Contributors:', 'rtca' ) . '</h4><ul>';
	foreach ( $contributors as $contributor_id ) {

		if ( intval( $contributor_id ) <= 0 ) {
			continue;
		}

		include 'single-contributor.php';
	}
	echo '</ul></div>';
}
