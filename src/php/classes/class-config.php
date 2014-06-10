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
class Config extends \WPP\Slideshow\Base\Instance_Config {

	/**
	 * Initialization point for the configuration
	 * 
	 * Because this is used before the overall config you must 
	 * use the $config class directly
	 *
	 * @return void No return value
	 */
	static public function init_config() {
		parent::init_config();
		//Local config
		static::set_config( 'id', 'wpp-slideshow-config' ); // All instances require an id :)
		//Global config
		static::set_config( 'text_domain', WPP_SLIDESHOW_TEXT_DOMAIN, TRUE );
		static::set_config( 'asset_version', WPP_SLIDESHOW_ASSETS_VERSION, TRUE );
		static::set_config( 'base_url', WPP_SLIDESHOW_BASE_URL, TRUE );
		static::set_config( 'base_scripts_url', WPP_SLIDESHOW_BASE_URL_SCRIPTS, TRUE );
		static::set_config( 'base_styles_url', WPP_SLIDESHOW_BASE_URL_STYLES, TRUE );
		static::set_config( 'extension_js', WPP_SLIDESHOW_EXTENTION_SCRIPTS, TRUE );
		static::set_config( 'extension_css', WPP_SLIDESHOW_EXTENTION_STYLES, TRUE );
		static::set_config( 'meta_key_prefix', '', TRUE );
		static::set_config( 'cache_group', WPP_SLIDESHOW_CACHE_GROUP, TRUE );
	}

}
