<?php

// function: post_type BEGIN
function activities_post_type(){
    
    $labels = array(
                    'name' => __( 'Activities'), 
                    'singular_name' => __('Activities'),
                    'rewrite' => array(
                            'slug' => __( 'activities' ) 
                    ),
                    'add_new' => _x('Add Item', 'activities'), 
                    'edit_item' => __('Edit Activities Item'),
                    'new_item' => __('New Activities Item'), 
                    'view_item' => __('View Activities'),
                    'search_items' => __('Search Activities'), 
                    'not_found' =>  __('No Activities Items Found'),
                    'not_found_in_trash' => __('No Activities Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/activities.png',
                    'show_ui' => true,
                    'query_var' => true,
                    'has_archive' => 'activities',
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
    
    register_post_type(__( 'activities' ), $args);        
} 

// function: activities_messages BEGIN
function activities_messages($messages)
{
    $messages[__( 'activities' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Activities Updated. <a href="%s">View activities</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Activities Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Activities Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Activities Published. <a href="%s">View Activities</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Activities Saved.'),
                    8 => sprintf(__('Activities Submitted. <a target="_blank" href="%s">Preview Activities</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Activities Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Activities</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Activities Draft Updated. <a target="_blank" href="%s">Preview Activities</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: activities_messages END

add_action( 'init', 'activities_post_type' );
add_filter( 'post_updated_messages', 'activities_messages' );

