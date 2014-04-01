<?php namespace WPP\Slideshow\Content_Types;
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
class Slideshow_Content_Type extends \WPP\Slideshow\Base\Content_Type {

	/** Used to store the post-type id*/
	const POST_TYPE = 'wpp-slideshow';

	/** Used to store the singular form of the name */
	const NAME_SINGLE = 'Slideshow';

	/** Used to store the plural form of the name */
	const NAME_PLURAL = 'Slideshows';

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_SLIDESHOW_TEXT_DOMAIN;

	///** Used by register_post_type args */
	//const DESCRIPTION = '';

	///** Used by register_post_type args */
	//const IS_PUBLIC = TRUE;

	/** Used by register_post_type args */
	const EXCLUDE_FROM_SEARCH = TRUE;

	/** Used by register_post_type args */
	const PUBLICLY_QUERYABLE = FALSE;
	
	/** Used by register_post_type args */
	const SHOW_UI = TRUE;

	/** Used by register_post_type args */
	const SHOW_IN_NAV_MENUS = TRUE;

	/** Used by register_post_type args */
	const SHOW_IN_MENU = TRUE;

	/** Used by register_post_type args */
	const SHOW_IN_ADMIN_BAR = TRUE;

	///** Used by register_post_type args */
	//const MENU_POSITION = NULL;

	/** Used by register_post_type args */
	const MENU_ICON = 'dashicons-images-alt2';

	///** Used by register_post_type args */
	//const CAPABILITY_TYPE = 'post';

	///** Used by register_post_type args */
	//const MAP_META_CAP = TRUE;

	///** Used by register_post_type args */
	//const HIERARCHICAL = FALSE;

	/** Used by register_post_type args, comma delimited */
	const SUPPORTS = 'title';

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

	/** Used to disable the quick edit box */
	const DISABLE_QUICK_EDIT = TRUE;

	///** Used to enable cascade delete */
	const ENABLE_CASCADE_DELETE = TRUE;

	/**
	 * Initialization point for the static class
	 *
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		parent::init( wpp_array_merge_nested(
			array(
				'args' => array(
					'rewrite' => FALSE,
				),
			),
			$options
		) );
	}

	/**
	 * Method for inserting/updating post
	 */
	static public function insert_post( $post, $wp_error = FALSE ) {
		return parent::insert_post( $post, $wp_error );
	}

	/**
	 * Method for deleting data
	 */
	static public function delete_post( $post_id, $force_delete = FALSE ) {
		return parent::delete_post( $post_id, $force_delete );
	}

	/**
	 * Method for getting the post
	 */
	static public function get_post( $id, $output = 'OBJECT', $filter = 'raw' ) {
		$post = parent::get_post( $id, $output, $filter );
		$options = static::get_options();
		if ( empty( $post ) || empty( $options[ 'metadata_key_data' ] ) ) {
			return $post;
		}
		if ( 'OBJECT' === $output ) {
			$post->carousel_data = json_decode( get_post_meta( $post->ID, $options[ 'metadata_key_data' ], TRUE ), TRUE );
		} else if ( 'ARRAY_A' === $output ) {
			$post[ 'carousel_data' ] = json_decode( get_post_meta( $post[ 'ID' ], $options[ 'metadata_key_data' ], TRUE ), TRUE );
		}
		return $post;
	}

	/**
	 * Method for getting multiple posts
	 */
	static public function get_posts( $args ) {
		return parent::get_posts( $args );
	}

}