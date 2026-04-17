<?php
/**
 * Plugin Name: WC Subscription Box
 */

if (!defined('ABSPATH')) exit;

add_action('plugins_loaded', function () {

    // Ensure WooCommerce is active
    if (!class_exists('WC_Product')) return;

    require_once __DIR__ . '/includes/class-wc-product-subscription-box.php';
    require_once __DIR__ . '/admin/class-admin.php';

    // Register product type
    add_filter('product_type_selector', function ($types) {
        $types['subscription_box'] = 'Subscription Box';
        return $types;
    });

    // Load custom class
    add_filter('woocommerce_product_class', function ($classname, $type) {
        if ($type === 'subscription_box') {
            return 'WC_Product_Subscription_Box';
        }
        return $classname;
    }, 10, 2);

});
