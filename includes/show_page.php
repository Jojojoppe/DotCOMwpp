<?php

function dotcomwpp_template_showpage($template, $type){
    switch($type){
        case 'single':
            $template = plugin_dir_path(__FILE__)."../resources/php/single.php";
            break;
    }
    return $template;
}
add_filter('single_templage', 'dotcomwpp_template_showpage', 10, 2);