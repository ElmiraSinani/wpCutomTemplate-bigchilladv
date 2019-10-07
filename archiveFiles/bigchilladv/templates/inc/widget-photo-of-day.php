<?php 

/**
 * Adds Photo_Day widget.
 */
class Photo_Day extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'photo_day', // Base ID
			__( 'Photo Of The Day', 'bca' ), // Name
			array( 'description' => __( 'Photo of Day', 'bca' ), ) // Args
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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>
                <div class="prod_item">
                    <div class="prod_image">
                        <?php
                            query_posts( array( 'order' => 'ASC', 'posts_per_page' => 1, 'category_name' => 'photo-of-the-day'));
                            if (have_posts()) : while (have_posts()) : the_post();                                

                        ?>
                            <?php
                                if (has_post_thumbnail()) :
                                    the_post_thumbnail('photoday');
                                endif;
                            ?>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>                             
                    </div>
                </div> 
                <?php
                
               echo $args['after_widget'];
	}

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

} // class Photo_Day


// register Photo_Day widget
function photo_day() {
    register_widget( 'Photo_Day' );
}
add_action( 'widgets_init', 'photo_day' );