<?php
class nav{
    var $nav = Array();


    function nav($mainTpl){
        $this->mainTpl = $mainTpl;

        $this->breadcrumb = SITE_NAME;
        $this->tpl = new template();

        $this->tpl->set_file($this->mainTpl->templatepath."nav.tpl");

        # START SET_VAR
        $this->tpl->set_var("TPL_VAR_NAVIGATION", $this->buildNavString($this->mainTpl->contentpath));
        # END SET_VAR
    }

    function fixChar($name){
        $newName = str_replace("ae", "&aelig;", $name);
        $newName = str_replace("aa", "&aring;", $newName);
        $newName = str_replace("oe", "&oslash;", $newName);
        $newName = str_replace("Ae", "&Aelig;", $newName);
        $newName = str_replace("Aa", "&Aring;", $newName);
        $newName = str_replace("Oe", "&Oslash;", $newName);
        return $newName;
    }

    function getMain(){
        if(isset($_REQUEST["main"]) && $_REQUEST["main"] != ""){
            $main = $_REQUEST["main"];
        }else{
            $main = HOME_SITE_CONTENT_FOLDER;
        }
        return $main;
    }

    function getSub(){
        if(isset($_REQUEST["sub"]) && $_REQUEST["sub"] != ""){
            $sub = $_REQUEST["sub"];
        }else{
            $sub = "";
        }
        return $sub;
    }


    function buildNavArray($contentFolder){
        if ($dirHandle = opendir($contentFolder)) {
            while (false !== ($dir = readdir($dirHandle))) {
                if ($dir != "." && $dir != ".." && $dir != ".DS_Store"){
                    preg_match('/\\[[^\\]]*\\]/', $dir, $matches);
                    $mainIndex = $matches[0];
                    $pregDir = preg_replace('/\\[[^\\]]*\\]/', '', $dir);
                    $folderName = $this->fixChar($pregDir);
                    $pages = array();
                    if ($handle = opendir($contentFolder."/".$dir)) {
                        while (false !== ($file = readdir($handle))) {
                            if ($file != "." && $file != ".." && $file != ".DS_Store" && $file != "index.tpl") {
                                preg_match('/\\[[^\\]]*\\]/', $file, $matches);
                                $subIndex = $matches[0];
                                $pregFile = preg_replace('/\\[[^\\]]*\\]/', '', $file);
                                $filename = $this->fixChar(str_replace(".tpl", "", $pregFile));
                                $sub = str_replace(".tpl", "", $pregFile);
                                $pages[] = array("index" => $subIndex, "name" => ucfirst($filename), "sub" => $sub, "subFile" => $pregFile);
                            }
                        }
                        closedir($handle);
                    }
                    $this->nav[] = array("index" => $mainIndex, "name" => ucfirst($folderName), "main" => $pregDir, "subPages" => $pages);
                }
            }
            closedir($dirHandle);
        }
        sort($this->nav);
    }


    function buildNavString($contentFolder){
        $this->buildNavArray($contentFolder);
        $navString = '<ul class="clearfix">';

        for($i = 0; $i < count($this->nav); $i++){
            if($this->getMain() == $this->nav[$i]["main"]){
                $navString .= '<li class="currentMain"><a href="index.php?main='.$this->nav[$i]["main"].'">'.$this->nav[$i]["name"].'</a>';
                $this->breadcrumb .= BREADCRUMB_SEPERATOR.$this->nav[$i]["name"];
            }else{
                $navString .= '<li><a href="index.php?main='.$this->nav[$i]["main"].'">'.$this->nav[$i]["name"].'</a>';
            }

            if(NAV_TYPE == 1 || NAV_TYPE == 3){
                $navString .= '<ul class="clearfix">';
                for($j = 0; $j < count($this->nav[$i]["subPages"]); $j++){
                    if($this->getSub() == $this->nav[$i]["subPages"][$j]["sub"]){
                        $navString .= '<li class="currentSub"><a href="index.php?main='.$this->nav[$i]["main"].'&sub='.$this->nav[$i]["subPages"][$j]["sub"].'">'.$this->nav[$i]["subPages"][$j]["name"].'</a></li>';
                        $this->breadcrumb .= BREADCRUMB_SEPERATOR.$this->nav[$i]["subPages"][$j]["name"];
                    }else{
                        $navString .= '<li><a href="index.php?main='.$this->nav[$i]["main"].'&sub='.$this->nav[$i]["subPages"][$j]["sub"].'">'.$this->nav[$i]["subPages"][$j]["name"].'</a></li>';
                    }
                }
                $navString .= '</ul>';
            }
            $navString .= '</li>';
        }
        $navString .= '</ul>';
        return $navString;
    }

    function buildSidebarNavString($contentFolder){
        $this->buildNavArray($contentFolder);
        $main = $this->getMain();
        $navSet = false;

        $navString = "";


        for($i = 0; $i < count($this->nav); $i++){
            if($this->nav[$i]["main"] == $main && !$navSet){
                $navString .= SIDEBAR_NAVIGATION_HEADER.'<ul class="clearfix">';
                for($j = 0; $j < count($this->nav[$i]["subPages"]); $j++){
                    if($this->getSub() == $this->nav[$i]["subPages"][$j]["sub"]){
                        $navString .= '<li class="currentSub"><a href="index.php?main='.$this->nav[$i]["main"].'&sub='.$this->nav[$i]["subPages"][$j]["sub"].'">'.$this->nav[$i]["subPages"][$j]["name"].'</a></li>';

                    }else{
                        $navString .= '<li><a href="index.php?main='.$this->nav[$i]["main"].'&sub='.$this->nav[$i]["subPages"][$j]["sub"].'">'.$this->nav[$i]["subPages"][$j]["name"].'</a></li>';
                    }
                }
                $navString .= '</ul>';
                $navSet = true;
            }
        }
        return $navString;
    }

    function toString(){
        return $this->tpl->parse();
    }
}
?>