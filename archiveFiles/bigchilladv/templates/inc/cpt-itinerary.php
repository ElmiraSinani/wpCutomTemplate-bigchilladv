<?php

// function: post_type BEGIN
function itinerary_post_type(){
    
    $labels = array(
                    'name' => __( 'Itinerary'), 
                    'singular_name' => __('Itinerary'),
                    'rewrite' => array(
                            'slug' => __( 'itinerary' ) 
                    ),
                    'add_new' => _x('Add Item', 'itinerary'), 
                    'edit_item' => __('Edit Itinerary Item'),
                    'new_item' => __('New Itinerary Item'), 
                    'view_item' => __('View Itinerary'),
                    'search_items' => __('Search Itinerary'), 
                    'not_found' =>  __('No Itinerary Items Found'),
                    'not_found_in_trash' => __('No Itinerary Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/itinerary.png',
                    'show_ui' => true,
                    'query_var' => true,
                    'has_archive' => 'itinerary',
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array(
                            'title',                            
                            'thumbnail',
                            'editor'
                    )
             );
    
    register_post_type(__( 'itinerary' ), $args);        
} 

// function: itinerary_messages BEGIN
function itinerary_messages($messages)
{
    $messages[__( 'itinerary' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Itinerary Updated. <a href="%s">View itinerary</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Itinerary Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Itinerary Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Itinerary Published. <a href="%s">View Itinerary</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Itinerary Saved.'),
                    8 => sprintf(__('Itinerary Submitted. <a target="_blank" href="%s">Preview Itinerary</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Itinerary Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Itinerary</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Itinerary Draft Updated. <a target="_blank" href="%s">Preview Itinerary</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: itinerary_messages END

// function: itinerary_filter BEGIN
function itinerary_filter()
{
    register_taxonomy(
            __( "itinerary-cat" ),
            array(__( "itinerary" )),
            array(
                    "hierarchical" => true,
                    "label" => __( "Categories" ),
                    "singular_label" => __( "Filter" ),
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
//                    "rewrite" => array(
//                            'slug' => 'itinerary',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: itinerary_filter END


add_action( 'init', 'itinerary_post_type' );
add_action( 'init', 'itinerary_filter', 0 );
add_filter( 'post_updated_messages', 'itinerary_messages' );

