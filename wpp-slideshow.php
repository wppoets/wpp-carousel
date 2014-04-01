<?php
/**
 * Plugin Name: WPP Slideshow with Carousel
 * Plugin URI: http://wppoets.com/plugins/slideshow.html
 * Description: Adds a slideshow content type to your WordPress installation. With an easy to use interface you can add a slides to a carousel for displaying on your website.
 * Version: 0.9.0
 * Author: WP Poets <plugins@wppoets.com>
 * Author URI: http://wppoets.com
 * License: GPLv2 (dual-licensed)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <copyright@wppoets.com>
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
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
defined( 'ABSPATH' ) or die(); // We should not be loading this outside of wordpress

defined( 'WPP_SLIDESHOW_VERSION_NUM' )       or define( 'WPP_SLIDESHOW_VERSION_NUM', '0.9.0' );
//defined( 'WPP_SLIDESHOW_ASSETS_VERSION_NUM') or define( 'WPP_SLIDESHOW_ASSETS_VERSION_NUM', WPP_SLIDESHOW_VERSION_NUM ); 
defined( 'WPP_SLIDESHOW_ASSETS_VERSION_NUM') or define( 'WPP_SLIDESHOW_ASSETS_VERSION_NUM', date('YmdHis') ); // Devolopment Only
defined( 'WPP_SLIDESHOW_TEXT_DOMAIN' )       or define( 'WPP_SLIDESHOW_TEXT_DOMAIN', 'wpp-slideshow' );
defined( 'WPP_SLIDESHOW_PLUGIN_FILE' )       or define( 'WPP_SLIDESHOW_PLUGIN_FILE', __FILE__ );
defined( 'WPP_SLIDESHOW_PLUGIN_PATH' )       or define( 'WPP_SLIDESHOW_PLUGIN_PATH', dirname(__FILE__ ) );
defined( 'WPP_SLIDESHOW_NAMESPACE_PATH' )    or define( 'WPP_SLIDESHOW_NAMESPACE_PATH', WPP_SLIDESHOW_PLUGIN_PATH . '/src/namespace' );
defined( 'WPP_SLIDESHOW_FUNCTION_PATH' )     or define( 'WPP_SLIDESHOW_FUNCTION_PATH', WPP_SLIDESHOW_PLUGIN_PATH . '/src/functions' );
defined( 'WPP_SLIDESHOW_FILTER_FILE' )       or define( 'WPP_SLIDESHOW_FILTER_FILE', 'wpp-slideshow/wpp-slideshow.php' );

//Include the required function files
require_once( WPP_SLIDESHOW_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'common.php' );
require_once( WPP_SLIDESHOW_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-slideshow-autoloader.php' );
require_once( WPP_SLIDESHOW_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-slideshow-helper.php' );

//Make the magic happen!
\WPP\Slideshow\Plugin::init();
