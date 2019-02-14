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
    $title="Контакты";
    require_once "head.php"
    ?>
    <script>
        $(document).ready(function(){
            $("#done").click(function(){
                $("#messageshow").hide();
                var name=$("#name").val();
                var email=$("#email").val();
                var subject=$("#subject").val();
                var message=$("#message").val();
                var human=$("#human").val();
                var fail="";
                if(name.length<3) fail="Имя не меньше 3 символов";
                else if(subject.length<5) fail="Тема сообщения не меньше 5 символов";
                else if(message.length<20) fail="Сообщение не меньше 20 символов";
                else if(human!=4) fail="Ваш ответ на анти-спам некорректен!";
                if(fail!=""){
                    $("#messageshow").html(fail);
                    $("#messageshow").show();
                    return false;
                }
                $.ajax({
                    url:'mail.php',
                    type:'POST',
                    cache:false,
                    data:{'name':name,'email':email, 'subject':subject, 'message':message},
                    datatype:'html',
                    success:function(data){
                        $("#messageshow").html(data);
                        $("#messageshow").show();
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">
    <div id="mainpage">
        <div id="center">
            <h2>Контакты</h2>
            <p>Адрес магазина и самовывоза: </p>
            <h5>г. Москва, ул. Профсоюзная д. 11</h5>
            <p>Телефоны:  (499) 000-00-01  (500) 500-00-00</p>
            <p>E-mail:       zooshop@yandex.ru</p><br><br>
            <h2>Связаться с нами</h2>
        </div>
        <form method="post" action="mail.php">

            <label for="name">Имя</label>
            <input name="name" type="text" id="name" placeholder="Ваше имя">

            <label for="email">Email</label>
            <input name="email" id="email" type="email" placeholder="Ваш email">

            <label for="subject">Тема сообщения</label>
            <input name="subject" id="subject" type="text" placeholder="Ваш email">

            <label for="message">Сообщение</label>
            <textarea name="message" id="message" placeholder="Ваше сообщение"></textarea>

            <label for="human">*What is 2+2? (Anti-spam)</label>
            <input name="human" id="human" placeholder="Введите число">

            <div id="messageshow"></div>

            <input id="done" name="done" type="button" value="Отправить">

        </form>
    </div>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
