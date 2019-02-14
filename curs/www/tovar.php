<?php
include("db_connect.php");
include("functions.php");
session_start();
include("auth_cookie.php");
$id=clearstring($_GET["id"]);
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
    <?php
    $result1 = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
    If (mysql_num_rows($result1) > 0) {
        $row1 = mysql_fetch_array($result1);
        do {
            if (strlen($row1["image"]) > 0 && file_exists("./upload_images/" . $row1["image"])) {
                $img_path = './upload_images/' . $row1["image"];
                $max_width = 300;
                $max_height = 300;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height / $height;
                $ratiow = $max_width / $width;
                $ratio = min($ratioh, $ratiow);

                $width = intval($ratio * $width);
                $height = intval($ratio * $height);
            } else {
                $img_path = "/img/no-image.png";
                $width = 110;
                $height = 200;
            }
            echo  '

<div id="block_breadcrumbs">
 <span>'.$row1["brand"].'</span>
</div>

<div id="block_content_info">

<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />

<div id="block_mini_description">

<p id="content_title">'.$row1["title"].'</p>

<p id="style_price" ><strong>'.group_numerals($row1["price"]).'</strong> руб</p>

<input type="button" tid="'.$row1["products_id"].'" id="add_tobasket" value="Купить">

<p id="content_text">'.$row1["mini_description"].'</p>

</div>

</div>

';

} while ($row1 = mysql_fetch_array($result1));

        $result = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
        $row = mysql_fetch_array($result);

        echo '

<ul class="tabs">
    <li><a class="active" href="#" >Описание</a></li>
    <li><a href="#" >Характеристики</a></li>
</ul>

<div class="tabs_content">

<div>'.$row["description"].'</div>
<div>'.$row["features"].'</div>
</div>
';
    }
    ?>

</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
