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
    $title="Регистрация";
    require_once "head.php"
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_reg').validate(
                {

                    rules:{
                        "login":{
                            required:true,
                            minlength:5,
                            maxlength:15

                        },
                        "pass":{
                            required:true,
                            minlength:7,
                            maxlength:15
                        },
                        "firstname":{
                            required:true,
                            minlength:3,
                            maxlength:15
                        },
                        "secondname":{
                            required:true,
                            minlength:3,
                            maxlength:15
                        },
                        "lastname":{
                            required:true,
                            minlength:3,
                            maxlength:25
                        },
                        "email":{
                            required:true,
                            email:true
                        },
                        "phone":{
                            required:true
                        },
                        "adress":{
                            required:true
                        },
                        "captcha":{
                            required:true,
                            remote: {
                                type: "post",
                                url: "/check_captcha.php"

                            }

                        }
                    },


                    messages:{
                        "login":{
                            required:"Укажите логин!",
                            minlength:"От 5 до 15 символов!",
                            maxlength:"От 5 до 15 символов!"

                        },
                        "pass":{
                            required:"Укажите пароль!",
                            minlength:"От 7 до 15 символов!",
                            maxlength:"От 7 до 15 символов!"
                        },
                        "firstname":{
                            required:"Укажите вашу фамилию!",
                            minlength:"От 3 до 20 символов!",
                            maxlength:"От 3 до 20 символов!"
                        },
                        "secondname":{
                            required:"Укажите ваше имя!",
                            minlength:"От 3 до 15 символов!",
                            maxlength:"От 3 до 15 символов!"
                        },
                        "lastname":{
                            required:"Укажите ваше отчество!",
                            minlength:"От 3 до 25 символов!",
                            maxlength:"От 3 до 25 символов!"
                        },
                        "email":{
                            required:"Укажите свой E-mail",
                            email:"Некорректный E-mail"
                        },
                        "phone":{
                            required:"Укажите номер телефона!"
                        },
                        "adress":{
                            required:"Необходимо указать адрес доставки!"
                        },
                        "captcha":{
                            required:"Введите код с картинки!",
                            remote: "Неверный код проверки!"
                        }
                    },

                    submitHandler: function(form){
                        $(form).ajaxSubmit({
                            success: function(data) {

                                if (data == true)
                                {
                                    $("#form_reg").fadeOut(300,function() {
                                        $("#reg_mes").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
                                        $("#reg_submit").hide();

                                    });

                                }
                                else
                                {
                                    $("#reg_mes").addClass("reg_message_error").fadeIn(400).html(data);
                                }
                            }
                        });
                    }
                });
            $('#reload_captcha').click(function(){
                $('#block_captcha > img').attr("src","/reg_captcha.php?r=" +Math.random());
            });
        });

    </script>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">
    <div id="mainpage">
        <h2>Регистрация</h2>
        <p id="reg_mes"></p>
        <form method="post" id="form_reg" action="/handler_reg.php">

            <label for="login">Логин</label>
            <input name="login" type="text" id="login" placeholder="Ваш Логин">
            <div class="clear"></div>

            <label for="pass">Пароль</label>
            <input name="pass" id="pass" type="text" placeholder="Ваш пароль">
            <div class="clear"></div>

            <label for="firstname">Фамилия</label>
            <input name="firstname" id="firstname" type="text" placeholder="Ваша Фамилия">
            <div class="clear"></div>

            <label for="secondname">Имя</label>
            <input name="secondname" id="secondname" type="text" placeholder="Ваше имя">
            <div class="clear"></div>

            <label for="lastname">Отчество</label>
            <input name="lastname" id="lastname" type="text" placeholder="Ваше Отчество">
            <div class="clear"></div>

            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Ваш email">
            <div class="clear"></div>

            <label for="phone">Мобильный телефон</label>
            <input name="phone" id="phone" type="text" placeholder="Мобильный телефон">
            <div class="clear"></div>

            <label for="adress">Адрес доставки</label>
            <input name="adress" id="adress" type="text" placeholder="Адрес доставки">
            <div class="clear"></div>

            <label for="captcha">Защитный код</label>
            <div id="block_captcha">

                <img src="/reg_captcha.php">
                <input name="captcha" id="captcha" type="text" placeholder="Защитный код">
                <div class="clear"></div>
                <p id="reload_captcha">Обновить</p>
            </div>
            <div class="clear"></div>

            <input id="reg_submit" name="reg_submit" type="submit" value="Зарегистрироваться">

        </form>
    </div>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
