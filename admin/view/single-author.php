<?php
/**
 * Single Author Template
 *
 * @link              https://profiles.wordpress.org/the-ank/
 * @since             1.0.0
 * @package           Rtcamp_Assignment
 */

if ( ! empty( $author ) ) {

	printf(
		'<li id="%d">
                    <input type="checkbox" name="rtca_contributors[]" value="%d">
                    <a href="%s">
                        %s
                        <label>%s</label>
                    </a>
                </li>',
		esc_attr( $author->ID ),
		esc_attr( $author->ID ),
		esc_url( get_edit_user_link( $author->ID ) ),
		get_avatar( $author->ID, 30 ),
		esc_attr( $author->display_name ),
		esc_html( htmlspecialchars( $author->display_name, ENT_QUOTES, 'UTF-8' ) )
	);
}
