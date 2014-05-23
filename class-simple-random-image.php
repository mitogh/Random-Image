<?php
/**
 * Class for extract a random image from the 
 * library of attachments, allows the different 
 * sizes of images
 */
class Simple_Random_Image{

    /**
     * The object to retrive the data from the librry
     */
    private $dataObject;
    /**
     * Array with the data of the image independient 
     * of the size of the different sizes, the array
     * is as follows.
     */
    private $image;

    public function __construct(){
        $this->initialize();
        $this->generate();
    }

    /**
     * initialize the values for the member variables
     */
    private function initialize(){
        $this->dataObject = null;
        $this->image = array();

        $this->image["url"] = "";
        $this->image["alt"] = "";
        $this->image["height"] = 0;
        $this->image["width"] = 0;
    }

    /**
     *  Fill the $image with the data from the object of 
     *  attachments
     */
    public function fill($size = "medium"){
        if( $this->dataObject != null ){
            if( $size && $size != "thumbnail" && 
                $size != "large" && $size != "full"){
                $size = "medium";
            }

            $data = $this->dataObject;
            $image = wp_get_attachment_image_src( $data->ID, $size );

            $this->image["alt"] = $data->post_title;
            if( count( $image ) ){
                $this->image["url"]     = $image[0];
                $this->image["width"]   = $image[1];
                $this->image["height"]  = $image[2];
            }
        }
    }

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
     * Fill the image with the data of a random image object
     * œparam   string  $size   The size of the image: thumbnail, medium, large or full
     * @return  array           The array with the data of the image.
     */
    public function get( $size = "medium"){
        $this->fill( $size );
        return $this->image;
    }
}
