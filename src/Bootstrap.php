<?php
/**
 * @package inc2734/wp-pure-css-gallery
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Pure_CSS_Gallery;

class Bootstrap {

	public function __construct() {
		add_filter( 'post_gallery', [ $this, '_post_gallery' ], 10, 3 );
		add_filter( 'tiny_mce_before_init', [ $this, '_tiny_mce_before_init' ] );
		add_action( 'wp_enqueue_scripts', [ $this, '_enqueue_styles' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, '_enqueue_styles' ] );
		add_action( 'after_setup_theme', [ $this, '_add_editor_style' ] );
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

		$atts = shortcode_atts(
			[
				'id'      => $post ? $post->ID : 0,
				'link'    => '',
				'size'    => 'thumbnail',
				'columns' => 3,
				'order'   => 'ASC',
				'orderby' => 'menu_order ID',
				'include' => '',
			],
			$attr
		);

		$pot_id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$attachments = get_posts(
				[
					'include'        => $atts['include'],
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $atts['order'],
					'orderby'        => $atts['orderby'],
				]
			);
		} else {
			$attachments = get_children(
				[
					'post_parent'    => $pot_id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $atts['order'],
					'orderby'        => $atts['orderby'],
				]
			);
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			return $this->_render(
				'feed',
				[
					'attachments' => $attachments,
				]
			);
		}

		return $this->_render(
			'pure-css-gallery',
			[
				'attachments' => array_values( $attachments ),
				'atts'        => $atts,
			]
		);
	}

	/**
	 * Change style of gallery in wysiwyg
	 *
	 * @param array $mce_init
	 */
	public function _tiny_mce_before_init( $mce_init ) {
		$styles  = '.mce-content-body .wpview .gallery { margin: 0; display: block; border: 2px solid #666; text-align: center; height: 80px; }';
		$styles .= '.mce-content-body .wpview .gallery > * { display: none; }';
		$styles .= '.mce-content-body .wpview .gallery::before { margin-top: 20px; display: inline-block; content: \'\\\\f161\'; font-family: dashicons; font-size: 18px; color: #666 }';
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

	/**
	 * Enqueue styles
	 *
	 * @return void
	 */
	public function _enqueue_styles() {
		wp_enqueue_style(
			'wp-pure-css-gallery',
			get_template_directory_uri() . '/vendor/inc2734/wp-pure-css-gallery/src/assets/css/wp-pure-css-gallery.min.css',
			[],
			filemtime( get_template_directory() . '/vendor/inc2734/wp-pure-css-gallery/src/assets/css/wp-pure-css-gallery.min.css' )
		);
	}

	/**
	 * Add editor style
	 *
	 * @return void
	 */
	public function _add_editor_style() {
		add_editor_style(
			[
				'vendor/inc2734/wp-pure-css-gallery/src/assets/css/wp-pure-css-gallery.min.css',
			]
		);
	}
}
