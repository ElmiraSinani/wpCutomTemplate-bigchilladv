<?php

// function: post_type BEGIN
function booking_post_type(){
    
    $labels = array(
                    'name' => __( 'Booking'), 
                    'singular_name' => __('Booking'),
                    'rewrite' => array(
                            'slug' => __( 'booking' ) 
                    ),
                    'add_new' => _x('Add Item', 'booking'), 
                    'edit_item' => __('Edit Booking Item'),
                    'new_item' => __('New Booking Item'), 
                    'view_item' => __('View Booking'),
                    'search_items' => __('Search Booking'), 
                    'not_found' =>  __('No Booking Items Found'),
                    'not_found_in_trash' => __('No Booking Items Found In Trash'),
                    'parent_item_colon' => ''
                );
    $args = array(
                    'labels' => $labels,
        
                    'public' => true,
                    'publicly_queryable' => true,                   
                    'menu_icon' => get_template_directory_uri().'/images/icons/booking.png',
                    //'show_ui' => true,
                    'query_var' => true,
                    'has_archive' => 'booking',
                    'rewrite' => true,
                    'capability_type' => 'post',
                            'capabilities' => array(
                        'create_posts' => false, // Removes support for the "Add New" function
                    ),
                    'map_meta_cap' => true, // Set to false, if users are not allowed to edit/delete existing
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array(
                            'title',                            
                            //'thumbnail',
                            //'editor',
                            //'excerpt',
                            //'custom-fields'
                    )
             );
    
    register_post_type(__( 'booking' ), $args);        
} 

// function: booking_messages BEGIN
function booking_messages($messages)
{
    $messages[__( 'booking' )] = 
            array(
                    0 => '', 
                    1 => sprintf(('Booking Updated. <a href="%s">View booking</a>'), esc_url(get_permalink($post_ID))),
                    2 => __('Custom Field Updated.'),
                    3 => __('Custom Field Deleted.'),
                    4 => __('Booking Updated.'),
                    5 => isset($_GET['revision']) ? sprintf( __('Booking Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                    6 => sprintf(__('Booking Published. <a href="%s">View Booking</a>'), esc_url(get_permalink($post_ID))),
                    7 => __('Booking Saved.'),
                    8 => sprintf(__('Booking Submitted. <a target="_blank" href="%s">Preview Booking</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
                    9 => sprintf(__('Booking Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Booking</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                    10 => sprintf(__('Booking Draft Updated. <a target="_blank" href="%s">Preview Booking</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            );
    return $messages;

} // function: booking_messages END

// function: booking_filter BEGIN
function booking_filter()
{
    register_taxonomy(
            __( "accommodation" ),
            array(__( "booking" )),
            array(
                    "hierarchical" => true,
                    'show_ui'           => true,
                    //'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "Accommodation" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'booking',
//                            'hierarchical' => true
//                    )
            )
    );
    register_taxonomy(
            __( "contact-methods" ),
            array(__( "booking" )),
            array(
                    "hierarchical" => true,
                    'show_ui'           => true,
                    //'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "Contact Method" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'booking',
//                            'hierarchical' => true
//                    )
            )
    );
     register_taxonomy(
            __( "how-found-us" ),
            array(__( "booking" )),
            array(
                    "hierarchical" => true,
                    'show_ui'           => true,
                   // 'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "How Found Us" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'booking',
//                            'hierarchical' => true
//                    )
            )
    );
     register_taxonomy(
            __( "country" ),
            array(__( "booking" )),
            array(
                    "hierarchical" => true,
                    //'show_ui'           => true,
                    //'show_admin_column' => true,
                    'query_var'         => true,
                    "label" => __( "Countries" ),
                    "singular_label" => __( "Filter" ),
//                    "rewrite" => array(
//                            'slug' => 'booking',
//                            'hierarchical' => true
//                    )
            )
    );
} // function: booking_filter END


add_action( 'init', 'booking_post_type' );
add_action( 'init', 'booking_filter', 0 );
add_filter( 'post_updated_messages', 'booking_messages' );


//Mete Boxes
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function booking_add_meta_box() {

	$screens = array( 'booking' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'booking_sectionid',
			__( 'Booking Details', 'bca' ),
			'booking_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'booking_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function booking_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'booking_meta_box', 'booking_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
        
        $trips         = get_post_meta( $post->ID, '_trips_val', true );
        $maxNumVal     = get_post_meta( $post->ID, '_max_num_val', true );
        $waitlistVal   = get_post_meta( $post->ID, '_waitlist_num_val', true );
        $tripPrice     = get_post_meta( $post->ID, '_trip_price_val', true );
        $accFee        = get_post_meta( $post->ID, '_acc_fee_val', true );
        $accTotal      = get_post_meta( $post->ID, '_total_price_val', true );
        $accomodation  = get_post_meta( $post->ID, '_accomodation_val', true );
        $name          = get_post_meta( $post->ID, '_name_val', true );
        $email         = get_post_meta( $post->ID, '_email_val', true );
        $day_phone     = get_post_meta( $post->ID, '_day_phone_val', true );
        $ev_phone      = get_post_meta( $post->ID, '_ev_phone_val', true );
        $cnt_method    = get_post_meta( $post->ID, '_contact_method_val', true );
        $found_us      = get_post_meta( $post->ID, '_found_us_val', true );
        $comments      = get_post_meta( $post->ID, '_comments_val', true );
        $street        = get_post_meta( $post->ID, '_street_val', true );
        $city          = get_post_meta( $post->ID, '_city_val', true );
        $state         = get_post_meta( $post->ID, '_state_val', true );
        $postcode      = get_post_meta( $post->ID, '_postcode_val', true );
        $country       = get_post_meta( $post->ID, '_country_val', true );
        $promotion     = get_post_meta( $post->ID, '_promotion_val', true );	
        
        $promoVal       =  get_option( 'booking_promo_day' );
        
        ?>
            <style type="text/css">
                .cptItem label{font-weight:bold;width:18%;display: inline-block;}
                .cptItem input[type='text'],.cptItem input[type='email'], .cptItem select.full {width: 80%;}
                .cptItem select, .cptItem input[type='number']{width: 20%;}
                .cptItem .small{font-size: 10px; font-style: oblique; color: #111; margin-left: 8px;}               
                .title2{ width:100%!important; margin-top:10px; padding: 10px 0; font-size: 15px; border-bottom: 1px solid #999; border-top: 1px solid #999; }
            </style>
        <?php
               
        echo '<p class="cptItem"><label for="name_field">';
	_e( 'Trips', 'bca' );
	echo '</label> ';
        echo  esc_attr( $trips );
	echo '</p>';
        
        echo '<p class="cptItem"><label for="name_field">';
	_e( 'Accommodation', 'bca' );
	echo '</label> ';
        echo '<div>';
        foreach ($accomodation as $val){
            echo  esc_attr( $val );
            echo '<br/>';
        }
        echo '</div>';
	echo '</p>';
        
        echo '<p class="cptItem"><label for="name_field">';
        if ( $maxNumVal > 0 ){
            _e( 'Number of partipants', 'bca' );
            echo '</label> ';
            echo  esc_attr( $maxNumVal );
        }else{
            _e( 'Number of waitlist partipants', 'bca' );
            echo '</label> ';
            echo  esc_attr( $waitlistVal );
        }
	echo '</p>';
        
        echo '<p class="cptItem"><label for="name_field">';
	_e( 'Trip Price', 'bca' );
	echo '</label> ';
        echo  esc_attr( $tripPrice );
	echo '</p>';
        
         echo '<p class="cptItem"><label for="name_field">';
	_e( 'Accommodation %', 'bca' );
	echo '</label> ';
        echo  esc_attr( $accFee );
	echo '</p>';
        
        echo '<p class="cptItem"><label for="name_field">';
	_e( 'Total Price', 'bca' );
	echo '</label> ';
        echo  esc_attr( $accTotal );
	echo '</p>';
        
        echo '<p class="cptItem"><label class="title2">';
	_e( 'Contact Details:', 'bca' );
	echo '</label></p>'; 
        
        echo '<p class="cptItem"><label>';
	_e( 'Name', 'bca' );
	echo '</label> ';
        echo  esc_attr( $name );
	echo '</p>';
        
        echo '<p class="cptItem"><label>';
	_e( 'Email', 'bca' );
	echo '</label> ';
        echo esc_attr( $email );
	echo '</p>';
       
        echo '<p class="cptItem"><label>';
	_e( 'Day Phone', 'bca' );
	echo '</label> ';
        echo esc_attr( $day_phone );
	echo '</p>';
       
        echo '<p class="cptItem"><label>';
	_e( 'Evening Phone', 'bca' );
	echo '</label> ';
        echo esc_attr( $ev_phone );
	echo '</p>';
        
        echo '<p class="cptItem"><label>';
	_e( 'Preferred method of contact', 'bca' );
	echo '</label> ';
        echo esc_attr( $cnt_method );
	echo '</p>';
       
        echo '<p class="cptItem"><label>';
	_e( 'How did you hear about us?', 'bca' );
	echo '</label> ';
        echo esc_attr( $found_us );
	echo '</p>';
               
        echo '<p class="cptItem"><label>';
	_e( 'Street', 'bca' );
	echo '</label> ';
        echo esc_attr( $street );
	echo '</p>';
       
        echo '<p class="cptItem"><label>';
	_e( 'City', 'bca' );
	echo '</label> ';
        echo esc_attr( $city );
	echo '</p>';
               
        echo '<p class="cptItem"><label>';
	_e( 'State', 'bca' );
	echo '</label> ';
        echo esc_attr( $state );
	echo '</p>';
       
        echo '<p class="cptItem"><label>';
	_e( 'Postcode', 'bca' );
	echo '</label> ';
        echo esc_attr( $postcode );
	echo '</p>';
               
        echo '<p class="cptItem"><label>';
	_e( 'Country', 'bca' );
	echo '</label> ';
        echo esc_attr( $country );
	echo '</p>';
               
        echo '<p class="cptItem"><label>';
	_e( 'Promotion', 'bca' );
	echo '</label> ';
        echo esc_attr( $promotion );
	echo '</p>';
        
        echo '<p class="cptItem"><label>';
	_e( 'Additional comments', 'bca' );
	echo '</label> ';
        echo esc_attr( $comments );
	echo '</p>';
}



add_action('admin_menu' , 'booking_settings');

function booking_settings() {
    add_submenu_page('edit.php?post_type=booking', 'Booking Admin','Booking Settings', 'edit_posts', basename(__FILE__), 'booking_settings_callback');
}
function  booking_settings_callback(){
    
    $deprecated = null;
    $autoload = 'no';
    add_option( 'booking_mail_to', 'example@mail.info', $deprecated, $autoload );
    add_option( 'booking_sucsess_msg', 'Booking Success, thanks!!!', $deprecated, $autoload );
    add_option( 'booking_failed_msg', 'Booking failed, Try again', $deprecated, $autoload );
    add_option( 'booking_terms_msg', 'Please read and accept our Terms and Conditions', $deprecated, $autoload );
    
    $bMailTo = get_option('booking_mail_to');
    $successMsg = get_option('booking_sucsess_msg');
    $failed_msg = get_option('booking_failed_msg');
    $terms_msg = get_option('booking_terms_msg');
    
    $mailToVal =  $bMailTo ? $bMailTo : "";    
    $successMsgVal =  $successMsg ? $successMsg : "";
    $failedMsgVal  =  $failed_msg ? $failed_msg : "";
    $termsMsgVal   =  $terms_msg ? $terms_msg : "";
    
    $data = $_POST;
        
    if( isset($_POST['saveSettings'])){
        saveBookingOptions($_POST);
    }
    
    
    ?>
            <style type="text/css">
                .cptItem label{font-weight:bold;display: block;}
                .cptItem input[type='text'],.cptItem input[type='email'] {width: 40%;}
                h1{ font-size: 20px; margin: 30px 0; color: #215988;}             
            </style>
            <form action="" method="post">
            <div class="form_container">
                <h1>Booking Form General Settings</h1>
                <p class="cptItem">
                    <label for="to_mail">Booking Mail: </label>
                    <input name="to_mail" type="email" value="<?php echo $mailToVal; ?>" />
                </p>
                <p class="cptItem">
                    <label for="success_msg">Success Message Text: </label>
                    <input name="success_msg" type="text" value="<?php echo $successMsgVal; ?>" />
                </p>
                <p class="cptItem">
                    <label for="failed">Failed Message Text: </label>
                    <input name="failed_msg" type="text" value="<?php echo $failedMsgVal; ?>" />
                </p>
                <p class="cptItem">
                    <label for="terms_msg">Message When Not Checked Terms and Conditions: </label>
                    <input name="terms_msg" type="text" value="<?php echo $termsMsgVal; ?>" />
                </p>
                <p class="cptItem">                   
                    <input name="saveSettings" type="submit" value="Save Settings" />
                </p>
            </div>
            </form>
    <?php
}
function saveBookingOptions($data){
    
    extract($_POST);
    
    if ( get_option( 'booking_mail_to' ) !== false ) {
            // The option already exists, so we just update it.
            
        update_option( 'booking_mail_to', $to_mail );
        update_option( 'booking_sucsess_msg', $success_msg );
        update_option( 'booking_failed_msg', $failed_msg );
        update_option( 'booking_terms_msg', $terms_msg );
    } else {
        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        
        add_option( 'booking_mail_to', $to_mail, $deprecated, $autoload );
        add_option( 'booking_sucsess_msg', $to_mail, $deprecated, $autoload );
        add_option( 'booking_failed_msg', $failed_msg, $deprecated, $autoload );
        add_option( 'booking_terms_msg', $terms_msg, $deprecated, $autoload );
    }
        
    return false;
}



/************* accommodation custom fileds **/
// Add term page
function accommodation_add_new_meta_field() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
            <label for="term_meta[price_term_meta]"><?php _e( 'Accommodation Percentage', 'bca' ); ?></label>
            <input type="text" name="term_meta[price_term_meta]" id="term_meta[price_term_meta]" value="">
            <p class="description"><?php _e( 'Accommodation Percentage For Trips','bca' ); ?></p>
	</div>
<?php
}
add_action( 'accommodation_add_form_fields', 'accommodation_add_new_meta_field', 10, 2 );

// Edit term page
function accommodation_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;        
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_{$t_id}" ); 
        
        ?>
            
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[price_term_meta]"><?php _e( 'Accommodation Percentage', 'bca' ); ?></label></th>
            <td>
                <input type="number" name="term_meta[price_term_meta]" id="term_meta[price_term_meta]" value="<?php echo esc_attr( $term_meta['price_term_meta'] ) ? esc_attr( $term_meta['price_term_meta'] ) : ''; ?>">
                <p class="description"><?php _e( 'Accommodation Percentage For Trips','bca' ); ?></p>
            </td>
	</tr>
<?php
}
add_action( 'accommodation_edit_form_fields', 'accommodation_edit_meta_field', 10, 2 );

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_accommodation', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_accommodation', 'save_taxonomy_custom_meta', 10, 2 );
