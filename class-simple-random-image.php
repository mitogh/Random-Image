<?php
/**
 * Class for extract a random image from the library of attachments,
 * allows the different sizes of images
 */
class Simple_Random_Image{

    /**
     * The object to retrive the data from the library
     */
    private $dataObject = null;

    /**
     * Array with the data of the image independient
     * of the size of the different images, the array
     * is as follows.
     */
    private $image = array(
      "url"     => "",
      "alt"     => "",
      "height"  => 0,
      "width"   => 0
    );

    /**
     * Generate a new random object from the library
     */
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

    /**
     * Ensures the use of the right sizes for the images, updating the
     * reference to $size with "medium" if it's different of the default values
     *
     * @param   string  $size   The string with the size of the image
     */
    public function right_size( &$size ){
        if( $size && $size != "thumbnail" && $size != "large" && $size != "full"){
            $size = "medium";
        }
    }

    /**
     *  Fill the $image aarray with the data from the object of
     *  attachments: url, width, height and alt text.
     *
     *  @param  string  $size   The size of the image: thumbnail, medium, large or full
     */
    public function fill( $size = "medium" ){
        if( $this->dataObject != null ){
            $this->right_size( $size );

            $data = $this->dataObject;
            // Retrive the info from this attachment
            $image = wp_get_attachment_image_src( $data->ID, $size );

            if( count( $image ) ){
                $this->image["url"]     = $image[0];
                $this->image["width"]   = $image[1];
                $this->image["height"]  = $image[2];
                $this->image["alt"]     = $data->post_title;
            }
        }
    }

    /**
     * Updates the $image object with a new random image from the library
     *
     * @param   string  $size   The size of the image: thumbnail, medium, large or full
     */
    private function create( $size = "medium" ){
        $this->generate();
        $this->fill( $size );
    }

    /**
     * Generate a new image, calling to the create() method
     *
     * @param   string  $size   The size of the image: thumbnail, medium, large or full
     * @return  array           The array with the data of the image.
     */
    public function get( $size = "medium" ){
        $this->create( $size );
        return $this->image;
    }

    /**
     * Generates a new random imagem calling to the create() method
     *
     * @param   string  $size   The size of the image: thumbnail, medium, large or full
     * @return  string          The url of the image
     */
    public function get_url( $size = "medium" ){
        $this->create( $size );
        if( $image != null ) {
            return $image['url'];
        } else {
            return "";
        }
    }
}
