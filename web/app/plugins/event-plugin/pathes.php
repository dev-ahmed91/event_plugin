<?php

/*
    define Plugin Pathes
*/

// Plugin Url =>
define('PLUGIN_URL', plugin_dir_url( __FILE__ ));
// Plugin Path
define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));
// Css Folder Url
define('PLUGIN_URL_CSS', PLUGIN_URL."css".DIRECTORY_SEPARATOR);
// Js Folder Url
define('PLUGIN_URL_JS', PLUGIN_URL."js".DIRECTORY_SEPARATOR);
// Views Folder Path 
define('PLUGIN_PATH_VIEWS', PLUGIN_PATH."views".DIRECTORY_SEPARATOR);
// Backend Views Path 
define('PLUGIN_PATH_VIEWS_BACKEND', PLUGIN_PATH."views".DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR);
// Frontend Views Path 
define('PLUGIN_PATH_VIEWS_FRONTEND', PLUGIN_PATH."views".DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR);
// Vendor Folder Url
define('PLUGIN_URL_VENDOR', PLUGIN_URL."vendor".DIRECTORY_SEPARATOR);