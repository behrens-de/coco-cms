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
$cocopage = new Page(PREFIX);
$cocodata = $cocopage->data();
$cocomenu = new Menu($cocopage->pages, $cocopage->uri());
$cocoheader = new Header($cocodata, $cocopage->isPage(), $cocopage->domain, PREFIX);

print $cocoheader->load();

// TEMPLATE INFORMATION
// TODO: Prüfen ob das gewählte template auch vorhanden ist
define('TEMPLATE', ($cocodata->template ? $cocodata->template : 'default'));
define('TEMPLATENAME', 'coco-one');
define('TEMPLATE_ERROR', '404');
define('TEMPLATE_PATH', __DIR__ . '/../template/'.TEMPLATENAME.'/');


// $lastSlash = $cocopage->uri[strlen($cocopage->uri) - 1];
// $lastSlash === '/' ? true: false;
// $cocopage->uri = $lastSlash ? rtrim($cocopage->uri, "/"):$cocopage->uri;

 
// echo $cocopage->domain;
// echo $cocopage->uri;
$css = $cocopage->domain.PREFIX.'/src/css/main.css';
//

$templateFile =  $cocopage->isPage() ? TEMPLATE : TEMPLATE_ERROR;
include(TEMPLATE_PATH . $templateFile . '.php');