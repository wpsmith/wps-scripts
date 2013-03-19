<?php

require_once( 'font-awesome.php' );

/**
 * Font Awesome More Class
 * Version: 3.0.1
 *
 */
if ( ! class_exists( 'WPSS_Font_Awesome_More' ) ) {
class WPSS_Font_Awesome_More extends WPSS_Font_Awesome {
	
	/**
	 * Github repo name.
	 *
	 * @since 1.0.0
	 *
	 * @var script
	 */
	public $library = 'font-awesome-more';
	
	/**
	 * Plugin Name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin_name = 'WPS Scripts - Font Awesome More for WordPress';
	
	/**
     * Constructor Method
     * 
     */
    public function __construct() {
        parent::__construct();
		add_action( 'plugins_loaded', array( $this, 'loaded' ) );
    }
	
	/**
     * Hooks plugin into all basic
     * 
     * @todo Updater doesn't need to run on every admin page
     */
    public function loaded() {
		
		// Register Styles
        add_action( 'init', array( $this, 'register_more_scripts' ) );
		
    }

	/**
      * Get all Font Awesome classes raw
      * 
      * WP_Font_Awesome::get_font_classes_raw()
      * 
      * @return array $icons Alpha sorted list of available Font Awesome classes
      */
	static function get_font_classes_raw() {
		// Font Awesome More icons
		$social = array(
			'dropbox', 'drupal', 'git-fork', 'instagram', 'share-this-sign', 'share-this', 'foursquare-sign', 'foursquare', 'hacker-news', 'skype', 'spotify', 'soundcloud', 'paypal', 'youtube-sign', 'youtube', 'reddit', 'blogger-sign', 'blogger', 'dribble-sign', 'dribble', 'evernote-sign', 'evernote', 'flickr-sign', 'flickr', 'forrst-sign', 'forrst', 'delicious', 'lastfm-sign', 'lastfm', 'picasa-sign', 'picasa', 'stack-overflow', 'tumblr-sign', 'tumblr', 'vimeo-sign', 'vimeo', 'wordpress-sign', 'wordpress', 'yelp-sign', 'yelp',
		);
		
		$corp = array(
			'amazon-sign', 'amazon', 'android', 'apple-itunes', 'apple', 'aws', 'bing-sign', 'bing', 'duck-duck-go', 'google-sign', 'google', 'sparrow-sign', 'sparrow', 'windows', 'windows8', 'yahoo',
		);
		
		$ext = array(
			'accessibility-sign', 'bike-sign', 'bus-sign', 'car-sign', 'taxi-sign', 'truck-sign', 'adobe-pdf', 'ms-excel', 'ms-ppt', 'ms-word', 'zip-file', 'css3', 'html5', 'layers', 'map', 'chrome', 'firefox', 'ie', 'opera', 'safari', 'rss-sign',
		);
		
		// Font Awesome icons
		$icons = array(
			// Font Awesome 3.0 icons
			'cloud-download', 'cload-upload', 'lightbulb', 'exchange', 'bell-alt', 'beer', 'coffee', 'food', 'fighter-jet', 'user-md', 'stethoscope', 'suitcase', 'building', 'hospital', 'ambulance', 'medkit', 'h-sign', 'plus-sign-alt', 'spinner', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'double-angle-left', 'double-angle-right', 'double-angle-up', 'double-angle-down', 'circle-blank', 'circle', 'desktop', 'laptop', 'tablet', 'mobile-phone', 'quote-left', 'quote-right', 'reply', 'github-alt', 'folder-close-alt', 'folder-open-alt', 
			
			// Font Awesome 2.0 icons
			'glass', 'music', 'search', 'envelope', 'heart', 'star', 'star-empty', 'user', 'film', 'th-large', 'th', 'th-list', 'ok', 'remove', 'zoom-in', 'zoom-out', 'off', 'signal', 'cog', 'trash', 'home', 'file', 'time', 'road', 'download-alt', 'download', 'upload', 'inbox', 'play-circle', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'indent-left', 'indent-right', 'facetime-video', 'picture', 'pencil', 'map-marker', 'adjust', 'tint', 'edit', 'share', 'check', 'move', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-sign', 'minus-sign', 'remove-sign', 'ok-sign', 'question-sign', 'info-sign', 'screenshot', 'remove-circle', 'ok-circle', 'nam-circle', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'share-alt', 'resize-full', 'resize-small', 'plus', 'minus', 'asterisk', 'exclamation-sign', 'gift', 'leaf', 'fire', 'eye-open', 'eye-close', 'warning-sign', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder-close', 'folder-open', 'resize-vertical', 'resize-horizontal', 'bar-chart', 'twitter-sign', 'facebook-sign', 'camera-retro', 'key', 'cogs', 'comments', 'thumbs-up', 'thumbs-down', 'star-half', 'heart-empty', 'signout', 'linkedin-sign', 'pushpin', 'external-link', 'signin', 'trophy', 'github-sign', 'upload-alt', 'lemon', 
		);
		
		$all = array();
		foreach ( array( 'social' => $social, 'corp' => $corp, 'ext' => $ext, 'default' => $icons, ) as $key => $set ) {
			if ( apply_filters( 'wp_font_awesome_more_' . $key, true ) )
				$all = array_merge( $all, $set );
		}
		
		return asort( $all );
	}
	
	/**
     * Register Font Awesome More
     * 
     */
    public function register_more_scripts() {
		$this->suppress_suffix = true;
		foreach ( array( 'corp', 'ext', 'social', ) as $handle ) {
			if ( apply_filters( 'wp_font_awesome_more_' . $handle, true ) ) {
				$args = $this->get_args( 'font-awesome-' . $handle );
				if ( false !== $args && is_array( $args ) )
					wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
			}
		}
		$this->suppress_suffix = false;
		
		if ( apply_filters( 'wp_font_awesome_more_ie7', true ) ) {
			$args = $this->get_args( $this->library . '-ie7' );
			if ( false !== $args && is_array( $args ) )
				$this->register_conditional_style( $args, 'lte IE 7' );
		}
	}
	
	/**
     * Enqueue Font Awesome More
     * 
     * Style can be prevented via wp_font_awesome_more_remove custom field.
     */
    public function enqueue_scripts() {
		global $post;
		
		foreach( $this->handles as $handle ) {
			if ( 
				! get_post_meta( $post->ID, 'wp_font_awesome_more_remove', true ) && 
				apply_filters( 'wp_font_awesome_more_enqueue', true, $post ) &&
				apply_filters( 'wp_font_awesome_more_' . str_replace( 'font-awesome-more-', '', $handle ), true, $post )
			)
				wp_enqueue_style( $handle );
		}
		
    }
		
}
}