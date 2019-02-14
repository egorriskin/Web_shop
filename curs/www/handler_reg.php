<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    include("db_connect.php");
    include("functions.php");

    $error = array();

    $login = strtolower(clearstring($_POST['login']));
    $pass =  strtolower(clearstring($_POST['pass']));
    $firstname = clearstring($_POST['firstname']);

    $secondname = clearstring($_POST['secondname']);
    $lastname =  clearstring($_POST['lastname']);
    $email =  clearstring($_POST['email']);

    $phone = clearstring($_POST['phone']);
    $adress = clearstring($_POST['adress']);


    if (strlen($login) < 5 or strlen($login) > 15) {
        $error[] = "Логин должен быть от 5 до 15 символов!";
    } else {
        $result = mysql_query("SELECT login FROM reg_user WHERE login = '$login'",$link);
        If (mysql_num_rows($result) > 0) {
            $error[] = "Логин занят!";
        }

    }

    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Укажите пароль от7 до 15 символов!!";
    if (strlen($firstname) < 3 or strlen($firstname) > 20) $error[] = "Укажите фамилию от 3 до 20 символов!";
    if (strlen($secondname) < 3 or strlen($secondname) > 15) $error[] = "Укажите имя от3 до 15 символов!";
    if (strlen($lastname) < 3 or strlen($lastname) > 25) $error[] = "Укажите отчество от 3 до 25 символов!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "Укажите корректный email!";
    if (!$phone) $error[] = "Укажите номер телефона!";
    if (!$adress) $error[] = "Необходимо указать адрес доставки!";

    if ($_SESSION['img_captcha'] != strtolower($_POST['captcha'])) $error[] = "Неверный код с картинки!";
    unset($_SESSION['img_captcha']);

    if (count($error)) {

        echo implode('<br />', $error);

    } else {
        $pass   = md5($pass);
        $pass   = strrev($pass);
        $pass   = "ekgmskf".$pass."wgergvds";

        $ip = $_SERVER['REMOTE_ADDR'];

        mysql_query("	INSERT INTO reg_user(login,pass,firstname,secondname,lastname,email,phone,adress,datetime,ip)
						VALUES(

							'".$login."',
							'".$pass."',
							'".$firstname."',
							'".$secondname."',
							'".$lastname."',
                            '".$email."',
                            '".$phone."',
                            '".$adress."',
                            NOW(),
                            '".$ip."'
						)",$link);

        echo true;
    }
}
?>