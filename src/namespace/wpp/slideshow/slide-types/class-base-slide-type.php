<?php namespace WPP\Slideshow\Slide_Types;
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
defined( 'WPP_SLIDESHOW_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
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
	 * Method for returning the HAS_IMAGE static const
	 */
	static public function has_image() {
		return static::HAS_IMAGE;
	}

	/**
	 * Method for returning the ALLOW_IMAGE_CHANGE static const
	 */
	static public function allow_image_change() {
		return static::ALLOW_IMAGE_CHANGE;
	}

	/**
	 * Method for building the javascript field content
	 *
	 * The javascript varible "row" id must be present for fields to map back to the form data 
	 */
	static public function get_javascript_form_fields( $html_id_prefix, $html_class_prefix, $html_form_prefix ) {
$content = <<<"EOT"
		content = content + [
				'<input class="{$html_class_prefix}-post-id" name="{$html_form_prefix}[rows][' + row_id + '][slide_value]" value="true" />',
			].join('');
EOT;
		return $content;
	}

	/**
	 * Method for getting the slides based on the post passed in
	 */
	static public function get_slides( &$post ) {
		return array( self::$_default_slide );
	}

	/**
	 * Method for building the data array from the passed post
	 *
	 * Builds the data array to return. By default all the data is stored in the post_content_decoded
	 */
	static public function get_slide_data( &$post ) {
		if ( empty( $post->post_content_decoded ) ) {
			return array();
		}
		if ( empty( $post->post_content_decoded['slide_post_id'] ) ) {
			return $post->post_content_decoded;
		}
		$post_thumbnail_id = get_post_thumbnail_id( $post->post_content_decoded['slide_post_id'] );
		if ( ! empty( $post_thumbnail_id ) ) {
			$thumbnail_image = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
			if ( $thumbnail_image ) {
				list($src, $width, $height) = $thumbnail_image;
				$post->post_content_decoded['slide_image_src'] = $src;
				unset( $src, $width, $height );
			}
			unset( $thumbnail_image );
		}
		return $post->post_content_decoded;
	}

}
