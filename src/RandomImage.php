<?php namespace mitogh;

/**
 * Class that abstracts the process to retrieve random images from the entiry
 * library of attachments or from a specifc post.
 *
 * @since 1.0.0
 */
class RandomImage {

	/**
	 * Default mime types of images this can be overwrite by using the filter
	 * mitogh_rand_image_mime_type.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $mime_types
	 */
	private $mime_types = array(
		'image/jpeg',
		'image/gif',
		'image/png',
		'image/bmp',
		'image/tiff',
	);

	/**
	 * Default values that the user can overwrite when he creates a new instance
	 * of the class that allow to have custom results, for example:
	 *
	 * - count, specifies the number of images to be returned
	 * - parent_ID, here you can specify the ID from where retrive the images null to
	 *				retrieve the images from the entire library.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $defaults
	 */
	private $defaults = array(
		'count' => 1,
		'parent_ID' => null,
	);

	/**
	 * This are the default values to be used in the WP_Query function to query
	 * into the DB it will return always the ID of each attachment.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $query_args
	 */
	private $query_args = array(
		'posts_per_page' => 1,
		'orderby' => 'rand',
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_parent' => null,
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'fields' => 'ids',
	);

	/**
	 * PHP5 Constructor.
	 *
	 * @param array $args The list of arguments passed to the file, you can use,
	 *			inside of an associative array, with the following keys.
	 *				- count, specifies the number of images to be returned
	 *				- parent_ID, here you can specify the ID from where retrive the images null to
	 *					retrieve the images from the entire library.
	 *
	 * @since 1.0.0
	 */
	public function __construct( array $args = array() ) {
		$this->defaults = wp_parse_args( $args, $this->defaults );
		$this->parse_defaults_into_query_args();
	}

	/**
	 * Updates the $query_args array with the data passed by the user and the
	 * filter before run the query into the DB.
	 *
	 * @since 1.0.0
	 */
	private function parse_defaults_into_query_args() {
		$this->query_args['posts_per_page'] = $this->defaults['count'];
		$this->query_args['post_parent'] = $this->defaults['parent_ID'];
		$this->query_args['post_mime_type'] = apply_filters(
			'mitogh_rand_image_mime_type',
			$this->mime_types
		);
	}

	/**
	 * Runs the query into the DB and returns the IDs of each image in a rand order.
	 *
	 * @since 1.0.0
	 *
	 * @return array An array with the IDs of each random image
	 */
	public function get_ids() {
		$query = $this->query();
		return $query->have_posts() ? $query->posts : array();
	}

	/**
	 * Return an array of random src from the images, you can specify the size
	 * of the images to be returned.
	 *
	 * @since 1.0.0
	 *
	 * @param string $size The size of the image to retrieve.
	 * @return array An array with the src attribute of each image.
	 */
	public function get_srcs( $size = 'thumbnail' ) {
		$ids = self::get_ids();
		$srcs = array();
		foreach ( $ids as $image_id ) {
			$data = wp_get_attachment_image_src( $image_id, $size );
			if ( is_array( $data ) ) {
				$srcs[] = $data[0];
			}
		}
		return $srcs;
	}

	/**
	 * Runs the query into the DB using WP_Query
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Query The result of the query.
	 */
	private function query() {
		return new \WP_Query( $this->query_args );
	}
}
