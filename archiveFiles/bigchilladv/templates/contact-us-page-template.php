<?php
/**
 * Template Name: Contact Us Page Template
 */
get_header();
?>

<div id="middle" class="cols2">
    <div class="container_12">   
        
        <!-- content -->
        <div class="content">

               
            
          	<!-- contact form -->
                <?php 
                
                if (have_posts()) : while (have_posts()) : the_post(); 
                
                    $formSubTitle = get_post_meta( get_the_ID(), '_sub_title_val', true );
                    $formDescripton = get_post_meta( get_the_ID(), '_description_val', true );
                    $contactForm = get_post_meta( get_the_ID(), '_form_id_val', true );
                ?>	
                
                
                <div class="post-detail">
                    <h1><?php echo $formSubTitle; ?></h1>
                    <div class="entry"><?php echo $formDescripton; ?></div>
                </div>
                    <?php echo do_shortcode( $contactForm );  ?>   
		<?php endwhile; endif; ?>
        </div>
        <!--/ contact form -->
       
        
        <!-- sidebar -->
        
        
        <div class="sidebar">
	    <?php dynamic_sidebar( 'contacts-page-sidebar' ); ?>             
        </div>
        <!--/ sidebar -->
        
        <div class="clear"></div>        
    </div>
</div>
<!--/ middle -->

	

<?php //get_sidebar(); ?>

<?php get_footer(); ?>