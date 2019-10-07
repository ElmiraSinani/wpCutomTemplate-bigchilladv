<?php

// function: post_type BEGIN
function trips_post_type(){
    
    $labels = array(
                    'name' => __( 'Trips'), 
                    'singular_name' => __('Trips'),
                    'rewrite' => array(
                            'slug' => __( 'trips' ) 
                    ),
                    'add_new' => _x('Add Item', 'trips'), 
                    'edit_item' => __('Edit Trips Item'),
                    'new_item' => __('New Trips Item'), 
                    'view_item' => __('View Trips'),
                    'search_items' => __('Search Trips'), 
                    'not_found' =>  __('No Trips Items Found'),
                    'not_found_in_trash' => __('No Trips Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
        
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/travel-icons-general-md.png',
                    'show_ui' => true,
                    'query_var' => true,
                    'has_archive' => 'trips',
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array(
                            'title',                            
                            'thumbnail',
                            'editor',
                            //'excerpt',
                            //'custom-fields'
                    )
             );
    
    register_post_type(__( 'trips' ), $args);        
} 

// function: trips_messages BEGIN
function trips_messages($messages)
{
    $messages[__( 'trips' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Trips Updated. <a href="%s">View trips</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Trips Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Trips Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Trips Published. <a href="%s">View Trips</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Trips Saved.'),
                    8 => sprintf(__('Trips Submitted. <a target="_blank" href="%s">Preview Trips</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Trips Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Trips</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Trips Draft Updated. <a target="_blank" href="%s">Preview Trips</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: trips_messages END

// function: trips_filter BEGIN
function trips_filter()
{
    register_taxonomy(
            __( "trips-cat" ),
            array(__( "trips" )),
            array(
                    "hierarchical" => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "Countries" ),
                    "singular_label" => __( "Countries" ),
                    "labels" => array(
                         "add_new_item" =>  __( 'Add new Country' ),
                    ),
//                    "rewrite" => array(
//                            'slug' => 'trips',
//                            'hierarchical' => true
//                    )
            )
    );
    register_taxonomy(
            __( "filter-cat" ),
            array(__( "trips" )),
            array(
                    "hierarchical" => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "Custom Filter" ),
                    "singular_label" => __( "Custom Filter" ),
                    "labels" => array(
                         "add_new_item" =>  __( 'Add Custom Filter' ),
                    ),
//                    "rewrite" => array(
//                            'slug' => 'trips',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: trips_filter END


add_action( 'init', 'trips_post_type' );
add_action( 'init', 'trips_filter', 0 );
add_filter( 'post_updated_messages', 'trips_messages' );


//Mete Boxes
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function trip_add_meta_box() {

	$screens = array( 'trips' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'trip_sectionid',
			__( 'Package Details', 'bca' ),
			'trip_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'trip_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function trip_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'trip_meta_box', 'trip_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$tripVal        = get_post_meta( $post->ID, '_duration_val', true );
	$priceVal       = get_post_meta( $post->ID, '_price_val', true );
	$specPriceVal   = get_post_meta( $post->ID, '_spec_price_val', true );
	$imgTitle       = get_post_meta( $post->ID, '_img_title_val', true );        
        $overviewVal    = get_post_meta( $post->ID, '_overview_val', true );
        $mapsVal        = get_post_meta( $post->ID, '_maps_val', true );
        $notIncVal      = get_post_meta( $post->ID, '_not_included_val', true );        
        $itineraryVal   = get_post_meta( $post->ID, '_itinerary_val', true );
        $packingVal    = get_post_meta( $post->ID, '_packing_val', true );
        $maxNumVal     = get_post_meta( $post->ID, '_max_num_val', true );
        $activitiesVal = get_post_meta( $post->ID, '_activities_val', true );
        $bookedNumVal  = get_post_meta( $post->ID, '_booked_num_val', true );
        $bookedNumVal = $bookedNumVal ? $bookedNumVal : "0";
        
        $waitlistNumVal  = get_post_meta( $post->ID, '_waitlist_num_val', true );
        $waitlistNumVal = $waitlistNumVal ? $waitlistNumVal : "0";
        
        $promoVal       =  get_option( 'trip_promo_day' );
        
               
        $itineraryCats = get_terms( 'itinerary-cat', array(
                            'orderby'    => 'count',
                            'hide_empty' => 0,
                        ) );  
        $packingCats  = get_terms( 'packing-cat', array(
                            'orderby'    => 'count',
                            'hide_empty' => 0,
                        ) );
        $activites = get_posts( array( 'post_type' => 'activities')  );
                
        ?>
            <style type="text/css">
                .cptItem label{font-weight:bold;width:18%;display: inline-block;}
                .cptItem input[type='text']{width: 80%;}
                .cptItem select, .cptItem input[type='number']{width: 20%;}
                .cptItem .small{font-size: 10px; font-style: oblique; color: #111; margin-left: 8px;}               
                .title2{ width:100%!important; margin-top:10px; padding: 10px 0; font-size: 18px; border-bottom: 1px solid #999; border-top: 1px solid #999; }
            </style>
        <?php
        
        echo '<p class="cptItem"><label for="img_title_field">';
	_e( 'Front Image Title & SubTitle', 'bca' );
	echo '</label> ';
	echo '<input type="text" id="img_title_field" name="img_title_field" value="' . esc_attr( $imgTitle ) . '" /></p>';
        
	echo '<p class="cptItem"><label for="duration_field">';
	_e( 'Duration (By Days)', 'bca' );
	echo '</label> ';
	echo '<input type="number" id="duration_field" name="duration_field" value="' . esc_attr( $tripVal ) . '" /></p>';
	
        echo '<p class="cptItem"><label for="price_field">';
	_e( 'Price', 'bca' );
	echo '</label> ';
	echo '<input type="number" id="price_field" name="price_field" value="' . esc_attr( $priceVal ) . '" /> <strong> $ </strong> </p>';
        
        echo '<p class="cptItem"><label for="spec_price_field">';
	_e( 'Price OFF', 'bca' );
	echo '</label> ';
	echo '<select id="spec_price_field" name="spec_price_field" >';
        echo '<option value="">--- NONE ---</option>';
        for ( $i = 5; $i <= 80; $i+=5 ){
            echo '<option '. isSelected( $i, $specPriceVal ) .' value="'.$i.'">'.$i.'</option>';
        }
        echo '</select><strong> % </strong> </p>';
        
        echo '<p class="cptItem"><label for="max_num_field">';
	_e( 'Max Number of partipants', 'bca' );
	echo '</label> ';
	echo '<input type="number" id="max_num_field" name="max_num_field" value="' . esc_attr( $maxNumVal ) . '" /></p>';
        
        echo '<p class="cptItem"><label for="booked_num_field">';
	_e( 'Booked number', 'bca' );
	echo '</label> ';
	echo '<input type="number" id="booked_num_field" name="booked_num_field" value="' . esc_attr( $bookedNumVal ) . '"  /></p>';
        
        echo '<p class="cptItem"><label for="waitlist_num_field">';
	_e( 'Waitlist number', 'bca' );
	echo '</label> ';
	echo '<input type="number" id="waitlist_num_field" name="waitlist_num_field" value="' . esc_attr( $waitlistNumVal ) . '"  /></p>';
        
        echo '<p class="cptItem"><label for="promo_day_field">';
	_e( 'Promo Of The Day', 'bca' );
	echo '</label> ';
	echo '<input type="checkbox" '. isPromo( $promoVal, $post->ID ) .' id="promo_day_field" name="promo_day_field" value="' . esc_attr( $promoVal ) . '" />';
        echo '<span class="small">Checking this option will uncheck all prev checked promos of the day</span></p>';
       
        echo '<hr/><p class="cptItem"><label for="itinerary_field">';
	_e( 'Select Itinerary', 'bca' );
	echo '</label> ';
	echo '<select id="itinerary_field" name="itinerary_field" >';
        echo '<option value="">--- NONE ---</option>';
        foreach ( $itineraryCats as $tax_term ) {
            echo '<option  '. isSelected( $itineraryVal, $tax_term->slug ) .' value="'.$tax_term->slug.'">'.$tax_term->name.'</option>';            
        }       
        echo '</select></p>';
        
        echo '<hr/><p class="cptItem"><label for="packing_field">';
	_e( 'Select Packing List', 'bca' );
	echo '</label> ';
	echo '<select id="packing_field" name="packing_field" >';
        echo '<option value="">--- NONE ---</option>';
        foreach ( $packingCats as $tax_term ) {
            echo '<option  '. isSelected( $packingVal, $tax_term->slug ) .' value="'.$tax_term->slug.'">'.$tax_term->name.'</option>';            
        }       
        echo '</select></p>';
        
         echo '<hr/><p class="cptItem"><label for="activities_field">';
	_e( 'Select Activities', 'bca' );
	echo '</label> ';
	echo '<select id="activities_field" name="activities_field[]" multiple>';
        echo '<option value="">--- NONE ---</option>';
        foreach ( $activites as $activite ) {
            echo '<option '. isSelected( $activitiesVal, $activite->ID, true ) .' value="'.$activite->ID.'">'.$activite->post_title.'</option>';            
        }       
        echo '</select></p>';
        
        echo '<p class="cptItem"><label class="title2" for="overview_field">';
	_e( 'Package Includes:', 'bca' );
	echo '</label> ';
        wp_editor( htmlspecialchars_decode($overviewVal), 'overview_field', $settings = array('textarea_name'=>'overview_field') );
	echo '</p>';
        
        echo '<p class="cptItem"><label class="title2" for="maps_field">';
	_e( 'MAPS & AREA:', 'bca' );
	echo '</label> ';
        wp_editor( htmlspecialchars_decode($mapsVal), 'maps_field', $settings = array('textarea_name'=>'maps_field') );
	echo '</p>';
        
        echo '<p class="cptItem"><label class="title2" for="not_included_field">';
	_e( 'Not Included:', 'bca' );
	echo '</label> ';
        wp_editor( htmlspecialchars_decode($notIncVal), 'not_included_field', $settings = array('textarea_name'=>'not_included_field') );
	echo '</p>';
        
}



/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function trip_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['trip_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['trip_meta_box_nonce'], 'trip_meta_box' ) ) {
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
	if ( ! isset( $_POST['duration_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['price_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['spec_price_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['img_title_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['overview_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['not_included_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['itinerary_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['packing_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['activities_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['max_num_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['booked_num_field'] ) ) {
            return;
	}
	if ( ! isset( $_POST['waitlist_num_field'] ) ) {
            return;
	}
	
        
	// Sanitize user input.
	$duration_data = isset( $_POST['duration_field'] ) ? sanitize_text_field( $_POST['duration_field'] ) : "";
	$price_data    = isset($_POST['price_field']) ? sanitize_text_field( $_POST['price_field'] ) : "";
	$spec_price_data    = isset($_POST['spec_price_field']) ? sanitize_text_field( $_POST['spec_price_field'] ) : "";
	$img_title_data    = isset($_POST['img_title_field']) ? sanitize_text_field( $_POST['img_title_field'] ) : "";
	$overview_data    = isset($_POST['overview_field']) ? htmlspecialchars( $_POST['overview_field'] ) : "";
	$maps_data    = isset($_POST['maps_field']) ? htmlspecialchars( $_POST['maps_field'] ) : "";
	$not_inc_data    = isset($_POST['not_included_field']) ? htmlspecialchars( $_POST['not_included_field'] ) : "";
	$itinerary_data    = isset($_POST['itinerary_field']) ? htmlspecialchars( $_POST['itinerary_field'] ) : "";
	$packing_data    = isset($_POST['packing_field']) ? htmlspecialchars( $_POST['packing_field'] ) : "";
	$max_num_data    = isset($_POST['max_num_field']) ? htmlspecialchars( $_POST['max_num_field'] ) : "";
	$booked_num_data    = isset($_POST['booked_num_field']) ? htmlspecialchars( $_POST['booked_num_field'] ) : "";
	$waitlist_num_data  = isset($_POST['waitlist_num_field']) ? htmlspecialchars( $_POST['waitlist_num_field'] ) : "";
        
        $activities    = isset($_POST['activities_field']) ?  serialize($_POST['activities_field'])  : "";
        
	        
	// Update the meta field in the database.
	update_post_meta( $post_id, '_duration_val', $duration_data );
	update_post_meta( $post_id, '_price_val', $price_data );
	update_post_meta( $post_id, '_spec_price_val', $spec_price_data );
	update_post_meta( $post_id, '_img_title_val', $img_title_data );
	update_post_meta( $post_id, '_overview_val', $overview_data );
	update_post_meta( $post_id, '_maps_val', $maps_data );
	update_post_meta( $post_id, '_not_included_val', $not_inc_data );
	update_post_meta( $post_id, '_itinerary_val', $itinerary_data );         
	update_post_meta( $post_id, '_packing_val', $packing_data );         
	update_post_meta( $post_id, '_max_num_val', $max_num_data );         
	update_post_meta( $post_id, '_booked_num_val', $booked_num_data );         
	update_post_meta( $post_id, '_waitlist_num_val', $waitlist_num_data );         
	update_post_meta( $post_id, '_activities_val', $activities );         
        
       
        if ( get_option( 'trip_promo_day' ) !== false ) {
            // The option already exists, so we just update it.
            
            update_option( 'trip_promo_day', $post_id );
        } else {
            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $deprecated = null;
            $autoload = 'no';
            add_option( 'trip_promo_day', $post_id, $deprecated, $autoload );
        }
        
}
add_action( 'save_post', 'trip_save_meta_box_data' );
