<?php
/**
 * Generates a list of random images from 1 to N such as N < 1000
 * allowing to set the total of images to display, also the size 
 * and the alt for each image is optional, the default values are:
 * 1 image, size: medium, alt as false. 
 *
 * Example of usage:
 * [random-images total=10 size="large", alt=true class="picture"]
 * [random-images total=10 size="large", alt=true id="random"]
 *
 * @param   $atts   Array   The asociative array with the key value pairs
 * @return          String  The HTML with the images
 */
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

        // Limit number of images
        if($data['total'] <= 0 || $data['total'] > 1000){
            $data['total'] = 1;
        }
        // Check for right values
        $randomImage->right_size( $data['size'] );
        // HTML OUTPUT;
        $output = "\n";

        for($i = 1; $i <= $data['total']; $i++){
            $image = $randomImage->get($data['size']);

            if( $image == null ){
                break;
            }

            if( $data['before'] && strlen( $data['before'] ) ){
              $output .= $data['before'] . "\n";
            }

            // Open image tag
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
            // Close the image tag
            $output .= ">\n";

            if( $data['after'] && strlen( $data['after'] ) ){
              $output .= $data['after'] . "\n" ;
            }
        }
        return $output;
    }
}

/**
 * Generates just one image, uses the same method above but
 * just with one image as a total for the images to display.
 *
 * Example of usage:
 * [random-image alt=true size="large" class="picture"]
 *
 * @param   $atts   Array   The asociative array with the value key value pairs
 * @return          String  HTML with the image generated          
 */
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

add_shortcode( 'random-images', 'random_images_shortcode' );
add_shortcode( 'random-image', 'random_image_shortcode' );
