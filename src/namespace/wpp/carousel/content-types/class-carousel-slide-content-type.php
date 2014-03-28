<?php namespace WPP\Carousel\Content_Types;
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
class Carousel_Slide_Content_Type extends \WPP\Carousel\Base\Content_Type {

	/** Used to store the post-type id */
	const POST_TYPE= 'wpp-carousel-slide';

	/** Used to store the singular form of the name */
	const NAME_SINGLE = 'Carousel Slide';

	/** Used to store the plural form of the name */
	const NAME_PLURAL = 'Carousel Slides';

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;

	///** Used by register_post_type args */
	//const DESCRIPTION = '';

	/** Used by register_post_type args */
	const IS_PUBLIC = FALSE;

	/** Used by register_post_type args */
	const EXCLUDE_FROM_SEARCH = TRUE;

	/** Used by register_post_type args */
	const PUBLICLY_QUERYABLE  = FALSE;

	/** Used by register_post_type args */
	const SHOW_UI = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_NAV_MENUS = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_MENU = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_ADMIN_BAR = FALSE;

	///** Used by register_post_type args */
	//const MENU_POSITION = NULL;

	///** Used by register_post_type args */
	//const MENU_ICON = NULL;

	///** Used by register_post_type args */
	//const CAPABILITY_TYPE = 'post';

	///** Used by register_post_type args */
	//const MAP_META_CAP = TRUE;

	///** Used by register_post_type args */
	//const HIERARCHICAL = FALSE;

	/** Used by register_post_type args, comma delimited */
	const SUPPORTS = 'title,excerpt';

	///** Used by register_post_type args, comma delimited */
	//const TAXONOMIES = '';

	///** Used by register_post_type args */
	//const HAS_ARCHIVE = FALSE;

	///** Used by register_post_type args */
	//const PERMALINK_EPMASK = EP_PERMALINK;

	///** Used by register_post_type args */
	//const QUERY_VAR = self::POST_TYPE;

	///** Used by register_post_type args */
	//const CAN_EXPORT = TRUE;

	///** Used by register_post_type args */
	//const SHOW_DASHBOARD = FALSE;

	///** Used to disable the quick edit box */
	//const DISABLE_QUICK_EDIT = FALSE;

	///** Used to enable cascade delete */
	//const ENABLE_CASCADE_DELETE = FALSE;

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
	 * Method for getting multiple posts
	 */
	static public function get_posts( $args ) {
		$slides = parent::get_posts( wpp_array_merge_nested ( 
			array( 
				'post_type'      => static::POST_TYPE,
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
		$meta_box_options = static::get_options();
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
					'post_type'      => static::POST_TYPE,
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
		if ( ! is_wp_error( $insert_post_return ) && ! empty( $data[ 'slide_type' ] ) && ! empty( $meta_box_options['metadata_key_slide_type'] ) ) {
			add_post_meta( $insert_post_return, $meta_box_options['metadata_key_slide_type'], $data[ 'slide_type' ], TRUE ) || update_post_meta( $insert_post_return, $meta_box_options['metadata_key_slide_type'], $data[ 'slide_type' ] );
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