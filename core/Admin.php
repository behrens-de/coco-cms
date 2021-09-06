<?
class Admin
{

    function cocoKey($length = 25)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static function firstRun($path, $post, $key)
    {

        $isCorrect = $post["password"] === $post["password2"] && (strlen($post["name"]) > 2 && strlen($post["password2"]) > 7
            && filter_var($post["email"], FILTER_VALIDATE_EMAIL)) ? true : false;
        $hash = password_hash($post["name"] . $post["password"], PASSWORD_DEFAULT);

        if ($isCorrect) {
            $data['admin']["email"] = $post["email"];
            $data['admin']["name"] = $post["name"];
            $data['admin']["id"] = $key;
            $data['admin']["hash"] = $hash;
            $file = fopen($path, 'w');
            fwrite($file, json_encode($data));
            fclose($file);
            return true;
        }
        return false;
    }

    static function checkFirstRun($path)
    {
        // Prüft ob es das setting File schon gibt
        return file_exists($path);
    }

    static function checkLogin($post, $path)
    {
        $file = json_decode(file_get_contents($path, true));
        $admin = $file->admin;
        return password_verify($post["name"] . $post["password"], $admin->hash) ? true : false;
    }

    static function data($path){
        return json_decode(file_get_contents($path, true));
    }    

    static function html_head(string $title)
    {

        $here = new Page();
        return '
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
            <link rel="stylesheet" href="' . $here->uri() . '/src/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </head>
        <body>
        ';
    }

    static function html_end()
    {
        return '</body></html>';
    }

    static function html_render(string $contnet, string $title = 'no Title')
    {
        $header = Admin::html_head($title);
        $contnet = file_get_contents($contnet, true);
        // SET THE ADMIN NAME
        $contnet = str_replace("{NAME}", ucfirst($_SESSION["admin"]["name"]), $contnet);
        $contnet = str_replace("{GREETING}", Admin::greeting(), $contnet);
        $end = Admin::html_end();
        return $header . $contnet . $end;
    }


    static function greeting(){
        $Hour = date('H');
  
        if ( $Hour >= 5 && $Hour <= 11 ) {
            $greeting =  "Guten Morgen ";
        } else if ( $Hour >= 12 && $Hour <= 18 ) {
            $greeting =  "Guten Tag ";
        } else if ( $Hour >= 19 || $Hour <= 4 ) {
            $greeting =  "Guten Abend ";
        } else {
            $greeting = 'Hallo';
        }
        return $greeting;
    }


}
