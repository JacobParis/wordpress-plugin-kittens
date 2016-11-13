<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Trial_Project
 * @subpackage Trial_Project/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Trial_Project
 * @subpackage Trial_Project/public
 * @author     Your Name <email@example.com>
 */
class Trial_Project_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $trial_project    The ID of this plugin.
	 */
	private $trial_project;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $fnames    The current version of this plugin.
	 */
	public $actions;

	public $aliases;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $trial_project       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $trial_project, $version ) {

		$this->trial_project = $trial_project;
		$this->version = $version;

	}

	/**
	 * Initialise the LESS include process.
	 *
	 * @since    1.0.0
	 */
	function enqueue_less_styles($tag, $handle) {
	    global $wp_styles;
	    $match_pattern = '/\.less$/U';
	    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
	        $handle = $wp_styles->registered[$handle]->handle;
	        $media = $wp_styles->registered[$handle]->args;
	        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
	        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
	        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

	        $tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
	    }
	    return $tag;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trial_Project_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trial_Project_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_style( $this->trial_project, plugin_dir_url( __FILE__ ) . 'css/trial-project-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trial_Project_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trial_Project_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 /** UNCOMMENT THIS LINE TO ENABLE PARSING LESS
		 wp_enqueue_script( $this->trial_project, 'https://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.1/less.min.js');
		 **/

		wp_enqueue_script( $this->trial_project, plugin_dir_url( __FILE__ ) . 'js/trial-project-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Display records when the shortcode is called.
	 *
	 * @since    1.0.2
	 */
	public function display_records() {


		//Check which letters contain posts
		$indexes = array();
		$terms = get_terms(array(
			"taxonomy" => 'kitten_index'
		));

		if($terms) {
			foreach($terms as $index) {
				$indexes[] = $index;
			}
		}

		//Jump to:
		echo '<nav class="kittens-indexes">';
		foreach(range('A', 'Z') as $i) {
			foreach($indexes as $term) {
				if($term->name == $i) {
					//A B C [...etc...] X Y Z
					printf('<a href="#%s"><button>%s</button></a>', $i, $i );
				} else continue;
			}
		}
		echo '</nav>';


		foreach($indexes as $term) {
			echo '<section>';
			// Letter Heading
			printf('<header id="%s" class="letter-heading">%s</header>', $term->name, $term->name);
			//Insert kittens
			echo '<ul class="letter-items">';

			$args = array(
				'post_type' => 'kitten',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'kitten_index',
						'field' => 'name',
						'terms' => $term->name
					)
				)
			);

			$kittens = get_posts( $args );

			foreach($kittens as $kitten) {
				//Open Kitten
				echo '<li>';
				// Photo
				echo '<div class="photo">'.get_the_post_thumbnail($kitten, 'large').'</div>';

				//Open meta -- this ensures name and story remain below Photo
				echo '<div class="meta">';
				// Title
				echo '<span class="name">'.$kitten->post_title.'</span>';

				// Story snippet if present
				if($kitten->post_content) {
					echo '<p class="story">'.$kitten->post_content.'</p>';
				}

				//End meta
				echo '</div>';
				//End kitten
				echo '</li>';
			}

			//End kittens
			echo '</ul>';
			echo '</section>';
		}
	}
}
