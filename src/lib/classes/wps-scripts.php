<?php

/**
 * WPS Scripts Class
 *
 */
if ( !class_exists( 'WPS_Scripts' ) ) {
abstract class WPS_Scripts {
	
	/**
	 * Plugin Name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin_name = '';
	
	/**
	 * Suppress suffix.
	 *
	 * @since 0.0.1
	 *
	 * @var boolean
	 */
	public $suffix_suppres = false;
	
	/**
	 * Github repo name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin = 'wpsmith/wp-scripts';
	
	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 0.0.1
	 *
	 * @var object
	 */
	protected static $instance;
	
	/**
	 * Holds a copy of the handles.
	 *
	 * @since 0.0.1
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
     * Updater
     * 
     */
	protected function updater() {

		include_once 'updater/updater.php';

		define( 'WP_GITHUB_FORCE_UPDATE', true );
		
		$config = array(
			'slug'               => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'wp-scripts',
			'api_url'            => sprintf( 'https://api.github.com/repos/%s', $this->plugin ),
			'raw_url'            => sprintf( 'https://raw.github.com/%s/master/build', $this->plugin ),
			'readme_raw_url'     => sprintf( 'https://raw.github.com/%s/master', $this->plugin ),
			'github_url'         => sprintf( 'https://github.com/%s', $this->plugin ),
			'zip_url'            => sprintf( 'https://github.com/%s/blob/master/build/wp-font-awesome.zip?raw=true', $this->plugin ),
			'sslverify'          => false,
			'requires'           => '3.0',
			'tested'             => '3.5.2',
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
	public function suffix_css( $script ) {
	
		$script  = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( $this->suppress_suffix ) ) ? $script . '.css' : $script . '.min.css';

		return $script;
	}
	
	/**
      * Builds style suffix for font awesome CSS files based on WP_DEBUG or SCRIPT_DEBUG
      * 
      * @param string $script Base name of file
      * 
      * @return string $script Full file name
      */
	public function suffix_js( $script ) {
	
		$script  = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( $this->suffix_suppres ) ) ? $script . '.js' : $script . '.min.js';

		return $script;
	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 0.0.1
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}

}
}
