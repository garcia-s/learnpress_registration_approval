<?php

/**
 * Plugin Name: LearnPress Registration Approval
 * Plugin URI: github.com/garcia-s/learnpress_registration_approval
 * Description: Handles registration approval for LearnPress.
 * Version: 1.0.0
 * Author: Juan Garcia
 * Author URI: github.com/garcia-s
 * License: [License]
 */
require_once(plugin_dir_path(__FILE__) . "learnpress_admin_panel.php");


if (!defined('ABSPATH')) {
    exit;
}

function create_custom_roles()
{
    $pendingRole = 'pending_user';
    $pendingDN = 'Pending User';

    $deniedRole = 'denied';
    $deniedDN = "Blocked User";

    if (!get_role($pendingRole)) {
        add_role($pendingRole, $pendingDN, array());
    }

    if (!get_role($denied)) {
        add_role($deniedRole, $deniedDN, array());
    }
}
add_action('init', 'create_custom_roles');

