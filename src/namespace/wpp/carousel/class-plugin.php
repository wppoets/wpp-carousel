<?php namespace WPP\Carousel;
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
 * Starting point for the plugin
 * 
 * Everything about the plugin starts here.
 * 
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * 
 */
class Plugin extends \WPP\Carousel\Base\Plugin {
	
	/** Used to set the plugins ID */
	const ID = 'wpp-carousel';

	/** Used to set the plugins ID */
	const CACHE_GROUP = self::ID;

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;
	
	/** Used to enable shortcode function */	
	const SHORTCODE_ENABLE = TRUE;
	
	static private $_slide_content_type = "\WPP\Carousel\Content_Types\Carousel_Slide_Content_Type";

	/** Default carousel options */
	static private $_default_carousel_options = array(
		'id' => '',
		'title' => '',
		'slug' => '',
		'carousel_id' => '',
	);

	static private $_slide_tyes = array(
		'static' => "\WPP\Carousel\Slide_Types\Static_Slide_Type",
	);

	static private $_view_tyes = array(
		'bootstrap_3' => "\WPP\Carousel\View_Types\Bootstrap_3_View_Type",
	);

	/**
	 * Initialization point for the static class
	 * 
	 * @return void No return value
	 */
	static public function init() {
		parent::init( array(
			'admin_controllers' => array( 
				"\WPP\Carousel\Admin", 
			),
			'admin_controller_options' => array(
				"\WPP\Carousel\Admin" => array(
					'cache_group' => static::CACHE_GROUP,
					'content_type' => \WPP\Carousel\Content_Types\Carousel_Content_Type::POST_TYPE,
					'delete_cache_content_type_exception' => array(
						\WPP\Carousel\Content_Types\Carousel_Slide_Content_Type::POST_TYPE,
					),
				),
			),
			'content_types' => array(
				"\WPP\Carousel\Content_Types\Carousel_Content_Type",
				"\WPP\Carousel\Content_Types\Carousel_Slide_Content_Type",
			),
			'content_type_options' => array(
				"\WPP\Carousel\Content_Types\Carousel_Content_Type" => array(
					'slide_types' => self::$_slide_tyes,
				),
			),
			'meta_boxes' => array(
				"\WPP\Carousel\Meta_Boxes\Carousel_Meta_Box",
				"\WPP\Carousel\Meta_Boxes\Carousel_Slide_Meta_Box",
			),
			'meta_box_options' => array(
				"\WPP\Carousel\Meta_Boxes\Carousel_Meta_Box" => array(
					'view_types' => self::$_view_tyes,
				),
				"\WPP\Carousel\Meta_Boxes\Carousel_Slide_Meta_Box" => array(
					'data_content_type' => "\WPP\Carousel\Content_Types\Carousel_Slide_Content_Type",
					'include_post_types' => \WPP\Carousel\Content_Types\Carousel_Content_Type::POST_TYPE,
					'slide_types' => self::$_slide_tyes,
				),
			),
		) );
	}
	
	/**
	 * WordPress action method for processing the shortcode
	 * 
	 * The method processes the shortcode command
	 * 
	 * @return string Returns the results of the shortcode
	 */
	static public function action_shortcode( $atts, $content='' ) {
		$shortcode_tag = static::SHORTCODE_TAG;
		if ( empty( $shortcode_tag ) ) {
			$shortcode_tag = static::ID;
		}
		$options = shortcode_atts( 
			self::$_default_carousel_options,
			$atts,
			$shortcode_tag
		);
		return static::get_carousel( $options );
	}

	/**
	 * Display method for the carousel
	 * 
	 * The method processes the shortcode command
	 * 
	 * @return string Returns the results of the shortcode
	 */
	static public function display_carousel( $options ) {
		if ( ! static::is_initialized() ) {
			trigger_error( __( 'Plugin not initialized.', static::TEXT_DOMAIN ), E_USER_NOTICE);
			return;
		}
		print( static::get_carousel( $options ) );
	}

	/**
	 * Get method for the carousel
	 * 
	 * The method for returning the carousel
	 * 
	 * @return void No return value
	 */
	static public function get_carousel( $options ) {
		if ( ! static::is_initialized() ) {
			trigger_error( __( 'Plugin not initialized.', static::TEXT_DOMAIN ), E_USER_NOTICE);
			return;
		}
		$options = wpp_array_merge_options(
			self::$_default_carousel_options,
			$options
		);
		wpp_debug( $options );

		$return_value = wp_cache_get( $options['id'], static::ID );
		if ( $return_value !== FALSE ) {
			wpp_debug( "{static::ID}:{$options['id']} - Return cached carousel" );
			return $return_value;
		}
		wpp_debug( "{static::ID}:{$options['id']} - No cache avalable, must build" );
		$return_value = '';

		$slides = array();
		$content_type = self::$_slide_content_type;
		$raw_slides = $content_type::get_posts( array(
			'post_parent' => $options['id'],
		) );
		foreach ( $raw_slides as &$raw_slide ) {
			$raw_slide_type = NULL;
			if ( ! empty( $raw_slide->post_content_decoded['slide_type'] ) && ! empty( self::$_slide_tyes[ $raw_slide->post_content_decoded['slide_type'] ] ) ) {
				$raw_slide_type = self::$_slide_tyes[ $raw_slide->post_content_decoded['slide_type'] ];
			}
			if ( ! empty( $raw_slide_type ) && class_exists( $raw_slide_type ) && method_exists( $raw_slide_type, 'get_slides' ) ) {
				$new_slides = $raw_slide_type::get_slides( $raw_slide );
				$slides = array_merge( $slides, $new_slides);
			}
		}
		$return_value = \WPP\Carousel\View_Types\Bootstrap_3_View_Type::get_carousel_view( array( 
			'slides' => $slides,
			'carousel_id' => $options[ 'carousel_id' ],
			'show_controls' => TRUE,
		) );
		wpp_debug( $return_value );
		
		return $return_value;
	}
}
