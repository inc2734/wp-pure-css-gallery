<?php
/**
 * @package inc2734/wp-pure-css-gallery
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Pure_CSS_Gallery;

class Pure_CSS_Gallery {

	public function __construct() {
		add_filter( 'post_gallery', array( $this, '_post_gallery' ), 10, 3 );
		add_filter( 'tiny_mce_before_init', array( $this, '_tiny_mce_before_init' ) );
	}

	/**
	 * Filters the default gallery shortcode output
	 *
	 * @param string $output The gallery output. Default empty.
	 * @param array $attr Attributes of the gallery shortcode.
	 *   @var link string null|file|none
	 *   @var size string null|thumbnail|medium|large|full
	 *   @var columns int
	 *   @var ids string
	 *   @var orderby string rand|null
	 * @param int $instance Unique numeric ID of this gallery shortcode instance.
	 */
	public function _post_gallery( $output, $attr, $instance ) {
		$post = get_post();

		if ( ! empty( $attr['ids'] ) ) {
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$atts = shortcode_atts( [
			'id'      => $post ? $post->ID : 0,
			'link'    => '',
			'size'    => 'thumbnail',
			'columns' => 3,
			'order'   => 'ASC',
			'orderby' => 'menu_order ID',
			'include' => '',
		], $attr );

		$pot_id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$attachments = get_posts( array(
				'include'        => $atts['include'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			) );
		} else {
			$attachments = get_children( array(
				'post_parent'    => $pot_id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			return $this->_render( 'feed', array(
				'attachments' => $attachments,
			) );
		}

		return $this->_render( 'pure-css-gallery', array(
			'attachments' => array_values( $attachments ),
			'atts'        => $atts,
		) );
	}

	/**
	 * Change style of gallery in wysiwyg
	 *
	 * @param array $mce_init
	 */
	public function _tiny_mce_before_init( $mce_init ) {
		$styles  = '#tinymce .wpview .gallery { margin: 0; display: block; border: 2px solid #666; text-align: center; height: 80px; }';
		$styles .= '#tinymce .wpview .gallery > * { display: none; }';
		$styles .= '#tinymce .wpview .gallery::before { margin-top: 20px; display: inline-block; content: \'\\\\f161\'; font-family: dashicons; font-size: 18px; color: #666 }';
		if ( isset( $mce_init['content_style'] ) ) {
			$mce_init['content_style'] .= $styles;
		} else {
			$mce_init['content_style'] = $styles;
		}
		return $mce_init;
	}

	/**
	 * Load view template
	 *
	 * @param  [string] $template_name
	 * @param  [array]  $attributes
	 * @return [string]
	 */
	protected function _render( $template_name, $attributes ) {
		$path = __DIR__ . '/app/view/' . $template_name . '.php';
		if ( ! file_exists( $path ) ) {
			return;
		}

		// @todo Using getter method
		// @codingStandardsIgnoreStart
		extract( $attributes );
		// @codingStandardsIgnoreEnd
		ob_start();
		include( $path );
		return ob_get_clean();
	}
}
