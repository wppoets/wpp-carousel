<?php
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
defined( 'WPP_CAROUSEL_NAMESPACE_PATH' ) or die(); //Required down the road as well
/**
 * Autoloader function for loading classes based on namespace
 *
 * The function tests to see if the class starts with the required name
 * space and if so tries to find the needed file
 *
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * @param string $class The class that needs to be autoloaded
 * @return void No return value
 */
if ( ! function_exists( 'wpp_carousel_spl_autoload' ) ) {
	function wpp_carousel_spl_autoload( $class ) {
		if ( substr( $class, 0, 12 ) !== "WPP\Carousel" ) return; //If we are not working with WPP\Carousel namespace request skip the rest of the checks
		$folders = explode( '\\', str_replace( '_', '-', strtolower( $class ) ) ); // Lowercase class, replace _ with -, then explode base on namespace seperator
		$class_name = array_pop( $folders ); // The class name should be the last item in the array
		$class_path = WPP_CAROUSEL_NAMESPACE_PATH; // Set the starting path to the carousel name space path
		foreach ( $folders as $folder ) { // Loop through the folders to build the path
			$class_path .= DIRECTORY_SEPARATOR . $folder; // Ammend the new folder
		}
		$class_path .= DIRECTORY_SEPARATOR . 'class-' . $class_name . '.php'; // Ammend the class file name, following the WordPress class file naming structure
		if ( is_readable ( $class_path ) ) { // Check to see if the file is readable
			// Include the file, we use include instead of require because it is faster and if the class is already loaded 
			// we should never have needed to autoload it
			include( $class_path ); 
		}
		unset( $folders, $class_name, $class_path ); // Clean up
	}
}
spl_autoload_register ( 'wpp_carousel_spl_autoload' ); // Register the autoloader
