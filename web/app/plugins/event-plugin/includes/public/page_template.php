<?php
/*
* Template Name : Front End Events Layout
*/
get_header();
// load css files
wp_register_style( 'bootstrap_css', PLUGIN_URL_VENDOR.'/bootstrap-3.3.6-dist/css/bootstrap.min.css');
wp_enqueue_style( 'bootstrap_css' );
wp_register_style( 'tags_css', PLUGIN_URL_VENDOR.'/tag/tag.css');
wp_enqueue_style( 'tags_css' );
wp_register_style( 'base_css', PLUGIN_URL_PUBLIC_CSS.'/base.css');
wp_enqueue_style( 'base_css' );
// load js files
wp_enqueue_script( 'jquery_js', PLUGIN_URL_VENDOR. '/jquery.js' );
wp_enqueue_script( 'bootstrap_js', PLUGIN_URL_VENDOR. '/bootstrap-3.3.6-dist/js/bootstrap.min.js' );
wp_enqueue_script( 'tag_js', PLUGIN_URL_VENDOR. '/tag/tag.js' );


/*
 *require controller Class class
 */

require_once(PLUGIN_PATH_ADMIN."event_controller.php");
// get events
$events = new event_frontend();
$events_data = $events->get_all_events();

?>

<h1>Our Events</h1>

<div class="container">
    <div class="row">
       <?php
        if(count($events_data)>0)
        {
            foreach($events_data as $key=>$event)
            {
                
        ?>
        <div class="col-lg-3">
            <div class="event">
                <div class="ev_image img-responsive">
                    <img src="<?php echo $event->image; ?>" class="img-responsive" />
                </div>
                <p class="event_title">
                    <?php echo $event->title; ?>
                </p>
                <a class="view_event btn btn-success" href="">View</a>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>
</div>


<?php
do_shortcode("[events_page]");
get_footer();
?>