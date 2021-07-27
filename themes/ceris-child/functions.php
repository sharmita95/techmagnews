<?php
// Put your custom code here
if ( ! function_exists( 'ceris_child_theme_scripts_method' ) ) {
    function ceris_child_theme_scripts_method() {
        wp_enqueue_style( 'child-theme-style', get_stylesheet_directory_uri().'/style.css', array('ceris-style'), '' );
    }
}

add_action('wp_enqueue_scripts', 'ceris_child_theme_scripts_method');

function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');

/********* custom widget *************/    
function hstngr_register_widget() {
    register_widget( 'hstngr_widget' );
}
add_action( 'widgets_init', 'hstngr_register_widget' );

class hstngr_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
        // widget ID
        'hstngr_widget',
        // widget name
        __('Social Link Widget', ' ceris'),
        // widget description
        array( 'description' => __( 'Social Link Widget', 'ceris' ), )
        );
    }
    public function widget( $args, $instance ) {
        $fb_link = apply_filters( 'widget_title', $instance['fb_link'] );
        $linkedin_link = apply_filters( 'widget_title', $instance['linkedin_link'] );
        echo $args['before_widget'];
        //output
        echo __( '<div class="widget__title block-heading block-heading--line"><h4 class="widget__title-text">Follow Us</h4></div>', 'ceris' );
        
        //if title is present
        echo __('<ul class="list-unstyled list-space-xs">', 'ceris' );
        if ( ! empty( $fb_link ) )
        echo '<li><a href="' . $fb_link .'" target="_blank" rel="nofollow" class="social-tile social-facebook facebook-theme-bg"><div class="social-tile__icon"><i class="mdicon mdicon-facebook"></i></div><div class="social-tile__inner flexbox"><div class="social-tile__left flexbox__item"><h5 class="social-tile__title meta-font">Facebook</h5><span class="social-tile__count"> likes</span></div><div class="social-tile__right"><i class="mdicon mdicon-arrow_forward"></i></div></div></a></li>';
        
        if ( ! empty( $linkedin_link ) )
        echo '<li><a href="' . $linkedin_link .'" target="_blank" rel="nofollow" class="social-tile social-linkedin linkedin-theme-bg"><div class="social-tile__icon"><i class="mdicon mdicon-linkedin"></i></div><div class="social-tile__inner flexbox"><div class="social-tile__left flexbox__item"><h5 class="social-tile__title meta-font">Linkedin</h5><span class="social-tile__count"> likes</span></div><div class="social-tile__right"><i class="mdicon mdicon-arrow_forward"></i></div></div></a></li>';
        echo __('</ul>', 'ceris' );
        
        echo $args['after_widget'];
    }
    public function form( $instance ) {
        if ( isset( $instance[ 'fb_link' ] ) )
            $fb_link = $instance[ 'fb_link' ];
        else
            $fb_link = __( '', 'ceris' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'fb_link' ); ?>"><?php _e( 'Facebook Link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'fb_link' ); ?>" name="<?php echo $this->get_field_name( 'fb_link' ); ?>" type="text" value="<?php echo esc_attr( $fb_link ); ?>" />
        </p>
        
        <?php
        if ( isset( $instance[ 'linkedin_link' ] ) )
            $linkedin_link = $instance[ 'linkedin_link' ];
        else
            $linkedin_link = __( '', 'ceris' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'linkedin_link' ); ?>"><?php _e( 'Linkedin Link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_link ); ?>" />
        </p>
        
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['fb_link'] = ( ! empty( $new_instance['fb_link'] ) ) ? strip_tags( $new_instance['fb_link'] ) : '';
        $instance['linkedin_link'] = ( ! empty( $new_instance['linkedin_link'] ) ) ? strip_tags( $new_instance['linkedin_link'] ) : '';
        return $instance;
    }
}
    
?>