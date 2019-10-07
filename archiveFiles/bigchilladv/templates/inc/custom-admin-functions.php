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
function isSelected($field, $val){
    if( $field == $val ){
        $sel = 'selected="selected"';
    }else{
         $sel = "";
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
    
    if ( $post_id ){
        
        // Update the meta field in the database.
        add_post_meta( $post_id, '_trips_val', $trips_fields ) or update_post_meta( $post_id, '_trips_val', $trips_fields );
        add_post_meta( $post_id, '_max_num_val', $max_num_field ) or update_post_meta( $post_id, '_max_num_val', $max_num_field );
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
        
        $data = array(
                'from' => $email_field,
                'to' => $mailToVal,
                'subject' => $trips_fields,
                'message' => $comments_field
        );
        
        sendMail($data);
    }
    
    return $post_id;
    
}

//get post categories by post type
function getPostCats($postCat){
    $cats = get_terms( $postCat, array(
                            'orderby'    => 'count',
                            'hide_empty' => 0,
                        ) ); 
    
    return $cats;
}

function sendMail($data){
    
    
    $headers = 'From: ' .$data['from']. "\r\n" .
        'Reply-To: ' .$data['to']. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($data['to'], $data['subject'], $data['message'], $headers);
    
    return FALSE;
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