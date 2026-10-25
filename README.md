# WP Pure CSS Gallery

[![CI](https://github.com/inc2734/wp-pure-css-gallery/actions/workflows/ci.yml/badge.svg)](https://github.com/inc2734/wp-pure-css-gallery/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-pure-css-gallery/v/stable)](https://packagist.org/packages/inc2734/wp-pure-css-gallery)
[![License](https://poser.pugx.org/inc2734/wp-pure-css-gallery/license)](https://packagist.org/packages/inc2734/wp-pure-css-gallery)

## Install
```
$ composer require inc2734/wp-pure-css-gallery
```

## Development

```sh
npm ci
npm run build
npm test
```

`npm start` starts the development environment. PHP lint and PHPUnit use the
separate `.wp-env.tests.json` environment on port 8889 and stop it after each
check. Run `npm run test:lint:php` or `npm run test:unit:php` for individual checks.
Composer and PHPUnit are installed and run inside wp-env; host PHP is not required.

`npm stop` stops development, `npm run test:php:stop` stops tests, and
`npm run destroy` removes both environments.

## How to use
```
<?php
new Inc2734\WP_Pure_CSS_Gallery\Bootstrap();
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

## Filter hooks

### inc2734_wp_pure_css_gallery_close_label

```
/**
 * Customize close label
 *
 * @param string $label
 * @return string
 */
add_filter(
	'inc2734_wp_pure_css_gallery_close_label',
	function( $label ) {
		return $label;
	}
);
```

### inc2734_wp_pure_css_gallery_prev_label

```
/**
 * Customize prev label
 *
 * @param string $label
 * @return string
 */
add_filter(
	'inc2734_wp_pure_css_gallery_prev_label',
	function( $label ) {
		return $label;
	}
);
```

### inc2734_wp_pure_css_gallery_next_label

```
/**
 * Customize next label
 *
 * @param string $label
 * @return string
 */
add_filter(
	'inc2734_wp_pure_css_gallery_next_label',
	function( $label ) {
		return $label;
	}
);
```
