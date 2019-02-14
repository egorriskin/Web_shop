<?php
include("db_connect.php");
include("functions.php");
session_start();
include("auth_cookie.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    $title="Товары для собак";
    require_once "head.php"
    ?>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">

    <?php require_once "rightcol.php"?>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
