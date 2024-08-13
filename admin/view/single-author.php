<?php

if ( ! empty( $author ) ) {

	printf(
		'<li id="%d">
                    <input type="checkbox" name="rtca_contributors[]" value="%d">
                    <a href="%s">
                        %s
                        <label>%s</label>
                    </a>
                </li>',
		$author->ID,
		$author->ID,
		get_edit_user_link( $author->ID ),
		get_avatar( $author->ID, 30 ),       // Ensure you have the URL for the image
		esc_attr( $author->display_name ),   // Use display name as alt text for the image
		htmlspecialchars( $author->display_name, ENT_QUOTES, 'UTF-8' ) // Display name in label
	);
}
