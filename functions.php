<?php

require_once("templates/inc/custom-admin-functions.php");
require_once("templates/inc/custom_nav_menu.php");
require_once("templates/inc/cpt-globeTitles.php");
require_once("templates/inc/cpt-press.php");
require_once("templates/inc/cpt-destinations.php");
require_once("templates/inc/cpt-itinerary.php");
require_once("templates/inc/cpt-packingList.php");
require_once("templates/inc/cpt-activities.php");
require_once("templates/inc/cpt-booking.php");
require_once("templates/inc/cpt-bcaSlider.php");
require_once("templates/inc/cpt-bcaStaff.php");
require_once("templates/inc/metaBoxContactUs.php");
require_once("templates/inc/widget-photo-of-day.php");
require_once("templates/inc/widget-book-now.php");


// Add RSS links to <head> section
//automatic_feed_links();

// Clean up the <head>
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');


add_theme_support( 'post-thumbnails' ); 

set_post_thumbnail_size( 'single-sl-big', 660, 348, true ); 
set_post_thumbnail_size( 'single-sl-small', 75, 75, true ); 
set_post_thumbnail_size( 'front-trips', 300, 210, true ); 
set_post_thumbnail_size( 'trips-list', 235, 165, true ); 
set_post_thumbnail_size( 'photoday', 285, 155, true ); 
add_image_size( 'single-sl-big', 660, 348, true ); 
add_image_size( 'single-sl-small', 75, 75, true ); 
add_image_size( 'front-trips', 300, 210, true ); 
add_image_size( 'trips-list', 235, 165, true ); 
add_image_size(  'photoday', 285, 155, true ); 

function bca_sidebar_init() {
    register_sidebar(
         array(
            'name' => 'Header Top Widgets',
            'id' => 'header-top-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="none">',
            'after_title' => '</h4>',
        )
    );
    register_sidebar(
         array(
            'name' => 'Left Sidebar Widgets',
            'id' => 'left-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-container"><div class="inner">',
            'after_widget' => '</div> <div class="clear"></div></div></aside>',
            'before_title' => '<h3 class="">',
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
         array(
            'name' => 'After Front Content Widgets',
            'id' => 'front-after-content',
            'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="inner">',
            'after_widget' => '</div> </aside>',
            'before_title' => '<h3 class="">',
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
         array(
            'name' => 'ContactUs Page Widgets',
            'id' => 'contacts-page-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="none">',
            'after_title' => '</h4>',
        )
    );
    register_sidebar(
         array(
            'name' => 'Single Page Widgets',
            'id' => 'single-page-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="none">',
            'after_title' => '</h4>',
        )
    );
    register_sidebar(
         array(
            'name' => 'Footer Widgets',
            'id' => 'footer-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h4 class="none">',
            'after_title' => '</h4>',
        )
    );
 
}
add_action( 'init', 'bca_sidebar_init' );


function register_bca_menus() {
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu','bca'),
            'footer-menu' => __('Footer Menu','bca')
        )
    );
}
add_action('init', 'register_bca_menus');


function load_styles_and_scripts() {
        
    //load styles     
    wp_enqueue_style('main-style', get_template_directory_uri() . '/css/main_style.css'); 
    wp_enqueue_style('screen', get_template_directory_uri() . '/css/screen.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css');
    wp_enqueue_style('customInput', get_template_directory_uri() . '/css/customInput.css');
    wp_enqueue_style('custom-theme', get_template_directory_uri() . '/css/custom-theme/jquery-ui-1.8.20.custom.css');
    wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css');
  
    //load scripts
    
    //JS libs 
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.5.3.min.js', array(), '', true);
    wp_enqueue_script('respond', get_template_directory_uri() . '/js/libs/respond.min.js', array(), '', true);
    
    
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/libs/jquery.min.js', array(), '', false);

   
    //scripts
    wp_enqueue_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.min.js', array(), '', true);
    wp_enqueue_script('hover',  get_template_directory_uri() . '/js/hoverIntent.js', array(), '', true);
    wp_enqueue_script('general', get_template_directory_uri() . '/js/general.js', array(), '', true);
    wp_enqueue_script('galleriffic', get_template_directory_uri() . '/js/jquery.galleriffic.min.js', array(), '', true);
    wp_enqueue_script('opacityrollover', get_template_directory_uri() . '/js/jquery.opacityrollover.js', array(), '', true);
    wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), '', true);
    
    //sliders
    wp_enqueue_script('sliders', get_template_directory_uri() . '/js/slides.min.jquery.js', array(), '', true);
    wp_enqueue_script('jquery-tools', get_template_directory_uri() . '/js/jquery.tools.min.js', array(), '', true);
    wp_enqueue_script('jquery-ui-custom', get_template_directory_uri() . '/js/jquery-ui-1.8.20.custom.min.js', array(), '', true);
    

}

add_action('wp_enqueue_scripts', 'load_styles_and_scripts');


//single page slider list
function display_slider_images($postID, $title) {
    $arg = array(
		'post_parent'    => $postID,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		//'post_status'    => null,
		'post_mime_type' => 'image',
                'orderby'        => 'menu_order',
                'order'           => 'ASC',
            );
    $images = get_posts( $arg );
       
    if( $images ) {
        foreach( $images as $image ) {                
            $thumb = wp_get_attachment_image_src( $image->ID, array(75,75), false ); 
            $c_full = wp_get_attachment_image_src( $image->ID, array(660, 348), false ); 
            $full = wp_get_attachment_image_src( $image->ID, 'full', false ); 
            ?>
            <li>
                <a class="thumb" href="<?php echo $c_full[0]; ?>">
                    <img src="<?php echo $thumb[0]; ?>" alt="">
                </a>
                <div class="caption">
                    <a href="<?php echo $full[0]; ?>" class="enlarge" data-rel="prettyPhoto" title="<?php echo $title; ?>">View Large</a>
                    <div class="image-desciption"><?php echo $title; ?></div>
                </div>
            </li>
            <?php
        }
    }
}


add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );
function wptuts_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
        
        wp_enqueue_script('dataPicker', get_template_directory_uri() . '/js/libs/jquery-ui/js/jquery-ui-1.10.4.custom.min.js', array(), '', true);
        
        //wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_register_style('jquery-ui', get_template_directory_uri() . '/js/libs/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
        wp_enqueue_style( 'jquery-ui' );   
     
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'my-script-handle', get_template_directory_uri() .'/js/admin-script.js', array( 'wp-color-picker' ), false, true );
        
        
    }
}