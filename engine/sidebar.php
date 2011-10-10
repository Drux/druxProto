<?php
class sidebar{
    function sidebar($mainTpl, $nav){
        $this->mainTpl = $mainTpl;
        $this->nav = $nav;
        $this->tpl = new template();

        $this->tpl->set_file($this->mainTpl->templatepath."sidebar.tpl");

        # START SET_VAR

        if(NAV_TYPE == 2 || NAV_TYPE == 3){
            $this->tpl->set_var("TPL_VAR_SIDEBAR_NAVIGATION", $this->nav->buildSidebarNavString($this->mainTpl->contentpath));
        }else{
            $this->tpl->set_var("TPL_VAR_SIDEBAR_NAVIGATION", "");
        }

        # END SET_VAR
    }
    function toString(){
        return $this->tpl->parse();
    }
}
?>