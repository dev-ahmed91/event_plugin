<?php
/*
Plugin Name: Events
Plugin URI: https://github.com/dev-ahmed91/event_plugin.git
Description: A Plugin For Events Crud ( Create, Read, Update & Delete ) 
Author: Ahmed Mohamed
Author URI: https://github.com/dev-ahmed91
Version: 1.0.0
*/

defined("ABSPATH") or die("Bad Access");

/*
 * get Plugin All Pathes
 */
require_once("pathes.php");

/*
 * get event admin class Pathes
 */
require_once(PLUGIN_PATH_ADMIN."event-admin.php");


if(class_exists("eventsAdmin"))
{
    $eventsPlugin = new eventsAdmin();
}


