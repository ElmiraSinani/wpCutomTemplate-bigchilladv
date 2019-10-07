<?php

add_action( 'init', 'default_gl_titles' );

function default_gl_titles() {
    
    $deprecated = null;
    $autoload = 'no';
    add_option( 'travel_categoies', 'WHERE DO YOU WANT TO TRAVEL?', $deprecated, $autoload );
    add_option( 'upcoming_trips', 'EXPLORE OUR UPCOMING TRIPS', $deprecated, $autoload );
    add_option( 'custom_trips', 'CUSTOM TRIPS - CONTACT FOR MORE INFORMATION', $deprecated, $autoload );
    
    add_option( 'world_destinations', 'WORLD DESTINATIONS:', $deprecated, $autoload );
    add_option( 'useful_links', 'USEFUL LINKS:', $deprecated, $autoload );
    add_option( 'cunnect_us', 'CONNECT WITH US', $deprecated, $autoload );
    add_option( 'footer_search_more', 'Search for more', $deprecated, $autoload );
    
}


add_action('admin_menu' , 'gl_titles_settings');

function gl_titles_settings() {
    add_menu_page('Global Title', 'Global Titles', 'manage_options', 'global-titles', 'gl_title_settings_callback', '', '25');
}

function  gl_title_settings_callback(){
    
    $travelCats = $_POST['travel_categoies'] ? $_POST['travel_categoies'] : get_option('travel_categoies');    
    $upcomingTrips = $_POST['upcoming_trips'] ? $_POST['upcoming_trips'] : get_option('upcoming_trips');
    $customTrips   = $_POST['custom_trips'] ? $_POST['custom_trips'] : get_option('custom_trips');
    
    $worldDestinations = $_POST['world_destinations'] ? $_POST['world_destinations'] : get_option('world_destinations');
    $usefulLinks =  $_POST['useful_links'] ? $_POST['useful_links'] : get_option('useful_links');
    $cunnectUs =  $_POST['cunnect_us'] ? $_POST['cunnect_us'] : get_option('cunnect_us');
    $searchMore =  $_POST['footer_search_more'] ? $_POST['footer_search_more'] : get_option('footer_search_more');
        
    if( isset($_POST['saveSettings'])){
       saveTitlesOptions($_POST);
    }
    
    
    ?>
            <style type="text/css">
                .cptItem label{font-weight:bold;display: block;}
                .cptItem input[type='text'],.cptItem input[type='email'] {width: 40%;}
                 h1{ font-size: 17px; margin: 20px 0; color: #215988;}             
            </style>
            <form action="" method="post">
            <div class="form_container">
                <hr/>
                <h1>Front Page Titles</h1>
                <p class="cptItem">
                    <label for="travel_categoies">Travel Categories: </label>
                    <input name="travel_categoies" type="text" value="<?php echo $travelCats; ?>" />
                </p>
                <p class="cptItem">
                    <label for="upcoming_trips">Upcomintg Trips: </label>
                    <input name="upcoming_trips" type="text" value="<?php echo $upcomingTrips; ?>" />
                </p>
                <p class="cptItem">
                    <label for="custom_trips">Custom Trips: </label>
                    <input name="custom_trips" type="text" value="<?php echo $customTrips; ?>" />
                </p>
                
                <hr/>
                <h1>Footer Titles</h1>
                <p class="cptItem">
                    <label for="world_destinations">Destinations: </label>
                    <input name="world_destinations" type="text" value="<?php echo $worldDestinations; ?>" />
                </p>
                <p class="cptItem">
                    <label for="footer_search_more">Search More: </label>
                    <input name="footer_search_more" type="text" value="<?php echo $searchMore; ?>" />
                </p>
                <p class="cptItem">
                    <label for="useful_links">Useful Links: </label>
                    <input name="useful_links" type="text" value="<?php echo $usefulLinks; ?>" />
                </p>
                <p class="cptItem">
                    <label for="cunnect_us">Connect us: </label>
                    <input name="cunnect_us" type="text" value="<?php echo $cunnectUs; ?>" />
                </p>
                <hr/>
                
                <p class="cptItem">                   
                    <input name="saveSettings" type="submit" value="Save Settings" />
                </p>
            </div>
            </form>
    <?php
}
function saveTitlesOptions($data){
    
    extract($_POST);
    
    update_option( 'travel_categoies', $travel_categoies );
    update_option( 'upcoming_trips', $upcoming_trips );
    update_option( 'custom_trips', $custom_trips);    
    
    update_option( 'world_destinations', $world_destinations );
    update_option( 'useful_links', $useful_links );
    update_option( 'cunnect_us', $cunnect_us );
    update_option( 'footer_search_more', $footer_search_more );
        
    return false;
}




