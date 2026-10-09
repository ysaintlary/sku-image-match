=== YS | SKU Image Match ===
Contributors: ysaintlary
Tags: woocommerce, sku, image, product, gallery
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Automatically matches uploaded images to WooCommerce products by SKU filename convention.

== Description ==

YS SKU Image Match automatically assigns uploaded images to WooCommerce products based on a filename convention using the product SKU.

= Filename convention =

* `SKU_f.jpg` — set as the product featured image
* `SKU_g01.jpg`, `SKU_g02.jpg`, … — added to the product gallery (ordered by number)

= How it works =

1. Upload images to the WordPress media library (single or bulk)
2. The plugin parses each filename for the `SKU_f` or `SKU_gNN` pattern
3. If a matching product is found, the image is automatically assigned

= Features =

* Works with any image format supported by WordPress
* Supports bulk upload via the media library
* Featured image and gallery image assignment
* HPOS compatible

== Installation ==

1. Upload the `sku-image-match` folder to `/wp-content/plugins/`
2. Activate the plugin through the "Plugins" menu in WordPress
3. Upload images named with the SKU convention

== Changelog ==

= 1.0.0 =
* Initial release
