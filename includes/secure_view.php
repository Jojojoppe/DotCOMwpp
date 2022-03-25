<?php

function dotcomwpp_secure_view_shortcode($atts=[], $content=null){
    if(array_key_exists('capability', $atts) && current_user_can($atts['capability'])){
        $content = do_shortcode($content);
        return $content;
    }

    if(array_key_exists('role', $atts) && in_array("dotcomwpp_".strtolower(dotcomwpp_escape($atts['role'])), wp_get_current_user()->roles)){
        $content = do_shortcode($content);
        return $content;
    }

    if(array_key_exists('msg', $atts)){
        return "<p>".$atts['msg']."</p>";
    }

    return "";
}
add_shortcode('secure_view', 'dotcomwpp_secure_view_shortcode');