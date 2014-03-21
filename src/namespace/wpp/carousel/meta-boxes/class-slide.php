<?php namespace WPP\Carousel\Meta_Boxes;
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
 class Slide extends \WPP\Carousel\Base\Meta_Box {
	const META_BOX_ID          = 'carousel_slide_meta_box';
	const META_BOX_TITLE       = 'Carousel Slides';
	const META_BOX_NONCE       = __FILE__;
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display() {
		parrent::meta_box_display();
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		parrent::save_post( $post_id );
	}
}