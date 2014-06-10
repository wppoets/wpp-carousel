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
		static::set_config( 'enable_content_types', FALSE );
		static::set_config( 'enable_meta_boxes', FALSE );
		static::set_config( 'enable_shortcodes', FALSE );
	}

}
