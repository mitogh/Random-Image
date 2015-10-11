<?php namespace mitogh\github\com;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Simple_Random_Image{

    private $dataObject = null;

    private $image = array(
      'url'     => '',
      'alt'     => '',
      'height'  => 0,
      'width'   => 0
    );

    public function generate(){
        $args = array(
            'numberposts'       => 1,
            'orderby'           => 'rand',
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_status'       => null,
            'post_parent'       => null
        );

        $attachments = get_posts( $args );
        if( $attachments ){
            $this->dataObject = $attachments[0];
        }
    }

    public function right_size( &$size ){
        if( $size && $size != 'thumbnail' && $size != 'large' && $size != 'full'){
            $size = 'medium';
        }
    }

    public function fill( $size = 'medium' ){
        if( $this->dataObject != null ){
            $this->right_size( $size );

            $data = $this->dataObject;
            // Retrive the info from this attachment
            $image = wp_get_attachment_image_src( $data->ID, $size );

            if( count( $image ) ){
                $this->image['url']     = $image[0];
                $this->image['width']   = $image[1];
                $this->image['height']  = $image[2];
                $this->image['alt']     = $data->post_title;
            }
        }
    }

    private function create( $size = 'medium' ){
        $this->generate();
        $this->fill( $size );
    }

    public function get( $size = 'medium' ){
        $this->create( $size );
        return $this->image;
    }

    public function get_url( $size = 'medium' ){
        $this->create( $size );
        if( $image != null ) {
            return $image['url'];
        } else {
            return '';
        }
    }
}
