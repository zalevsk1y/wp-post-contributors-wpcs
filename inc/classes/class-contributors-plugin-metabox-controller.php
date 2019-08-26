<?php
/**
 * Contributors Plugin metabox controller class
 *
 * @package Controllers
 */

if ( ! class_exists( 'Contributors_Plugin_Metabox_Controller' ) ) {
	/**
	 * Class manage metabox functions
	 *
	 * PHP version 7.0
	 *
	 * @package Controllers
	 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
	 * @license MIT
	 */
	class Contributors_Plugin_Metabox_Controller {
		/**
		 * Template file path for post contributors box template
		 *
		 * @var string
		 */
		protected $post_template;
		/**
		 * Template file path for admin select contributors box template
		 *
		 * @var string
		 */
		protected $admin_template;
		/**
		 * Init function
		 *
		 * @param Contributors_Plugin_Template_Render $admin_template object renders template for admin select contributors box.
		 * @param Contributors_Plugin_Template_Render $post_template object renders template for post contributors box.
		 */
		public function __construct( Contributors_Plugin_Template_Render $admin_template, Contributors_Plugin_Template_Render $post_template ) {
			$this->admin_template = $admin_template;
			$this->post_template  = $post_template;
			$this->add_actions();
		}
		/**
		 * Add WP actions.
		 *
		 * @return void
		 */
		public function add_actions() {
			\add_action( 'save_post', array( $this, 'save_meta_data' ) );
			\add_action( 'the_content', array( $this, 'render_post' ) );
			\add_action( 'add_meta_boxes', array( $this, 'add_contributors_box' ) );
		}
		/**
		 *  Save contributors data to post meta.
		 *
		 * @param int $post_id post id.
		 * @return void|string
		 */
		public function save_meta_data( $post_id ) {
			if ( ! isset( $_POST[ CONTRIBUTORS_PLUGIN_NONCE ] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST[ CONTRIBUTORS_PLUGIN_NONCE ], CONTRIBUTORS_PLUGIN_NONCE_ACTION ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( isset( $_POST[ CONTRIBUTORS_PLUGIN_FIELD ] ) ) {
				$contributors = sanitize_meta( CONTRIBUTORS_PLUGIN_META, $_POST[ CONTRIBUTORS_PLUGIN_FIELD ], 'post' );

				if ( isset( $contributors ) && '' !== $contributors ) {
					update_post_meta( $post_id, CONTRIBUTORS_PLUGIN_META, implode( ',', $contributors ) );
				} else {
					update_post_meta( $post_id, CONTRIBUTORS_PLUGIN_META, '' );
				}
			}
		}
		/**
		 * Render view for post-edit page that allow to add and remove contributors.
		 *
		 * @param int $post WP_Post object.
		 * @return void
		 */
		public function render_post_contributors_box( $post ) {
			$contributors_ids = get_post_meta( $post->ID, CONTRIBUTORS_PLUGIN_META, true );
			$args             = array( 'authors' => get_users( 'orderby=nicename' ) );
			if ( ! empty( $contributors_ids ) ) {
				$contributors_ids     = explode( ',', $contributors_ids );
				$args['contributors'] = $this->get_contributors_data( $contributors_ids );
			}

			echo $this->admin_template->render( $args );
		}
		/**
		 * Add metabox "Contributors" to "post_author_meta".Used in add action.
		 *
		 * @return void
		 */
		public function add_contributors_box() {
			add_meta_box(
				'post_author_meta',
				__( 'Contributors' ),
				array( $this, 'render_post_contributors_box' ),
				'post',
				'side',
				'high'
			);
		}
		/**
		 * Get contributors nickname by id
		 *
		 * @param array $contributors_id  array of user ids that marked as contributors.
		 * @return array of stdClass objects with contributors id and nickname.
		 */
		protected function get_contributors_data( $contributors_id ) {
			$contributors = array();
			foreach ( $contributors_id as $id ) {
				$user = \get_userdata( intval( $id ) );
				if ( $user ) {
					$contributors[] = (object) array(
						'ID'       => $user->ID,
						'nickname' => $user->nickname,
					);
				}
			}
			return $contributors;
		}
		/**
		 * Render contributors list to add to the post content
		 *
		 * @param string $content post content.
		 * @return string
		 */
		public function render_post( $content ) {
			$meta_data = get_post_meta( get_the_ID(), CONTRIBUTORS_PLUGIN_META, true );
			if ( '' === $meta_data ) {
				return $content;
			}
			$contributors = explode( ',', $meta_data );
			$user_data    = array();
			foreach ( $contributors as $contributor ) {
				$contributor_data = get_userdata( $contributor );
				if ( ! $contributor_data ) {
					continue;
				}
				$user_data[] = (object) array(
					'nickname'   => esc_html( $contributor_data->nickname ),
					'link'       => esc_url( get_author_posts_url( $contributor_data->ID ) ),
					'avatar_tag' => get_avatar( $contributor, 40 ),
				);
			}
			$contributors_box = $this->post_template->render( array( 'contributors' => $user_data ) );
			return $content . $contributors_box;
		}
	}
}
