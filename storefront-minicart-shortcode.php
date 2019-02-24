<?php
/*
Plugin Name: StoreFront Minicart Shortcode
Plugin URI: https://bogaczek.com
Description: This plugin romoves Storefront Minicart from header, and creates shortcode <code>[minicart]</code> for display it wherever you want. For WooCommerce StoreFront theme only.
Version: 0.7
Author: Black Sun
Author URI: https://bogaczek.com
Text Domain: storefront-minicart-shortcode
*/
defined('ABSPATH') or die();

// Enqueuing basic styles for plugin
function dexter_minicart_shortcode_styles() {
	wp_enqueue_style( 'dexter-minicart-shortcode-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
}
add_action('wp_enqueue_scripts', 'dexter_minicart_shortcode_styles', 666 );

//remove minicart from StoreFront header
function dexter_remove_storefront_header_cart() {
    remove_action( 'storefront_header', 'storefront_header_cart', 60 );
}
add_action('template_redirect','dexter_remove_storefront_header_cart');

//create shortcode for minicart
function dexter_minicart_shortcode() {
	if ( storefront_is_woocommerce_activated() ) {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
?>
<ul id="site-header-cart" class="site-header-cart shortcode-minicart">
	<li class="<?php echo esc_attr( $class ); ?>">
		<?php storefront_cart_link(); ?>
	</li>
	<li>
		<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
	</li>
</ul>
<?php
	}
}
add_shortcode('minicart', 'dexter_minicart_shortcode');
?>