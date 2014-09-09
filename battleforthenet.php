<?php
/*
Plugin Name: Battle For The Net
Description: We're in the battle for the net.  This plugin will display a linked image to BattleForTheNet.com to help spread the word on Net Neutrality
Plugin URI: http://#
Author: The WP Valet
Author URI: http://thewpvalet.com/
Version: 1.0
License: GPL2
*/

/*

    Copyright (C) 2014  The WP Valet  contact@thewpvalet.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Set default image size
 */
define( 'BFTN_DEFAULT_SIZE', '500x300' );



/**
 * Outputs image and link to battleforthenet.com
 * @param  string 	$size 	size of image
 * @return string       	image/link output
 */
function battle_for_the_net( $size, $custom_image = null ){

	switch ( $size ) {
		case '150x150':
			$image_url = 'http://placehold.it/150x150';
			break;
		
		default:
			$image_url = 'http://placehold.it/' . BFTN_DEFAULT_SIZE;
			break;
	}

	if ( ! empty( $custom_image ) ){
		$image_url = esc_url( $custom_image );
	}

	return "<a class='btfn-image' href='http://www.battleforthenet.com/' target='_blank'><img src={$image_url}></a>";

}


/**
 * Shortcode
 */
add_shortcode( 'battleforthenet', 'bftn_shortcode_output' );

function bftn_shortcode_output( $atts = null ){
	extract( shortcode_atts( array( 'size' => BFTN_DEFAULT_SIZE, 'custom_image' => null ), $atts ) );
	return battle_for_the_net( $size, $custom_image );
}




/**
 * Register Widget
 */
add_action( 'widgets_init', 'bftn_register_widget' );

function bftn_register_widget(){
	register_widget( 'BFTN_Widget' );
}


/**
 * BFTN Widget Class
 */
class BFTN_Widget extends WP_Widget {

    function BFTN_Widget() {
        $widget_ops = array( 'classname' => 'bftn', 'description' => __( 'Displays an image linked to battleforthenet.com', 'bftn' ) );
        $this->WP_Widget( 'bftn', 'Battle For The Net', $widget_ops );
    }

    /**
     * Display widget
     */
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        echo $before_widget;
        echo $before_title;
        echo $instance['title']; // Can set this with a widget option, or omit altogether
        echo battle_for_the_net( $instance['size'], $instance['custom_image'] );
        echo $after_title;
    	echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {
        $updated_instance['title'] = esc_html( $new_instance['title'] );
        $updated_instance['size'] = esc_html( trim( $new_instance['size'] ) );
        $updated_instance['custom_image'] = esc_url( $new_instance['custom_image'] );
        return $updated_instance;
    }

    /**
     * Widget form
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => __( "We're in the battle for the net.", 'btfn' ), 'size' => BFTN_DEFAULT_SIZE, 'custom_image' => '' ) );
        extract( $instance );
        ?>
            <p>
              <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('custom_image'); ?>"><?php _e('Use your own image, custom image url:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('custom_image'); ?>" name="<?php echo $this->get_field_name('custom_image'); ?>" type="text" value="<?php echo $custom_image; ?>" />
            </p>
        <?php
    }
}