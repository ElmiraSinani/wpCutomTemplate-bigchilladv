<?php get_header(); ?>

<?php 
    $count_posts = wp_count_posts('trips'); 
?>

<div id="middle" class="cols2">
    <div class="container_12">
        
        <!-- content -->
        <div class="content">

            <div class="title ">
                <h1><a href="<?php  echo get_post_type_archive_link('trips'); ?>">See all </a></h1>
                <span class="title_right count"><?php echo $count_posts->publish; ?> available options </span>
            </div>
            <div class="bottom_hr"></div>

            <!-- offers list -->
            <div class="re-list">
                
            <?php if (have_posts()) : ?>                
            <?php 
                while (have_posts()) : the_post(); 
            
                $imgTitle = get_post_meta(get_the_ID(), '_img_title_val', true);
                $tripPrice = get_post_meta(get_the_ID(), '_price_val', true);
                $tripDuration = get_post_meta(get_the_ID(), '_duration_val', true);
                if( $tripDuration != "" ){
                    $days = ($tripDuration > 1) ? 'days' : 'day';
                    $tripDuration = "( " . $tripDuration . " ".$days." )";
                }
            ?>
                
                <div class="re-item">        	
                    <div class="re-image">
                        <a href="<?php the_permalink(); ?>">
                        <?php
                            if (has_post_thumbnail()) :
                                the_post_thumbnail('trips-list');
                            endif;
                        ?>
                        <span class="caption"><?php echo $imgTitle; ?></span>
                        </a>
                    </div>

                    <div class="re-short">            	
                        <div class="re-top">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="re-subtitle"><strong><?php echo $imgTitle; ?></strong><?php echo $tripDuration; ?></div>
                        </div>                
                        <div class="re-descr">
                            <?php
                                 if (strlen(get_the_excerpt()) > 180) {
                                    $excerpt = substr(get_the_excerpt(), 0, 180) . "...";                                     
                                }else{
                                    $excerpt = get_the_excerpt();
                                }
                            ?>
                            <p><?php echo $excerpt; ?></p>
                        </div>                

                    </div>
                    <div class="re-bot">
                        <span class="re-price">Price: <strong>$<?php echo $tripPrice; ?></strong></span>
                        <a href="<?php the_permalink(); ?>#map" class="link-viewmap" title="View on Map">View Map</a> 
                        <a href="<?php the_permalink(); ?>" class="link-viewimages" title="View Photos">Photos</a>
                    </div>
                    <div class="clear"></div>
                </div>

                <?php endwhile; ?>

                <?php //include (TEMPLATEPATH . '/inc/nav.php' ); ?>

            <?php else : ?>
                <h2>Nothing found</h2>
            <?php endif; ?>
                
            </div>
            <!-- offers list -->

           

        </div>
        <!--/ content -->

        <!-- sidebar -->
        <div class="sidebar">
            
        <!-- Left sidebar widgets here -->            

        <?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'left-sidebar' ); ?>
        <?php endif; ?>                      

        <!--/ Left sidebar widgets here  -->

    </div>
    <!--/ sidebar -->

        <div class="clear"></div>        
    </div>
</div>
<!--/ middle -->





<?php get_footer(); ?>