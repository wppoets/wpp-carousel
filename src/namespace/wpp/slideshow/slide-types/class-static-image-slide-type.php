<?php namespace WPP\Carousel\Slide_Types;
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
class Static_Slide_Type extends Base_Slide_Type {

	/** Used by has_image() */
	const HAS_IMAGE = TRUE;

	/** Used by allow_image_change() */
	const ALLOW_IMAGE_CHANGE = TRUE;
	
	/**
	 * Function for building the javascript field content
	 *
	 * The javascript varible "row" id must be present for fields to map back to the form data 
	 */
	static public function get_javascript_form_fields( $html_id_prefix, $html_class_prefix, $html_form_prefix ) {
$content = <<<"EOT"
		content = content + [
				'<input class="{$html_class_prefix}field-title-enabled" type="checkbox" name="{$html_form_prefix}[rows][' + row_id + '][slide_title_enabled]" checked />Title:<br />',
				'<input class="{$html_class_prefix}field-title widefat" type="text" name="{$html_form_prefix}[rows][' + row_id + '][slide_title]" value="" /><br />',
				'<input class="{$html_class_prefix}field-link-enabled" type="checkbox" name="{$html_form_prefix}[rows][' + row_id + '][slide_link_enabled]" />Link:<br />',
				'<input class="{$html_class_prefix}field-link widefat" type="text" name="{$html_form_prefix}[rows][' + row_id + '][slide_link]" value="" /><br />',
				'<input class="{$html_class_prefix}field-caption-enabled" type="checkbox" name="{$html_form_prefix}[rows][' + row_id + '][slide_caption_enabled]" checked />Caption:<br />',
				'<textarea class="{$html_class_prefix}field-caption widefat" rows="1" cols="40" name="{$html_form_prefix}[rows][' + row_id + '][slide_caption]"></textarea>',
			].join('');
EOT;
		return $content;
	}

	/**
	 * Method for getting the slides based on the post passed in
	 */
	static public function get_slides( &$post ) {
		if ( empty( $post->post_content_decoded ) ) {
			return array();
		}
		$slide_data = &$post->post_content_decoded;
		if ( ! empty( $slide_data['slide_post_id'] ) ) { 
			$post_thumbnail_id = get_post_thumbnail_id( $slide_data['slide_post_id'] );
			if ( ! empty( $post_thumbnail_id ) ) {
				$full_image = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				if ( $full_image ) {
					list($src, $width, $height) = $full_image;
					$slide_data['slide_image_src'] = $src;
					unset( $src, $width, $height );
				}
				unset( $full_image );
			}
		} else {
			$slide_data['slide_image_src'] = NULL;
		}

		$return_array = wpp_array_merge_options(
			parent::$_default_slide,
			array(
				'image' => ( empty( $slide_data['slide_image_src'] ) ) ? FALSE : $slide_data['slide_image_src'],
				'title' => ( empty( $slide_data['slide_title_enabled'] ) ) ? FALSE : $slide_data['slide_title'],
				'link' => ( empty( $slide_data['slide_link_enabled'] ) ) ? FALSE : $slide_data['slide_link'],
				'caption' => ( empty( $slide_data['slide_caption_enabled'] ) ) ? FALSE : $slide_data['slide_caption'],
			)
		);
		return array( $return_array );
	}
}
