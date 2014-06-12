<?php namespace WPP\Slideshow;
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
class Plugin extends \WPP\Slideshow\Base\Plugin {

	/**
	 * Initialization point for the configuration
	 * 
	 * @return void No return value
	 */
	static public function init_config() {
		static::set_config_instance( Config::init() ); //Required before pretty much anything!
		parent::init_config();
		static::set_config( 'id', 'wpp-slideshow' );
		static::set_config( 'option_key', '' );
		static::set_config( 'option_autoload', FALSE );
		static::set_config( 'enable_admin_controllers', FALSE );
		static::set_config( 'enable_admin_pages', FALSE );
		static::set_config( 'enable_content_types', TRUE );
		static::set_config( 'enable_meta_boxes', FALSE );
		static::set_config( 'enable_shortcodes', FALSE );

		static::set_config( 'slide_types', array(
			'static' => "\WPP\Slideshow\Slide_Types\Static_Image_Slide_Type",
		), TRUE );
		static::set_config( 'view_types', array(
			'bootstrap_3' => "\WPP\Slideshow\View_Types\Bootstrap_3_View_Type",
		), TRUE );

		//Add the admin section
		$admin_section = '\WPP\Slideshow\Admin_Sections\Admin_Section';
		//static::append_config( 'admin_sections', $admin_section );

		//Add the settings admin page
		$settings_admin_page = '\WPP\Slideshow\Admin_Pages\Settings_Admin_Page';
		//static::append_config( 'admin_pages', $settings_admin_page );

		//Add the slideshow content type
		$slideshow_content_type = '\WPP\Slideshow\Content_Types\Slideshow_Content_Type';
		static::append_config( 'content_types', $slideshow_content_type );
		static::set_config( 'metadata_key_data', '_wpp_slideshow_data', $slideshow_content_type );

		//Add the slideshow slide content type
		$slideshow_slide_content_type = '\WPP\Slideshow\Content_Types\Slideshow_Slide_Content_Type';
		static::append_config( 'content_types', $slideshow_slide_content_type );
		static::set_config( 'metadata_key_slide_type', '_wpp_slideshow_slide_type', $slideshow_slide_content_type );

		//Add the settings meta box
		$settings_meta_box = '\WPP\Slideshow\Meta_Boxes\Settings_Meta_Box';
		//static::append_config( 'meta_boxes', $settings_meta_box );

		//Add the slides meta box
		$slides_meta_box = '\WPP\Slideshow\Meta_Boxes\Slides_Meta_Box';
		//static::append_config( 'meta_boxes', $slides_meta_box );

	}

}
