'use strict';

import $ from 'jquery';

export default class Inc2734_WP_Pure_CSS_Gallery {
  constructor() {
    $(() => {
      this.images = $('a:not([class]) > img[class*="wp-image-"]');
      this.generateLightbox();
    });
  }

  generateLightbox() {
    this.images.each((i, e) => {
      const image  = $(e);
      const anchor = image.parent();
      const href   = anchor.attr('href');

      if (! href.match(image.attr('src').replace('/^([^\.]+)\.+?$/'))) {
        return true;
      }

      const remoteImg = new Image();
      remoteImg.src = href;
      const remoteImgWidth  = remoteImg.width;
      const remoteImgHeight = remoteImg.height;

      if (! remoteImgWidth || ! remoteImgHeight) {
        return true;
      }

      const id = 'wp-pre-css-gallery-lightbox-id-' + i;
      anchor.attr('href', `#${id}`);

      const overlay = $(`<div class="wp-pure-css-gallery-lightbox" id="${id}" />`)
        .append(
          $('<a class="wp-pure-css-gallery-lightbox__close-btn" href="#_">&times</a>')
        ).append(
          $('<a class="wp-pure-css-gallery-lightbox__image-wrapper" href="#_" />').append(
            $('<div class="wp-pure-css-gallery-lightbox__image" />').css({
              backgroundImage: `url(${href})`,
              height: remoteImgHeight,
              width: remoteImgWidth
            })
          )
        );

      anchor.after(overlay);
    });
  }
}
