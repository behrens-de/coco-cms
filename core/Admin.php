<?
class Admin
{

    static function firstRun($path, $post)
    {

        $isCorrect = $post["password"] === $post["password2"] && (strlen($post["name"]) > 2 && strlen($post["password2"]) > 7) ? true : false;
        $hash = password_hash($post["name"] . $post["password"], PASSWORD_DEFAULT);

        if ($isCorrect) {
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

    static function checkLogin($post)
    {
        $file = json_decode(file_get_contents(__DIR__ . '/../private/settings/settings.json', true));
        $admin = $file->admin;
        return password_verify($post["name"] . $post["password"], $admin->hash) ? true : false;
    }

    static function html_head(string $title)
    {
        return '
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $title . '</title>
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
        $end = Admin::html_end();
        return $header.$contnet.$end;
        
    }
}
