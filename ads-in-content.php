<?php
/**
 * Plugin Name:       Ads In Content
 * Plugin URI:        https://wordpress.org/plugins/ads-in-content/
 * Description:       You can easily add your ad codes to anywhere in your content.
 * Version:           1.0.0
 * Author:            Çağdaş Dağ
 * Author URI:        http://www.cagdasdag.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ads-in-content
 * Domain Path:       /languages
 */

namespace AIC_Admin;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// The class that contains the plugin info.
require_once plugin_dir_path(__FILE__) . 'includes/class-info.php';

/**
 * The code that runs during plugin activation.
 */
function activation() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-activator.php';
    Activator::activate();
}
register_activation_hook(__FILE__, __NAMESPACE__ . '\\activation');

/**
 * Run the plugin.
 */
function run() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-plugin.php';
    $plugin = new Plugin();
    $plugin->run();
}
run();
