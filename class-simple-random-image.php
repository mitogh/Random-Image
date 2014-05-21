<?php
class Simple_Random_Image{

    private $dataObject;
    private $image;

    public function __construct(){
        $this->initialize();
        $this->generate();
    }

    private function initialize(){
        $this->dataObject = null;
        $this->image = array();

        $this->image["url"] = "";
        $this->image["alt"] = "";
        $this->image["height"] = 0;
        $this->image["width"] = 0;
    }

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

    public function get( $size = "medium"){
        $this->fill( $size );
        return $this->image;
    }
}
