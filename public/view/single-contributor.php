<?php
/* Single Contributor HTML */

$contributor = get_userdata( $contributor_id );

if ( $contributor ) {
	echo get_the_author_meta( 'url', $contributor->ID );
	printf(
		'<li id="%d">
                    <a href="%s">
                        %s
                        <label>%s</label>
                    </a>
                </li>',
		$contributor->ID,
		esc_url( get_author_posts_url( $contributor_id ) ),
		get_avatar( $contributor->ID, 50 ),       // Ensure you have the URL for the image
		esc_attr( $contributor->display_name ),   // Use display name as alt text for the image
		htmlspecialchars( $contributor->display_name, ENT_QUOTES, 'UTF-8' ) // Display name in label
	);
}
