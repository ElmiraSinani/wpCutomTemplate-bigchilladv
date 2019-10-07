<?php
/**
 * Template Name: Front Page Template
 */
get_header();
?>

<div id="middle" class="full_width">
    <div class="container_12">

        <!-- breadcrumbs -->
        <div class="breadcrumbs"></div>
        <!--/ breadcrumbs -->

        <!-- content -->
        <div class="content">

            <div class="post-detail">
                <div class="entry">


                    <!-- LATEST offers list -->                    
                    <div class="title">
                        <h2>EXPLORE OUR UPCOMING TRIPS</h2>
                        <span class="title_right"><a href="<?php  echo get_post_type_archive_link('trips'); ?>">See all</a></span>
                    </div>
                    <div class="line_hr"></div>
                    <div class="grid_list">
                        <?php
                        $taxQ = array(
                                    'taxonomy'  => 'filter-cat',
                                    'field'     => 'slug',
                                    'terms'     => 'custom-trips', // exclude media posts in the news-cat custom taxonomy
                                    'operator'  => 'NOT IN'
                                    );
                        query_posts(array('post_type' => 'trips', 'tax_query' => array($taxQ), 'order' => 'ASC', 'posts_per_page' => 6));
                        if (have_posts()) : while (have_posts()) : the_post();
                                $imgTitle = get_post_meta(get_the_ID(), '_img_title_val', true);
                                //$tripPrice = get_post_meta(get_the_ID(), '_price_val', true);
                                $tripDuration = get_post_meta(get_the_ID(), '_duration_val', true);
                                if( $tripDuration != "" ){
                                    $days = ($tripDuration > 1) ? 'days' : 'day';
                                    $tripDuration = " - " .$tripDuration . " " . $days;
                                }
                                ?>
                                <div class="list_item">
                                    <div class="item_img">                       	    
                                        <?php
                                        if (has_post_thumbnail()) :
                                            the_post_thumbnail('front-trips');
                                        endif;
                                        ?> 
                                        <p class="caption">
                                            <a href="<?php the_permalink(); ?>"><?php echo $imgTitle . $tripDuration; ?></a>
                                        </p>
                                        <a href="<?php the_permalink(); ?>" class="link-img">more...</a>
                                    </div>
                                </div>
                            <?php endwhile;
                        else: ?>
                            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?> 

                        <div class="clear"></div>
                    </div>                    
                    <!-- LATEST offers list -->   
                    
                    <!--/ CUSTOM TRIPS list -->                  
                    <div class="title">
                        <h2>CUSTOM TRIPS - CONTACT FOR MORE INFORMATION</h2>
                        <span class="title_right"><a href="<?php  echo get_term_link( 'custom-trips', 'filter-cat' ); ?>">See all</a></span>
                    </div>
                    <div class="line_hr"></div>
                    <div class="grid_list">
                        <?php
                        query_posts(array('post_type' => 'trips', 'filter-cat' => 'custom-trips', 'order' => 'ASC', 'posts_per_page' => 6));
                        if (have_posts()) : while (have_posts()) : the_post();
                                $imgTitle = get_post_meta(get_the_ID(), '_img_title_val', true);
                                //$tripPrice = get_post_meta(get_the_ID(), '_price_val', true);
                                $tripDuration = get_post_meta(get_the_ID(), '_duration_val', true);
                                if( $tripDuration != "" ){
                                    $days = ($tripDuration > 1) ? 'days' : 'day';
                                    $tripDuration = " - " .$tripDuration . " " . $days;
                                }
                                ?>
                                <div class="list_item">
                                    <div class="item_img">                       	    
                                        <?php
                                        if (has_post_thumbnail()) :
                                            the_post_thumbnail('front-trips');
                                        endif;
                                        ?> 
                                        <p class="caption">
                                            <a href="<?php the_permalink(); ?>"><?php echo $imgTitle . $tripDuration; ?></a>
                                        </p>
                                        <a href="<?php the_permalink(); ?>" class="link-img">more...</a>
                                    </div>
                                </div>
                            <?php endwhile;
                        else: ?>
                            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?> 
                    </div>
                    <!--/ CUSTOM TRIPS  list -->

<!--                    <div class="divider_space"></div>

                     HOLIDAYS offers list 
                    <div class="title">
                        <h2>CHOOSE FROM A WIDE VARIETY OF HOLIDAYS</h2>
                        <span class="title_right"><a href="#">See all Travel offers</a></span>
                    </div>

                    <div class="boxed_list">

                        <div class="boxed_item">
                            <div class="boxed_icon"><img src="<?php bloginfo('template_url'); ?>/images/icons/holidays_icon_1.png" width="48" height="48" alt="SUMMER HOLIDAYS"></div>
                            <div class="boxed_title"><strong>SUMMER HOLIDAYS</strong></div>
                            <span><a href="#">243 offers available</a></span>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><img src="<?php bloginfo('template_url'); ?>/images/icons/holidays_icon_2.png" width="48" height="48" alt="ALL INCLUSIVE"></div>
                            <div class="boxed_title"><strong>ALL INCLUSIVE</strong></div>
                            <span><a href="#">65 offers available</a></span>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><img src="<?php bloginfo('template_url'); ?>/images/icons/holidays_icon_3.png" width="48" height="48" alt="FAMILY HOLIDAYS"></div>
                            <div class="boxed_title"><strong>FAMILY HOLIDAYS</strong></div>
                            <span><a href="#">27 offers available</a></span>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><img src="<?php bloginfo('template_url'); ?>/images/icons/holidays_icon_4.png" width="48" height="48" alt="LUXURY CITY BREAKS"></div>
                            <div class="boxed_title"><strong>LUXURY CITY BREAKS</strong></div>
                            <span><a href="#">78 offers available</a></span>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="boxed_list boxed_list2">

                        <div class="boxed_item">                        	
                            <div class="boxed_title_arrow"><strong>Last Minute Deals</strong></div>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><span class="price_box"><ins>$</ins><strong>579</strong></span></div>
                            <div class="boxed_title"><a href="#"><strong>Houda Golf Beach 5*</strong></a></div>
                            <span><a href="#">Tunisia, Sousse</a></span>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><span class="price_box"><ins>$</ins><strong>480</strong></span></div>
                            <div class="boxed_title"><a href="#"><strong>Hilton Sharks Bay 4*</strong></a></div>
                            <span><a href="#">Egipt, Sharm El Sheik</a></span>
                        </div>

                        <div class="boxed_item">
                            <div class="boxed_icon"><span class="price_box"><ins>$</ins><strong>980</strong></span></div>
                            <div class="boxed_title"><a href="#"><strong>JW Marriot Cancun 5*</strong></a></div>
                            <span><a href="#">Mexico, Cancun</a></span>
                        </div>
                        <div class="clear"></div>
                    </div>-->


                    <!--/ HOLIDAYS offers list -->

                    <!--<div class="divider_space_big"></div>-->

                    <!-- SPECIAL offers list  -->  
                    <!--
                    <div class="title">
                        <h2>SPECIAL PRICES AND LATEST PROMOS</h2>
                        <span class="title_right"><a href="#">See all Special Prices & Promos</a></span>
                    </div>

                    <div class="line_hr"></div>

                    <div class="grid_list promo_list">
                        
                        <?php
                        query_posts(array('post_type' => 'trips', 'order' => 'ASC', 'posts_per_page' => 6));
                        if (have_posts()) : while (have_posts()) : the_post();
                                $imgTitle = get_post_meta(get_the_ID(), '_img_title_val', true);
                                $tripPrice = get_post_meta(get_the_ID(), '_price_val', true);
                                $priceOff = get_post_meta(get_the_ID(), '_spec_price_val', true);
                                $tripDuration = get_post_meta(get_the_ID(), '_duration_val', true);
                                
                                $priceMinus = $tripPrice * $priceOff / 100;
                                
                                $specPrice = $tripPrice - $priceMinus;
                                
                               
                        ?>
                                <div class="list_item">
                                    <div class="item_img">
                                         <?php
                                        if (has_post_thumbnail()) :
                                            the_post_thumbnail('front-trips');
                                        endif;
                                        ?> 
                                        <p class="caption">
                                            <a href="<?php the_permalink(); ?>"><?php echo $imgTitle . " - " . $tripDuration; ?></a> 
                                            <span class="price_off"><ins>$</ins><strong><?php echo $tripPrice; ?></strong></span>
                                            <span class="price"><ins>$</ins><strong><?php echo $specPrice; ?></strong></span>
                                        </p>
                                        <span class="ribbon off-<?php echo $priceOff; ?>">SALE: <?php echo $priceOff; ?> OFF</span>
                                        <a href="<?php the_permalink(); ?>" class="link-img">more...</a>                            
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?> 
                            
                        <div class="clear"></div>
                    </div>
                    -->
                    <!--/ SPECIAL offers list -->
                     
                    
                    <div class="clear"></div>
                    
<!--                    <div class="title">
                        <h2>Members</h2>
                    </div>
                    <div class="line_hr"></div>
                    <?php
                        query_posts( array( 'order' => 'ASC', 'posts_per_page' => 1, 'category_name' => 'logoes'));
                        if (have_posts()) : while (have_posts()) : the_post();                                
                               
                    ?>
                        <div class="members_cnt">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> -->
                    
                    
                </div>
            </div>

        </div>
        <!--/ content -->

        <div class="clear"></div>        
    </div>
</div>
<!--/ middle -->

<!-- after content -->
<div class="after_content">
    <div class="after_inner">
        <div class="container_12">

            
            <div class="sidebar_after_content">
                 <?php if ( is_active_sidebar( 'front-after-content' ) ) : ?>
                    <?php dynamic_sidebar( 'front-after-content' ); ?>
                <?php endif; ?> 
            </div>
            
         
<!--            # widgets area, col 3 
            <div class="widgetarea widget_col_3">

                 widget_twitter             
                <div class="widget-container widget_twitter">
                    <h3>TWITTER FEED:</h3>   

                    <div class="tweet_item">
                        <div class="tweet_image"><img src="<?php bloginfo('template_url'); ?>/images/temp/twitter_avatar.png" width="30" height="30" alt=""></div>
                        <div class="tweet_text">
                            <div class="inner">
                                How the Explosion in Online’s Education can be the Revolution for your Business: <a href="#">ow.ly/aFK40</a>
                                <br><a href="#" class="tweet_author">#blogging</a>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>   

                    <a href="#" class="fallow">Follow us</a>
                </div>
                / widget_twitter 
            </div>
            / widgets area, col 3 -->

            <div class="clear"></div>
        </div>
    </div>
</div>
<!--/ after content -->



<?php get_footer(); ?>