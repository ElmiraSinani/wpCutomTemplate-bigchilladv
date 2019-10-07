<?php
/**
 * Template Name: Book Now Form Template
 */
get_header();
if( isset( $_POST['book_post'] ) ){
    //var_dump($_POST);
}
if( isset($_POST['bookingNow'])){   
    
    if( isset($_POST['accomodation_field']) ){ 
        foreach ( $_POST['accomodation_field'] as $k => $val){
            if ( $val == "0" ){
               unset($_POST['accomodation_field'][$k]);
            }
        }
    }
    
    $successMsg = get_option('booking_sucsess_msg');
    $failed_msg = get_option('booking_failed_msg');
    $terms_msg = get_option('booking_terms_msg');    
      
    $successMsgVal =  $successMsg ? $successMsg : "";
    $failedMsgVal  =  $failed_msg ? $failed_msg : "";
    $termsMsgVal   =  $terms_msg ? $terms_msg : "";
    
    //print_r($_POST);die();
    if ( isset($_POST['terms_field']) && $_POST['terms_field'] != ""){
        $form = saveBookingForm( $_POST );
        if($form){
            $message = "<span class='success'>".$successMsgVal."</span>";
        }else{
           $message = "<span class='denger'>".$failedMsgVal."</span>"; 
        }
    }else{
        $message = "<span class='denger'>".$termsMsgVal."</span>";
    }
    
}
?>

<div class="full_content about">
    
    <?php if($message): ?>
    <div class="form_message">
        <span class="close">X</span>
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <form action="" id="booking-form"  method="post">

       <div class="form_container_full">

        <h1 class="title">Tour Details</h1>
        
        <div class="formItem">
            <label>Trips</label>
            <?php             
                $args=array(
                  'post_type' => 'trips',
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                  'caller_get_posts'=> 1
                );
            $my_query = null;
            $my_query = new WP_Query($args);
            if( $my_query->have_posts() ) { 
                              
            ?>
            <select class="full" name="trips_fields" id="trips_fields">
              <?php 
                
                while ($my_query->have_posts()) : $my_query->the_post(); 
                    
                    $duration = get_post_meta($my_query->post->ID, '_duration_val', true );
                    $price    = get_post_meta($my_query->post->ID, '_price_val', true );
                    if( $price == "" ){
                        $price = "0.00";
                    }
                    $bookedNumVal = get_post_meta($my_query->post->ID, '_booked_num_val', true );
                    
                    $maxNumVal    = get_post_meta($my_query->post->ID, '_max_num_val', true );
                    $maxNum = $maxNumVal - $bookedNumVal;
                ?>
                    <option data-trip-id="<?php echo $my_query->post->ID; ?>" 
                            data-trip-link="<?php the_permalink(); ?>" 
                            data-trip-price="<?php echo $price; ?>" 
                            data-trip-days="<?php echo $duration ?>" 
                            data-max-num="<?php echo $maxNum; ?>" 
                            data-booked-num="<?php echo $bookedNumVal; ?>" 
                            value="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </option>
              <?php endwhile; ?>
            </select>            
            <input type="hidden" id="trip-link" name="trip_link" value="" />
            <input type="hidden" id="trip-id" name="trip_id" value="" />
            <?php } wp_reset_query();?>            
        </div>
        
        <div class="formItem"> 
            <label>Number of partipants</label>            
            <select class="full" name="max_num_field" id="max_num_fields"></select>
            
        </div>
        
        <div class="formItem">               
            <label for="accomodation_field">Accommodation</label>     
            
            <div id="accomodation_field" class="text BookingSelect">
                <!--<option value="">-- Select Accommodation --</option>-->
             <?php   
                $accomodation = getPostCats('accommodation');
                foreach ( $accomodation as $tax_term ) {
                    $price = get_option( "taxonomy_{$tax_term->term_id}" );
                    $price = $price['price_term_meta'];
                    echo '<input type="text" readonly value="'.$tax_term->name.'" data-acc-id="'.$tax_term->term_id.'" > ';
                    echo '<input type="number"  min="0" data-acc-price="'.$price.'" data-acc-id="'.$tax_term->term_id.'" data-acc-title="'.$tax_term->name.'" />';
                    echo '<input id="accContent-'.$tax_term->term_id.'" type="hidden" name="accomodation_field[]"  value="" >'; 
                    echo '<br/>';
                }
            ?>
            </div>
        </div>
       </div>
        
        <h1 class="title">Contact Details</h1>
        <div class="form_container">
            <div class="left">
                <div class="formItem">    
                    <label for="name_field">Name</label>            
                    <input type="text" required id="name_field" class="text required BookingInput" name="name_field" >
                </div>
                <div class="formItem">
                    <label for="email_field">Email</label>
                    <input type="email" id="email_field" required class="text required email BookingInput" name="email_field" >
                </div>
                <div class="formItem">    
                   <label for="day_phone_field">Day Phone</label>
                   <input id="day_phone_field" class="text required BookingInput" name="day_phone_field" type="text">
                </div>
                <div class="formItem">    
                   <label for="ev_phone_field">Evening Phone</label>
                   <input id="ev_phone_field" class="text BookingInput" name="ev_phone_field" type="text">
                </div>
                
                <div class="formItem">               
                    <label for="cnt_method_field">Preferred method of contact</label>                    
                    <select id="cnt_method_field" class="text required  BookingSelect valid" name="cnt_method_field">
                     <?php   
                        $accomodation = getPostCats('contact-methods');
                        foreach ( $accomodation as $tax_term ) {
                            echo '<option  value="'.$tax_term->name.'">'.$tax_term->name.'</option>';            
                        }
                    ?>
                    </select>
                </div>
                <div class="formItem">               
                    <label for="found_us_field">How did you hear about us?</label>                    
                    <select id="found_us_field" class="text required  BookingSelect valid" name="found_us_field">
                     <?php   
                        $accomodation = getPostCats('how-found-us');
                        foreach ( $accomodation as $tax_term ) {
                            echo '<option value="'.$tax_term->name.'">'.$tax_term->name.'</option>';            
                        }
                    ?>
                    </select>
                </div>
                <div class="formItem">  
                    <label for="comments_field">Additional comments</label>
                    <textarea id="comments_field" class="text BookingTextArea" name="comments_field" cols="30" rows="3"></textarea>
                </div>
                
            </div>
            
            <div class="right">
                <div class="formItem">
                    <label for="street_field">Street</label>
                    <input id="street_field" class="text required BookingInput" name="street_field" type="text">
                </div>
                <div class="formItem">
                    <label for="city_field">City</label>
                    <input id="city_field" class="text required BookingInput" name="city_field" type="text">
                </div>
                <div class="formItem">
                    <label for="state_field">State</label>
                    <input id="state_field" class="text required BookingInput" name="state_field" type="text">
                </div>
                <div class="formItem">
                    <label for="postcode_field">Postcode</label>
                    <input id="postcode_field" class="text required BookingInput" name="postcode_field" type="number">
                </div>
                <div class="formItem">               
                    <label for="country_field">Country</label>                    
                    <select id="country_field" class="text required  BookingSelect valid" name="country_field">
                     <?php   
                        $accomodation = getPostCats('country');
                        foreach ( $accomodation as $tax_term ) {
                            echo '<option value="'.$tax_term->name.'">'.$tax_term->name.'</option>';            
                        }
                    ?>
                    </select>
                </div>
                <div class="formItem">
                   <label for="promotion_field">Promotion code</label>
                   <input id="promotion_field" class="text BookingInput" name="promotion_field" type="number">
                </div>
                
            </div>
        </div>
        
        <div class="summary">
            <div class="title">Your Trip Summary</div> 
            
            <div class="leftSum">                                   
                <div id="summary-tour">
                     <span class="label">Trip:</span> 
                    <span id="trip-name">2015 Hannibal Epic! - Barcelona to Rome 5th September (Saturday) - 
                    3rd October (Saturday)
                    </span>
                     &nbsp;[<span id="trip-days"></span> days]
                </div>  
                <div id="sum-accommodation">
                    <span class="label">Accommodation:</span>
                    <div class="accContent">
                        <span id="acc-title">Single occupancy </span>
                    </div>
                </div>
            </div>
            <div class="rightSum">
                <input name="trip_price_field" type="text" readonly id="tour-cost" value="" /><br />            
                <input name="acc_fee_field" type="hidden" readonly id="accomodation-cost" value=""/><br />
                <span class="label">Total</span>
                <input name="total_price_field" type="text" readonly id="summary-total" value=""/>  
            </div>
        </div>
        
        <div class="terms">
            <p>
                <input id="terms_field" class="text" required name="terms_field" type="checkbox">
                <a href="<?php get_home_url(); ?>/terms-of-service" target="_blank">Please read and accept our Terms and Conditions</a>
            </p>
            
            <input name="bookingNow" class="btn-submit" type="submit" value="Book Now" required>
        </div>  
       
    </form>
    
    <script type="text/javascript">
        
        jQuery(document).ready(function($){
            
            var trip = $("#trips_fields");
            var acc  = $("#accomodation_field");
            var maxNumSel  = $("#max_num_fields");
            var waitlistSel  = $("#waitlist_field");
            
            var tripTitle = trip.children('option').first().text();
            var tripdays = trip.children('option').first().data('trip-days');
            var tripPrice = trip.children('option').first().data('trip-price');
           
            var tripMaxNum = trip.children('option').first().data('max-num');
            var tripBookedNum = trip.children('option').first().data('booked-num');
            var tripLink  = trip.children('option').first().data('trip-link');
            var tripId  = trip.children('option').first().data('trip-id');
               
            //Max number or waitlisted number of partipants
            var options = "";                    
            if (tripMaxNum > 0 ){
                for( var j = 1; j <= tripMaxNum; j++ ){
                    options += '<option value="'+j+'">'+j+'</option>';
                }
                maxNumSel.append(options); 
            }else{
                maxNumSel.parent().find("label").text("Number of waitlist partipants");
                for( var j = 1; j <= tripBookedNum; j++ ){
                    options += '<option value="'+j+'">'+j+'</option>';
                }
                maxNumSel.attr("name", "waitlist_field");
                maxNumSel.append(options);                 
            }
            
            var maxNumOpt = maxNumSel.children('option').first().text();
            if ( maxNumOpt == 1 ){
                acc.parent().hide();
            }
            
            var accPrice = acc.children('option').data('acc-price');
            var accTitle = acc.children('option').first().text();
            var title = "Single occupancy - additional charge x 1";
            
            $('input[id^="accContent-"]').val("0");
            $('input[id^="accContent-"]').first().val(title);
            
            $('#trip-link').val(tripLink);
            $('#trip-id').val(tripId);
            $('#trip-name').text(tripTitle);
            $('#trip-days').text(tripdays);
            $('#tour-cost').val(tripPrice);
            
            $('#acc-price').text(accPrice);
            $('#acc-title').text(title);
            
            var tripCost = $('#tour-cost').val();
            var accPrice = 10;
            //var accCost  = (parseInt(tripCost) * accPrice)/100;  
            var accCost  = 0;  
            var total = parseInt(tripCost) + accCost;
            $('#accomodation-cost').val(accCost);            
            $('#summary-total').val(total);
            
            
            trip.change(function(){
                tripTitle = $(this).children('option:selected').text();
                tripdays = $(this).children('option:selected').data('trip-days');
                tripPrice =  $(this).children('option:selected').data('trip-price');
                tripLink =  $(this).children('option:selected').data('trip-link');
                tripId  =  $(this).children('option:selected').data('trip-id');
                
                $('#acc-title').text("Single occupancy - additional charge x 1");
                $("#accomodation_field input[type='number']" ).val("");
                
                $('#trip-name').text(tripTitle);
                $('#tour-cost').val(tripPrice);
                $('#trip-days').text(tripdays);
                $('#trip-link').val(tripLink);
                $('#trip-id').val(tripId);
                
                acc.parent().hide();
                //checking max number for selected
                maxNumSel.attr("name", "max_num_fields");  
                maxNumSel.parent().find("label").text("Number of partipants");
                tripMaxNum = $(this).children('option:selected').data('max-num');
                tripBookedNum = $(this).children('option:selected').data('booked-num');
                
                //max num field 
                var options = "";
                if (tripMaxNum > 0 ){
                    for( var j = 1; j <= tripMaxNum; j++ ){
                         options += '<option value="'+j+'">'+j+'</option>';
                    }
                    $( "#max_num_fields option" ).remove();
                    maxNumSel.append(options); 
                }else{
                    waitlistSel.parent().find("label").text("Number of waitlist partipants");
                    for( var j = 1; j <= tripBookedNum; j++ ){
                        options += '<option value="'+j+'">'+j+'</option>';
                    }
                    $( "#max_num_fields option" ).remove();
                    maxNumSel.attr("name", "waitlist_field");
                    maxNumSel.append(options);                 
                }
       
                
                
                tripCost = $('#tour-cost').val();
                accPrice = 10;
                //accCost  = (parseInt(tripCost) * accPrice)/100;  
                accCost  = 0;  
                total = parseInt(tripCost) + accCost;
                $('#accomodation-cost').val(accCost);
                $('#summary-total').val(total);
                
            });
            
            maxNumSel.change(function(){
                
                $( "#accomodation_field input[type='number']" ).val("");
                $("#acc-title").empty().text(title);
                $('input[id^="accContent-"]').val("0");
                $('input[id^="accContent-"]').first().val(title);
                
                maxNumOpt = $(this).children('option:selected').text();
                
                var oldCost = $("#tour-cost").val();
                var newCost = parseInt(tripCost) * parseInt(maxNumOpt);
                var newPrice = trip.children('option:selected').data('trip-price');

                //accCost  = (parseInt(newCost) * accPrice)/100;  
                //total = parseInt(newCost) + accCost;
                
                if ( parseInt(maxNumOpt) == 1 ){
                    acc.parent().hide();
                    
                    newCost = parseInt(newPrice) * parseInt(maxNumOpt);
                    //accCost  = (parseInt(newPrice) * 10)/100; 
                    accCost  = 0; 
                   
                }else{
                    acc.parent().show(); 
                    accCost = "";
                    $("#acc-title").empty();
                }
                
                total = parseInt(newCost) + accCost;
                $("#tour-cost").val(newCost);
                $('#accomodation-cost').val(accCost);
                $('#summary-total').val(total);
                
                
             });
           
           
            $( "#accomodation_field input[type='number']" ).change(function() {
                               
                $('#acc-title').empty();
               
                jQuery.each( $( "#accomodation_field input[type='number']" ), function( i, val ) {
                    
                    tripCost = $('#tour-cost').val();
                    
                    var div = '';
                    var id = $(val).data('acc-id');
                    var accPriceData =  trip.children('option:selected').data('trip-price');
                     
                    accPrice = $(val).data('acc-price'); 
                    div = '<div id='+ id +' data-prcent='+ accPrice+'></div>';                    
                    $('#acc-title').append(div);
                    
                    if ( $(val).val() != 0 || $(val).val() != "" ){  
                        accTitle  = $(val).data('acc-title') + ' x ' + $(val).val();
                        $('#acc-title #'+id).text(accTitle);
                        $('#accContent-'+id).val(accTitle);
                        
                        if ( accPrice != 0 || accPrice != "" ){
                            //accCost  = (parseInt(accPriceData) * parseInt(accPrice))/100;
                            accCost  = 0;
                            if ( parseInt(accPrice) > 1 ){
                                accCost = accCost * $(val).val();
                            }
                            total = parseInt(tripCost) + accCost;
                        }
                        $('#accomodation-cost').val(accCost);
                        $('#summary-total').val(total);
                    }
                    
                    
                });
                
               
                
               
                
            });
            
            $('form#booking-form').on('submit', function (event, extra) {
                //terms_field
                var terms = false;
                if ($('input.#terms_field').is(':checked')) {
                    terms =true;
                }
                
                return terms;
            });
         
        }); 
    </script>

</div>
<?php get_footer(); ?>