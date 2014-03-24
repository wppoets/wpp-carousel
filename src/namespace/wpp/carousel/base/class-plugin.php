<?php namespace WPP\Carousel\Base;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <opensource@wppoets.com>
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
 */
abstract class Plugin {
	/** Used to keep the init state of the class */
	private static $_initialized = array();
	
	/** Used to store the plugin options */
	private static $_options = array();

	/** Used to store the plugin settings */
	private static $_settings = array();

	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	public static function init( $options = array() ) {
		$static_instance = get_called_class();
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { return; }
		static::set_options( $options );
		static::content_types_init();
		if ( is_admin() ) static::admin_controllers_init();
		self::$_initialized[ $static_instance ] = true;
	}
	
	/**
	 * set function for the options
	 *  
	 * @param string|array $options An array containing the meta box options
	 * 
	 * @return void No return value
	 */
	public static function set_options( $options, $merge = FALSE ) {
		$static_instance = get_called_class();
		if ( empty( self::$_options[ $static_instance ] ) ) self::$_options[ $static_instance ] = array(); //setup an empty instance if empty
		self::$_options[ $static_instance ] = wpp_array_merge_nested(
			array( //Default options
				'content_types' => array(),
				'admin_controllers' => array(),
			),
			( $merge ) ? self::$_options[ $static_instance ] : array(), //if merge, merge the excisting values
			(array) $options //Added options
		);
	}

	/*
	 * get function for the option array
	 *  
	 * @return array Returns the option array
	 */
	public static function get_options() {
		$static_instance = get_called_class();
		return self::$_options[ $static_instance ];
	}

	/**
	 * content_types_init
	 * 
	 * @return void No return value
	 */
	public static function content_types_init() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'content_types' ] as $content_type ) {
			$content_type::init();
		}
	}


	/**
	 * admin_init
	 * 
	 * @return void No return value
	 */
	public static function admin_controllers_init() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'admin_controllers' ] as $admin ) {
			$admin::init();
		}
	}
}
