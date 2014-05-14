<?php
class Simple_Random_Image{

    private $imageObject;

    public function __construct(){
        $this->imageObject = null;
        $this->random_image_from_library();
    }

    private function random_image_from_library(){
        $args = array(
            'numberposts'       => 1,
            'orderby'           => 'rand',
            'post_type'         => 'attachment',
            'post_mime_type'    =>'image',
            'post_status'       => null,
            'post_parent'       => null
        );

        $attachments = get_posts( $args );
        if( $attachments ){
            $this->imageObject = $attachments[0];
        }
    }
}
