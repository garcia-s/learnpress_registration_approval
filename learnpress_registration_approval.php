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

if (!defined('ABSPATH')) {
    exit;
}

register_activation_hook(__FILE__, 'learnpress_registration_approval_activate');

function learnpress_registration_approval_activate()
{
}

register_deactivation_hook(__FILE__, 'learnpress_registration_approval_deactivate');

function learnpress_registration_approval_deactivate()
{
}







