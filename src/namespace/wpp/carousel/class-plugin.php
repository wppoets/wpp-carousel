<?php namespace WPP\Carousel;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <plugins@wppoets.com>
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
class Plugin {
	/** Used to keep the init state of the class */
	private static $_initialized = false;
	
	/** Used to store the plugin settings */
	private static $_settings = array();
	
	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	public static function init() {
		if ( self::$_initialized ) return; // If initialized return
		
		self::content_types_init();

		if ( is_admin() ) Admin::init();
		
		self::$_initialized = true;
	}
	
	/**
	 * add_content_types
	 * 
	 * @return void No return value
	 */
	public static function content_types_init() {
		Content_Types\Carousel::init();
	}
}
