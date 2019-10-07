<?php

// function: post_type BEGIN
function packing_list_post_type(){
    
    $labels = array(
                    'name' => __( 'Packing List'), 
                    'singular_name' => __('Packing List'),
                    'rewrite' => array(
                            'slug' => __( 'packing_list' ) 
                    ),
                    'add_new' => _x('Add Item', 'packing_list'), 
                    'edit_item' => __('Edit Packing List Item'),
                    'new_item' => __('New Packing List Item'), 
                    'view_item' => __('View Packing List'),
                    'search_items' => __('Search Packing List'), 
                    'not_found' =>  __('No Packing List Items Found'),
                    'not_found_in_trash' => __('No Packing List Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/packing_list.png',
                    'show_ui' => true,
                    'query_var' => true,
                    'has_archive' => 'packing_list',
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
    
    register_post_type(__( 'packing_list' ), $args);        
} 

// function: packing_list_messages BEGIN
function packing_list_messages($messages)
{
    $messages[__( 'packing_list' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Packing List Updated. <a href="%s">View packing_list</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Packing List Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Packing List Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Packing List Published. <a href="%s">View Packing List</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Packing List Saved.'),
                    8 => sprintf(__('Packing List Submitted. <a target="_blank" href="%s">Preview Packing List</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Packing List Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Packing List</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Packing List Draft Updated. <a target="_blank" href="%s">Preview Packing List</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: packing_list_messages END

// function: packing_list_filter BEGIN
function packing_list_filter()
{
    register_taxonomy(
            __( "packing-cat" ),
            array(__( "packing_list" )),
            array(
                    "hierarchical" => true,
                    "label" => __( "Categories" ),
                    "singular_label" => __( "Filter" ),
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
//                    "rewrite" => array(
//                            'slug' => 'packing_list',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: packing_list_filter END


add_action( 'init', 'packing_list_post_type' );
add_action( 'init', 'packing_list_filter', 0 );
add_filter( 'post_updated_messages', 'packing_list_messages' );

