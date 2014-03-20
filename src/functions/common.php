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
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */

/**
 * Helper function for the debug process
 * 
 * @param string $message The message to send to the error log
 * @return void No return value
 */
if ( ! function_exists( 'wpp_debug' ) ) {
	function wpp_debug( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

/**
 * Helper function for the checking if a class has been included
 * 
 * First the function checks to see if the class exists, if not it requires the file,
 * 
 * @param string $class_name The name of the class to check for
 * @param string $class_path The full path to the file to include if the class does not exists
 * @return void No return value
 */
if ( ! function_exists( 'wpp_include_class' ) ) {
	function wpp_include_class( $class_name, $class_path ) {
		if ( ! class_exists( $class_name ) ) {
			require_once( $class_path );
		}
	}
}

/**
 * Helper function for the checking if a class has been included and init
 * 
 * First the function checks to see if the class exists, if not it requires the file,
 * once that is complete it calls the static class function init()
 * 
 * @param string $class_name The name of the class to check for
 * @param string $class_path The full path to the file to include if the class does not exists
 * @return void No return value
 */
if ( ! function_exists( 'wpp_init_class' ) ) {
	function wpp_init_class( $class_name, $class_path ) {
		wpp_include_class( $class_name, $class_path );
		if ( method_exists( $class_name, 'init' ) ) { 
			call_user_func( array( $class_name, 'init' ) );
		}
	}
}
