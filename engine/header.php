<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Roger
 * Date: 5/23/11
 * Time: 4:16 PM
 * To change this template use File | Settings | File Templates.
 */
 
class header {

    function header($mainTpl){

        $this->mainTpl = $mainTpl;

        $this->tpl = new Template();
        $this->tpl->set_file($this->mainTpl->templatepath."header.tpl");

        # START SET_VAR
        $this->tpl->set_var("TPL_VAR_SITENAME", SITE_NAME);
        # END SET_VAR
    }

    function toString(){
        return $this->tpl->parse();
    }

}

?>