<?php get_header(); ?>
<div class="full_content pageContent">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
	<?php 
            $tripID = $_SESSION['tripID'];
            $tripLink = get_permalink( $tripID );
            $postType = get_post_type( $post->ID );
            $taxonomy = get_object_taxonomies($postType );
            $taxonomy = $taxonomy[0];
            $terms = get_the_terms( $post->ID , $taxonomy );
            foreach ($terms as $k => $v ){
                    $termID = $v->term_id;
                    $termSlug = $v->slug;
            }  
	?>	
	<div class="nextPrevPost">
            
            <?php if($tripID && $postType == 'itinerary'){ ?>
                <a class="pull-left" href="<?php echo $tripLink ."#".$postType; ?>">Return to Itinerary</a>
            <?php } ?>
            
            <?php getTripSiblings($taxonomy, $termID); ?>
            
	</div> 
	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

		<h2><?php the_title(); ?></h2>

		<div class="entry">
			<?php the_content(); ?>
		</div>               
		
	</div>
	<div class="nextPrevPost">
            <?php if($tripID && $postType == 'itinerary'){ ?>
                <a class="pull-left" href="<?php echo $tripLink ."#".$postType; ?>">Return to Itinerary</a>
            <?php } ?>
                
            <?php getTripSiblings($taxonomy, $termID); ?>
	</div>  
    
        <?php endwhile;
    endif;
    ?>

</div>
<?php get_footer(); ?>