<?php
/**
 * Generates a list of random images from 1 to N such as N < 1000
 * allowing to set the total of images to display, also the size 
 * and the alt for each image is optional, the default values are:
 * 1 image, size: medium, alt as false. 
 *
 * Example of usage:
 * [random-images number=10 size="large", alt=true]
 */
function random_images_shortcode( $atts ) {
    $data = shortcode_atts( array(
        'total'  =>  1,
        'size'    => 'medium',
        'alt'     => false

    ), $atts );
    $randomImage = new Simple_Random_Image();

    // Limit number of images
    if($data['total'] <= 0 || $data['total'] > 1000){
      $data['total'] = 1;
    }
    // Check for right values
    $data['size'] = $randomImage->rightSize($data['size']);
    // HTML OUTPUT;
    $output = "\n";

    for($i = 0; $i < $data['total']; $i++){
      $image = $randomImage->get($data['size']);
      // Open image tag
      $output .= "<img src='" . $image['url'] . "'";
      if($data['alt']){
        $output .= " alt='" . $image['alt'] . "' ";
      }
      // Close the image tag
      $output .= ">\n";
    }
    return $output;
}
add_shortcode( 'random-images', 'random_images_shortcode' );
