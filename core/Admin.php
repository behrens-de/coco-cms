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

    static function data($path)
    {
        return json_decode(file_get_contents($path, true));
    }

    static function html_head(string $title)
    {

        $page = new Page();

        $cssURI = $page->domain . '/public/admin/src/style.css';
        return '
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
            <link rel="stylesheet" href="' . $cssURI . '">
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
        if ($contnet) {
            // SET THE ADMIN NAME
            $contnet = str_replace("{NAME}", ucfirst($_SESSION["admin"]["name"]), $contnet);
            $contnet = str_replace("{GREETING}", Admin::greeting(), $contnet);
            $contnet = str_replace("{ADMINMENU}", Admin::adminMenu(), $contnet);
            $contnet = str_replace("{BREADCRUMBS}", Admin::breadcrumbs(), $contnet);
        } else {
            $contnet = "Diese Seite ist nicht verfügbar";
        }

        $end = Admin::html_end();
        return $header . $contnet . $end;
    }


    static function greeting()
    {
        $Hour = date('H');

        if ($Hour >= 5 && $Hour <= 11) {
            $greeting =  "Guten Morgen ";
        } else if ($Hour >= 12 && $Hour <= 18) {
            $greeting =  "Guten Tag ";
        } else if ($Hour >= 19 || $Hour <= 4) {
            $greeting =  "Guten Abend ";
        } else {
            $greeting = 'Hallo';
        }
        return $greeting;
    }

    static function adminMenu()
    {
        $items = array(
            array("icon" => "far fa-file", "label" => "Seiten", "uri" => "pages"),
            array("icon" => "fas fa-list", "label" => "Navigation", "uri" => "menus"),
            array("icon" => "fas fa-user-cog", "label" => "Einstellungen", "uri" => "settings"),
            array("icon" => "fas fa-code", "label" => "Templates", "uri" => "templates"),
            array("icon" => "far fa-folder", "label" => "Datein", "uri" => "files"),
            array("icon" => "fas fa-users", "label" => "Benutzer", "uri" => "users"),
            array("icon" => "far fa-envelope", "label" => "Newsletter", "uri" => "newsletter"),
        );

        $page = new Page();

        $adminUri = $page->domain . '/public/admin/';

        $output = "";
        foreach ($items as $item) {
            $output .= '
            <li>
            <a href="' . $adminUri . $item["uri"] . '">
                <div class="icon"><i class="' . $item["icon"] . '"></i></div>
                <div class="label">' . $item["label"] . '</div>
            </a>
        </li> ';
        }
        return $output;
    }


    static function breadcrumbs()
    {

        $page = new Page();
        $adminUri = $page->domain . '/public/admin/';
        $output = '<li><a href="' . $adminUri . '">'.strtoupper("Dashboard").'</a></li>';


        $uri = explode('/admin', $page->uri);
        $uri = explode('/', $uri[1]);

        $uriCount = count($uri) - 1;

        while ($uriCount > 0) {

            $output .= '
            <li>
                <a href="' . $adminUri . $uri[$uriCount] . '">' . strtoupper($uri[$uriCount]) . '</a>
            </li>
        ';

            $uri[$uriCount];
            $uriCount--;
        }

        // if($uriCount > 0){
        //     foreach ($uri as $index => $myuri) {
        //         $output .= '<li>
        //         <a href="'.$adminUri.$uri[$index].'">+'.$index.$uriCount.'</a>
        //         </li>';
        //     } 
        // } else {}
        return '<ul class="admin-breadcrumb">DU BIST HIER: ' . $output . '</ul>';
    }
}
