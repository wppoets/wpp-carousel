<?php namespace WPP\Carousel\Slide_Type;
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
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
class Static_Slide_Type extends Base_Slide_Type {

	/** Used by has_image() */
	const HAS_IMAGE = TRUE;

	/** Used by allow_image_change() */
	const ALLOW_IMAGE_CHANGE = TRUE;
	
}
