<?php

function dotcomwpp_settings_init(){
	// Register section
	add_settings_section('dotcomwpp_section_main', __('Main settings of DotCOMwpp', 'dotcomwpp'),
		'dotcomwpp_section_header_callback', 'dotcomwpp');

	register_setting('dotcomwpp', 'dotcomwpp_committees_old', ['default'=>'']);
	add_settings_field('dotcomwpp_field_committees_old', __('Roles (old)', 'dotcomwpp'),
		'dotcomwpp_field_text_disabled', 'dotcomwpp', 'dotcomwpp_section_main', [
			'label_for'				=> 'dotcomwpp_committees_old',
		]);
	register_setting('dotcomwpp', 'dotcomwpp_committees', ['default'=>'']);
	add_settings_field('dotcomwpp_field_committees', __('Roles', 'dotcomwpp'),
		'dotcomwpp_field_text', 'dotcomwpp', 'dotcomwpp_section_main', [
			'label_for'				=> 'dotcomwpp_committees',
			'description'			=> 'Comma seperated list of roles (used for member roles on the site). Editing this causes Wordpress Roles to be created or deleted'
		]);

	register_setting('dotcomwpp', 'dotcomwpp_capabilities_old', ['default'=>'']);
	add_settings_field('dotcomwpp_field_capabilities_old', __('Capabilities (old)', 'dotcomwpp'),
		'dotcomwpp_field_textarea_disabled', 'dotcomwpp', 'dotcomwpp_section_main', [
			'label_for'				=> 'dotcomwpp_capabilities_old',
		]);
	register_setting('dotcomwpp', 'dotcomwpp_capabilities', ['default'=>'']);
	add_settings_field('dotcomwpp_field_capabilities', __('Capabilities', 'dotcomwpp'),
		'dotcomwpp_field_textarea', 'dotcomwpp', 'dotcomwpp_section_main', [
			'label_for'				=> 'dotcomwpp_capabilities',
			'description'			=> 'Comma seperated list of capabilities (used for member roles on the site)'
		]);
}
add_action('admin_init', 'dotcomwpp_settings_init');

// Settings section header callback
// ------------------------------
function dotcomwpp_section_header_callback($args){
	echo "<p id=\"".esc_attr($args["id"])."\">";
}