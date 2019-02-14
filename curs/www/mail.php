<?php
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);
$subject = htmlspecialchars($_POST['subject']);
$human = htmlspecialchars($_POST['human']);
$from = 'From: $email';
$to = 'egor.riskin@yandex.ru';



$body = "From: $name\n E-Mail: $email\n Message:\n $message";


    if ($name != '' && $email != '' && $subject != '') {
            if (mail ($to, $subject, $body, $from)) {
                echo 'Сообщение отправлено!';
            } else {
                echo 'Сообщение не отправлено!';
            }

    } else {
        echo 'Вы должны заполнить все поля!"';
    }

?>