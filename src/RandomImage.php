<?php namespace mitogh;

class RandomImage {

	private $mime_types = array(
		'image/jpeg',
		'image/gif',
		'image/png',
		'image/bmp',
		'image/tiff',
	);

	private $defaults = array(
		'count' => 1,
		'parent_ID' => null,
	);

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

	public function __construct( array $args = array() ){
		$this->defaults = wp_parse_args( $args, $this->defaults );
		$this->parse_defaults_into_query_args();
	}

	private function parse_defaults_into_query_args(){
		$this->query_args['posts_per_page'] = $this->defaults['count'];
		$this->query_args['post_parent'] = $this->defaults['parent_ID'];
		$this->query_args['post_mime_type'] = apply_filters(
			'mitogh_rand_image_mime_type',
			$this->mime_types
		);
	}

	public function get_ids(){
		$query = $this->query();
		return $query->have_posts() ? $query->posts : array();
	}

	public function get_srcs( $size = 'thumbnail' ){
		$ids = self::get_ids();
		$srcs = array();
		foreach( $ids as $image_id ) {
			$data = wp_get_attachment_image_src( $image_id, $size );
			if ( is_array( $data ) ) {
				$srcs[] = $data[0];
			}
		}
		return $srcs;
	}

	private function query(){
		return new \WP_Query( $this->query_args );
	}
}
