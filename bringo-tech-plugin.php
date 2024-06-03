<?php
/**
 * Plugin Name: Bringo Tech Plugin
 * Plugin URI:  https://bringotech.com/
 * Description: A plugin to extend WooCommerce functionality with dynamic discounts.
 * Version:     1.0
 * Author:      Joseph Makki S. Carino
 * Author URI:  https://bringotech.com/
 * License:     GPL-2.0+
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Add settings page to the admin menu
add_action('admin_menu', 'bringo_tech_plugin_menu');

function bringo_tech_plugin_menu() {
    add_menu_page(
        'Bringo Tech Plugin Settings',
        'WooCommerce Discount',
        'manage_options',
        'bringo-tech-plugin-settings',
        'bringo_tech_plugin_settings_page',
        'dashicons-admin-generic'
    );
}

// Display settings page content
function bringo_tech_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Bringo Tech Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('bringo_tech_plugin_settings_group');
            do_settings_sections('bringo-tech-plugin-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'bringo_tech_plugin_settings_init');

function bringo_tech_plugin_settings_init() {
    register_setting('bringo_tech_plugin_settings_group', 'btp_product_id');
    register_setting('bringo_tech_plugin_settings_group', 'btp_discount_amount');

    add_settings_section(
        'bringo_tech_plugin_settings_section',
        'Discount Settings',
        'bringo_tech_plugin_settings_section_callback',
        'bringo-tech-plugin-settings'
    );

    add_settings_field(
        'btp_product_id',
        'Product ID',
        'btp_product_id_callback',
        'bringo-tech-plugin-settings',
        'bringo_tech_plugin_settings_section'
    );

    add_settings_field(
        'btp_discount_amount',
        'Discount Amount',
        'btp_discount_amount_callback',
        'bringo-tech-plugin-settings',
        'bringo_tech_plugin_settings_section'
    );
}

function bringo_tech_plugin_settings_section_callback() {
    echo 'Enter the product ID and discount amount.';
}

function btp_product_id_callback() {
    $product_id = get_option('btp_product_id');
    echo '<input type="text" name="btp_product_id" value="' . esc_attr($product_id) . '" />';
}

function btp_discount_amount_callback() {
    $discount_amount = get_option('btp_discount_amount');
    echo '<input type="text" name="btp_discount_amount" value="' . esc_attr($discount_amount) . '" />';
}

// Add discount to a specific product in the cart
add_action('woocommerce_cart_calculate_fees', 'apply_discount_to_specific_product');

function apply_discount_to_specific_product($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Retrieve product ID and discount amount from settings
    $product_id = get_option('btp_product_id');
    $discount_amount = get_option('btp_discount_amount');

    if (!$product_id || !$discount_amount) {
        return; // Exit if settings are not set
    }

    // Loop through the cart items
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // Check if the product ID matches
        if ($cart_item['product_id'] == $product_id) {
            // Calculate the discount
            $discount = floatval($discount_amount) * $cart_item['quantity'];

            // Apply the discount
            $cart->add_fee('Product Discount', -$discount);
            break;
        }
    }
}

