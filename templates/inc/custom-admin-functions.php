<?php

//get next - prev links
function getTripSiblings($taxonmoy, $termID){
    
    $prev_post = get_adjacent_post( true, '', true, $taxonmoy ); 
    $next_post = get_adjacent_post( true, '', false, $taxonmoy ); 
    
    
    if ( is_a( $next_post, 'WP_Post' ) ) { 
        $nextTerms = get_the_terms($next_post->ID , $taxonmoy );
        if ($nextTerms[0]->term_id == $termID ){
    ?>
        <a href="<?php echo get_permalink( $next_post->ID ); ?>">&laquo; Previous Day <?php //echo get_the_title( $next_post->ID ); ?></a>
        <span>&nbsp;&nbsp;</span>
    <?php } }
    
    if ( is_a( $prev_post, 'WP_Post' ) ) { 
        $prevTerms = get_the_terms($prev_post->ID , $taxonmoy );
        if($prevTerms[0]->term_id == $termID){
    ?>

        <a href="<?php echo get_permalink( $prev_post->ID ); ?>">Next Day &raquo;<?php //echo get_the_title( $prev_post->ID ); ?></a> 
        
    <?php } }
}

//Checking Selectbox option selected
function isSelected($field, $val, $multi=NULL){
    
    if ( $multi ) {
        $multiValues = unserialize($field);        
        if ( in_array($val, $multiValues) ) {
           $sel = 'selected="selected"';
        }else{
             $sel = "";
        }
        
    }else{
        if( $field == $val ){
            $sel = 'selected="selected"';
        }else{
             $sel = "";
        }
    }
    return $sel;    
}

//checking if checkbox checked
function isChecked($fieldVal){
    
    if($fieldVal){
        $chacked = "checked=checked";
    }else{
         $chacked = "";
    }
    
    return $chacked;
}
//checking if checkbox checked
function isPromo( $promoVal, $postId ){
    
    if( $promoVal == $postId ){
        $chacked = "checked=checked";
    }else{
         $chacked = "";
    }
    
    return $chacked;
}

//Booking Template functions
function saveBookingForm( $data ){
   //echo "<pre>";
    //var_dump($data);die;
       
    extract($data);
    
    
    global $user_ID;
    $new_post = array(
        'post_title' => $name_field." - ".$email_field." - ".$trips_fields,
        'post_status' => 'publish',
        'post_date' => date('Y-m-d H:i:s'),
        'post_author' => $user_ID,
        'post_type' => 'booking'
    );
    $post_id = wp_insert_post($new_post);
    
    $trip_booked_val = get_post_meta( $trip_id, '_booked_num_val', true );    
    $trip_booked_val = $trip_booked_val + $max_num_fields;  
    update_post_meta( $trip_id, '_booked_num_val', $trip_booked_val );
    
    $waitlistNumVal  = get_post_meta( $trip_id, '_waitlist_num_val', true );
    $waitlistNumVal = $waitlistNumVal + $waitlist_field;    
    update_post_meta( $trip_id, '_waitlist_num_val', $waitlistNumVal );
    
    
    if ( $post_id ){
        //var_dump($post_id);
        // Update the meta field in the database.
        add_post_meta( $post_id, '_trips_val', $trips_fields ) or update_post_meta( $post_id, '_trips_val', $trips_fields );
        add_post_meta( $post_id, '_max_num_val', $max_num_fields ) or update_post_meta( $post_id, '_max_num_val', $max_num_fields );
        add_post_meta( $post_id, '_booked_num_val', $trip_booked_val ) or update_post_meta( $post_id, '_booked_num_val', $trip_booked_val );
        add_post_meta( $post_id, '_waitlist_num_val', $waitlist_field ) or update_post_meta( $post_id, '_waitlist_num_val', $waitlist_field );
        add_post_meta( $post_id, '_trip_price_val', $trip_price_field ) or update_post_meta( $post_id, '_trip_price_val', $trip_price_field );
        add_post_meta( $post_id, '_acc_fee_val', $acc_fee_field ) or update_post_meta( $post_id, '_acc_fee_val', $acc_fee_field );
        add_post_meta( $post_id, '_total_price_val', $total_price_field ) or update_post_meta( $post_id, '_total_price_val', $total_price_field );
        add_post_meta( $post_id, '_accomodation_val', $accomodation_field ) or update_post_meta( $post_id, '_accomodation_val', $accomodation_field );
        add_post_meta( $post_id, '_name_val', $name_field ) or update_post_meta( $post_id, '_name_val', $name_field );
        add_post_meta( $post_id, '_email_val', $email_field ) or update_post_meta( $post_id, '_email_val', $email_field );
        add_post_meta( $post_id, '_day_phone_val', $day_phone_field ) or update_post_meta( $post_id, '_day_phone_val', $day_phone_field );
        add_post_meta( $post_id, '_ev_phone_val', $ev_phone_field ) or update_post_meta( $post_id, '_ev_phone_val', $ev_phone_field );
        add_post_meta( $post_id, '_contact_method_val', $cnt_method_field ) or update_post_meta( $post_id, '_contact_method_val', $cnt_method_field );
        add_post_meta( $post_id, '_found_us_val', $found_us_field ) or update_post_meta( $post_id, '_found_us_val', $found_us_field );
        add_post_meta( $post_id, '_comments_val', $comments_field ) or update_post_meta( $post_id, '_comments_val', $comments_field );
        add_post_meta( $post_id, '_street_val', $street_field ) or update_post_meta( $post_id, '_street_val', $street_field );
        add_post_meta( $post_id, '_city_val', $city_field ) or update_post_meta( $post_id, '_city_val', $city_field );
        add_post_meta( $post_id, '_state_val', $state_field ) or update_post_meta( $post_id, '_state_val', $state_field );
        add_post_meta( $post_id, '_postcode_val', $postcode_field ) or update_post_meta( $post_id, '_postcode_val', $postcode_field );
        add_post_meta( $post_id, '_country_val', $country_field ) or update_post_meta( $post_id, '_country_val', $country_field );
        add_post_meta( $post_id, '_promotion_val', $promotion_field ) or update_post_meta( $post_id, '_promotion_val', $promotion_field );
          
        $bMailTo = get_option('booking_mail_to');    
        $mailToVal =  $bMailTo ? $bMailTo : ""; 
        
            
        bookingConfirmMail();
    }
    
    return $post_id;
    
}
function bookingConfirmMail(){    
    
    $ownerMail = get_option('booking_mail_to');
    
    //Get e-mail template     
    $message_template = file_get_contents(ABSPATH.'/wp-content/themes/bigchilladv/email_templates/bookingConfirmation.html'); 
    $total = $_POST['total_price_field'];
    
    //replace placeholders with user-specific content
    $message = str_ireplace('[customer-name]',$_POST['name_field'], $message_template);     
    $message = str_ireplace('[tour-name]',$_POST['trips_fields'], $message);     
    $message = str_ireplace('[number-participants]',$_POST['max_num_field'], $message);     
    $message = str_ireplace('[tour-link]',$_POST['trip_link'], $message);
    $message = str_ireplace('[total]', $total, $message);
    $message = str_ireplace('[ten-of-total]', $total*10/100, $message);
    $message = str_ireplace('[total-minus-ten]', $total - $total*10/100, $message);
    
    $mail = get_option('booking_mail_to');
    
    $emeilFrom = $_POST['email_field'];  
    
    //Prepare headers for HTML
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Big Chill Adventures <'.$mail.'>' . "\r\n";
    
    //Prepare headers for owner
    $headers1  = 'MIME-Version: 1.0' . "\r\n";
    $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers1 .= 'From: Big Chill Adventures <'.$emeilFrom.'>' . "\r\n";
    $message1  = $_POST['name_field'].' just booked '. '"'. $_POST['trips_fields']. '" trip';
    
    wp_mail($_POST['email_field'], 'Big Chill Adventures - Booking', $message, $headers);
    wp_mail($ownerMail, 'New Booking Event - Big Chill Adventures ', $message1, $headers1);
    
    return FALSE;
}

//get post categories by post type
function getPostCats($postCat){
    $cats = get_terms( $postCat, array(
                            'orderby'    => 'count',
                            'hide_empty' => 0,
                        ) ); 
    
    return $cats;
}


//remove some meta boxes from Booking Admin page
function wpse_76815_remove_publish_box() {
    remove_meta_box( 'submitdiv', 'booking', 'side' );
    remove_meta_box( 'accommodationdiv', 'booking', 'side' );
    remove_meta_box( 'contact-methodsdiv', 'booking', 'side' );
    remove_meta_box( 'how-found-usdiv', 'booking', 'side' );
    remove_meta_box( 'countrydiv', 'booking', 'side' );
}
add_action( 'admin_menu', 'wpse_76815_remove_publish_box' );