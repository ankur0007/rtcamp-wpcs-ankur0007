<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/the-ank/
 * @since      1.0.0
 *
 * @package    Rtcamp_Assignment
 * @subpackage Rtcamp_Assignment/admin/view
 */

if ( ! empty( $authors ) ) {

	foreach ( $authors as $author ) {
		include '/single-author.php';
	}
}
