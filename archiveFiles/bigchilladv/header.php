<?php
    session_start();
    if ($_SERVER['REQUEST_URI'] == '/wp/') {
       wp_redirect( home_url() ); exit;
    }
?>
<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        
        <title>
            <?php if ( is_category() ) {
                    echo 'Category Archive for &quot;'; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
            } elseif ( is_tag() ) {
                    echo 'Tag Archive for &quot;'; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
            } elseif ( is_archive() ) {
                    wp_title(''); echo ' Archive | '; bloginfo( 'name' );
            } elseif ( is_search() ) {
                    echo 'Search for &quot;'.wp_specialchars($s).'&quot; | '; bloginfo( 'name' );
            } elseif ( is_home() || is_front_page() ) {
                    bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
            }  elseif ( is_404() ) {
                    echo 'Error 404 Not Found | '; bloginfo( 'name' );
            } elseif (  is_page() ) {
                 bloginfo( 'name' );  echo ' | '; the_title();       
            } elseif ( is_single() ) {
                    wp_title('');
            } else {
                    echo wp_title( ' | ', false, right ); bloginfo( 'name' );
            } ?>
        </title>
        
        <meta name="description" content="">
        <meta name="keywords" content="">

        <link href="http://fonts.googleapis.com/css?family=Lato:400,400italic,700|Sorts+Mill+Goudy:400,400italic" rel="stylesheet">

        <!-- Mobile viewport optimized: h5bp.com/viewport -->
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <!-- favicon.ico and apple-touch-icon.png -->
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="apple-touch-icon" href="images/apple-touch-icon-57x57-iphone.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72-ipad.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114-iphone4.png">
        
        <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>

	
	
	<link rel="shortcut icon" href="/favicon.ico">	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	
	

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <div class="body_wrap homepage">

    <div class="header">
        <div class="container_12">

            <div class="logo">
                <a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt=""></a>
            </div>
            
            <?php if ( is_active_sidebar( 'header-top-sidebar' ) ) : ?>
            <div class="header_right">
                <?php dynamic_sidebar( 'header-top-sidebar' ); ?>                       
                <div class="clear"></div>
            </div>
            <?php endif; ?>
            
            <div class="topmenu">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'menu_class' => 'dropdown',
                        'container' => 'ul'
                    ));
                ?>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
    <!--/ header -->

  <?php  if ( is_front_page() ) { ?>
    <!-- header slider -->
        <div class="header_slider" style="background-image:url(<?php bloginfo('template_url'); ?>/images/pattern_4.png); background-color:#222">

            <div class="slides_container">            
            <?php
            query_posts( array ( 'post_type' => 'slider', 'cpy_slider-cat' => 'front-top-slider', 'order' => 'ASC' ) );
            if ( have_posts() ) : while ( have_posts() ) : the_post();  
            $subTitle = get_post_meta( get_the_ID(), '_sub_title_val', true ); 
            $textPosition = get_post_meta( get_the_ID(), '_text_position_val', true );
            $class = str_replace("_"," ",$textPosition);
            ?>
            <div class="slide">
                <?php 
                    if ( has_post_thumbnail()) : 
                        the_post_thumbnail("front_top_slider");
                    endif; 
                ?> 
                <div class="slide_text <?php echo $class;?>">
                    <div class="slide_title"><strong><?php the_title(); ?></strong></div>
                    <p class="subtitle"><?php echo $subTitle; ?></p>
                </div>
            </div> 
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
            <?php wp_reset_query(); ?> 
        </div>
        </div>
        <!--/ header slider -->
  <?php } ?>

  <!-- before content -->
    <div class="before_content">
        <div class="before_inner">
            <div class="container_12">

                <div class="title">
                    <h2>WHERE DO YOU WANT TO TRAVEL?</h2>
                    <span class="title_right">
                        <a href="<?php  echo get_post_type_archive_link('trips'); ?>"></a>
                    </span>
                </div>
                <?php 
                    $categories = get_terms( 'trips-cat', array(
                            'orderby'    => 'count',
                            'hide_empty' => 0,
                     ) );
                ?>

                <div class="search_main">
                    <div class="search_col_1">
                        <div class="row input_styled inlinelist">
                            <?php
                            foreach ($categories as $tax_term) {
                                echo '<div class="rowRadio">' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a></div> ';
                            }
                            ?>                                                           
                        </div>
                    </div>         
                </div>

            </div>
        </div>
    </div>
    <!--/ before content -->