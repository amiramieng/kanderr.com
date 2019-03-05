<?php class Custom_Recent_Posts_Thumbnail extends WP_Widget { public function __construct() { $widget_ops = array('classname' => 'widget_recent_entries_thumbnail', 'description' => __( "Your site&#8217;s most recent Posts with thumbnail.") );
    parent::__construct('recent-posts-thumbnail', __('Recent Posts Thumbnail'), $widget_ops);
    $this->alt_option_name = 'widget_recent_entries_thumbnail';

    add_action( 'save_post', array($this, 'flush_widget_cache') );
    add_action( 'deleted_post', array($this, 'flush_widget_cache') );
    add_action( 'switch_theme', array($this, 'flush_widget_cache') );
}

public function widget( $args, $instance ) {
    $cache = array();
    if ( ! $this->is_preview() ) {
        $cache = wp_cache_get( 'widget_recent_posts_thumbnail', 'widget' );
    }

    if ( ! is_array( $cache ) ) {
        $cache = array();
    }

    if ( ! isset( $args['widget_id'] ) ) {
        $args['widget_id'] = $this->id;
    }

    if ( isset( $cache[ $args['widget_id'] ] ) ) {
        echo $cache[ $args['widget_id'] ];
        return;
    }

    ob_start();

    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
    if ( ! $number )
    $number = 5;
    $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

    $r = new WP_Query( apply_filters( 'widget_posts_args', array(
        'posts_per_page'      => $number,
        'no_found_rows'       => true,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true
    ) ) );

    if ($r->have_posts()) :
        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) { echo $args['before_title'] . $title . $args['after_title']; } ?>



        <ul>
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <?php
                echo '


                <li>


                <div class="row">';
                echo '


                <div class="widget-image col-xs-4">';
                if (has_post_thumbnail() ) {
                    echo '<a href="';the_permalink(); echo '">';
                    the_post_thumbnail();
                    echo '</a>';
                }
                echo '</div>



                ';
                echo '


                <div class="widget-data col-xs-8">';
                echo '


                <h4><a href="'; the_permalink(); echo'">';
                echo substr(get_the_title(),0,100).'...';
                echo '</a></h4>



                ';
                echo '<span class=""><i class="fa fa-calendar-check-o"></i> '.get_the_date().'</span>';
                echo '</div>


                </div>


                </li>



                ';
                ?>
            <?php endwhile; ?>
        </ul>



        <?php echo $args['after_widget']; ?>
        <?php // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata(); endif; if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_recent_posts_thumbnail', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries_thumbnail']) )
        delete_option('widget_recent_entries_thumbnail');
        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts_thumbnail', 'widget');
    }

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>


        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />




        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />




        <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label>

        <?php
    }
}
function register_Custom_Recent_Posts_Thumbnail() {
    register_widget( 'Custom_Recent_Posts_Thumbnail' );
}
add_action( 'widgets_init', 'register_Custom_Recent_Posts_Thumbnail' );
