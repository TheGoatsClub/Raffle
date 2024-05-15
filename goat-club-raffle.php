<?php
/*
Plugin name: RaffleClub
Description: Giveaway builder
Author: WOP lab LLC
Author URI:  https://wop-lab.company/
Text Domain: raffle
Version 1.0
Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RFL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('RFL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RFL_PLUGIN_NAME', plugin_basename(__DIR__));

/* Load classes */
require_once('autoloader.php');

/* Load Stripe library */
require_once('lib/stripe/vendor/autoload.php');

const RAFFLE_DOMAIN = 'raffle';
const RAFFLE_PREFIX = 'gc';

register_activation_hook(__FILE__, function () {
    RFL_Database::table_stripe_payments_install();
});

register_uninstall_hook(__FILE__, [RFL_Database::class, 'clear_after_uninstall']);