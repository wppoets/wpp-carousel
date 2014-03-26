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

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;
	
	/** Used to enable shortcode function */	
	const SHORTCODE_ENABLE = TRUE;
	
	/** Default carousel options */
	static private $_default_carousel_options = array(
		'id' => '',
		'title' => '',
		'slug' => '',
	);

	static private $_slide_tyes = array(
		'static' => "\WPP\Carousel\Slide_Types\Static_Slide_Type",
	);

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
				"\WPP\Carousel\Content_Types\Carousel_Content_Type",
				"\WPP\Carousel\Content_Types\Carousel_Slide_Content_Type",
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
		$shortcode_tag = static::SHORTCODE_TAG;
		if ( empty( $shortcode_tag ) ) {
			$shortcode_tag = static::ID;
		}
		$options = shortcode_atts( 
			self::$_default_carousel_options,
			$atts,
			$shortcode_tag
		);
		return static::get_carousel( $options );
	}

	/**
	 * Display method for the carousel
	 * 
	 * The method processes the shortcode command
	 * 
	 * @return string Returns the results of the shortcode
	 */
	static public function display_carousel( $options ) {
		if ( ! static::is_initialized() ) {
			trigger_error( __( 'Plugin not initialized.', static::TEXT_DOMAIN ), E_USER_NOTICE);
			return;
		}
		print( static::get_carousel( $options ) );
	}

	/**
	 * Get method for the carousel
	 * 
	 * The method for returning the carousel
	 * 
	 * @return void No return value
	 */
	static public function get_carousel( $options ) {
		if ( ! static::is_initialized() ) {
			trigger_error( __( 'Plugin not initialized.', static::TEXT_DOMAIN ), E_USER_NOTICE);
			return;
		}
		$return_value = '';
		$options = wpp_array_merge_options(
			self::$_default_carousel_options,
			$options
		);
		wpp_debug( $options );
		return $return_value;
	}
}
