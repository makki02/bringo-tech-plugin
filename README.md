# Bringo Tech Plugin

**Bringo Tech Plugin** is a custom WooCommerce plugin that allows you to dynamically apply a discount to a specific product via the WordPress admin interface.

## Features

- Add a settings page in the WordPress admin to configure the product ID and discount amount.
- Apply a discount to the specified product in the WooCommerce cart.

## Installation

1. Download the plugin files and place them in a folder named `bringo-tech-plugin` in your `wp-content/plugins` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. Go to the WordPress admin area.
2. Navigate to `WooCommerce Discount` under the WordPress admin menu.
3. Enter the product ID and discount amount.
4. Save the settings.

## Detailed Steps to Create the Plugin

### Step 1: Create Plugin Directory and File

- Create a directory named `bringo-tech-plugin` in `wp-content/plugins`.
- Inside this directory, create a file named `bringo-tech-plugin.php`.

### Step 2: Add Plugin Header

Add the following header information to `bringo-tech-plugin.php`:

```php
<?php
/**
 * Plugin Name: Bringo Tech Plugin
 * Plugin URI:  http://example.com
 * Description: A plugin to extend WooCommerce functionality with dynamic discounts.
 * Version:     1.0
 * Author:      Your Name
 * Author URI:  http://example.com
 * License:     GPL-2.0+
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
