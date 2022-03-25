<?php

function dotcomwpp_admin_menu(){
    add_menu_page(
        "NEST Stuff",
        "NEST Stuff",
        "nest_edit_settings",
        "dotcomwpp",
        "dotcomwpp_options_page_html",
        file_get_contents(plugin_dir_path(__FILE__)."../resources/images/nest_icon.wpico")
    );
}
add_action('admin_menu', 'dotcomwpp_admin_menu');

function dotcomwpp_options_page_html(){
    if(!is_admin()){
        return;
    }

	if(isset($_GET['settings-updated'])){

        // Differences must be resolved -> create and delete roles for committees
        $comms_new = explode(',', get_option('dotcomwpp_committees'));
        $comms_old = explode(',', get_option('dotcomwpp_committees_old'));
        foreach($comms_new as $c){
            if($c=='') continue;
            if(!in_array($c, $comms_old)){
                // Add role
                wp_roles()->add_role('dotcomwpp_'.strtolower(dotcomwpp_escape($c)), $c);
                add_settings_error('dotcomwpp_messages', 'dotcomwpp_message',
                    __('Create role '.$c, 'rordb'), 'updated');

                // Create role edit capabilities
                $caps = explode(',', get_option('dotcomwpp_capabilities'));
                $caps = array_merge($caps, [
                    'nest_edit_'.strtolower(dotcomwpp_escape($c)).'_permissions',
                    'nest_edit_'.strtolower(dotcomwpp_escape($c)).'_users',
                ]);
                update_option('dotcomwpp_capabilities', join(',', $caps));
            }
        }
        foreach($comms_old as $c){
            if($c=='') continue;
            if(!in_array($c, $comms_new)){
                // Remove
                wp_roles()->remove_role('dotcomwpp_'.strtolower(dotcomwpp_escape($c)));
                add_settings_error('dotcomwpp_messages', 'dotcomwpp_message',
                    __('Remove role '.$c, 'rordb'), 'updated');

                // Remove role edit capabilities
                $caps = explode(',', get_option('dotcomwpp_capabilities'));
                unset($caps[array_search('nest_edit_'.strtolower(dotcomwpp_escape($c))).'_permissions']);
                unset($caps[array_search('nest_edit_'.strtolower(dotcomwpp_escape($c))).'_users']);
                update_option('dotcomwpp_capabilities', join(',', $caps));
            }
        }

        // Update performed, shift data to old fields
        update_option('dotcomwpp_committees_old', get_option('dotcomwpp_committees'));
        update_option('dotcomwpp_capabilities_old', get_option('dotcomwpp_capabilities'));

        add_settings_error('dotcomwpp_messages', 'dotcomwpp_message',
            __('Settings are updated', 'rordb'), 'updated');
    }

	settings_errors('dotcomwpp_messages');

    ?>
    <div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
			<?php
			settings_fields('dotcomwpp');
			do_settings_sections('dotcomwpp');
			submit_button('Save settings');
			?>
		</form>
    </div>
    <?php
}