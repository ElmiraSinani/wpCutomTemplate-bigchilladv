<?php
/**
 * Template Name: Blog Template
 */

get_header();
?>
<div id="book-template-two">
    
    <div class="booktemplate_two">
        <h1 class="blogPageTitle"><?php the_title(); ?></h1>
        <?php
            query_posts( array( 'order' => 'DESC'));
            if (have_posts()) : while (have_posts()) : the_post();                                

        ?>
        <div class="grid">
            <h1 class="blogTitle">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h1>
            <div><?php the_excerpt(); ?></div>                
            <a href="<?php the_permalink(); ?>">Read More &raquo;</a>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        <?php if(function_exists('wp_pagenavi')) { ?>
        <div class="pagenavigat"><?php wp_pagenavi(); ?></div><?php } else { ?>
        <div class="navigation">
            <p>
                <span class="previous"><?php next_posts_link(__('&laquo; Older Entries', 'sweettech')); ?></span>  
                <span class="newest"><?php previous_posts_link(__('Newer Entries &raquo;', 'sweettech')); ?></span>
            </p>
        </div>
        <?php } ?>    
        <?php wp_reset_query(); ?> 
    </div>
    <div class="blog_sidebar"> 
            <div class="book_sidebar_one">
                    <?php get_sidebar('book-menu-1'); ?>
            </div>
            <div class="book_menu_sidebar">
                    <h1 class="book-title">The Lee Segas</h1>
                    <div class="book_sidebar_content">
                            <?php get_sidebar('book-menu'); ?>
                    </div>
                    <div class="book_bottomLine"></div>
            </div>
            <div class="book_sidebar">
                    <?php get_sidebar('book-menu-2'); ?>
            </div>
    </div>
    
    
</div>

<?php get_footer(); ?>