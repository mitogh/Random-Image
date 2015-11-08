<?php namespace mitogh;

class Query{
	private $args = array(
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

	public function __construct( $args = array() ){
		$args = is_array( $args ) ? $args : array();
		$this->args = wp_parse_args( $args, $this->args );
	}

	public function run(){
		$query = new \WP_Query( $this->args );
		return $query->have_posts() ? $query->posts : [];
	}
}

