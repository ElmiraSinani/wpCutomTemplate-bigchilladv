<?php

// function: post_type BEGIN
function slider_post_type(){
    
    $labels = array(
                    'name' => __( 'Slider'), 
                    'singular_name' => __('Slider'),
                    'rewrite' => array(
                            'slug' => __( 'slider' ) 
                    ),
                    'add_new' => _x('Add Item', 'slider'), 
                    'edit_item' => __('Edit Slider Item'),
                    'new_item' => __('New Slider Item'), 
                    'view_item' => __('View Slider'),
                    'search_items' => __('Search Slider'), 
                    'not_found' =>  __('No Slider Items Found'),
                    'not_found_in_trash' => __('No Slider Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/iconGallery.png',
                    'show_ui' => true,
                    'query_var' => true,
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array(
                            'title',                            
                            'thumbnail'
                    )
             );
    
    register_post_type(__( 'slider' ), $args);        
} 

// function: slider_messages BEGIN
function slider_messages($messages)
{
    $messages[__( 'slider' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Slider Updated. <a href="%s">View slider</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Slider Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Slider Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Slider Published. <a href="%s">View Slider</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Slider Saved.'),
                    8 => sprintf(__('Slider Submitted. <a target="_blank" href="%s">Preview Slider</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Slider Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Slider</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Slider Draft Updated. <a target="_blank" href="%s">Preview Slider</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: slider_messages END

// function: slider_filter BEGIN
function slider_filter()
{
    register_taxonomy(
            __( "slider-cat" ),
            array(__( "slider" )),
            array(
                    "hierarchical" => true,
                    "label" => __( "Categories" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'slider',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: slider_filter END


add_action( 'init', 'slider_post_type' );
add_action( 'init', 'slider_filter', 0 );
add_filter( 'post_updated_messages', 'slider_messages' );


//Mete Boxes
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function slider_add_meta_box() {

	$screens = array( 'slider' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'slider_sectionid',
			__( 'Slider Custom Fields', 'bca' ),
			'slider_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'slider_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function slider_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'slider_meta_box', 'slider_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$subTitle = get_post_meta( $post->ID, '_sub_title_val', true );
        $cptLink  = get_post_meta( $post->ID, '_cpt_link_val', true );
	$textPosition       = get_post_meta( $post->ID, '_text_position_val', true );
        ?>
            <style type="text/css">
                .cptItem label{font-weight:bold;width:18%;display: inline-block;}
                .cptItem input{width: 80%;}
                .cptItem select{width: 25%;}
                .denger{ color: #D11; font-weight: bold;}
            </style>
        <?php
	echo '<p class="cptItem"><label for="sub_title_field">';
	_e( 'Sub Title', 'bca' );
	echo '</label> ';
	echo '<input type="text" id="sub_title_field" name="sub_title_field" value="' . esc_attr( $subTitle ) . '" size="25" /></p>';
        
        echo '<p class="cptItem"><label for="cpt_link_field">';
	_e( 'Custom Link', 'bca' );
	echo '</label> ';
	echo '<input type="text" id="cpt_link_field" name="cpt_link_field" value="' . esc_attr( $cptLink ) . '" size="25" /></p>';
	
        echo '<p class="cptItem"><label for="text_position_field">';
	_e( 'Text Position', 'bca' );
	echo '</label> ';
	echo '<select id="text_position_field" name="text_position_field" /> ';
        echo '<option '. isSelected($textPosition, "center_top") .' value="center_top">Center Top</option>';
        echo '<option '. isSelected($textPosition, "bottom_left") .' value="bottom_left">Bottom Left</option>';
        echo '<option '. isSelected($textPosition, "bottom_right") .' value="bottom_right">Bottom Right</option>';
        echo '<option '. isSelected($textPosition, "left_middle") .' value="left_middle">Left Middle</option>';
        echo '<option '. isSelected($textPosition, "right_middle") .' value="right_middle">Right Middle</option>';
       
        echo '</select></p>';
        
        echo '<p class="cptItem denger">';
	_e( 'Slider image minimum size must be 1250x467px', 'bca' );
	echo '</p> ';
        
}
 


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function slider_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['slider_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['slider_meta_box_nonce'], 'slider_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['sub_title_field'] ) ) {
		return;
	}
	if ( ! isset( $_POST['cpt_link_field'] ) ) {
		return;
	}
	if ( ! isset( $_POST['text_position_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$sub_title_data = isset( $_POST['sub_title_field'] ) ? sanitize_text_field( $_POST['sub_title_field'] ) : "";
	$cpt_link_data = isset( $_POST['cpt_link_field'] ) ? sanitize_text_field( $_POST['cpt_link_field'] ) : "";
	$text_position_data    = isset($_POST['text_position_field']) ? sanitize_text_field( $_POST['text_position_field'] ) : "";

	// Update the meta field in the database.
	update_post_meta( $post_id, '_sub_title_val', $sub_title_data );
	update_post_meta( $post_id, '_cpt_link_val', $cpt_link_data );
	update_post_meta( $post_id, '_text_position_val', $text_position_data );
}
add_action( 'save_post', 'slider_save_meta_box_data' );
