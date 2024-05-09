<?php
/*
Plugin name: Goat Club Raffle
Description: Giveaway builder
Author: WOP lab LLC
Author URI:  https://wop-lab.company/
Text Domain: gcraffle
Version 1.0
Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('RFL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('RFL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RFL_PLUGIN_NAME', plugin_basename(__DIR__));