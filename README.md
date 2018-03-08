# WP Pure CSS Gallery

[![Build Status](https://travis-ci.org/inc2734/wp-pure-css-gallery.svg?branch=master)](https://travis-ci.org/inc2734/wp-pure-css-gallery)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-pure-css-gallery/v/stable)](https://packagist.org/packages/inc2734/wp-pure-css-gallery)
[![License](https://poser.pugx.org/inc2734/wp-pure-css-gallery/license)](https://packagist.org/packages/inc2734/wp-pure-css-gallery)

## Install
```
$ composer require inc2734/wp-pure-css-gallery
```

## How to use
```
<?php
// When Using composer auto loader
new Inc2734\WP_Pure_CSS_Gallery\Pure_CSS_Gallery();
```

```
// Using default styles (.scss)
@import 'vendor/inc2734/wp-pure-css-gallery/src/assets/scss/wp-pure-css-gallery';
```

```
// Import js
import Inc2734_WP_Pure_CSS_Gallery from '../../vendor/inc2734/wp-pure-css-gallery/src/assets/js/wp-pure-css-gallery.js';
new Inc2734_WP_Pure_CSS_Gallery();
```

## Shortcode
```
/**
 * @param ids      Attachment IDs
 * @param link
 *   @var file     Lightbox
 *   @var none     No link
 *   @var (blank)  Attachment page
 * @param size     Thubmnail Size
 * @param columns  Column size
 * @param order    ASC or DESC
 * @param orderby
 */

[gallery ids="1,2,3" columns="3"]
```
