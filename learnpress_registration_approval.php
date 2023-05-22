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
require_once("./learnpress_admin_panel.php");

if (!defined('ABSPATH')) {
    exit;
}


add_action('learn_press_before_register_user', 'learnpress_registration_approval_check');

function learnpress_registration_approval_check($user_id)
{
    $approval_status = 'pending';
    update_user_meta($user_id, 'learnpress_registration_approval_status', $approval_status);
    wp_redirect(home_url('/pending-approval'));
    exit;
}


add_action('learn_press_course_access_before', 'learnpress_registration_approval_access_check');
function learnpress_registration_approval_access_check($user_id, $course_id)
{
    $approval_status = get_user_meta($user_id, 'learnpress_registration_approval_status', true);
    if ($approval_status !== 'approved') {
        wp_redirect(home_url('/access-denied'));
        exit;
    }
}
