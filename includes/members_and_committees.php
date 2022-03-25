<?php

function dotcomwpp_members_and_committees_action(){
    // Perform action if needed (and unset POST[action] to do it once)
    if(array_key_exists('action', $_POST) && $_POST['action']=='editc'){

        // Save edited committee
        $committees = unserialize(get_option('dotcomwpp_committees'));
        $c = $_POST['dotcomwpp_name'];
        $cesc = dotcomwpp_escape($c);

        // Check if the old name is in the list
        if(!in_array($_POST['dotcomwpp_old_name'], $committees)){
            dotcomwpp_error("Committee not in list...", 'error');
            goto render;
        }

        $i = array_search($_POST['dotcomwpp_old_name'], $committees);
        $committees[$i] = $cesc;
        update_option('dotcomwpp_committees', serialize($committees));

        // Remove all users from the (old) role
        foreach(get_users() as $user){
            $user->remove_role('dotcomwpp_'.strtolower($_POST['dotcomwpp_old_name']));
        }

        // Update role, only if new name
        if($cesc!=$_POST['dotcomwpp_old_name']){
            wp_roles()->remove_role("dotcomwpp_".strtolower($_POST['dotcomwpp_old_name']));
            wp_roles()->add_role("dotcomwpp_".strtolower($cesc), $c, ['dotcomwpp_NULL']);
            wp_cache_delete('alloptions', 'options');
        }

        // Add the users to the role
        foreach($_POST['dotcomwpp_users'] as $userid){
            $user = get_user_by('id', $userid);
            $user->add_role('dotcomwpp_'.strtolower($cesc));
        }

        dotcomwpp_error('Committee saved!', 'message');

    }elseif(array_key_exists('action', $_POST) && $_POST['action']=='addc'){

        // Save new committee
        $committees = unserialize(get_option('dotcomwpp_committees'));
        $c = $_POST['dotcomwpp_name'];
        $cesc = dotcomwpp_escape($c);

        // Check if the name is not yet in the list
        if(in_array($c, $committees)){
            dotcomwpp_error("Committee already added...", 'error');
            goto render;
        }

        update_option('dotcomwpp_committees', serialize(array_merge($committees, [$cesc])));

        // Create role
        wp_roles()->add_role("dotcomwpp_".strtolower($cesc), $c, ['dotcomwpp_NULL']);
        wp_cache_delete('alloptions', 'options');

        // Add the users to the role
        foreach($_POST['dotcomwpp_users'] as $userid){
            $user = get_user_by('id', $userid);
            $user->add_role('dotcomwpp_'.strtolower($cesc));
        }

        dotcomwpp_error('Committee added!', 'message');
    }

    render:
    if(isset($_POST['action'])) unset($_POST['action']);
}

function dotcomwpp_members_and_committees_shortcode($atts=[], $content=null){
    if(!array_key_exists('page', $atts)){
        return "Need page attribute in shortcode tag!";
    }

    dotcomwpp_members_and_committees_action();

    if($atts['page']=='menu') return dotcomwpp_members_and_committees_menu($atts, $content);
    if($atts['page']=='main') return dotcomwpp_members_and_committees_main($atts, $content);
}
add_shortcode('members_and_committees', 'dotcomwpp_members_and_committees_shortcode');

function dotcomwpp_members_and_committees_menu($atts, $content){
    $ret = "";
    $committees = unserialize(get_option('dotcomwpp_committees'));

    // Show errors and messages if needed
    $ret .= dotcomwpp_show_errors();

    $ret .= "<b>Committees</b><br>";
    foreach($committees as $cesc){
        if($cesc=='') continue;

        $c = dotcomwpp_unescape($cesc);
        $ret .= " + <a href='?action=editc&c=$cesc'>$c</a><br>";
    }
    $ret .= "[<a href='?action=addc'>Add committee</a>]";

    return $ret;
}

function dotcomwpp_members_and_committees_edit_committee(){
    $ret = "<h5>Edit committee</h5>";

    if(!isset($_GET['c'])){
        dotcomwpp_error("No committee selected", "error");
        return $ret.dotcomwpp_show_errors();
    }

    $cesc = $_GET['c'];
    $c = dotcomwpp_unescape($cesc);

    $ret .= "<form action='' method='post' class='wpcf7'>";

    function add_field($field, $label, $desc=''){
        $ret = "<p><label>".$label."<br><span class='wpcf7-form-control-wrap'>".$field.$desc."</p>";
        return $ret;
    }

    $ret .= add_field("<input type='hidden' name='action' value='editc'>", "");
    $ret .= add_field("<input type='hidden' name='dotcomwpp_old_name' value='".$cesc."'>", "");
    $ret .= add_field("<input type='text' name='dotcomwpp_name' value='".$c."'>", "Name");

    $ret .= '<p class="submit"><input type="submit" value="Edit Committee" class="button button-secondary"></p>';

    // User list
    $users = get_users();

    $ret .= '<p>Add users to committee:</p>';
    foreach($users as $user){
        $ret .= "<input type='checkbox' value='".$user->id."' name='dotcomwpp_users[]'";
        if(in_array("dotcomwpp_".strtolower($cesc), (array)$user->roles)){
            $ret .= "checked";
        }
        $ret .= "> ".$user->user_nicename."<br>";
    }
    $ret .= "</form>";

    return $ret;
}

function dotcomwpp_members_and_committees_add_committee(){
    $ret = "<h5>Add Committee</h5>";
    $ret .= "<form action='' method='post' class='wpcf7'>";

    function add_field($field, $label, $desc=''){
        $ret = "<p><label>".$label."<br><span class='wpcf7-form-control-wrap'>".$field.$desc."</p>";
        return $ret;
    }

    $ret .= add_field("<input type='hidden' name='action' value='addc'>", "");
    $ret .= add_field("<input type='text' name='dotcomwpp_name'>", "Name");

    $ret .= '<p class="submit"><input type="submit" value="Add Committee" class="button button-secondary"></p>';

    // User list
    $users = get_users();

    $ret .= '<p>Add users to committee:</p>';
    foreach($users as $user){
        $ret .= "<input type='checkbox' value='".$user->id."' name='dotcomwpp_users[]'> ".$user->user_nicename."<br>";
    }

    $ret .= "</form>";
    return $ret;
}

function dotcomwpp_members_and_committees_main($atts, $content){
    $ret = "";
    $committees = explode(',', get_option('dotcomwpp_committees'));

    // Show errors and messages if needed
    $ret .= dotcomwpp_show_errors();

    if(array_key_exists('action', $_GET) && $_GET['action']=='editc'){
        $ret .= dotcomwpp_members_and_committees_edit_committee();
    }elseif(array_key_exists('action', $_GET) && $_GET['action']=='addc'){
        $ret .= dotcomwpp_members_and_committees_add_committee();
    }

    return $ret;
}