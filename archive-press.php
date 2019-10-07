<?php get_header(); ?>

<div id="middle" class="cols2">
    <div class="container_12">
        
        <!-- content -->
        <div class="fuul-content">
            <!-- offers list -->
            <div class="full-list">
                
            <?php if (have_posts()) : ?>                
            <?php 
                while (have_posts()) : the_post(); 
            ?>
                
                <div class="list-item">        	
                    <div class="re-image list_img news_logo">
                        <?php
                            if (has_post_thumbnail()) :
                                the_post_thumbnail();
                            endif;
                        ?>
                    </div>

                    <div class="list_content">            	
                        <div class="list_header">
                            <h2 class="newsTitle"><?php the_title(); ?></h2>
                        </div>                
                        <div class="re-descr">
                            <p><?php the_content(); ?></p>
                        </div>    
                    </div>
                    <div class="clear"></div>
                    <div class="bottom_hr"></div>
                </div>

                <?php endwhile; ?>

            <?php else : ?>
                <h2>Nothing found</h2>
            <?php endif; ?>
                
            </div>
            <!-- offers list -->

           

        </div>
        <!--/ content -->

        
        

        <div class="clear"></div>        
    </div>
</div>
<!--/ middle -->





<?php get_footer(); ?>