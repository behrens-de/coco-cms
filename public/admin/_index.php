<?php
session_start();
$SID = session_id();

//---------------------------
spl_autoload_register(function ($name) {
    require(__DIR__ . '/../../core/' . $name . '.php');
});

define('PREFIX', '/public');
//---------------------------
$cocopage = new Page(PREFIX);
$settings = json_decode(file_get_contents(__DIR__ . '/../../private/settings/settings.json', true));
$admin = $settings->admin;



?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="<? echo $cocopage->domain . $cocopage->uri; ?>/src/style.css">
    <link rel="icon" type="image/png" href="<? echo $cocopage->domain; ?>/public/img/base/coco-cms-icon.png">
</head>

<body>
    <div class="page">
        <div>
            <h1>LOGO</h1>

        </div>
        <div>

       
            <?
            //var_dump($admin);

  if (isset($_POST) && $_POST["user"] === $admin->user && $_POST["pswd"] === $admin->pwd) {
                $_SESSION['login'] = true;
            } 

            echo $_SESSION['login'] === true ? '
            <h1>Willkommen User</h1>
            <a href="">Abmelden</a>
            ': '
            <form method="post" class="coco-login">
            <h1>Login</h1>
            <label for="">Username</label>
            <input type="text" name="user" id="">
            <label for="">Passwort</label>
            <input type="password" name="pswd" id="">
            <button type="submit">LOG IN</button>
        </form>';
          
?>
          
        </div>
        <div>
            <div class="copy">
                copyright 2021 by COCO CMS
            </div>
        </div>

    </div>
</body>

</html>