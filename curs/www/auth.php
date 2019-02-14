<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    include('db_connect.php');
    include('functions.php');
    
    $login = clearstring($_POST["login"]);

    $pass   = md5(clearstring($_POST["pass"]));
    $pass   = strrev($pass);
    $pass   = strtolower("ekgmskf".$pass."wgergvds");



    if ($_POST["rememberme"] == "yes")
    {

            setcookie('rememberme',$login.'+'.$pass,time()+3600*24*31, '/');

    }
    
       
   $result = mysql_query("SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND pass = '$pass'",$link);
if (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);
    session_start();
    $_SESSION['auth'] = 'yes_auth'; 
    $_SESSION['auth_pass'] = $row["pass"];
    $_SESSION['auth_login'] = $row["login"];
    $_SESSION['auth_firstname'] = $row["firstname"];
    $_SESSION['auth_secondname'] = $row["secondname"];
    $_SESSION['auth_lastname'] = $row["lastname"];
    $_SESSION['auth_adress'] = $row["adress"];
    $_SESSION['auth_phone'] = $row["phone"];
    $_SESSION['auth_email'] = $row["email"];
    echo 'yes_auth';

}else
{
    echo 'no_auth';
}  
} 

?>