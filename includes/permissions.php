<?php

function dotcomwpp_permissions_shortcode($atts=[], $content=null){
    if(!array_key_exists('page', $atts)){
        return "Need page attribute in shortcode tag!";
    }

    dotcomwpp_permissions_action();

    if($atts['page']=='menu') return dotcomwpp_permissions_menu($atts, $content);
    if($atts['page']=='main') return dotcomwpp_permissions_main($atts, $content);
}
add_shortcode('dotcomwpp_permissions', 'dotcomwpp_permissions_shortcode');

function dotcomwpp_permissions_action(){
    if(isset($_POST['action']) && $_POST['action'] == 'role'){
        $role = $_POST['dotcomwpp_role'];
        if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_permissions") || in_array('administrator', wp_get_current_user()->roles)){
            // Update member capabilities
            $member = get_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role)));
            $capabilities = explode(',', get_option('dotcomwpp_capabilities'));
            foreach($capabilities as $cap){
                if($cap=='') continue;
                if(in_array($cap, $_POST['dotcomwpp_capabilities'])){
                    $member->add_cap($cap);
                }else{
                    $member->remove_cap($cap);
                }
            }
            dotcomwpp_error('Role capabilities updated', 'message');
        }
        if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_users") || in_array('administrator', wp_get_current_user()->roles)){
            // Update user list
            foreach(get_users() as $user){
                $user->remove_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role)));
                $user->remove_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role)).'_edit');
            }
            foreach($_POST['dotcomwpp_users_1'] as $userid){
                $user = get_user_by('id', $userid);
                $user->add_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role)));
            }
            if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_permissions") || in_array('administrator', wp_get_current_user()->roles)){
                foreach($_POST['dotcomwpp_users_2'] as $userid){
                    $user = get_user_by('id', $userid);
                    $user->add_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role))."_edit");
                }
            }
            dotcomwpp_error('Role users updated', 'message');
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'home'){
        if(current_user_can('nest_edit_member')){
            // Update member capabilities
            $member = get_role('member');
            $capabilities = explode(',', get_option('dotcomwpp_capabilities'));
            foreach($capabilities as $cap){
                if($cap=='') continue;
                if(in_array($cap, $_POST['dotcomwpp_capabilities'])){
                    $member->add_cap($cap);
                }else{
                    $member->remove_cap($cap);
                }
            }
            dotcomwpp_error('Member capabilities updated', 'message');
        }
    }

    unset($_POST['action']);
}

function dotcomwpp_permissions_menu($atts, $content){
    $ret = "";

    $roles = explode(',', get_option('dotcomwpp_committees'));

    $ret .= "<h5>Menu</h5>";

    // Show errors and messages if needed
    $ret .= dotcomwpp_show_errors();

    $ret .= "<a href='?action=home'>Home</a><br><br>";

    $ret .= "<b>Roles:</b><br>";
    foreach($roles as $role){
        if($role=='') continue;
        if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_users") || current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_permissions") || in_array('administrator', wp_get_current_user()->roles)){
            $ret .= "+ <a href='?action=editrole&role=".$role."'>$role</a><br>";
        }
    }

    return $ret;
}

function dotcomwpp_permissions_main($atts, $content){
    $ret = "";

    // Show errors and messages if needed
    $ret .= dotcomwpp_show_errors();

    $capabilities = explode(',', get_option('dotcomwpp_capabilities'));

    if(isset($_GET['action']) && $_GET['action']=='editrole'){

        // EDIT ROLE
        // ---------
        $role = $_GET['role'];
        $ret .= "<h2>Edit ".$role."</h2><form action='' method='post' class='wpcf7'><input type='hidden' name='action' value='role'><input type='hidden' name='dotcomwpp_role' value='$role'>";

        // Users in role
        if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_users") || in_array('administrator', wp_get_current_user()->roles)){
            $ret .= "<p><b>Users with role '$role':</b><br>";
            $users = get_users();
            foreach($users as $user){
                $ret .= "<input type='checkbox' value='".$user->id."' name='dotcomwpp_users_1[]'";
                if(in_array("dotcomwpp_".dotcomwpp_escape(strtolower($role)), (array)$user->roles)){
                    $ret .= "checked";
                }
                $ret .= "> ";

                if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_permissions") || in_array('administrator', wp_get_current_user()->roles)){
                    $ret .= " [admin <input type='checkbox' value='".$user->id."' name='dotcomwpp_users_2[]'";
                    if(in_array("dotcomwpp_".dotcomwpp_escape(strtolower($role))."_edit", (array)$user->roles)){
                        $ret .= "checked";
                    }
                    $ret .= ">]  ";
                }
                $ret .= $user->user_nicename."<br>";
            }
            $ret .= '<input type="submit" value="Save changes" class="button button-secondary"><br>';
            $ret .= "</p>";
        }else{
            $ret .= "<p>You do not have permission to add or remove users from this role</p>";
        }

        // Capabilities of role
        if(current_user_can('nest_edit_'.dotcomwpp_escape(strtolower($role))."_permissions") || in_array('administrator', wp_get_current_user()->roles)){
            $ret .= "<p><b>Capabilities of $role:</b><br>";
            $member = get_role('dotcomwpp_'.dotcomwpp_escape(strtolower($role)));
            foreach($capabilities as $cap){
                if($cap=='') continue;
                $ret .= "<input type='checkbox' value='$cap' name='dotcomwpp_capabilities[]'";
                if(in_array($cap, $member->capabilities) && $member->capabilities[$cap]) $ret .= " checked";
                $ret .= "> ". $cap ."<br>";
            }
            $ret .= '<input type="submit" value="Save changes" class="button button-secondary"><br>';
            $ret .= "</p>";
        }

        $ret .= "</form>";

        
    }else{

        // HOME
        // ----
        $ret .= "<h2>Home</h2>On this page you can add and remove members from Role groups. These groups regulate permissions for different sections on the site. Click on a Role group and there you will see a list of all the members with a NEST account who has logged in at least once.";
        
        $ret .= "<form action='' method='post' class='wpcf7'><input type='hidden' name='action' value='home'>";

        // Capabilities of members
        if(current_user_can('nest_edit_members')){
            $ret .= "<p><b>Capabilities of members:</b><br>";
            $member = get_role('member');
            foreach($capabilities as $cap){
                if($cap=='') continue;
                $ret .= "<input type='checkbox' value='$cap' name='dotcomwpp_capabilities[]'";
                if(in_array($cap, $member->capabilities) && $member->capabilities[$cap]) $ret .= " checked";
                $ret .= "> ". $cap ."<br>";
            }
            $ret .= '<input type="submit" value="Save changes" class="button button-secondary"><br>';
            $ret .= "</p>";
        }

        $ret .= "</form>";

    }

    return $ret;
}