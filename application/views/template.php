<!DOCTYPE HTML>
<html>
    <head>
        <title><?php if(isset($title)) echo $title ?></title>
        <?php if(isset($css)) echo $css ?>
        <?php if(isset($javascript)) echo $javascript ?>
    </head>
    <body>
        <div id="wrapper">
            <?php if(isset($content)) echo $content ?>
        </div>
    </body>
</html>
