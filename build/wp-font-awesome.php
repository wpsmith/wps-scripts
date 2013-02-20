<?php
/**
 * Plugin Name: WP Font Awesome
 * Plugin URI: https://wpsmith.net
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
 * Font Awesome Class
 *
 */
class WP_Font_Awesome {

	public $handles = array();
	
    /**
     * Constructor Method
     * 
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
    }
	
	/**
     * Hooks plugin into all basic
     * 
     * @todo Updater doesn't need to run on every admin page
     */
    public function plugins_loaded() {
		
		// Updater
		add_action( 'admin_init', array( $this, 'updater' ) );
		
		// Register Styles
        add_action( 'init', array( $this, 'register_styles' ) );
        
		// Enqueue Styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		
		// Add Shortcodes
		add_shortcode( 'icon', array( $this, 'shortcode' ) );
		
		// Add shortcode to widgets
        add_filter( 'widget_text', 'do_shortcode' );
    }
	
	/**
     * Updater
     * 
     */
	function updater() {

		include_once 'updater/updater.php';

		define( 'WP_GITHUB_FORCE_UPDATE', true );
		$plugin = 'wpsmith/WP-Font-Awesome';
		$config = array(
			'slug'               => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'WP-Font-Awesome',
			'api_url'            => sprintf( 'https://api.github.com/repos/%s', $plugin ),
			'raw_url'            => sprintf( 'https://raw.github.com/%s/master', $plugin ),
			'github_url'         => sprintf( 'https://github.com/%s', $plugin ),
			'zip_url'            => sprintf( 'https://github.com/%s/zipball/master', $plugin ),
			'sslverify'          => true,
			'requires'           => '3.0',
			'tested'             => '3.3',
			'readme'             => 'README.md',
			'access_token'       => '',
		);

		$_wp_github_updater = new WP_GitHub_Updater( $config );

	}
	
     /**
      * Builds style suffix for font awesome CSS files based on WP_DEBUG or SCRIPT_DEBUG
      * 
      * @param string $script Base name of file
      * 
      * @return string $script Full file name
      */
	private function suffix( $script ) {
	
		$script  = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? $script . '.css' : $script . '.min.css';

		return $script;
	}
	
	/**
     * Register Font Awesome
     * 
     * Two filters: wp_font_awesome_args & wp_font_awesome_ie7_args
     */
    public function register_styles() {
        global $wp_styles;
		
		$args = apply_filters( 'wp_font_awesome_args', $this->get_args( 'font-awesome' ) );
		wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
		$args = apply_filters( 'wp_font_awesome_ie7_args', $this->get_args( 'font-awesome-ie7' ) );
		wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
        $wp_styles->add_data( $args['handle'], 'conditional', 'lte IE 7' );
    }
	
	/**
     * Register Font Awesome
     * 
     */
	private function get_args( $handle ) {
		$this->handles[] = $handle;
		
		return array(
			'handle' => $handle,
			'src'    => plugins_url( 'lib/css/' . $this->suffix( $handle ), __FILE__  ),
			'deps'   => array(),
			'ver'    => '3.0',
			'media'  => 'all',
		);
	}
	
	/**
     * Enqueue Font Awesome
     * 
     * Style can be prevented via wp_font_awesome_remove custom field.
     */
    public function enqueue_styles() {
		global $post;
		foreach( $this->handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wp_font_awesome_remove', true ) )
				wp_enqueue_style( $handle );
		}
		
    }
	
	/**
     * Font Awesome Shortcode
     * Use: [icon name="icon-pencil"]
     */
    public function shortcode( $atts ) {
		$this->enqueue_styles();
		
        shortcode_atts(
			array(
				'name' => 'icon-wrench',
				'tag'  => 'i',
			), 
			$atts
		);
		
        $icon = '<' . $atts['tag'] . ' class="' . $atts['name'] . '">&nbsp;</' . $atts['tag'] . '>';

        return $icon;
    }

}

// Instantiate
$_wp_font_awesome = new WP_Font_Awesome();
