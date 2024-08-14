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

?>

<div class="rtca_contributors_meta_box">

	<div class="rtca_contributors_meta_box_inner">
		<!-- <label class="">
		<?php
		// _e('Selected Contributor', 'rtca');
		?>
								</label> -->
		<div class="rtca-selected-contributors"></div>

		<div class="rtca_contributors_search">
			<label class="rtca_heading"><?php esc_html_e( 'Add New Contributor', 'rtca' ); ?></label>
			<input type="search" name="rtca_contributors_search_field" id="rtca_contributors_search_field" autocomplete="off" class="rtca_search" placeholder="<?php esc_html_e( 'Enter at least 3 characters', 'rtca' ); ?>">
		</div>

		<ul class="rtca_contributors_search_output">
			<!-- Result -->
		</ul>


	</div>
</div>