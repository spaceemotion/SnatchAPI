<?php

  class Model{
    private $header;
    private $footer;
    
    public function __construct(){
      
    }
    
    public function setHeader($file){
      $this->header = $file;
    }
    
    public function setFooter($file){
      $this->footer = $file;
    }
    
    public function &getHeader(){
      return $this->header;
    }
    
    public function &getFooter(){
      return $this->footer;
    }
  }

?>