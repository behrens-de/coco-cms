<?php
session_start();
$SID = session_id();
//---------------------------
spl_autoload_register(function ($name) {
    require(__DIR__ . '/../core/' . $name . '.php');
});

// definiert den Server prefix zb. https://expamle.de{/prefix}/beispiel/
define('PREFIX', '/public');


//---------------------------
$cocopage = new Page();
$cocodata = $cocopage->data();
$cocomenu = new Menu($cocopage->pages, $cocopage->uri);
$cocoheader = new Header($cocodata, $cocopage->isPage());

echo $cocoheader->load();

// TEMPLATE INFORMATION
// TODO: Prüfen ob das gewählte template auch vorhanden ist
define('TEMPLATE', ($cocodata->template ? $cocodata->template : 'default'));
define('TEMPLATENAME', 'coco-one');
define('TEMPLATE_ERROR', '404');
define('TEMPLATE_PATH', __DIR__ . '/../template/'.TEMPLATENAME.'/');

$templateFile =  $cocopage->isPage() ? TEMPLATE : TEMPLATE_ERROR;
include(TEMPLATE_PATH . $templateFile . '.php');