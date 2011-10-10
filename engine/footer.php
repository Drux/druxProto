<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Roger
 * Date: 5/23/11
 * Time: 4:16 PM
 * To change this template use File | Settings | File Templates.
 */
 
class footer {
    function footer($mainTpl){

        $this->mainTpl = $mainTpl;

        $this->tpl = new Template();
        $this->tpl->set_file($this->mainTpl->templatepath."footer.tpl");

        # START SET_VAR

        # END SET_VAR
    }

    function toString(){
        return $this->tpl->parse();
    }
}

?>