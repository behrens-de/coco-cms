<?
# 1 - First Run
$settingFile = __DIR__ . '/../../private/settings/settings.json';
$fileExist = file_exists($settingFile);

if (!$fileExist) 
{
    print '// Create a setting JSON File';
    if(isset($_POST)){
        createSettings($settingFile, $_POST);
    }

?>
    <form action="" method="post">
        <label for="">Benutzername</label>
        <input type="text" name="name" id="">
        <label for="">Passwort</label>
        <input type="password" name="password" id="">
        <button>Button</button>
    </form>
<?

    // Create a setting JSON File
} else {
    print '// Show Login';

    // Show Login
}


function createSettings($path, $post)
{
    
    $data['andmin']["token"] = md5($post["name"].$post["passwort"]);
var_dump($post);
    // $file = fopen($path, 'w');
    // fwrite($file, json_encode($data));
    // fclose($file);
}
