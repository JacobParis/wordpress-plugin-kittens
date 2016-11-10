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

		wp_enqueue_script( $this->trial_project, plugin_dir_url( __FILE__ ) . 'js/trial-project-public.js', array( 'jquery' ), $this->version, false );

	}


	public function display_records() {
		return "#YOLO";
	}
	public function display_featured_post($id) {
		$link = get_post_meta($id, 'Reddit Link', true);
      if($link) {
          $url      = "https://www.reddit.com/{$link}/_";
          $response = wp_remote_get( esc_url_raw( $url . ".json?sort=top&limit=3&depth=1" ) );

          /* Will result in $api_response being an array of data,
          parsed from the JSON response of the API listed above */
          $api_response = json_decode( wp_remote_retrieve_body( $response ), true );
          $thread = $api_response[0]['data']['children'][0]['data'];

          echo '<a id="reddit" href="'.$url.'">';
					echo '  <div class="r-op">';
					echo '    <div class="r-header r-meta">' . $thread['title'] . " by <strong>" . $thread['author'] . '</strong></div>';
					echo '    <div class="r-body">';
					echo '			<span>' . $thread['selftext'] . '</span>';
					echo '    </div>'; //Close .r-body
					echo '  </div>'; //Close .r-op

    			$comments = array_slice($api_response[1]['data']['children'],0,3);
    			foreach($comments as $commentHeader) {
      			$comment = $commentHeader['data'];
						$score = $comment['score'] == 1 ? $comment['score'] . " point" : $comment['score'] . " points";
						$num_replies = $comment['replies'] ? $comment['replies']['data']['children'][0]['data']['count'] : 0;
						$replies = $num_replies == 1 ? $num_replies . " reply" : $num_replies . " replies";
						$replies = $num_replies ? ' and ' . $replies : "";
      			echo '<div class="r-comment">';
		        echo '  <div class="r-meta">';
						echo '	  <strong>' . $comment['author'] . ' </strong>';
						echo 		  $score;
						echo 		  $replies;
						echo '	</div>'; //Close .r-meta
		        echo '  <div class="r-body">';
						echo '			<span>' . $comment['body'] . '</span>';
						echo '  </div>'; //Close .r-body
		        echo '</div>';
    			}
					/* Join the discussion action prompt */
					echo '<div class="r-comment">';
					echo '  <div class="r-meta">';
					if($thread['num_comments'] - count($comments) > 0) {
						echo '	<strong>View ' . ($thread['num_comments'] - count($comments)) . ' more comments and join the discussion by clicking here!</strong>';
					} else {
						echo '	<strong>Join the discussion by clicking here!</strong>';
					}
					echo '	</div>'; // Close .r-meta
					echo '</div>'; //Close .r-comment
					echo '</a>'; //Close #reddit
				}
	}

}
