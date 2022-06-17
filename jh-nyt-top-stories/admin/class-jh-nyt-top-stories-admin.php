<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.janushenderson.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/admin
 * @author     Janus Henderson <webtechteam@janushenderson.com>
 */
class Jh_Nyt_Top_Stories_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jh_Nyt_Top_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jh_Nyt_Top_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jh-nyt-top-stories-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jh_Nyt_Top_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jh_Nyt_Top_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jh-nyt-top-stories-admin.js', array( 'jquery' ), $this->version, false );

	}

	 function Jh_Nyt_Top_Stories_Get_Stories () {
			  require ABSPATH . '/wp-admin/includes/post.php';
		$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.nytimes.com/svc/topstories/v2/home.json?api-key=KxkgpxsV3z8uAxmbuAKaFdfFcJ9gAl3I',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);
	
	$object = json_decode($response);

	
$string ='';
	
 foreach ($object as $key=>$returned )  {
	

	 if  ($key =='results')  {
		   foreach ($returned as $key2=>$story )  {
			 	$fount_post = post_exists( $story->title,'','','nytstories');
			
			   if  (!$fount_post ) {
				  	$my_post = array(
				  'post_title'    => wp_strip_all_tags(  $story->title),
				  'post_excerpt'  =>  $story->abstract,
					 'post_content'  =>  $story->abstract,
				  'post_status'   => 'publish',
				 'post_date' =>  $story->published_date,
					'post_type'=> 'nytstories',
					'meta_input' => [ 'url'=> $story->url , 'byline' =>$story->byline ],
					 'tags_input' =>$story->des_facet
					);

				
				wp_insert_post( $my_post );
				   
				 $insert_id = wp_insert_post($id);
			 wp_set_object_terms($insert_id, $story->section, 'category', true);
				   //doesn't work properly
			
			   }
			
	
		  }
	
	 }
 	
	
 }

	}
	
	function nyt_shortcode_plugin() { 
 
$args = array(
    'post_type' => 'nytstories',
		 'posts_per_page' => 5,
		 'orderby' => 'date',
    'order'   => 'DESC'
);
$query = new WP_Query( $args );
	

if ( $query->have_posts() ) {
    echo '<ul>';
    while ( $query->have_posts() ) {
		$byline =  get_post_meta( get_the_ID(), 'byline', true ); 
		$url =  esc_url( get_post_meta( get_the_ID(), 'url', true ) ); 
		
        $query->the_post();
        echo '<li><a href="' . $url .'" target="_blank">' . get_the_title() . '</a><br><i>' . $byline. '</i></li>';
    }
    echo '</ul>';
}
wp_reset_postdata();
	
  
}
	
}
