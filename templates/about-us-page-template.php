<?php
/**
 * Template Name: About Us Page Template
 */
get_header();
?>

<div class="full_content about">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>       
        <div class="post-detail">
            <h1><?php the_title(); ?></h1>
            <div class="entry"><?php the_content(); ?></div>
        </div>
    <?php endwhile; endif; ?>
    
    <div class="line_hr"></div>
    <!--Our staff goes here-->
    <?php
    query_posts(array('post_type' => 'our_staff', 'order' => 'ASC', 'posts_per_page' => -1));
    if (have_posts()) : while (have_posts()) : the_post();
            ?>
            <div class="post-staff-detail">                
                <div class="staff_img">                       	    
                    <?php
                    if (has_post_thumbnail()) :
                        the_post_thumbnail('thumb');
                    endif;
                    ?> 
                </div>
                <div class="entry">
                    <h1><?php the_title(); ?></h1>
                    <p><?php the_content(); ?></p>
                </div>                
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    <?php wp_reset_query(); ?> 
</div>
<?php get_footer(); ?>