<?php namespace WPP\Carousel\Base;
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
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * @version 1.0.0
 */
abstract class Plugin {
	
	/** Used to set the plugins ID */
	const ID = 'wpp-plugin';
	
	/** Used to enable shortcode function */
	const SHORTCODE_ENABLE = FALSE;
	
	/** Used to set the shortcode tag */
	const SHORTCODE_TAG = '';
	
	/** Used to set the shortcode filter enable */
	const SHORTCODE_FILTER_ENABLE = FALSE;
	
	/** Used to keep the init state of the class */
	static private $_initialized = array();
	
	/** Used to store the plugin options */
	static private $_options = array();
	
	/** Used to store the plugin settings */
	static private $_settings = array();
	
	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		$static_instance = get_called_class();
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { 
			return; 
		}
		static::set_options( $options );
		static::init_content_types();
		if ( static::SHORTCODE_ENABLE ) {
			$shortcode_tag = static::SHORTCODE_TAG;
			if ( empty( $shortcode_tag ) ) {
				$shortcode_tag = static::ID;
			}
			add_shortcode( 
				$shortcode_tag, 
				array( $static_instance, 'action_shortcode' )
			);
			if ( static::SHORTCODE_FILTER_ENABLE ) {
				add_filter( "shortcode_atts_{$shortcode_tag}", array( $static_instance, 'filter_shortcode_atts' ), 10, 3 );
			}
			unset( $shortcode_tag );
		}
		if ( is_admin() ) {
			static::init_admin_controllers();
		}
		self::$_initialized[ $static_instance ] = true;
	}
	
	/**
	 * Set method for the options
	 *  
	 * @param string|array $options An array containing the meta box options
	 * @param boolean $merge Should the current options be merged in?
	 * 
	 * @return void No return value
	 */
	static public function set_options( $options, $merge = FALSE ) {
		$static_instance = get_called_class();
		if ( empty( self::$_options[ $static_instance ] ) ) {
			self::$_options[ $static_instance ] = array(); //setup an empty instance if empty
		}
		self::$_options[ $static_instance ] = wpp_array_merge_nested(
			array( //Default options
				'content_types' => array(),
				'admin_controllers' => array(),
			),
			( $merge ) ? self::$_options[ $static_instance ] : array(), //if merge, merge the excisting values
			(array) $options //Added options
		);
	}

	/**
	 * Get method for the option array
	 *  
	 * @return array Returns the option array
	 */
	static public function get_options() {
		$static_instance = get_called_class();
		return self::$_options[ $static_instance ];
	}

	/**
	 * Init method for the content types
	 * 
	 * @return void No return value
	 */
	static public function init_content_types() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'content_types' ] as $class ) {
			static::init_static_class( $class );
		}
	}

	/**
	 * Init method for the admin controllers
	 * 
	 * The method loops through the preconfigured admin_controllers 
	 * array set in the plugin options, then 
	 * 
	 * @return void No return value
	 */
	static public function init_admin_controllers() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'admin_controllers' ] as $class ) {
			static::init_static_class( $class );
		}
	}

	/**
	 * WordPress action method for processing the shortcode
	 * 
	 * The method processes the shortcode command
	 * 
	 * @return string Returns the results of the shortcode
	 */
	static public function action_shortcode( $atts, $content='' ) {
		// Holder, should be implemented inside the child class
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
		return $contents;
	}

	/**
	 * WordPress filter method for processing the shortcode atts
	 * 
	 * The method processes the shortcode atts
	 * 
	 * @return $out Returns the shortcode_atts results
	 */
	static public function filter_shortcode_atts( $out, $pairs, $atts ) {
		return $out;
	}

	/**
	 * Init method for a static class
	 * 
	 * The method loops through the preconfigured admin_controllers 
	 * array set in the plugin options, then 
	 * 
	 * @return void No return value
	 */
	static private function init_static_class( $class ) {
		if ( class_exists( $class ) && method_exists( $class, 'init' ) ) {
			$class::init();
		}
	}
}
