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
        $this->image["title"] = "";
        $this->image["height"] = 0;
        $this->image["width"] = 0;
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
        echo "<pre>";
        var_dump($this->dataObject);
        echo "</pre>";
    }

    public function get( $size = "medium", $value = "all" ){
        if( $value === "all" ){
            return $this->image;
        }
    }
}
