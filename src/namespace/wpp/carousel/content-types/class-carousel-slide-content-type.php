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
		'post_id' => 'false',
		'image' => NULL,
		'image_id' => 'false',
		'title' => NULL,
		'caption' => NULL,
		'order_id'  => 0,
	);

	/**
	 * 
	 */
	static public function get_posts( $options ) {
		$slides_query = new \WP_Query( wpp_array_merge_nested ( 
			array( 
				'post_type'      => static::POST_TYPE,
				'post_status'    => 'publish',
				'order'          => 'ASC',
				'order_by'       => 'menu_order',
				'nopaging'       => TRUE,
				'posts_per_page' => -1,
			),
			$options
		) );
		$slides = ( empty( $slides_query->posts ) ? array() : $slides_query->posts );
		wp_reset_postdata();
		foreach ( $slides as &$slide ) {
			$slide->post_content_decode = json_decode( $slide->post_content, TRUE );
		}
		return $slides;
	}

	/**
	 * 
	 */
	static public function save_post( $data, $options ) {
		$data = wpp_array_merge_nested(
			static::$_default_data,
			$data
		);
		$insert_post_return = wp_insert_post( 
			wpp_array_merge_nested(
				array(
					'ID'             => ('false' === $data[ 'post_id' ] ? NULL : $data[ 'post_id' ] ),
					'post_content'   => json_encode( $data ),
					'post_name'      => '',
					'post_title'     => wp_strip_all_tags( ( empty( $data[ 'title' ] ) ? '' : $data[ 'title' ] ) ),
					'post_status'    => 'publish',
					'post_type'      => static::POST_TYPE,
					'menu_order'     => ( empty( $data[ 'order_id' ] ) ? 0 : $data[ 'order_id' ] ),
					'post_excerpt'   => ( empty( $data[ 'caption' ] ) ? '' : $data[ 'caption' ] ),
					'comment_status' => 'closed',
				),
				$options
			),
			TRUE
		);
		if ( ! is_wp_error( $insert_post_return ) && ! empty( $data[ 'image_id' ] ) && 'false' !== $data[ 'image_id' ] ) {
			add_post_meta( $insert_post_return, '_thumbnail_id', $data[ 'image_id' ], TRUE ) || update_post_meta( $insert_post_return, '_thumbnail_id', $data[ 'image_id' ]);
		}
	}

	/**
	 * 
	 */
	static public function delete_post( $post_id, $options = array() ) {
		wp_delete_post( $post_id, TRUE );
	}

}