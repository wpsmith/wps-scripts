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
	protected $css_handles = array();
	
	/**
	 * Holds a copy of the handles.
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	protected $js_handles = array();
	
    /**
     * Constructor Method
     * 
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
    }
	
	/**
     * Hooks plugin into all basic
     * 
     * @todo Updater doesn't need to run on every admin page
     */
    public function plugins_loaded() {
		
		// Updater
		//add_action( 'admin_init', array( $this, 'updater' ) );
		
		// Register Styles
        add_action( 'init', array( $this, 'register_scripts' ) );
        
		// Enqueue Styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
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
      * Returns name of library with underscores.
      * 
      * @return string Name of library with underscores.
      */
	protected function _lib_name() {
		return $this->library;
	}
	
	/**
     * Register Conditional Style
     * 
     * @param array  $args      Array of args for wp_register_style().
	 * @param string $condition Condition for style output.
     */
    public function register_conditional_style( $args, $condition ) {
        global $wp_styles;
		
		$defaults = array(
			'handle' => '',
			'src'    => false,
			'deps'   => array(),
			'ver'    => false,
			'media'  => false,
		);
		$args = wp_parse_args( $args, $defaults );
		
		if ( is_array( $args ) ) {
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
			$wp_styles->add_data( $args['handle'], 'conditional', $condition );
		}
    }
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 0.0.1
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
	
	/**
     * Enqueue Styles
     * 
	 * This method must be re-defined in the extended class, to output the main
	 * admin page content.
     */
	abstract public function register_scripts();
	
	/**
     * Enqueue Styles
     * 
	 * This method must be re-defined in the extended class, to output the main
	 * admin page content.
     */
	abstract public function enqueue_scripts();
	
	/**
     * Enqueue Script
     * 
	 * This method must be re-defined in the extended class, to output the main
	 * admin page content.
     */
	abstract protected function activation();
}
}
