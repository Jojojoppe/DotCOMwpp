<?php

function dotcomwpp_users_init(){
    // Base capabilities for the plugin
    $admin = wp_roles()->get_role('administrator');
    $admin->add_cap('nest_edit_settings', true);
    $admin->add_cap('nest_edit_permissions', true);
    $admin->add_cap('nest_edit_members', true);
}

function dotcomwpp_users_deinit(){
    $admin = wp_roles()->get_role('administrator');
    $admin->remove_cap('nest_edit_settings');
    $admin->remove_cap('nest_edit_members');
}