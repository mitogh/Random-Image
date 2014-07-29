<?php
/**
 * Class for extract a random image from the 
 * library of attachments, allows the different 
 * sizes of images
 */
class Simple_Random_Image{

    /**
     * The object to retrive the data from the library
     */
    private $dataObject = null;

    /**
     * Array with the data of the image independient 
     * of the size of the different sizes, the array
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

    public function rightSize($size){
        if( $size && $size != "thumbnail" && $size != "large" && $size != "full"){
            return "medium";
        }else{
            return $size;
        }
    }


    /**
     *  Fill the $image with the data from the object of 
     *  attachments: url, width, height and alt text.
     */
    public function fill( $size = "medium" ){
        if( $this->dataObject != null ){
            $size = $this->rightSize($size);

            $data = $this->dataObject;
            // Retrive the info from this attachment
            $image = wp_get_attachment_image_src( $data->ID, $size );

            if( count( $image ) ){
                $this->image["url"]     = $image[0];
                $this->image["width"]   = $image[1];
                $this->image["height"]  = $image[2];
                $this->image["alt"] = $data->post_title;
            }
        }
    }

    /**
     * Fill the image with the data of a random image object
     * œparam   string  $size   The size of the image: thumbnail, medium, large or full
     * @return  array           The array with the data of the image.
     */
    public function get( $size = "medium" ){
        $this->generate();
        $this->fill( $size );
        return $this->image;
    }
}
