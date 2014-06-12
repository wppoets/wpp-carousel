<?php namespace WPP\Slideshow\Content_Types;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <wppoets@gmail.com>
 * Portions of this distribution are copyrighted by:
 *   Copyright (c) 2014 Michael Stutz <michaeljstutz@gmail.com>
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
class Slideshow_Slide_Content_Type extends \WPP\Slideshow\Base\Content_Type {

	/** Used to keep the default slide array data */
	static protected $_default_data = array(
		'slide_post_id' => 'false',
		'slide_image_src' => '',
		'slide_image_id' => 'false',
		'slide_title_enabled' => FALSE,
		'slide_title' => '',
		'slide_caption_enabled' => FALSE,
		'slide_caption' => '',
		'slide_link_enabled' => FALSE,
		'slide_link' => '',
	);

	/**
	 * Initialization point for the configuration
	 * 
	 * @return void No return value
	 */
	static public function init_config() {
		parent::init_config();
		static::set_config( 'id', 'wpp-slideshow-slide' );
		static::set_config( 'post_type', 'wpp-slideshow-slide' );
		static::set_config( 'post_type_name_single', 'Slideshow Slide' );
		static::set_config( 'post_type_name_plural', 'Slideshow Slides' );
		static::set_config( 'post_type_description', '' );
		static::set_config( 'post_type_is_public', FALSE );
		static::set_config( 'post_type_rewrite', FALSE );
	}

	/**
	 * Method for getting multiple posts
	 */
	static public function get_posts( $args ) {
		$slides = parent::get_posts( wpp_array_merge_nested ( 
			array( 
				'post_type'      => static::get_config( 'post_type' ),
				'post_status'    => 'publish',
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'nopaging'       => TRUE,
				'posts_per_page' => -1,
			),
			$args
		) );
		foreach ( $slides as &$slide ) {
			$slide->post_content_decoded = json_decode( $slide->post_content, TRUE );
			$slide->post_content_decoded['slide_post_id'] = $slide->ID;
		}
		return $slides;
	}

	/**
	 * Method for getting the post
	 */
	static public function get_post( $id, $output = 'OBJECT', $filter = 'raw' ) {
		$slide = parent::get_post( $id, $output, $filter );
		if ( empty( $slide ) ) {
			return $slide;
		}
		if ( 'OBJECT' === $output ) {
			$slide->post_content_decoded = json_decode( $slide->post_content, TRUE );
			$slide->post_content_decoded['slide_post_id'] = $slide->ID;
		} else if ( 'ARRAY_A' === $output ) {
			$slide[ 'post_content_decoded' ] = json_decode( $slide[ 'post_content' ], TRUE );
			$slide[ 'post_content_decoded' ]['slide_post_id'] = $slide[ 'ID' ];
		}
		return $slide;
	}

	/**
	 * Method for inserting/updating post
	 */
	static public function insert_post( $post, $wp_error = FALSE ) {
		$metadata_key_slide_type = static::get_config( 'metadata_key_slide_type' );
		! empty( $post['post_content_decoded'] ) or $post['post_content_decoded'] = array();
		$post['post_content_decoded'] = wpp_array_merge_nested(
			static::$_default_data,
			$post['post_content_decoded']
		);
		$data = &$post['post_content_decoded'];
		$insert_post_return = parent::insert_post( 
			wpp_array_merge_nested(
				array(
					'ID'             => ('false' === $data[ 'slide_post_id' ] ? NULL : $data[ 'slide_post_id' ] ),
					'post_content'   => json_encode( $data ),
					'post_name'      => '',
					'post_title'     => wp_strip_all_tags( ( empty( $data[ 'slide_title' ] ) ? '' : $data[ 'slide_title' ] ) ),
					'post_status'    => 'publish',
					'post_type'      => static::get_config( 'post_type' ),
					'post_excerpt'   => ( empty( $data[ 'slide_caption' ] ) ? '' : $data[ 'slide_caption' ] ),
					'comment_status' => 'closed',
				),
				$post
			),
			TRUE
		);
		if ( ! is_wp_error( $insert_post_return ) && ! empty( $data[ 'slide_image_id' ] ) && 'false' !== $data[ 'slide_image_id' ] ) {
			add_post_meta( $insert_post_return, '_thumbnail_id', $data[ 'slide_image_id' ], TRUE ) || update_post_meta( $insert_post_return, '_thumbnail_id', $data[ 'slide_image_id' ] );
		}
		if ( ! is_wp_error( $insert_post_return ) && ! empty( $data[ 'slide_type' ] ) && ! empty( $metadata_key_slide_type ) ) {
			add_post_meta( $insert_post_return, $metadata_key_slide_type, $data[ 'slide_type' ], TRUE ) || update_post_meta( $insert_post_return, $metadata_key_slide_type, $data[ 'slide_type' ] );
		}

		if ( $wp_error ) {
			return $insert_post_return;
		} else if ( ! is_wp_error( $insert_post_return ) ) {
			return $insert_post_return;
		} else {
			return FALSE;
		}
	}

	/**
	 * Method for deleting data
	 */
	static public function delete_post( $post_id, $force_delete = TRUE ) {
		return parent::delete_post( $post_id, $force_delete );
	}

}