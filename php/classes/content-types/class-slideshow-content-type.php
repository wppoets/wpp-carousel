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
class Slideshow_Content_Type extends \WPP\Slideshow\Base\Content_Type {

	/**
	 * Initialization point for the configuration
	 * 
	 * @return void No return value
	 */
	static public function init_config() {
		parent::init_config();
		static::set_config( 'id', 'wpp-slideshow' );
		static::set_config( 'post_type', 'wpp-slideshow' );
		static::set_config( 'post_type_name_single', 'Slideshow' );
		static::set_config( 'post_type_name_plural', 'Slideshows' );
		static::set_config( 'post_type_description', '' );
		static::set_config( 'post_type_is_public', TRUE );
		static::set_config( 'post_type_show_ui', TRUE );
		static::set_config( 'post_type_show_in_nav_menus', TRUE );
		static::set_config( 'post_type_show_in_menus', TRUE );
		static::set_config( 'post_type_exclude_from_search', TRUE );
		static::set_config( 'post_type_menu_icon', 'dashicons-images-alt2' );
		static::set_config( 'post_type_supports', array('title') );
		static::set_config( 'post_type_rewrite', FALSE );
		static::set_config( 'disable_quick_edit', TRUE );
		static::set_config( 'enable_cascade_delete', TRUE );
		static::set_config( 'enable_dashboard_item_count', TRUE );
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
		$metadata_key_data = static::get_config( 'metadata_key_data' );
		if ( empty( $post ) || empty( $metadata_key_data ) ) {
			return $post;
		}
		if ( 'OBJECT' === $output ) {
			$post->carousel_data = json_decode( get_post_meta( $post->ID, $metadata_key_data, TRUE ), TRUE );
		} else if ( 'ARRAY_A' === $output ) {
			$post[ 'carousel_data' ] = json_decode( get_post_meta( $post[ 'ID' ], $metadata_key_data, TRUE ), TRUE );
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