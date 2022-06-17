<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.janushenderson.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 * @author     Janus Henderson <webtechteam@janushenderson.com>
 */
class Jh_Nyt_Top_Stories_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		wp_schedule_event(time() + 5 * 60,'hourly', 'nyt_get_stories');
		nyt_register_custom_post ();
		flush_rewrite_rules();
		//add custom meta fields
	

	}
function nyt_register_custom_post () {
		 register_post_type('nytstories1',
        array(
            'labels'      => array(
                'name'          => __( 'NYT Top Stories1', 'textdomain' ),
                'singular_name' => __( 'NYT Top Story1', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
			'exclude_from_search' =>true,
			'supports' => ['title', 'editor', 'custom-fields']
        )
    );
		
		
	}
	//add function for custom meta tags
	//
}
