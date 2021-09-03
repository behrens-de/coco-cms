<?
class Header{

    function __construct($data, $ispage)
    {
        $this->data = $data;
        $this->ispage = $ispage;
    }  


    public function load(){
        return ($this->ispage) ? $this->default() :     header("HTTP/1.0 404 Not Found");
    }

    private function default(){
        return '<!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="La LA LA">
            <title>' . $this->data->title . '</title>
        
            <style>
            body{color: #444;}
            li{padding: 5px;}
            .active{
                background: green;
            }
            a{
                text-decoration: none;
                color: green;
            }
            .active a{
                color: #fff;
            }
            </style>
        
        </head>
        <body>
        ';
    }

}