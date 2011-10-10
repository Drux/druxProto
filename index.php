<?php
#LIBS
include_once("libs/template.php");
#CONFIG
include_once("config.php");

#ENGINE
include_once("engine/content.php");
include_once("engine/footer.php");
include_once("engine/header.php");
include_once("engine/nav.php");
include_once("engine/sidebar.php");


##MAIN LAYOUT TEMPLATE
$mainTpl = new template();
$mainTpl->templatepath = "templates/";
$mainTpl->contentpath = "content/";
$mainTpl->set_file($mainTpl->templatepath."layout/main.tpl");


#CREATE CONTENT
$header = new header($mainTpl);
$nav = new nav($mainTpl);
$sidebar = new sidebar($mainTpl, $nav);
$content = new content($mainTpl, $nav);
$footer = new footer($mainTpl);

#POPULATE HEAD
$mainTpl->set_var("TPL_VAR_SITE_TITLE", $nav->breadcrumb);
$mainTpl->set_var("TPL_VAR_STYLESHEET", STYLESHEET);



#POPULATE BODY
$mainTpl->set_var("TPL_VAR_HEADER", $header->toString());

$mainTpl->set_var("TPL_VAR_NAV", $nav->toString());
$mainTpl->set_var("TPL_VAR_SIDEBAR", $sidebar->toString());
$mainTpl->set_var("TPL_VAR_CONTENT", $content->toString());
$mainTpl->set_var("TPL_VAR_FOOTER", $footer->toString());

echo $mainTpl->parse();

?>