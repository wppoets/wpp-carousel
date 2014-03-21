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
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
function wpp_carousel_spl_autoload( $class ) {
	if ( substr( $class, 0, 12 ) !== "WPP\Carousel" ) return; //If we are not working with WPP\Carousel namespace request skip the rest of the checks
	$class = str_replace( '_', '-', $class );
	$folders = explode( '\\', strtolower( $class ) );
	$class_name = array_pop( $folders );
	$class_path = WPP_CAROUSEL_NAMESPACE_PATH;
	foreach ( $folders as $folder ) {
		$class_path .= DIRECTORY_SEPARATOR . $folder;
	}
	$class_path .= DIRECTORY_SEPARATOR . 'class-' . $class_name . '.php';
	if ( is_readable ( $class_path ) ) {
		include( $class_path );
	}
	unset( $folders, $class_name, $class_path );
}
spl_autoload_register ( 'wpp_carousel_spl_autoload' );