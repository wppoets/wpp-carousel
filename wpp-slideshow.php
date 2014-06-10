<?php
/**
 * Plugin Name: WPP Slideshow with Carousel
 * Plugin URI: https://github.com/wppoets/wpp-slideshow/wiki
 * Description: Adds a slideshow content type to your WordPress installation. With an easy to use interface you can add a slides to a carousel for displaying on your website.
 * Version: 0.1.0
 * Author: WP Poets <wppoets@gmail.com>
 * Author URI: https://github.com/wppoets/
 * License: GPL-2.0 (dual-licensed)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
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
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
defined( 'ABSPATH' ) or die(); // We should not be loading this outside of wordpress

defined( 'WPP_SLIDESHOW_DEBUG' )             or define( 'WPP_SLIDESHOW_DEBUG', TRUE );
defined( 'WPP_SLIDESHOW_VERSION_NUM' )       or define( 'WPP_SLIDESHOW_VERSION_NUM', '0.1.0' );
if ( WPP_SLIDESHOW_DEBUG ) {
	defined( 'WPP_SLIDESHOW_ASSETS_VERSION')     or define( 'WPP_SLIDESHOW_ASSETS_VERSION', date('YmdHis') ); // Devolopment Only
	defined( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS' ) or define( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS', '.js' ); // Devolopment Only
	defined( 'WPP_SLIDESHOW_EXTENTION_STYLES' )  or define( 'WPP_SLIDESHOW_EXTENTION_STYLES', '.css' ); // Devolopment Only
}
defined( 'WPP_SLIDESHOW_ASSETS_VERSION')     or define( 'WPP_SLIDESHOW_ASSETS_VERSION', WPP_SLIDESHOW_VERSION_NUM ); 
defined( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS' ) or define( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS', '.min.js' );
defined( 'WPP_SLIDESHOW_EXTENTION_STYLES' )  or define( 'WPP_SLIDESHOW_EXTENTION_STYLES', '.min.css' );
defined( 'WPP_SLIDESHOW_TEXT_DOMAIN' )       or define( 'WPP_SLIDESHOW_TEXT_DOMAIN', 'wpp-slideshow' );
defined( 'WPP_SLIDESHOW_PLUGIN_FILE' )       or define( 'WPP_SLIDESHOW_PLUGIN_FILE', __FILE__ );
defined( 'WPP_SLIDESHOW_PLUGIN_PATH' )       or define( 'WPP_SLIDESHOW_PLUGIN_PATH', dirname(__FILE__ ) );
defined( 'WPP_SLIDESHOW_NAMESPACE_PATH' )    or define( 'WPP_SLIDESHOW_CLASS_PATH', WPP_SLIDESHOW_PLUGIN_PATH . '/php/classes' );
defined( 'WPP_SLIDESHOW_FUNCTION_PATH' )     or define( 'WPP_SLIDESHOW_FUNCTION_PATH', WPP_SLIDESHOW_PLUGIN_PATH . '/php/functions' );
defined( 'WPP_SLIDESHOW_FILTER_FILE' )       or define( 'WPP_SLIDESHOW_FILTER_FILE', 'wpp-slideshow/wpp-slideshow.php' );
defined( 'WPP_SLIDESHOW_BASE_URL' )          or define( 'WPP_SLIDESHOW_BASE_URL', plugins_url( '', WPP_SLIDESHOW_FILTER_FILE ) );
defined( 'WPP_SLIDESHOW_BASE_URL_SCRIPTS' )  or define( 'WPP_SLIDESHOW_BASE_URL_SCRIPTS', WPP_SLIDESHOW_BASE_URL . '/js/' );
defined( 'WPP_SLIDESHOW_BASE_URL_STYLES' )   or define( 'WPP_SLIDESHOW_BASE_URL_STYLES', WPP_SLIDESHOW_BASE_URL . '/css/' );
defined( 'WPP_SLIDESHOW_CACHE_GROUP' )       or define( 'WPP_SLIDESHOW_CACHE_GROUP', 'wpp-slideshow' );
defined( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS' ) or define( 'WPP_SLIDESHOW_EXTENTION_SCRIPTS', '.min.js' );
defined( 'WPP_SLIDESHOW_EXTENTION_STYLES' )  or define( 'WPP_SLIDESHOW_EXTENTION_STYLES', '.min.css' );

//Include the required function files
require_once( WPP_SLIDESHOW_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-slideshow-autoloader.php' );
require_once( WPP_SLIDESHOW_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-slideshow-helper.php' );

//Make the magic happen!
\WPP\Slideshow\Plugin::init();
