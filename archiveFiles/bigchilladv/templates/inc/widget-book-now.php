<?php 

/**
 * Adds Book_Now widget.
 */
class Book_Now extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'book_now', // Base ID
			__( 'Book Now & Price', 'bca' ), // Name
			array( 'description' => __( 'Book Now & Product Price', 'bca' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            ?>
		<!-- filter -->
                <div class="widget-container widget_item_info" >
                    <div class="inner">
                        
                        <?php 
                            global $post;
                            $price = get_post_meta( $post->ID, '_price_val', true );
                            //var_dump($post);
                        ?>
                        <?php if( $price != "" ){ ?>
                        <h3 class="widget-title">PACKAGE PRICE:</h3>
                        <span class="price"><em>from</em> <ins>$</ins><strong><?php echo $price; ?></strong></span>                    	                                     	                                     
                        <?php } ?>
                        <div class="text-center">
                            <form action="<?php get_home_url(); ?>/book-now" method="POST">
                                <input type="hidden" name="book_post_id" value="<?php echo $post->ID; ?>" />
                                <input type="hidden" name="book_post_title" value="<?php  echo $post->post_title; ?>" />
                                <input type="hidden" name="book_post_price" value="<?php  echo $price; ?>" />
                                <input  class="btn btn-submit" name="book_post" type="submit" value="BOOK NOW" />                           
                            </form>
                        </div>
                    </div>
                </div>
            <!--/ filter -->
	<?php }

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Book_Now


// register Book_Now widget
function book_now() {
    register_widget( 'Book_Now' );
}
add_action( 'widgets_init', 'book_now' );