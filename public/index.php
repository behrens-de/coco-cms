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
define('TEMPLATENAME', Templates::name());
define('TEMPLATE_ERROR', '404');
define('TEMPLATE_PATH', __DIR__ . '/../template/' . TEMPLATENAME . '/');


// $lastSlash = $cocopage->uri[strlen($cocopage->uri) - 1];
// $lastSlash === '/' ? true: false;
// $cocopage->uri = $lastSlash ? rtrim($cocopage->uri, "/"):$cocopage->uri;


// echo $cocopage->domain;
// echo $cocopage->uri;
$css = $cocopage->domain . PREFIX . '/src/css/main.css';
//

// var_dump($_SESSION);

$templateFile =  $cocopage->isPage() ? TEMPLATE : TEMPLATE_ERROR;
include(TEMPLATE_PATH . $templateFile . '.php');






function dirToArray($dir)
{
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", "..", ".DS_Store"))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
}

$files = dirToArray(__DIR__ . '/../template/Lari Fari');


function printArrayList($array)
{
    $output = '';
    $output .= "<ul>";

    foreach($array as $k => $v) {
        if (is_array($v)) {
            $output .=  "<li>" . $k . "</li>";
            $output .= printArrayList($v);
            continue;
        }
        $output .=  "<li>" . $v . "</li>";
    }

    $output .=  "</ul>";

    return $output;
}
?>

<style>
    ul{
        margin: 0;
        margin-left: 2px;
        padding: 0;
        border-left: 3px solid #999;
    }
    li{
        margin: 0;
        padding: 3px 10px;
        list-style: none;
    }
    li:hover{
        background: #eee;
    }
</style>
<?
echo printArrayList($files);