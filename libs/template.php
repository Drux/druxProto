<?php

class template {
    protected $file = "";
    protected $values = array();

    public $templatepath;
    public $contentpath;

    function set_file($file){
        $this->file = $file;
    }

    function set_var($key, $value){
        $this->values[$key] = $value;

    }

    function parse(){
        if(!file_exists($this->file)){
            return "Could not find the specified Template";
        }else{
            $output = file_get_contents($this->file);

            foreach($this->values as $key => $value){
                $replaceKey = "{".$key."}";
                $output = str_replace($replaceKey, $value, $output);
            }

            return $output;
        }
    }

}

?>