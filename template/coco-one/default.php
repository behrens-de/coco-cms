<?
// TEMPLATE DEFAULT
//print_r(http_response_code());
//var_dump($cocodata)
?>
<header>
    
    <img class="coco-logo" src="./img/base/coco-cms-logo.png" alt="logo">
    <?
        echo $cocomenu->render(PREFIX, 'coco-nav');
    ?>
</header>
</body>

</html>