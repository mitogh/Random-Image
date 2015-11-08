<?php namespace mitogh;

function random_image_src( $size = 'full' ){
	$sources = random_images_src( $size,  1 );
	$src = '';
	foreach( $sources as $image_src ){
		$src = $image_src;
	}
	return $src;
}

function random_images_src( $size = 'full', $total = 1 ){
	$sources = array();
	$ids = random_images_ids( $total );
	foreach( $ids as $image_id ){
		$src = '';
		$data = wp_get_attachment_image_src( $image_id, $size );
		if( $data && ! empty( $data ) ){
			$src = $data[0];
		}
		$sources[] = $src;
	}
	return $sources;
}

function random_images_ids( $total = 1 ){
	$query = new Query( array(
		'post_mime_type' => 'image',
		'posts_per_page' => (int) $total,
	));
	return $query->run();
}
