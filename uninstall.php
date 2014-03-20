<?php
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <plugins@wppoets.com>
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
 * Plugin uninstaller code
 * 
 * The below code should be run when the user removed the plugin
 * 
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * 
 * @since 0.9.0
 */
if( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	die(); //This file should be run unless we are in wordpress and uninstalling the plugin

/**
 * Helper function for uninstalling the plugin
 * 
 * Want to go through the process of removing the options and any other items in the database
 * 
 * @since 0.9.0
 * @return void No return value
 */
function wpp_carousel_uninstall() {
	
}

wpp_carousel_uninstall();