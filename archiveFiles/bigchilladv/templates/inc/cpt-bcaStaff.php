<?php

// function: post_type BEGIN
function our_staff_post_type(){
    
    $labels = array(
                    'name' => __( 'Our Staff'), 
                    'singular_name' => __('Our Staff'),
                    'rewrite' => array(
                            'slug' => __( 'our_staff' ) 
                    ),
                    'add_new' => _x('Add Item', 'our_staff'), 
                    'edit_item' => __('Edit Our Staff Item'),
                    'new_item' => __('New Our Staff Item'), 
                    'view_item' => __('View Our Staff'),
                    'search_items' => __('Search Our Staff'), 
                    'not_found' =>  __('No Our Staff Items Found'),
                    'not_found_in_trash' => __('No Our Staff Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/staff.png',
                    'show_ui' => true,
                    'query_var' => true,
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
    
    register_post_type(__( 'our_staff' ), $args);        
} 

// function: our_staff_messages BEGIN
function our_staff_messages($messages)
{
    $messages[__( 'our_staff' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Our Staff Updated. <a href="%s">View our_staff</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Our Staff Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Our Staff Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Our Staff Published. <a href="%s">View Our Staff</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Our Staff Saved.'),
                    8 => sprintf(__('Our Staff Submitted. <a target="_blank" href="%s">Preview Our Staff</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Our Staff Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Our Staff</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Our Staff Draft Updated. <a target="_blank" href="%s">Preview Our Staff</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: our_staff_messages END

// function: our_staff_filter BEGIN
function our_staff_filter()
{
    register_taxonomy(
            __( "our_staff-cat" ),
            array(__( "our_staff" )),
            array(
                    "hierarchical" => true,
                    "label" => __( "Categories" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'our_staff',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: our_staff_filter END


add_action( 'init', 'our_staff_post_type' );
add_action( 'init', 'our_staff_filter', 0 );
add_filter( 'post_updated_messages', 'our_staff_messages' );

