<?php
defined("ABSPATH") or die("Bad Access");


// require Crud Class class
require_once(PLUGIN_PATH_ADMIN."events-crud.php");
/**
 * eventsAdmin class
 *
 * this class manage admin pages
 *
 * @since      1.0.0
 */

class eventsAdmin extends eventsCrud{
    
    
    /**
	 * Define constract to control the plugin
	 *
     * create plugin main table
	 * create plugin events tags table
	 * add pages to admin menu
	 * load css files
	 * load js files
	 * add plugin hooks
     *
	 * @since    1.0.0
	 */
    public function __construct(){
        
        // create Plugin Main Table
        $this->create_plugin_main_table();
        // create Plugin events tags table
        $this->create_plugin_events_tags_table();
        // Add Pages To Admin menu
        add_action('admin_menu', array($this,'add_pages_to_menu'));
        add_action('admin_menu',  array($this,'registerOptionPage'));
        // Load Css Files
        add_action( 'admin_enqueue_scripts', array($this,'load_custom_css'));
        // Load Js Files
        add_action( 'admin_enqueue_scripts', array($this,'load_custom_js'));
        // Add Hooks
        $this->add_hooks();  

    }
    
    /**
	 * Define activate function
	 *
	 * flush rewrite rules
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function activate(){
        //flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
	 * Define deactivate function
	 *
	 * flush rewrite rules
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function deactivate(){
        //flush rewrite rules
        flush_rewrite_rules();
    }

    /**
	 * Define create plugin main table function
	 *
	 * this function used for create main table 
     *
	 * @since    1.0.0
     * @access   private
	 */
    private function create_plugin_main_table(){
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        // create Event Table Sql Query
        $sql = "CREATE TABLE IF NOT EXISTS $this->tableName(
                `id` int(11) unsigned NOT NULL  AUTO_INCREMENT,
                `title` varchar(255),
                `description` text,
                `image` MEDIUMTEXT,
                `date` varchar(255),
                `start_time` varchar(255),
                `end_time` varchar(255),
                `event_category` varchar(255),
                PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    
    /**
	 * Define create plugin events tags function
	 *
	 * this function used for create events tags table 
     *
	 * @since    1.0.0
     * @access   private
	 */
    private function create_plugin_events_tags_table(){
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        // create Event Tags Table Sql Query
        $sql = "CREATE TABLE IF NOT EXISTS $this->tagesTable(
                `id` int(11) NOT NULL  AUTO_INCREMENT,
                `event_id` int(11) unsigned,
                `tag` varchar(255),
                PRIMARY KEY  (id),
                FOREIGN KEY (event_id) REFERENCES $this->tableName (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    
    /**
	 * Define drop main table function
	 *
	 * this function used for drop main table 
     *
	 * @since    1.0.0
     * @access   private
	 */
    private function drop_plugin_main_table() {
        global $wpdb;

        $sql = "DROP TABLE IF EXISTS $this->tableName";
        $wpdb->query($sql);
    }
    
    /**
	 * Define drop main table function
	 *
	 * this function used for drop main table 
     *
	 * @since    1.0.0
     * @access   private
	 */
    private function drop_plugin_events_tags_table() {
        global $wpdb;

        $sql = "DROP TABLE IF EXISTS $this->tagesTable";
        $wpdb->query($sql);
    }
    
    /**
	 * add pages to menu
	 *
	 * this function used for add pages to admin menu 
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function add_pages_to_menu(){
        add_menu_page('Events', 'Events', 'manage_options', 'new-event', array($this,'add_event_output'),'dashicons-megaphone' );
        add_submenu_page('new-event', 'Events', 'New Event', 'manage_options', 'new-event', array($this,'add_event_output'));
        add_submenu_page('new-event', 'Events', 'All Events', 'manage_options', 'view-events', array($this,'all_events_output') );
        add_submenu_page('wp-admin', 'Events', 'Edit Events', 'manage_options', 'edit-event', array($this,'edit_event_output') );
        
        add_action( 'admin_init', array($this,'register_plugin_settings'));
    }

    /**
	 * register option page
	 *
	 * this function used for add configration page to settings
     *
	 * @since    1.0.0
     * @access   public
	 */
    function registerOptionPage() {
      add_options_page('Events Plugin Settings', 'Events Plugin', 'manage_options', 'EventPluginSettings', array($this,'render_settings_page'));
    }

    /**
	 * register hooks 
	 *
	 * this function used for registers hooks for this plugin
     *
	 * @since    1.0.0
     * @access   private
	 */
    private function add_hooks(){
       // activate
        register_activation_hook( __FILE__, array($this,'activate'));
        // deactivate
        register_deactivation_hook( __FILE__, array($this,'deactivate')); 
    }
    
    /**
	 * load css files
	 *
	 * load plugin admin css files
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function load_custom_css() {
      wp_register_style( 'bootstrap_css', PLUGIN_URL_VENDOR.'/bootstrap-3.3.6-dist/css/bootstrap.min.css');
      wp_enqueue_style( 'bootstrap_css' );
      wp_register_style( 'tags_css', PLUGIN_URL_VENDOR.'/tag/tag.css');
      wp_enqueue_style( 'tags_css' );
    }
    
    /**
	 * load js files
	 *
	 * load plugin admin js files
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function load_custom_js() {
      wp_enqueue_script( 'jquery_js', PLUGIN_URL_VENDOR. '/jquery.js' );
      wp_enqueue_script( 'bootstrap_js', PLUGIN_URL_VENDOR. '/bootstrap-3.3.6-dist/js/bootstrap.min.js' );
      wp_enqueue_script( 'tag_js', PLUGIN_URL_VENDOR. '/tag/tag.js' );

    }
    
    /**
	 * register settings
	 *
	 * register plugin settings
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function register_plugin_settings(){
        register_setting("EventPluginSettings",'past_events');
        register_setting("EventPluginSettings",'events_per_page');
    }
    /**
	 * when user press on events plugin from settings menu
	 *
	 * get settings view
     *
	 * @since    1.0.0
     * @access   public
	 */
    public function render_settings_page()
    {
        require_once(PLUGIN_PATH_INCLUDES_ADMIN.'setting.php');
    }
    
}

if(class_exists("eventsPlugin"))
{
    $eventsPlugin = new eventsPlugin();
}


