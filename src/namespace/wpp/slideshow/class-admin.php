<?php namespace WPP\Slideshow;
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
class Admin extends \WPP\Slideshow\Base\Admin {

	/** Used to set if the class uses action_save_post */
	const HAS_SAVE_POST = TRUE;

	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		parent::init( wpp_array_merge_nested( 
			array(
				'cache_group' => '',
				'content_type' => '',
				'delete_cache_content_type_exception' => array(),
			),
			$options 
		) );
	}
	

	/**
	 * WordPress action for saving the post
	 * 
	 * @return void No return value
	 */
	static public function action_save_post( $post_id ) {
		if ( ! parent::action_save_post( $post_id ) ) {
			return;
		}
		$post_content_type = get_post_type( $post_id );
		$options = static::get_options();

		// We need to flush the cache for any carousel
		if ( ! in_array( $post_content_type, $options['delete_cache_content_type_exception'] ) ) {
			wpp_debug( "Flushing cache for {$options['cache_group']}" );
			$carousel_posts = new \WP_Query( array(
				'post_type'      => $options['content_type'],
				'post_status'    => 'any',
				'nopaging'       => TRUE,
				'posts_per_page' => -1,
				'fields'         => 'ids',
			) );
			$carousel_post_ids = ( empty( $carousel_posts->posts ) ? array() : $carousel_posts->posts );
			foreach ( (array) $carousel_post_ids as $carousel_post_id ) {
				wp_cache_delete( $carousel_post_id, $options['cache_group'] );
			}
		}
	}

}
