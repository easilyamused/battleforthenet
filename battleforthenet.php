<?php
/*
Plugin Name: Battle For The Net
Description: We're in the battle for the net.  This plugin will display a linked image to BattleForTheNet.com to help spread the word on Net Neutrality
Plugin URI: http://thewpvalet.com/
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
 * Set default battle image
 */
define( 'BFTN_PLUGIN_URI', plugin_dir_url(__FILE__) );
define( 'BFTN_DEFAULT_BATTLE_IMAGE', BFTN_PLUGIN_URI . '/images/battle3.png' );



/**
 * Outputs image and link to battleforthenet.com
 * @param  string 	$battle_image 	id of battle image
 * @return string       			image/link output
 */
function battleforthenet_output( $battle_image_id, $custom_image = null ){

	switch ( $battle_image_id ) {
		case '1':
			$image_url = BFTN_PLUGIN_URI . '/images/battle1.png';
			break;

		case '2':
			$image_url = BFTN_PLUGIN_URI . '/images/battle2.png';
			break;

		case '3':
			$image_url = BFTN_PLUGIN_URI . '/images/battle3.png';
			break;
		
		default:
			$image_url = BFTN_DEFAULT_BATTLE_IMAGE;
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
	extract( shortcode_atts( array( 'battle_image' => BFTN_DEFAULT_BATTLE_IMAGE, 'custom_image' => null ), $atts ) );
	return battleforthenet_output( $battle_image, $custom_image );
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
        echo battleforthenet_output( $instance['battle_image'], $instance['custom_image'] );
        echo $after_title;
    	echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {
        $updated_instance['title'] = esc_html( $new_instance['title'] );
        $updated_instance['battle_image'] = esc_html( trim( $new_instance['battle_image'] ) );
        $updated_instance['custom_image'] = esc_url( $new_instance['custom_image'] );
        return $updated_instance;
    }

    /**
     * Widget form
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => __( "We're in the battle for the net.", 'btfn' ), 'battle_image' => '3', 'custom_image' => '' ) );
        extract( $instance );
        ?>
            <p>
              <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('battle_image'); ?>"><?php _e('Select Battle Image:'); ?></label>
              <select id="<?php echo $this->get_field_id('battle_image'); ?>" name="<?php echo $this->get_field_name('battle_image'); ?>">
				<option value="1" <?php selected( $instance['battle_image'], '1'); ?> >1</option>
				<option value="2" <?php selected( $instance['battle_image'], '2'); ?> >2</option>
				<option value="3" <?php selected( $instance['battle_image'], '3'); ?> >3</option>
              </select>             
            <p>
              <label for="<?php echo $this->get_field_id('custom_image'); ?>"><?php _e('Use your own image, custom image url:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('custom_image'); ?>" name="<?php echo $this->get_field_name('custom_image'); ?>" type="text" value="<?php echo $custom_image; ?>" />
            </p>
        <?php
    }
}