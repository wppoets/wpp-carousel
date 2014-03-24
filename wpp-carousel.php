<?php
/**
 * Plugin Name: WPP Carousel
 * Plugin URI: http://wppoets.com/plugins/carousel.html
 * Description: TODO...
 * Version: 0.9
 * Author: WP Poets <plugins@wppoets.com>
 * Author URI: http://wppoets.com
 * License: GPLv2 (dual-licensed)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <plugins@wppoets.com>
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

defined( 'WPP_CAROUSEL_VERSION_NUM' )       or define( 'WPP_CAROUSEL_VERSION_NUM', '0.9.0' );
//defined( 'WPP_CAROUSEL_ASSETS_VERSION_NUM') or define( 'WPP_CAROUSEL_ASSETS_VERSION_NUM', WPP_CAROUSEL_VERSION_NUM ); 
defined( 'WPP_CAROUSEL_ASSETS_VERSION_NUM') or define( 'WPP_CAROUSEL_ASSETS_VERSION_NUM', date('YmdHis') ); // Devolopment Only
defined( 'WPP_CAROUSEL_TEXT_DOMAIN' )       or define( 'WPP_CAROUSEL_TEXT_DOMAIN', 'wpp-carousel' );
defined( 'WPP_CAROUSEL_PLUGIN_FILE' )       or define( 'WPP_CAROUSEL_PLUGIN_FILE', __FILE__ );
defined( 'WPP_CAROUSEL_PLUGIN_PATH' )       or define( 'WPP_CAROUSEL_PLUGIN_PATH', dirname(__FILE__ ) );
defined( 'WPP_CAROUSEL_NAMESPACE_PATH' )    or define( 'WPP_CAROUSEL_NAMESPACE_PATH', WPP_CAROUSEL_PLUGIN_PATH . '/src/namespace' );
defined( 'WPP_CAROUSEL_FUNCTION_PATH' )     or define( 'WPP_CAROUSEL_FUNCTION_PATH', WPP_CAROUSEL_PLUGIN_PATH . '/src/functions' );
defined( 'WPP_CAROUSEL_FILTER_FILE' )       or define( 'WPP_CAROUSEL_FILTER_FILE', 'wpp-carousel/wpp-carousel.php' );

//Include the required function files
require_once( WPP_CAROUSEL_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'common.php' );
require_once( WPP_CAROUSEL_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-carousel-autoloader.php' );
require_once( WPP_CAROUSEL_FUNCTION_PATH . DIRECTORY_SEPARATOR . 'wpp-carousel-helper.php' );

//Make the magic happen!
WPP\Carousel\Plugin::init();
