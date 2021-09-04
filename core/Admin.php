<?
class Admin{

    static function firstRun($path, $post){
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

    static function checkLogin($post){
        $file = json_decode(file_get_contents(__DIR__ . '/../private/settings/settings.json', true));
        $admin = $file->admin;
        return password_verify($post["name"].$post["password"], $admin->hash) ? true: false;
 
    }
}