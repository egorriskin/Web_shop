<?php
include("db_connect.php");
include("functions.php");
session_start();
include("auth_cookie.php");
$id = clearstring($_GET["id"]);
$action = clearstring($_GET["action"]);

switch ($action) {

    case 'clear':
        $clear = mysql_query("DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;

    case 'delete':
        $delete = mysql_query("DELETE FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;

}
if (isset($_POST["submitdata"]))
{
    if ( $_SESSION['auth'] == 'yes_auth' )
    {
        $_SESSION["order_delivery"] = $_POST["order_delivery"];
        $_SESSION["order_note"] = $_POST["order_note"];

        mysql_query("INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_address,order_phone,order_note,order_email)
						VALUES(
                             NOW(),
                            '".$_POST["order_delivery"]."',
							'".$_SESSION['auth_firstname'].' '.$_SESSION['auth_secondname'].' '.$_SESSION['auth_lastname']."',
                            '".$_SESSION['auth_adress']."',
                            '".$_SESSION['auth_phone']."',
                            '".$_POST['order_note']."',
                            '".$_SESSION['auth_email']."'
						    )",$link);

    }else
    {
        $_SESSION["order_delivery"] = $_POST["order_delivery"];
        $_SESSION["order_fio"] = $_POST["order_fio"];
        $_SESSION["order_email"] = $_POST["order_email"];
        $_SESSION["order_phone"] = $_POST["order_phone"];
        $_SESSION["order_address"] = $_POST["order_address"];
        $_SESSION["order_note"] = $_POST["order_note"];

        mysql_query("INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_address,order_phone,order_note,order_email)
						VALUES(
                             NOW(),
                            '".clearstring($_POST["order_delivery"])."',
							'".clearstring($_POST["order_fio"])."',
                            '".clearstring($_POST["order_address"])."',
                            '".clearstring($_POST["order_phone"])."',
                            '".clearstring($_POST["order_note"])."',
                            '".clearstring($_POST["order_email"])."'
						    )",$link);
    }


    $_SESSION["order_id"] = mysql_insert_id();

    $result = mysql_query("SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
    If (mysql_num_rows($result) > 0)
    {
        $row = mysql_fetch_array($result);

        do{


            mysql_query("update cart set cart_id_order=".$_SESSION["order_id"]." ",$link);


        } while ($row = mysql_fetch_array($result));
    }
    header("Location: basket.php?action=completion");
}
$result = mysql_query("SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);
If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);

    do
    {
        $int = $int + ($row["price"] * $row["cart_count"]);
    }
    while ($row = mysql_fetch_array($result));


    $itogpricecart = $int;
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    $title="Корзина заказов";
    require_once "head.php"
    ?>
    <link href="/trackbar/trackbar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            function isValidEmailAddress(emailAddress) {
                var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                return pattern.test(emailAddress);
            }

            $('#confirm_button_next').click(function(e){

                var order_fio = $("#order_fio").val();
                var order_email = $("#order_email").val();
                var order_phone = $("#order_phone").val();
                var order_address = $("#order_address").val();

                if (!$(".order_delivery").is(":checked"))
                {
                    $(".label_delivery").css("color","#E07B7B");
                    send_order_delivery = '0';

                }else { $(".label_delivery").css("color","black"); send_order_delivery = '1';



                    if (order_fio == "" || order_fio.length > 50 )
                    {
                        $("#order_fio").css("borderColor","#FDB6B6");
                        send_order_fio = '0';

                    }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}



                    if (isValidEmailAddress(order_email) == false)
                    {
                        $("#order_email").css("borderColor","#FDB6B6");
                        send_order_email = '0';
                    }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}



                    if (order_phone == "" || order_phone.length > 50)
                    {
                        $("#order_phone").css("borderColor","#FDB6B6");
                        send_order_phone = '0';
                    }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}



                    if (order_address == "" || order_address.length > 150)
                    {
                        $("#order_address").css("borderColor","#FDB6B6");
                        send_order_address = '0';
                    }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}

                }

                if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
                {

                    return true;
                }

                e.preventDefault();

            });

        });

    </script>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">
<?php
$action = clearstring($_GET["action"]);
switch($action)
{
    case 'oneclick':
        echo '
   <div id="block_step">
   <div id="name_step">
   <ul>
   <li><a class="active" >1. Корзина товаров</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=confirm">2. Контактная информация</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=completion">3. Завершение</a></li>
   </ul>
   </div>
   <p>Шаг 1 из 3</p>
   <a href="basket.php?action=clear" >Очистить</a>
   </div>
';
$result = mysql_query("SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);

If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);
        echo '
   <div id="header_list_cart">
   <div id="head1" >Изображение</div>
   <div id="head2" >Наименование товара</div>
   <div id="head3" >Кол-во</div>
   <div id="head4" >Цена</div>
   </div>
   ';
do
{

    $int = $row["price"] * $row["cart_count"];
    $all_price = $all_price + $int;

    if  (strlen($row["image"]) > 0 && file_exists("./upload_images/".$row["image"]))
    {
        $img_path = './upload_images/'.$row["image"];
        $max_width = 100;
        $max_height = 100;
        list($width, $height) = getimagesize($img_path);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh, $ratiow);

        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
    }else
    {
        $img_path = "/img/noimages.png";
        $width = 120;
        $height = 105;
    }
    echo '

    <div class="block_list_cart">
        <div class="img_cart">
            <p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
        </div>
        <div class="title_cart">
            <p><a href="">'.$row["title"].'</a></p>

        </div>
        <div class="count_cart">
            <ul class="input_count_style">

                <li>
                    <p align="center" iid="'.$row["cart_id"].'"  class="count_minus">-</p>
                </li>

                <li>
                    <p align="center">
                        <input id="input_id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count_input" maxlength="3" type="text" value="'.$row["cart_count"].'" />
                    </p>
                </li>

                <li>
                    <p align="center" iid="'.$row["cart_id"].'" class="count_plus">+</p>
                </li>
            </ul>
        </div>
        <div id="tovar'.$row["cart_id"].'" class="price_product">
            <h5>
                <span class="span_count" >'.$row["cart_count"].'</span> x <span>'.$row["price"].'</span>
            </h5>
            <p price="'.$row["price"].'">'.group_numerals($int).' руб</p>
        </div>
        <div class="delete_cart">
            <a href="basket.php?id='.$row["cart_id"].'&action=delete" >
                <img src="/img/bsk_item_del.png" />
            </a>
        </div>
        <div id="bottom_cart_line"></div>
    </div>
';
}
while ($row = mysql_fetch_array($result));

    echo '
 <h2 class="itog_price" align="right">Итого: <strong>'.group_numerals($all_price).'</strong>руб</h2>
 <p align="right" class="button_next" ><a href="basket.php?action=confirm" >Далее</a></p>
 ';

}
else
{
    echo '<h3 id="clear_cart" align="center">Корзина пуста</h3>';
}
        break;

    case 'confirm':
        echo '
   <div id="block_step">
   <div id="name_step">
   <ul>
   <li><a href="basket.php?action=oneclick">1. Корзина товаров</a></li>
   <li><span>&rarr;</span></li>
   <li><a class="active" >2. Контактная информация</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=completion">3. Завершение</a></li>
   </ul>
   </div>
   <p>Шаг 2 из 3</p>
   </div>
';
        if ($_SESSION['order_delivery'] == "По почте") $chck1 = "checked";
        if ($_SESSION['order_delivery'] == "Курьером") $chck2 = "checked";
        if ($_SESSION['order_delivery'] == "Самовывоз") $chck3 = "checked";

        echo '

<h3 class="title_h3" >Способ доставки:</h3>
<hr/>
<form method="post">
<ul id="info_radio">
<li>
<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="По почте" '.$chck1.'  />
<label class="label_delivery" for="order_delivery1">По почте</label>
</li>
<li>
<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером" '.$chck2.' />
<label class="label_delivery" for="order_delivery2">Курьером</label>
</li>
<li>
<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз" '.$chck3.' />
<label class="label_delivery" for="order_delivery3">Самовывоз</label>
</li>
</ul>
<h3 class="title_h3" >Информация для доставки:</h3>
<hr/>
<ul id="info_order">
';
        if ( $_SESSION['auth'] != 'yes_auth' )
        {
            echo '
<li><label for="order_fio"><span>*</span>ФИО</label><input type="text" name="order_fio" id="order_fio" value="'.$_SESSION["order_fio"].'" /><span class="order_span_style" >Пример: Иванов Иван Иванович</span></li>
<li><label for="order_email"><span>*</span>E-mail</label><input type="text" name="order_email" id="order_email" value="'.$_SESSION["order_email"].'" /><span class="order_span_style" >Пример: ivanov@mail.ru</span></li>
<li><label for="order_phone"><span>*</span>Телефон</label><input type="text" name="order_phone" id="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style" >Пример: 8 950 100 12 34</span></li>
<li><label class="order_label_style" for="order_address"><span>*</span>Адрес<br /> доставки</label><input type="text" name="order_address" id="order_address" value="'.$_SESSION["order_address"].'" /><span>Пример: г. Москва,<br /> ленинский проспект д 18, кв 58</span></li>
';
        }
        echo '
<li><label class="order_label_style" for="order_note">Примечания</label><textarea name="order_note"  >'.$_SESSION["order_note"].'</textarea><span>Уточните информацию о заказе.<br />  Например, удобное время для звонка<br />нашего менеджера</span></li>
</ul>
<p align="right" ><input type="submit" name="submitdata" id="confirm_button_next" value="Далее" /></p>
</form>
 ';
        break;

    case 'completion':
        echo '
   <div id="block_step">
   <div id="name_step">
   <ul>
   <li><a href="basket.php?action=oneclick" >1. Корзина товаров</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=confirm">2. Контактная информация</a></li>
   <li><span>&rarr;</span></li>
   <li><a class="active">3. Завершение</a></li>
   </ul>
   </div>
   <p>Шаг 3 из 3</p>
   </div>
   <h3>Конечная информация</h3>
';
        if ( $_SESSION['auth'] == 'yes_auth' )
        {
            echo '
<ul id="list_info" >
<li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
<li><strong>Email:</strong>'.$_SESSION['auth_email'].'</li>
<li><strong>ФИО:</strong>'.$_SESSION['auth_firstname'].' '.$_SESSION['auth_secondname'].' '.$_SESSION['auth_lastname'].'</li>
<li><strong>Адрес доставки:</strong>'.$_SESSION['auth_adress'].'</li>
<li><strong>Телефон:</strong>'.$_SESSION['auth_phone'].'</li>
<li><strong>Примечание: </strong>'.$_SESSION['order_note'].'</li>
</ul>

';
        }else
        {
            echo '
<ul id="list_info" >
<li><strong>Способ доставки:</strong>'.$_SESSION['order_delivery'].'</li>
<li><strong>Email:</strong>'.$_SESSION['order_email'].'</li>
<li><strong>ФИО:</strong>'.$_SESSION['order_fio'].'</li>
<li><strong>Адрес доставки:</strong>'.$_SESSION['order_address'].'</li>
<li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
<li><strong>Примечание: </strong>'.$_SESSION['order_note'].'</li>
</ul>

';
        }
        echo '
<h2 class="itog_price" align="right">Итого: <strong>'.$itogpricecart.'</strong>руб</h2>
  <p align="right" class="button_next" ><a href="" >Отправить</a></p>

 ';
        break;

    default:
        echo '
   <div id="block_step">
   <div id="name_step">
   <ul>
   <li><a class="active" >1. Корзина товаров</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=confirm">2. Контактная информация</a></li>
   <li><span>&rarr;</span></li>
   <li><a href="basket.php?action=completion">3. Завершение</a></li>
   </ul>
   </div>
   <p>Шаг 1 из 3</p>
   <a href="basket.php?action=clear" >Очистить</a>
   </div>
';
        $result = mysql_query("SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);

        If (mysql_num_rows($result) > 0)
        {
            $row = mysql_fetch_array($result);
            echo '
   <div id="header_list_cart">
   <div id="head1" >Изображение</div>
   <div id="head2" >Наименование товара</div>
   <div id="head3" >Кол-во</div>
   <div id="head4" >Цена</div>
   </div>
   ';
            do
            {

                $int = $row["price"] * $row["cart_count"];
                $all_price = $all_price + $int;

                if  (strlen($row["image"]) > 0 && file_exists("./upload_images/".$row["image"]))
                {
                    $img_path = './upload_images/'.$row["image"];
                    $max_width = 100;
                    $max_height = 100;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height/$height;
                    $ratiow = $max_width/$width;
                    $ratio = min($ratioh, $ratiow);

                    $width = intval($ratio*$width);
                    $height = intval($ratio*$height);
                }else
                {
                    $img_path = "/img/noimages.png";
                    $width = 120;
                    $height = 105;
                }
                echo '

    <div class="block_list_cart">
        <div class="img_cart">
            <p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
        </div>
        <div class="title_cart">
            <p><a href="">'.$row["title"].'</a></p>

        </div>
        <div class="count_cart">
            <ul class="input_count_style">

                <li>
                    <p align="center" iid="'.$row["cart_id"].'"  class="count_minus">-</p>
                </li>

                <li>
                    <p align="center">
                        <input id="input_id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count_input" maxlength="3" type="text" value="'.$row["cart_count"].'" />
                    </p>
                </li>

                <li>
                    <p align="center" iid="'.$row["cart_id"].'" class="count_plus">+</p>
                </li>
            </ul>
        </div>
        <div id="tovar'.$row["cart_id"].'" class="price_product">
            <h5>
                <span class="span_count" >'.$row["cart_count"].'</span> x <span>'.$row["price"].'</span>
            </h5>
            <p price="'.$row["price"].'">'.group_numerals($int).' руб</p>
        </div>
        <div class="delete_cart">
            <a href="basket.php?id='.$row["cart_id"].'&action=delete" >
                <img src="/img/bsk_item_del.png" />
            </a>
        </div>
        <div id="bottom_cart_line"></div>
    </div>
';
            }
            while ($row = mysql_fetch_array($result));

            echo '
 <h2 class="itog_price" align="right">Итого: <strong>'.group_numerals($all_price).'</strong>руб</h2>
 <p align="right" class="button_next" ><a href="basket.php?action=confirm" >Далее</a></p>
 ';

        }
        else
        {
            echo '<h3 id="clear_cart" align="center">Корзина пуста</h3>';
        }
        break;


}
?>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>