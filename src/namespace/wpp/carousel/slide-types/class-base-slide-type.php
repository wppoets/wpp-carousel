<?php namespace WPP\Carousel\Slide_Type;
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
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
abstract class Base_Slide_Type {

	/** Used by has_image() */
	const HAS_IMAGE = FALSE;

	/** Used by allow_image_change() */
	const ALLOW_IMAGE_CHANGE = FALSE;

	/** Used to keep the default slide array data */
	static protected $_default_slide = array(
		'image' => NULL,
		'title' => NULL,
		'link' => NULL,
		'caption' => NULL,
	);

	/** Used to keep the default post array data */
	static protected $_default_post_data = array(
		'ID'             => NULL,
		'post_content'   => '',
		'post_name'      => '',
		'post_title'     => '',
		'post_status'    => 'publish',
		'post_type'      => '',
		'post_parent'    => '',
		'menu_order'     => '',
		'post_excerpt'   => '',
		'comment_status' => 'closed',
	);

	/**
	 * 
	 */
	static public function has_image() {
		return static::HAS_IMAGE;
	}

	/**
	 * 
	 */
	static public function allow_image_change() {
		return static::ALLOW_IMAGE_CHANGE;
	}

	/**
	 * 
	 */
	static public function get_image_id( &$post ) {
		return NULL;
	}

	/**
	 * 
	 */
	static public function get_meta_box_display( $row_id, &$settings ) {
		return '';
	}

	/**
	 * 
	 */
	static public function build_post_data( &$form_data ) {
		return static::$_default_post_data;
	}

	/**
	 * 
	 */
	static public function build_slides( &$post ) {
		return array();
	}

	/**
	 * 
	 */
	static public function build_json_data( &$post ) {
		return json_encode( array( $post ) );
	}

	/**
	 * 
	 */
	static public function build_json_to_field() {
		return array();
	}

}
