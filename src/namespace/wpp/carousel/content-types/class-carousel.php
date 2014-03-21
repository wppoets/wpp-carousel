<?php namespace WPP\Carousel\Content_Types;
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
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
class Carousel extends \WPP\Carousel\Base\Content_Type {
	const CONTENT_TYPE_ID          = 'wpp-carousel';
	const CONTENT_NAME_SINGLE      = 'Carousel';
	const CONTENT_NAME_PLURAL      = 'Carousels';
	const CONTENT_TYPE_TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;

	/**
	 * Initialization point for the static class
	 * 
	 * @param string|array $options An optional array containing the meta box options
	 *
	 * @return void No return value
	 */
	public static function init( $options = array() ) {
		parent::init( array(
			'meta_boxes' => array( "\WPP\Carousel\Meta_Boxes\Slide" ),
		) );
	}

}