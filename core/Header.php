<?
class Header{

    function __construct($data, $ispage, $domain, $prefix = null)
    {
        $this->data = $data;
        $this->ispage = $ispage;
        $this->domain = $domain;
        $this->prefix = $prefix !== null ? '/'.$prefix: '';
    }  


    public function load(){
        return ($this->ispage) ? $this->default() :     header("HTTP/1.0 404 Not Found");
    }

    private function default(){
        return '<!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            '.$this->version().'
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="La LA LA">
            <title>' . $this->data->title . '</title>
            <link>
            <link rel="icon" type="image/png" href="'.$this->domain.$this->prefix.'/img/base/coco-cms-icon.png">
            <link rel="stylesheet" type="text/css" href="'.$this->domain.$this->prefix.'/src/css/main.css" media="all">
  
        </head>
        <body>
        ';
    }

    private function version(){

        $version = '<!-- 
        ©'.date('Y').' - MADE WITH ♥ IN KARLSRUHE BY JAN BEHRENS
        (COCO CMS v0.0.1) MIT LICENCE // https://github.com/behrens-de/coco-cms
        -->';

        return preg_replace("<[ \\t]+>", " ", $version);
    }

}