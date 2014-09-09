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


define( 'BFTN_PLUGIN_URI', plugin_dir_url(__FILE__) );


/**
 * Outputs image and link to battleforthenet.com
 * @param  string 	$type 	type of display
 * @return string       	image/link output
 */
function battleforthenet_output( $type ){

	switch ( $type ) {

		case 'modal':
			$output = '<script src="//widget.battleforthenet.com/widget.min.js" async></script>';
			break;

		case 'embed' :
			$output = '<iframe style="width: 750px; height: 467px;" frameborder="no" src="https://widget.battleforthenet.com/iframe/modal.html#EMBED"></iframe>';
			break;

		case 'lightbanner':
			$output = '<script type="text/javascript">var _bftn_options = { animation: "banner" }</script><script src="//widget.battleforthenet.com/widget.min.js" async></script>';
			break;

		case 'darkbanner':
			$output = '<script type="text/javascript">var _bftn_options = { animation: "banner", theme: "dark" }</script><script src="//widget.battleforthenet.com/widget.min.js" async></script>';
			break;

		case 'image1':
			$image = BFTN_PLUGIN_URI . '/images/battle1.png';
			break;

		case 'image2':
			$image = BFTN_PLUGIN_URI . '/images/battle2.png';
			break;

		case 'image3':
			$image = BFTN_PLUGIN_URI . '/images/battle3.png';
			break;
		
		default:
			//modal
			$output = '<script src="//widget.battleforthenet.com/widget.min.js" async></script>';
			break;

	}

	if ( ! empty( $image ) ){
		$output = "<a class='btfn-image' href='http://www.battleforthenet.com/' target='_blank'><img src={$image}></a>";
	}

	return $output;

}



/**
 * Shortcode
 */
add_shortcode( 'battleforthenet', 'bftn_shortcode_output' );

function bftn_shortcode_output( $atts = null ){
	extract( shortcode_atts( array( 'type' => 'modal' ), $atts ) );
	return battleforthenet_output( $type );
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
        $no_title = array( 'modal', 'lightbanner', 'darkbanner' );
        if ( ! in_array( $instance['type'], $no_title ) ){        	
	        echo $before_title;
	        echo $instance['title']; // Can set this with a widget option, or omit altogether
	        echo $after_title;
        }
        echo battleforthenet_output( $instance['type'] );        
    	echo $after_widget;
    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {
        $updated_instance['title'] = esc_html( $new_instance['title'] );
        $updated_instance['type'] = esc_html( trim( $new_instance['type'] ) );
        $updated_instance['custom_image'] = esc_url( $new_instance['custom_image'] );
        return $updated_instance;
    }

    /**
     * Widget form
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => __( "We're in the battle for the net.", 'btfn' ), 'type' => 'modal', 'custom_image' => '' ) );
        extract( $instance );
        ?>
            <p>
              <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Display Type:'); ?></label>
              <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="modal" <?php selected( $instance['type'], 'modal'); ?> >Modal</option>
				<option value="embed" <?php selected( $instance['type'], 'embed'); ?> >Embedded Modal</option>
				<option value="lightbanner" <?php selected( $instance['type'], 'lightbanner'); ?> >Light Banner</option>
				<option value="darkbanner" <?php selected( $instance['type'], 'darkbanner'); ?> >Dark Banner</option>
				<option value="image1" <?php selected( $instance['type'], 'image1'); ?> >Static Image 1</option>
				<option value="image2" <?php selected( $instance['type'], 'image2'); ?> >Static Image 2</option>
				<option value="image3" <?php selected( $instance['type'], 'image3'); ?> >Static Image 3</option>
              </select>             
            <p>
              <label for="<?php echo $this->get_field_id('custom_image'); ?>"><?php _e('Use your own image, custom image url:'); ?></label> 
              <input class="widefat" id="<?php echo $this->get_field_id('custom_image'); ?>" name="<?php echo $this->get_field_name('custom_image'); ?>" type="text" value="<?php echo $custom_image; ?>" />
            </p>
        <?php
    }
}