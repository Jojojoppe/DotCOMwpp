<?php

const dotcomwpp_escape_chars = [
    '_', '-', ',', '.',
    '!', '@', '#', '$', 
    '%', '^', '&', '(', 
    ')', '+', '=', '[', 
    '{', ']', '}', '\\', 
    '|', ';', ':', '\'', 
    '"', '/', '?', '<', 
    '>', '~', '`',
    '1', '2', '3', '4', 
    '5', '6', '7', '8', 
    '9', '0', ' ',
];
const dotcomwpp_unescape_chars = [
    '__a', '__b', '__c', '__d',
    '__e', '__f', '__g', '__h',
    '__i', '__j', '__k', '__l',
    '__m', '__n', '__o', '__p',
    '__q', '__r', '__s', '__t',
    '__u', '__v', '__w', '__x',
    '__y', '__z', '_aa', '_ab',
    '_ac', '_ad', '_ae',
    '_af', '_ag', '_ah', '_ai',
    '_aj', '_ak', '_al', '_am',
    '_an', '_ao', '_ap',
];

function dotcomwpp_escape($str){
    return str_replace(dotcomwpp_escape_chars, dotcomwpp_unescape_chars, $str);
}

function dotcomwpp_unescape($str){
    return str_replace(dotcomwpp_unescape_chars, dotcomwpp_escape_chars, $str);
}