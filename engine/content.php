<?php

class content {
    var $pageTitle;

    function content($mainTpl, $nav){
        $this->mainTpl = $mainTpl;
        $this->nav = $nav;

        $this->tpl = new template();

        if($contentFolder= opendir($this->mainTpl->contentpath)){
            while (false !== ($dir = readdir($contentFolder))){
                if($dir != "." || $dir != ".."){
                    $pregDir = preg_replace('/\\[[^\\]]*\\]/', '', $dir);
                    if($pregDir == $this->nav->getMain()){
                        if($this->nav->getSub() != ""){
                            if($mainFolder = opendir($this->mainTpl->contentpath.$dir."/")){
                                while (false !== ($file = readdir($mainFolder))){
                                    if($file != "." || $file != ".."){
                                        $pregFile = preg_replace("/\\[[^\\]]*\\]/", "", $file);
                                        $fileName = str_replace(".tpl", "", $pregFile);
                                        if($fileName == $this->nav->getSub()){
                                            $this->tpl->set_file($this->mainTpl->contentpath.$dir."/".$file);
                                        }
                                    }
                                }
                            }
                        }else{
                            $this->tpl->set_file($this->mainTpl->contentpath.$dir."/index.tpl");
                        }
                    }
                }
            }
        }
    }

    function toString(){
        return $this->tpl->parse();
    }
}

?>