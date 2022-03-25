<?php

function dotcomwpp_users_init(){
    // Base capabilities for the plugin
    $admin = wp_roles()->get_role('administrator');
    $admin->add_cap('dotcomwpp_edit_members_committees', true);
}

function dotcomwpp_users_deinit(){
    $admin = wp_roles()->get_role('administrator');
    $admin->remove_cap('dotcomwpp_edit_members_committees');
}

function dotcomwpp_register_cap_groups(){
	members_register_cap_group(
		'dotcomwpp',
		array(
			'label'    => __( 'NEST Stuff', 'dotcomwpp-textdomain' ),
			'caps'     => array(
                'dotcomwpp_edit_members_committees'
            ),
			'icon'     => 'dashicons-universal-access',
			'priority' => 10
		)
	);
}
add_action( 'members_register_cap_groups', 'dotcomwpp_register_cap_groups' );