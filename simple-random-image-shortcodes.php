<?php namespace mitogh\github\com;

if( !function_exists('random_images_shortcode') ){
	function random_images_shortcode( $atts ) {
		$data = shortcode_atts( array(
			'total'  =>  1,
			'size'    => 'medium',
			'alt'     => false,
			'class'   => '',
			'id'      => '',
			'after'   => '',
			'before'  => ''
		), $atts );
		$randomImage = new Simple_Random_Image();

		if($data['total'] <= 0 || $data['total'] > 1000){
			$data['total'] = 1;
		}
		$randomImage->right_size( $data['size'] );
		$output = "\n";

		for($i = 1; $i <= $data['total']; $i++){
			$image = $randomImage->get($data['size']);

			if( $image == null ){
				break;
			}

			if( $data['before'] && strlen( $data['before'] ) ){
				$output .= $data['before'] . "\n";
			}

			$output .= "<img src='" . $image['url'] . "'";
			if( $data['alt'] ){
				$output .= " alt='" . $image['alt'] . "'";
			}
			if( $data['class'] ){
				$output .= " class='" . $data['class'] . "'";
			}
			if( $data['id'] ){
				$output .= " id='" . $data['id'] . "'";
			}
			$output .= ">\n";

			if( $data['after'] && strlen( $data['after'] ) ){
				$output .= $data['after'] . "\n" ;
			}
		}
		return $output;
	}
}

if( !function_exists('random_image_shortcode') ){
	function random_image_shortcode( $atts ) {
		$data = shortcode_atts( array(
			'total'   => 1,
			'size'    => 'medium',
			'alt'     => false,
			'class'   => '',
			'id'      => '',
			'after'   => '',
			'before'  => ''
		), $atts );

		return random_images_shortcode( $data );
	}
}

add_shortcode( 'random-images', __NAMESPACE__ . '\random_images_shortcode' );
add_shortcode( 'random-image', __NAMESPACE__ . '\random_image_shortcode' );
