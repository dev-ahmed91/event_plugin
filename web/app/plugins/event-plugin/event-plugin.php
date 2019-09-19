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

 /*
 * get event frontend public class 
 */   
require_once(PLUGIN_PATH_PUBLIC."event_frontend.php");

if(class_exists("eventsAdmin"))
{
    $eventsPlugin = new eventsAdmin();
    /*
    * define activate function
    */
    function plugin_activate()
    {
        eventsAdmin::activate();
    }
    /*
    * define deactivate function
    */
    function plugin_deactivate()
    {
        eventsAdmin::deactivate();
    }
    
    
    /*
    * show all events
    */
    function all_events_layout()
    {
        return event_frontend::custom_page_layout();
    }
    // filter for show all events
    add_filter("page_template",'all_events_layout');
    // register activate hook
    register_activation_hook( __FILE__, 'plugin_activate');
    // register deactivate hook
    register_deactivation_hook( __FILE__, 'plugin_deactivate'); 
}


