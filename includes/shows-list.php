<?php

function dotcomwpp_shows_list_shortcode($atts=[], $content=null){
    if(!array_key_exists('category', $atts)){
        return "Need category attribute in shortcode tag!";
    }

    ob_start();

    // Get category ID
    $cat = get_cat_ID($atts['category']);
    foreach(get_posts([
        'numberposts' => -1,
        'category' => $cat,
        'orderby' => 'date',
        'order' => 'ASC',
    ]) as $post){
        $p_title = get_string_between($post->post_content, "{TITLE}", "{/TITLE}");
        $p_desc = get_string_between($post->post_content, "{DESC}", "{/DESC}");
        $p_when = get_string_between($post->post_content, "{WHEN}", "{/WHEN}");
        $p_lang = get_string_between($post->post_content, "{LANG}", "{/LANG}");
        $p_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');

        // Get first and last date
        $dates = preg_split('/ (-|=) /', $p_when);
        if(count($dates)>=2){
            $p_when = date("F jS Y - H:i", strtotime($dates[0])).' - '.date("F jS Y - H:i", strtotime(end($dates)));
        }else{
            $p_when = date("F jS Y - H:i", strtotime($p_when));
        }

        echo str_replace([
            '{TITLE}', '{DESC}', '{WHEN}', '{LANG}', '{IMGURL}', '{BTNURL}',
        ], [
            $p_title, $p_desc, $p_when, $p_lang, $p_image, '/'.$atts['category'].'/'.$post->post_name,
        ], $content);

    }

    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}
add_shortcode('dotcomwpp_shows_list', 'dotcomwpp_shows_list_shortcode');

