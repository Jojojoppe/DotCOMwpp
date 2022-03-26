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