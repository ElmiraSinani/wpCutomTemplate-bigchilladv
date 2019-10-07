<?php 
    $categories = get_terms( 'trips-cat', array(
            'orderby'    => 'count',
            'hide_empty' => 0,
     ) );
?>
<!-- footer -->
    <div class="footer">
        <div class="footer_inner">
            <div class="container_12">

                <!--# footer col 1 -->
                <div class="widgetarea f_col_1">

                    <!-- widget_categories -->
                    <div class="widget-container widget_categories">
                        <h3 class="widget-title">WORLD DESTINATIONS:</h3>
                        <ul>
                             <?php
                            foreach ($categories as $tax_term) {
                                echo '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '><span>' . $tax_term->name.'</span></a>';
                            }
                           
                            ?> 
                            <li class="item-search">
                                <a href="<?php  echo get_post_type_archive_link('trips'); ?>"><span>Search for more</span></a>
                            </li>
                        </ul>
                    </div>  
                    <!--/ widget_categories -->

                </div>
                <!--/ footer col 1 -->

                <!--# footer col 2 -->
                <div class="widgetarea f_col_2">

                    <div class="widget-container widget_pages">
                        <h3 class="widget-title">USEFUL LINKS:</h3>
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu',
                                'menu_class' => '',
                                'container' => 'ul'
                            ));
                        ?>
                        <?php
                        query_posts( array( 'order' => 'ASC', 'posts_per_page' => 1, 'category_name' => 'logoes'));
                        if (have_posts()) : while (have_posts()) : the_post();                                
                               
                        ?>
                            <div class="">
                                <?php the_content(); ?>
                            </div>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?> 
                    </div>


                </div>
                <!--/ footer col 2 -->


                <!--# footer col 3 -->
                <div class="widgetarea f_col_3">

                    <!-- widget_contact -->
                    <div class="widget-container widget_contact">   
                        <h3 class="widget-title">CONNECT WITH US</h3>
                        <div class="inner">   
                            <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
                                <?php dynamic_sidebar( 'footer-sidebar' ); ?>
                            <?php endif; ?>
                        </div>     
                    </div>
                    <!--/ widget_contact -->

                </div>
                <!--/ footer col 3 -->


                <div class="copyright">
                    <p class="alignleft">&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?></p>                    
                </div>

            </div>
        </div>
    </div>
    <!--/ footer -->

</div>		
	

	<?php wp_footer(); ?>
	
	<!-- Don't forget analytics -->
	
</body>

</html>
