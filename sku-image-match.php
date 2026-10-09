<?php
/**
 * Plugin Name:       YS | SKU Image Match
 * Plugin URI:        https://github.com/ysaintlary/sku-image-match
 * Description:       Associe automatiquement les images aux produits WooCommerce par SKU lors de l'upload. Convention : SKU_f.jpg = featured, SKU_g01.jpg = galerie.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Yves Saint-Lary
 * Author URI:        https://ysaintlary.com
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       sku-image-match
 * Domain Path:       /languages
 *
 * WC requires at least: 8.0
 * WC tested up to:      9.8
 * Requires Plugins:     woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'YS_SKU_IMAGE_MATCH_VERSION', '1.0.0' );

require_once __DIR__ . '/lib/wp-plugin-base/wp-plugin-base-runtime-updater.php';

/* ─── Compatibilité HPOS ─── */

add_action( 'before_woocommerce_init', function () {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__ );
	}
} );

/* ─── Hook sur l'upload d'un attachment ─── */

add_action( 'add_attachment', 'ys_sku_image_match_on_upload' );

function ys_sku_image_match_on_upload( int $attachment_id ): void {
	if ( ! wp_attachment_is_image( $attachment_id ) ) {
		return;
	}

	$filename = pathinfo( get_attached_file( $attachment_id ), PATHINFO_FILENAME );

	// SKU_f = featured, SKU_g01 = gallery
	if ( ! preg_match( '/^(.+)_(f|g\d+)$/i', $filename, $matches ) ) {
		return;
	}

	$sku    = $matches[1];
	$suffix = strtolower( $matches[2] );

	$product_id = wc_get_product_id_by_sku( $sku );
	if ( ! $product_id ) {
		return;
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		return;
	}

	if ( 'f' === $suffix ) {
		$product->set_image_id( $attachment_id );
		$product->save();
		return;
	}

	// Gallery: g01, g02, …
	$gallery_ids   = $product->get_gallery_image_ids();
	$gallery_ids[] = $attachment_id;
	$product->set_gallery_image_ids( $gallery_ids );
	$product->save();
}
