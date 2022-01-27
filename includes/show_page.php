<?php

function dotcomwpp_show_page_file($path, $file=''){
    if($file == 'single.php'){
        return plugin_dir_path(__FILE__).'resources/php/single.php';
    }
    return $path;
}
add_filter('theme_file_path', 'dotcomwpp_show_page_file', 20, 2);