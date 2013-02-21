<?php

/**
 * Plugin Name: WP Scripts
 * Plugin URI: http://wpsmith.net
 * Description: Use the Font Awesome icon set within WordPress. Icons can be inserted using either HTML or a shortcode.
 * Version: 3.0.1
 * Author: Travis Smith
 * Author URI: http://wpsmith.net
 *
 * License:
 * Copyright (C) 2012  Travis Smith
 * 
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 * 
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * WP Smith Scripts Class
 *
 */
class WPS_Scripts {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance;
	
	/**
	 * Holds a copy of the handles.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $handles = array();
	
    /**
     * Constructor Method
     * 
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
    }
	
	/**
      * Builds style suffix for font awesome CSS files based on WP_DEBUG or SCRIPT_DEBUG
      * 
      * @param string $script Base name of file
      * 
      * @return string $script Full file name
      */
	public function suffix( $script ) {
	
		$script  = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? $script . '.css' : $script . '.min.css';

		return $script;
	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}

}

// Instantiate
$_wp_font_awesome = new WP_Font_Awesome();