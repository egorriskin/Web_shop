<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
      session_start();
      unset($_SESSION['auth']);
      setcookie('rememberme','',0,'/');
      session_unset();
      session_destroy();
      //$_SESSION['auth']='';
      echo 'logout';
} 

?>