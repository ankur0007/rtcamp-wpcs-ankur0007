<?php
/**
 * Display Single Contributor Template
 *
 * @link              https://profiles.wordpress.org/the-ank/
 * @since             1.0.0
 * @package           Rtcamp_Assignment/public/view
 */

$contributor = get_userdata( $contributor_id );

if ( $contributor ) {
	printf(
		'<li id="%d">
                    <a href="%s">
                        %s
                        <label>%s</label>
                    </a>
                </li>',
		esc_attr( $contributor->ID ),
		esc_url( get_author_posts_url( $contributor_id ) ),
		get_avatar( $contributor->ID, 50 ),
		esc_attr( $contributor->display_name ),
		esc_html( htmlspecialchars( $contributor->display_name, ENT_QUOTES, 'UTF-8' ) )
	);
}
