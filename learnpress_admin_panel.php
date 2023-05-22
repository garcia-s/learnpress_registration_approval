<?php

add_action('admin_menu', 'learnpress_registration_approval_add_menu', 99);


// Register admin menu callback
function learnpress_registration_approval_add_menu()
{
    echo("HELLO");
    die();
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
    $pending_users = get_users(array(
        'meta_key' => 'learnpress_registration_approval_status',
        'meta_value' => 'pending',
    ));

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
function learnpress_registration_approval_process_action()
{
    // Check if the action is set and the user has the required capability
    if (isset($_GET['action']) && current_user_can('manage_options')) {
        $action = $_GET['action'];

        if ($action === 'approve' || $action === 'deny') {
            // Get the user ID from the query parameter
            $user_id = isset($_GET['user_id']) ? absint($_GET['user_id']) : 0;

            // Update the user's approval status based on the action
            $approval_status = ($action === 'approve') ? 'approved' : 'denied';
            update_user_meta($user_id, 'learnpress_registration_approval_status', $approval_status);

            // Redirect back to the admin page
            wp_redirect(admin_url('edit.php?post_type=lp_course&page=learnpress-registration-approval'));
            exit;
        }
    }
}
