<?php

function dotcomwpp_settings_init(){
	// Register section
	add_settings_section('dotcomwpp_section_main', __('Main settings of DotCOMwpp', 'dotcomwpp'),
		'dotcomwpp_section_header_callback', 'dotcomwpp');

	register_setting('dotcomwpp', 'dotcomwpp_committees', ['default'=>'']);
	add_settings_field('dotcomwpp_field_committees', __('Committees', 'dotcomwpp'),
		'dotcomwpp_field_text', 'dotcomwpp', 'dotcomwpp_section_main', [
			'label_for'				=> 'dotcomwpp_committees',
			'description'			=> 'Comma seperated list of committees (used for member roles on the site)'
		]);
}
add_action('admin_init', 'dotcomwpp_settings_init');

// Settings section header callback
// ------------------------------
function dotcomwpp_section_header_callback($args){
	echo "<p id=\"".esc_attr($args["id"])."\">";
}