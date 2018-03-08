<?php
/**
 * @package inc2734/wp-pure-css-gallery
 * @author inc2734
 * @license GPL-2.0+
 */
?>

<div class="wp-pure-css-gallery wp-pure-css-gallery--<?php echo esc_attr( $atts['columns'] ); ?>-columns">
	<?php $attachments_count = count( $attachments ); ?>
	<?php for ( $i = 0; $i < $attachments_count; $i ++ ) : ?>
		<?php
		$attachment = $attachments[ $i ];
		?>
		<div class="wp-pure-css-gallery__item">
			<?php if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) : ?>
				<a class="wp-pure-css-gallery__thumbnail" href="#wp-pure-css-gallery-id-<?php echo esc_attr( esc_attr( $attachment->ID ) ); ?>" style="
					background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $attachment->ID, $atts['size'], false ) ); ?>);
				"></a>
			<?php elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) : ?>
				<div class="wp-pure-css-gallery__thumbnail" style="
					background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $attachment->ID, $atts['size'], false ) ); ?>);
				"></div>
			<?php else : ?>
				<a class="wp-pure-css-gallery__thumbnail" href="<?php echo esc_url( get_attachment_link( $attachment->ID ) ); ?>" style="
					background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $attachment->ID, $atts['size'], false ) ); ?>);
				"></a>
			<?php endif; ?>

			<?php if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) : ?>
				<div class="wp-pure-css-gallery-lightbox" id="wp-pure-css-gallery-id-<?php echo esc_attr( $attachment->ID ); ?>">
					<a class="wp-pure-css-gallery-lightbox__close-btn" href="#_">
						<?php echo wp_kses_post( apply_filters( 'inc2734_wp_pure_css_gallery_close_label', '&times;' ) ); ?>
					</a>

					<?php if ( isset( $attachments[ $i - 1 ] ) ) : ?>
						<a class="wp-pure-css-gallery-lightbox__prev-btn" href="#wp-pure-css-gallery-id-<?php echo esc_attr( $attachments[ $i - 1 ]->ID ); ?>">
							<?php echo wp_kses_post( apply_filters( 'inc2734_wp_pure_css_gallery_prev_label', '&lt;' ) ); ?>
						</a>
					<?php endif; ?>

					<?php if ( isset( $attachments[ $i + 1 ] ) ) : ?>
						<a class="wp-pure-css-gallery-lightbox__next-btn" href="#wp-pure-css-gallery-id-<?php echo esc_attr( $attachments[ $i + 1 ]->ID ); ?>">
							<?php echo wp_kses_post( apply_filters( 'inc2734_wp_pure_css_gallery_next_label', '&gt;' ) ); ?>
						</a>
					<?php endif; ?>

					<a class="wp-pure-css-gallery-lightbox__image-wrapper" href="#_">
						<?php $size = image_downsize( $attachment->ID, 'full' ); ?>
						<div class="wp-pure-css-gallery-lightbox__image" style="
							background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $attachment->ID, 'full', false ) ); ?>);
							height: <?php echo esc_attr( $size[2] ); ?>px;
							width: <?php echo esc_attr( $size[1] ); ?>px;
						"></div>
					</a>
				</div>
			<?php endif; ?>
		</div>
	<?php endfor; ?>
</div>
