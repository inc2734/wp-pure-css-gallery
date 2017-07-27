<?php
/**
 * @package inc2734/wp-pure-css-gallery
 * @author inc2734
 * @license GPL-2.0+
 */

$output = "\n";
foreach ( $attachments as $attachment ) {
	$output .= wp_get_attachment_link( $attachment->ID, $atts['size'], true ) . "\n";
}
return $output;
