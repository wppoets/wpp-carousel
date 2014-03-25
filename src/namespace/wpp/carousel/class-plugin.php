<?php namespace WPP\Carousel;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <copyright@wppoets.com>
 * All rights reserved.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
defined( 'WPP_CAROUSEL_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
/**
 * Starting point for the plugin
 * 
 * Everything about the plugin starts here.
 * 
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * 
 */
class Plugin extends \WPP\Carousel\Base\Plugin {
	
	/** Used to set the plugins ID */
	const ID = 'wpp-carousel';
	
	/** Used to enable shortcode function */	
	const SHORTCODE_ENABLE = TRUE;
	
	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	static public function init() {
		parent::init( array(
			'admin_controllers' => array( 
				"\WPP\Carousel\Admin", 
			),
			'content_types' => array( 
				"\WPP\Carousel\Content_Types\Carousel",
				"\WPP\Carousel\Content_Types\Carousel_Slide",
			),
		) );
	}
	
	/**
	 * WordPress action method for processing the shortcode
	 * 
	 * The method processes the shortcode command
	 * 
	 * @return string Returns the results of the shortcode
	 */
	static public function action_shortcode( $atts, $content='' ) {
		wpp_debug( $atts );
		$shortcode_tag = static::SHORTCODE_TAG;
		if ( empty( $shortcode_tag ) ) {
			$shortcode_tag = static::ID;
		}
		extract( shortcode_atts( 
			array(
				'id' => '',
				'title' => '',
				'slug' => '',
			),
			$atts,
			$shortcode_tag
		) );
		return $content;
	}
}
