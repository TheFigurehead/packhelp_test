<?php

if(!defined('PachhelpThemeUrl')){
    define('PachhelpThemeUrl', get_template_directory_uri());
}

if(!defined('PachhelpThemePath')){
    define('PachhelpThemePath', get_template_directory());
}

add_theme_support( 'post-thumbnails' );

require PachhelpThemePath . '/src/init.php';
