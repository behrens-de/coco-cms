<?
session_start();
$SID = session_id();

spl_autoload_register(function ($name) {
    require(__DIR__ . '/../../core/' . $name . '.php');
});

$page = new Page();
$admin = new Admin();
$adminUri = $page->adminUri(); // the UIT after {DOMAIN}/public/admin

print '<h1>'.$adminUri.'</h1>';
# 1 - First Run
$settingFile = __DIR__ . '/../../private/settings/settings.json';
$fileExist = file_exists($settingFile);

if (!$fileExist) {
    // Create a setting JSON File
    $isCreated = false;

    if (isset($_POST)) {
        $isCreated = $admin::firstRun($settingFile, $_POST);
    }

    if ($isCreated) {
        echo 'Dein Master-Admin Account wurde erstellt<br>
        Du wirst gleich weiter geleitet!';
        // JAVASCRIPT WEITERLEITUNG NACH 2,5 SEKUNDEN
        echo '
        <script>
        setTimeout(function(){
            window.location.reload(1);
         }, 2500);
        </script>
        ';
    } else {

?>
<h2>Regestrieren Sie sich bitte :)</h2>
        <form action="" method="post">
            <label for="">Benutzername</label>
            <input type="text" name="name" id="">
            <label for="">Passwort</label>
            <input type="password" name="password" id="">
            <label for="">Passwort wiederholen</label>
            <input type="password" name="password2" id="">
            <button>Button</button>
        </form>
    <?
    }
    // Create a setting JSON File
} else {
    // Show Login
    print '// Show Login';
    ?>
    <form action="" method="post">
        <label for="">Benutzername</label>
        <input type="text" name="name" id="">
        <label for="">Passwort</label>
        <input type="password" name="password" id="">
        <button>Button</button>
    </form>
<?
if($admin::checkLogin($_POST)){
    echo 'Login erfolgreich';
    
} else {
    echo 'Login FALSCH';   
}
 
}
// TESTED ON PHP.VERSION => 7.3.24
