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

// get Plugin All Pathes
require_once("pathes.php");



class eventsPlugin{

    
    // define table name
    private $tableName = "ev_events";
    // define Tags Table
    private $tagesTable = "ev_events_tags";

    public function __construct(){
        add_action('admin_menu', array($this,'add_pages_to_menu'));
        add_action( 'admin_enqueue_scripts', array($this,'load_custom_css_js'));

        $this->add_hooks();
        
    }
    /*
    When User Activate Plugin
    */
    public function activate(){
        //flush rewrite rules
        flush_rewrite_rules();
        // create Plugin Tables
        $this->create_plugin_tables();
        // add Pages To Admin menu
        add_action('admin_menu', array($this,'add_pages_to_menu'));
        add_action( 'admin_enqueue_scripts', array($this,'load_custom_css_js'));
        
    }
    

    /*
    When User Deactivate Plugin
    */
    public function deactivate(){
        //flush rewrite rules
        flush_rewrite_rules();
    }
    /*
    When User Uninstall Plugin
    */
    public function uninstall(){
        // drop plugin tables
        $this->drop_plugin_tables();
    }

    /*
     * this Function Is Used For create plugin tables
     * */
    private function create_plugin_tables(){
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        // create Event Table Sql Query
        $sql = "CREATE TABLE IF NOT EXISTS $this->tableName(
                `id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT,
                `title` varchar(255),
                `description` text,
                `image` varchar(255),
                `date` varchar(255),
                `start_time` varchar(255),
                `end_time` varchar(255),
                `event_category` varchar(255),
                PRIMARY KEY  (id)
        ) $charset_collate;";
        
        // create Event Tags Table Sql Query
        $tag_sql = "CREATE TABLE IF NOT EXISTS $this->tagesTable(
                `id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT,
                `event_id` int(11),
                `tag` varchar(255),
                PRIMARY KEY  (id),
                FOREIGN KEY (id) REFERENCES $this->tableName(id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        dbDelta( $tag_sql );
    }
    /*
    this Function Used For Drop Plugin Tables
    */
    public function drop_plugin_tables() {
        global $wpdb;

        $sql = "DROP TABLE IF EXISTS $this->tableName";
        $wpdb->query($sql);
    }
    /*
    this function used for add pages To Admin Menu
    */
    public function add_pages_to_menu(){
        add_menu_page('Events', 'Events', 'manage_options', 'new-event', array($this,'add_event_output') );
        add_submenu_page('new-event', 'Events', 'New Event', 'manage_options', 'new-event', array($this,'add_event_output'));
        add_submenu_page('new-event', 'Events', 'All Events', 'manage_options', 'view-events', array($this,'all_events_output') );
        add_submenu_page(null, 'Events', 'Edit Events', 'manage_options', 'edit-event', array($this,'edit_event_output') );
    }
    /**
   * registers hooks for this plugin
   */
    public function add_hooks(){
       // activate
        register_activation_hook( __FILE__, array($this,'activate'));
        // deactivate
        register_deactivation_hook( __FILE__, array($this,'deactivate')); 
    }
    /*
    show add new event page
    */
    public function add_event_output() {
      var_dump($_POST['tags']);
      require_once(PLUGIN_PATH_VIEWS_BACKEND.'new_entry.php');
    }
    /*
    show adEdit event page
    */
    public function edit_event_output() {
      require_once(PLUGIN_PATH_VIEWS_BACKEND.'edit_entry.php');
    }
    /*
    show all events using wordpress list table 
    */
    function all_events_output() {
      require_once("EntryListTable.php");    
      $table = new EntryListTable($this->tableName);
      $table->prepare_items();
      echo '<h4>View Events</h4>';
      echo '<form action="" method="GET">';
      echo '<input type="hidden" name="page" value="'.$_REQUEST['page'].'"/>';   
      $table->search_box( 'search', 'search_id' );
      $table->display();
      echo '</form>';    
          
    }
    /*
    load Plugin Css And Js Files
    */
    function load_custom_css_js() {
      wp_register_style( 'bootstrap_css', PLUGIN_URL_VENDOR.'/bootstrap-3.3.6-dist/css/bootstrap.min.css');
      wp_enqueue_style( 'bootstrap_css' );
      wp_register_style( 'tags_css', PLUGIN_URL_VENDOR.'/tag/tag.css');
      wp_enqueue_style( 'tags_css' );
      wp_enqueue_script( 'jquery_js', PLUGIN_URL_VENDOR. '/jquery.js' );
      wp_enqueue_script( 'bootstrap_js', PLUGIN_URL_VENDOR. '/bootstrap-3.3.6-dist/js/bootstrap.min.js' );
      wp_enqueue_script( 'tag_js', PLUGIN_URL_VENDOR. '/tag/tag.js' );

    }
}

if(class_exists("eventsPlugin"))
{
    $eventsPlugin = new eventsPlugin();
}


