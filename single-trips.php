<?php get_header(); ?>

<div id="middle" class="cols2">
    <div class="container_12">
     
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
            $_SESSION['tripID'] = $post->ID;
            
            $tripDuration = get_post_meta( $post->ID, '_duration_val', true );
            $imgSubTitle  = get_post_meta( $post->ID, '_img_title_val', true );
            $subTitle = ( $imgSubTitle != "" ) ? ('<span>'.$imgSubTitle.'</span>') : "";
            $overviewVal  = get_post_meta( $post->ID, '_overview_val', true );
            $notIncVal   = get_post_meta( $post->ID, '_not_included_val', true );
            $mapsVal     = get_post_meta( $post->ID, '_maps_val', true );
            $itineraryCat = get_post_meta( $post->ID, '_itinerary_val', true );
            $activitiesVal = get_post_meta( $post->ID, '_activities_val', true );
            $packingCat =  get_post_meta( $post->ID, '_packing_val', true );
            $packingPrice = get_post_meta( $post->ID, '_price_val', true );
            
            $itineraryFrom = get_post_meta( $post->ID, '_itinerary_from_val', true );
            $itineraryTo   = get_post_meta( $post->ID, '_itinerary_to_val', true );
        ?>

        <div class="title m20">
            <h1>
                <?php 
                    the_title(); 
                    if($subTitle!=""){ echo " - ". $subTitle; }  
                ?>
            </h1> 
        </div>
        
        <?php if( $itineraryCat != "" ){ ?>
        <!-- Photo Gallery -->
        <div class="gal-wrap">

            <div id="gallery" class="gal-content">				
                <div class="slideshow-container">
                    <div id="loading" class="loader"></div>
                    <div id="slideshow" class="gal-slideshow"></div>
                    <div id="caption" class="caption-container"></div>
                </div>				
            </div>
            
           
            <div class="gal-right">
                <div id="thumbs" class="gal-nav">
                    <ul class="thumbs noscript">  
                    <?php
                   
                    
                    query_posts( array ( 'post_type' => 'itinerary', 'itinerary-cat'=> $itineraryCat,'posts_per_page' => -1,'oredr'=>'DASC' ) );
                    if ( have_posts() ) : while ( have_posts() ) : the_post();                     
                    ?>      
                    
                    <?php 
                        $img = display_slider_images( $post->ID, get_the_title() );
                       
                        echo $img;
                    ?>
                    
                    
                    
                        
                    <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> 
                            
                     <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/single-gallery.js" ></script>               
                    </ul>                  
                </div>

                <div id="controls" class="controls"></div>            

            </div>
            <div class="clear"></div>  

        </div>     
        <?php } ?>
        <!--/ Photo Gallery -->

        <!-- content -->
        <div class="full-content">

            <!-- offers tabs -->
            <div class="tabs_products">

                <ul class="tabs linked">
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="#itinerary">Itinerary</a></li>
                    <li><a href="#map">Maps & Area</a></li>
                    <li><a href="#packing_list">Packing List</a></li>
                    <li><a href="#packing_price">Package Price</a></li>                   
                </ul>

                <!-- overview -->
                <div class="tabcontent">
                    <div class="list_check list_details">  
                        <p><?php the_content(); ?></p>
                    </div>
                    <h2>Package Includes:</h2>
                    <div class="list_check list_details">  
                        <div class="title2">
                            <h3><span>Itinerary includes the following: </span></h3></h3>
                        </div>                        
                        <p>
                            <?php echo  htmlspecialchars_decode($overviewVal);  ?>
                        </p>
                    </div>

                    <h2>Not Included:</h2>
                    <div class="title2">
                        <h3><span>Itinerary does not include the following: </span></h3>
                    </div>
                    <div class="list_delete list_details">       
                        <p>
                            <?php echo  htmlspecialchars_decode($notIncVal);  ?>
                        </p>
                    </div>
                    
                    <h2 class="mt50">Activities:</h2>
                    <?php        
                    $ids = unserialize($activitiesVal);
                    if ( $activitiesVal != "" ){
                    query_posts( array ( 'post_type' => 'activities', 'post__in' => $ids, 'oredr'=>'DASC', 'posts_per_page' => -1 ) );
                    if ( have_posts() ) : while ( have_posts() ) : the_post();                     
                    ?>
                    <div class="title2">
                        <h2>
                            <span class="activitie_icon">
                                <?php 
                                if ( has_post_thumbnail()) : 
                                    the_post_thumbnail();
                                endif; 
                                ?> 
                            </span>
                            <?php the_title(); ?>
                        </h2>
                    </div>
                    
                    <div class="atraction_content">
                        <?php the_excerpt(); ?>
                    </div>  
                    
                    <div class="divider_space_thin"></div>
                    
                    <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> 
                    <?php }else{ ?>
                    <p><?php _e('Sorryff, no posts matched your criteria.'); ?></p>
                    <?php } ?>
                    
                </div>               
                <!--/ overview -->

                <!-- Itinerary -->
                <div class="tabcontent">
                    <h2>Itinerary  </h2> 
                    <?php if ( $itineraryFrom != "" ){ ?>
                    <h3> <?php echo $itineraryFrom ." - " . $itineraryTo; ?> </h3>
                    <?php } ?>
                    <?php                   
                    if ( $itineraryCat != "" ){
                    query_posts( array ( 'post_type' => 'itinerary', 'itinerary-cat'=> $itineraryCat, 'oredr'=>'DASC', 'posts_per_page' => -1 ) );
                    if ( have_posts() ) : while ( have_posts() ) : the_post();                     
                    ?>
                    <div class="title2">
                        <h2><?php the_title(); ?></h2>
                        <span class="title_right"><a href="<?php the_permalink(); ?>">+ more details</a></span>
                    </div>
                    
                    <div class="atraction_content">
                    <div class="atractionImg">
                       <?php 
                        if ( has_post_thumbnail()) : 
                            the_post_thumbnail(array(235,165));
                        endif; 
                        ?> 
                    </div>
                    <div class="atractionTxt">
                        <p>
                           <?php the_excerpt(); ?>
                        </p>
                    </div>  
                    </div>
                    <div class="divider_space_thin"></div>
                    
                    <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> 
                    <?php }else{ ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php } ?>
                </div>
                <!--/ Itinerary -->
                
                <!-- Maps -->
                <div class="tabcontent">
                    <h2>Maps & Area</h2>
                    <p><?php echo  htmlspecialchars_decode($mapsVal); ?></p>
                </div>
                <!--/ Maps -->

                <!-- Packing List -->
                <div class="tabcontent">
                    <h2>Packing List</h2>
                    <?php                   
                    if ( $packingCat != "" ){
                    query_posts( array ( 'post_type' => 'packing_list', 'packing-cat'=> $packingCat, 'oredr'=>'DASC', 'posts_per_page' => -1 ) );
                    if ( have_posts() ) : while ( have_posts() ) : the_post();                     
                    ?>
                    <div class="title2">
                        <h2><?php the_title(); ?></h2>
                    </div>                    
                    <div class="atraction_content">
                    <div class="atractionImg">
                       <?php 
                            if ( has_post_thumbnail()) : 
                                the_post_thumbnail(array(235,165));
                            endif; 
                        ?> 
                    </div>
                    <div class="atractionTxt">
                        <p>
                           <?php the_content(); ?>
                        </p>
                    </div>  
                    </div>
                    <div class="divider_space_thin"></div>                    
                    <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> 
                    <?php }else{ ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php } ?>                
                </div>
                <!--/ Packing List --> 
                
                <!-- Packing Price -->
                <div class="tabcontent packingPrice">
                    <h2>Package Price: </h2>
                    <span class="price"><em>from</em> <ins>$</ins><strong><?php echo $packingPrice; ?></strong></span>                    	                                     	                                     
                        
                    <div class="bookForm">
                        <form action="<?php get_home_url(); ?>/book-now" method="POST">
                            <input type="hidden" name="book_post_id" value="<?php echo $post->ID; ?>" />
                            <input type="hidden" name="book_post_title" value="<?php echo $post->post_title; ?>" />
                            <input type="hidden" name="book_post_price" value="<?php echo $packingPrice; ?>" />
                            <input  class="btn btn-submit" name="book_post" type="submit" value="BOOK NOW" />                           
                        </form>
                    </div>
                    
                </div>
                <!--/ Packing List --> 
                
                
            </div>
            <!--/ offers tabs -->

        </div>
        <!--/ content -->

        

        <div class="clear"></div>        
    </div>
    
    <?php endwhile; endif; ?>
    
</div>
<!--/ middle -->

<?php get_footer(); ?>