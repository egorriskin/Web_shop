<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include("db_connect.php");
include("functions.php");

$email = clearstring($_POST["email"]);

if ($email != "")
{
   $result = mysql_query("SELECT email FROM reg_user WHERE email='$email'",$link);
If (mysql_num_rows($result) > 0)
{
    $newpass = fungenpass();

    $pass   = md5($newpass);
    $pass   = strrev($pass);
    $pass   = strtolower("ekgmskf".$pass."wgergvds");

$update = mysql_query ("UPDATE reg_user SET pass='$pass' WHERE email='$email'",$link);

	         send_mail( 'zooshop@yandex.ru',
			             $email,
						'Новый пароль для сайта Zooshop.ru',
						'Ваш пароль: '.$newpass);
   
   echo 'yes';
    
}else
{
    echo 'Данный E-mail не найден!';
}

}
else
{
    echo 'Введите ваш E-mail';
}

}



?>