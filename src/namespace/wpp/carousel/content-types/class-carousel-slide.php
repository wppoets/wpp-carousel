<?php namespace WPP\Carousel\Content_Types;
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
class Carousel_Slide extends \WPP\Carousel\Base\Content_Type {

	/** Used to store the post-type id */
	const POST_TYPE= 'wpp-carousel-slide';

	/** Used to store the singular form of the name */
	const NAME_SINGLE = 'Carousel Slide';

	/** Used to store the plural form of the name */
	const NAME_PLURAL = 'Carousel Slides';

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;

	///** Used by register_post_type args */
	//const DESCRIPTION = '';

	/** Used by register_post_type args */
	const IS_PUBLIC = FALSE;

	/** Used by register_post_type args */
	const EXCLUDE_FROM_SEARCH = TRUE;

	/** Used by register_post_type args */
	const PUBLICLY_QUERYABLE  = FALSE;

	/** Used by register_post_type args */
	const SHOW_UI = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_NAV_MENUS = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_MENU = FALSE;

	/** Used by register_post_type args */
	const SHOW_IN_ADMIN_BAR = FALSE;

	///** Used by register_post_type args */
	//const MENU_POSITION = NULL;

	///** Used by register_post_type args */
	//const MENU_ICON = NULL;

	///** Used by register_post_type args */
	//const CAPABILITY_TYPE = 'post';

	///** Used by register_post_type args */
	//const MAP_META_CAP = TRUE;

	///** Used by register_post_type args */
	//const HIERARCHICAL = FALSE;

	/** Used by register_post_type args, comma delimited */
	const SUPPORTS = 'title,excerpt';

	///** Used by register_post_type args, comma delimited */
	//const TAXONOMIES = '';

	///** Used by register_post_type args */
	//const HAS_ARCHIVE = FALSE;

	///** Used by register_post_type args */
	//const PERMALINK_EPMASK = EP_PERMALINK;

	///** Used by register_post_type args */
	//const QUERY_VAR = self::POST_TYPE;

	///** Used by register_post_type args */
	//const CAN_EXPORT = TRUE;

	///** Used by register_post_type args */
	//const SHOW_DASHBOARD = FALSE;

	///** Used to disable the quick edit box */
	//const DISABLE_QUICK_EDIT = FALSE;

	///** Used to enable cascade delete */
	//const ENABLE_CASCADE_DELETE = FALSE;

	// There is nothing special to do for this content type. It is a raw content type used only for storing the slides nothing more

}