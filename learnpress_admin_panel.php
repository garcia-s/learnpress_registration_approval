<?php

add_action('admin_menu', 'learnpress_registration_approval_add_menu', 99);


// Register admin menu callback
function learnpress_registration_approval_add_menu()
{
    add_submenu_page(
        'learn_press',
        'Registration Approval',
        'Registration Approval',
        'manage_options',
        'learnpress-registration-approval',
        'learnpress_registration_approval_admin_page'
    );
}

// Admin page callback
function learnpress_registration_approval_admin_page()
{
    // Check if the user has the required capability
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Get all users with pending approval status

    $pending_users =  get_users(array('role' => 'pending_user'));
    // Display the pending registrations in a table
    echo '<div class="wrap">';
    echo '<h1>Registration Approval</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>' . __('User ID', 'learnpress-registration-approval') . '</th>';
    echo '<th>' . __('Username', 'learnpress-registration-approval') . '</th>';
    echo '<th>' . __('Email', 'learnpress-registration-approval') . '</th>';
    echo '<th>' . __('Actions', 'learnpress-registration-approval') . '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($pending_users as $user) {
        $user_id = $user->ID;
        $username = $user->user_login;
        $email = $user->user_email;

        echo '<tr>';
        echo '<td>' . $user_id . '</td>';
        echo '<td>' . $username . '</td>';
        echo '<td>' . $email . '</td>';
        echo '<td>';
        echo '<a href="' . esc_url(add_query_arg(array('action' => 'approve', 'user_id' => $user_id))) . '">' . __('Approve', 'learnpress-registration-approval') . '</a> | ';
        echo '<a href="' . esc_url(add_query_arg(array('action' => 'deny', 'user_id' => $user_id))) . '">' . __('Deny', 'learnpress-registration-approval') . '</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// Process approval or denial action
add_action('admin_init', 'learnpress_registration_approval_process_action');

// Process action callback
function learnpress_registration_approval_process_action($user_id)
{
    if (isset($_GET['action']) && current_user_can('manage_options')) {

        $action = $_GET['action'];

        if ($action === 'approve') {
            $user = new WP_User($user_id);
            $user->set_role('subscriber');
        } else if ($action === 'deny') {
            $user = new WP_User($user_id);
            $user->set_role('denied');
        }
    }
}
