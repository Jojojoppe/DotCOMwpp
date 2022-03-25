<?php

function dotcomwpp_error($type, $msg){
    if(!isset($_SESSION['RORDB_ERROR'])) $_SESSION['RORDB_ERROR'] = [];
    $_SESSION['RORDB_ERROR'] = array_merge($_SESSION['RORDB_ERROR'], [[$type, $msg]]);
}

function dotcomwpp_show_errors(){
    $ret = "";
    if(isset($_SESSION['RORDB_ERROR'])){
        foreach($_SESSION['RORDB_ERROR'] as $e){
            if($e[1]=="error"){
                $ret .= "<div width='100%' style='background-color:#ff6666'>ERROR: ";
            }else{
                $ret .= "<div width='100%' style='background-color:#bbff99'>MESSAGE: ";
            }
            $ret .= $e[0];
            $ret .= "</div>";       
        }
        unset($_SESSION['RORDB_ERROR']);
    };
    return $ret;
}