<?php

function dotcomwpp_secure_button_shortcode($atts=[], $content=null){
    if(!array_key_exists('url', $atts)){
        $atts['url']='';
    }
    if(!array_key_exists('capability', $atts)){
        $atts['capability']='';
    }

    $pre = '';

    if(array_key_exists('divclass', $atts)){
        $pre = "class = '".$atts['divclass']."'";
    }

    if(current_user_can($atts['capability']) || (array_key_exists('isadmin', $atts) && is_admin())){
        return "<div $pre><div class='wp-block-button aligncenter'><a class='wp-block-button__link' href='".$atts['url']."'>".$content."</a></div></div>";
    }

    return "";
}
add_shortcode('secure_button', 'dotcomwpp_secure_button_shortcode');