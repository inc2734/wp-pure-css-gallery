<?php
class Sample_Test extends WP_UnitTestCase {

	/**
	 * @test
	 */
	public function sample() {
		$bootstrap = new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();

		$this->assertTrue( is_a( $bootstrap, 'Inc2734\WP_Pure_CSS_Gallery\Bootstrap' ) );
	}

	public function test_gallery_without_images_is_empty() {
		$bootstrap = new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();

		$this->assertSame( '', $bootstrap->_post_gallery( '', [ 'ids' => '999999999' ] ) );
	}

	public function test_gallery_preserves_image_order_columns_and_lightbox_navigation() {
		$bootstrap = new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();
		$first     = $this->create_image( 'first.jpg' );
		$second    = $this->create_image( 'second.jpg' );
		$output    = $bootstrap->_post_gallery(
			'',
			[
				'ids'     => $second . ',' . $first,
				'link'    => 'file',
				'columns' => 2,
			]
		);

		$this->assertStringContainsString( 'wp-pure-css-gallery--2-columns', $output );
		$this->assertSame( 2, substr_count( $output, 'class="wp-pure-css-gallery__item"' ) );
		$this->assertLessThan( strpos( $output, 'id="wp-pure-css-gallery-id-' . $first . '"' ), strpos( $output, 'id="wp-pure-css-gallery-id-' . $second . '"' ) );
		$this->assertStringContainsString( 'class="wp-pure-css-gallery-lightbox__next-btn" href="#wp-pure-css-gallery-id-' . $first . '"', $output );
		$this->assertStringContainsString( 'class="wp-pure-css-gallery-lightbox__prev-btn" href="#wp-pure-css-gallery-id-' . $second . '"', $output );
		$this->assertSame( 2, substr_count( $output, 'class="wp-pure-css-gallery-lightbox__close-btn" href="#_"' ) );
		$this->assertStringContainsString( 'width: 640px;', $output );
		$this->assertStringContainsString( 'height: 480px;', $output );
	}

	public function test_gallery_without_links_has_no_lightbox() {
		$bootstrap = new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();
		$image     = $this->create_image( 'unlinked.jpg' );
		$output    = $bootstrap->_post_gallery( '', [ 'ids' => $image, 'link' => 'none' ] );

		$this->assertStringContainsString( '<div class="wp-pure-css-gallery__thumbnail"', $output );
		$this->assertStringNotContainsString( '<a ', $output );
		$this->assertStringNotContainsString( 'wp-pure-css-gallery-lightbox', $output );
	}

	public function test_gallery_defaults_to_attachment_links() {
		$bootstrap = new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();
		$image     = $this->create_image( 'attachment.jpg' );
		$output    = $bootstrap->_post_gallery( '', [ 'ids' => $image ] );

		$this->assertStringContainsString( 'href="' . esc_url( get_attachment_link( $image ) ) . '"', $output );
		$this->assertStringNotContainsString( 'wp-pure-css-gallery-lightbox', $output );
	}

	public function test_gallery_shortcode_uses_the_registered_filter() {
		new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();
		$image  = $this->create_image( 'shortcode.jpg' );
		$output = do_shortcode( '[gallery ids="' . $image . '" link="file" columns="4"]' );

		$this->assertStringContainsString( 'wp-pure-css-gallery--4-columns', $output );
		$this->assertStringContainsString( 'id="wp-pure-css-gallery-id-' . $image . '"', $output );
	}

	private function create_image( $filename ) {
		$image = self::factory()->attachment->create_object(
			$filename,
			0,
			[ 'post_mime_type' => 'image/jpeg' ]
		);
		wp_update_attachment_metadata(
			$image,
			[
				'width'  => 640,
				'height' => 480,
				'file'   => $filename,
			]
		);

		return $image;
	}
}
