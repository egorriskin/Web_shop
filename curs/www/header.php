<?php
include("db_connect.php");

?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.top_auth').toggle(
            function(){
                $('#auth').fadeIn(200);
            },
            function(){
                $('#auth').fadeOut(200);
            }
        );
        loadcart();
        $('#button_view').click(function(){
            var statuspass = $('#button_view').attr("class");

            if (statuspass == "pass_show")
            {
                $('#button_view').attr("class","pass_hide");

                var $input = $("#auth_pass");
                var change = "text";
                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
                    .attr("id", $input.attr("id"))
                    .attr("name", $input.attr("name"))
                    .attr('class', $input.attr('class'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;

            }else
            {
                $('#button_view').attr("class","pass_show");

                var $input = $("#auth_pass");
                var change = "password";
                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
                    .attr("id", $input.attr("id"))
                    .attr("name", $input.attr("name"))
                    .attr('class', $input.attr('class'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;

            }



        });
        $("#auth_but").click(function() {

            var auth_login = $("#auth_login").val();
            var auth_pass = $("#auth_pass").val();


            if (auth_login == "" || auth_login.length > 30 )
            {
                $("#auth_login").css("borderColor","#fdb6b6");
                send_login = 'no';
            }else {

                $("#auth_login").css("borderColor","#77d348");
                send_login = 'yes';
            }


            if (auth_pass == "" || auth_pass.length > 15 )
            {
                $("#auth_pass").css("borderColor","#FDB6B6");
                send_pass = 'no';
            }else { $("#auth_pass").css("borderColor","#77d348");  send_pass = 'yes'; }



            if ($("#remember_me").prop('checked'))
            {
                auth_rememberme = 'yes';

            }else { auth_rememberme = 'no'; }


            if ( send_login == 'yes' && send_pass == 'yes' )
            {
                $("#auth_but").hide();
                $(".auth_loading").show();

                $.ajax({
                    type: "POST",
                    url: "auth.php",
                    data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
                    dataType: "html",
                    cache: false,
                    success: function(data) {

                        if (data == 'yes_auth')
                        {
                            location.reload();

                            //$("#hider").fadeOut(100);
                           //$("#auth_user").fadeIn(100);

                        }else
                        {
                            $("#mist_mess").slideDown(400);
                            $(".auth_loading").hide();
                            $("#auth_but").show();

                        }

                    }
                });
            }
        });

        $('#remindpass').click(function(){

            $('#input_email').fadeOut(200, function() {
                $('#block_remind').fadeIn(300);
            });
        });
        $('#prev_auth').click(function(){

            $('#block_remind').fadeOut(200, function() {
                $('#input_email').fadeIn(300);
            });
        });

        $('#button_remind').click(function(){

            var recall_email = $("#remind_email").val();

            if (recall_email == "" || recall_email.length > 20 )
            {
                $("#remind_email").css("borderColor","#FDB6B6");

            }else
            {
                $("#remind_email").css("borderColor","#77d348");

                $("#button_remind").hide();
                $(".auth_loading").show();

                $.ajax({
                    type: "POST",
                    url: "remind_pass.php",
                    data: "email="+recall_email,
                    dataType: "html",
                    cache: false,
                    success: function(data) {

                        if (data == 'yes')
                        {
                            $(".auth_loading").hide();
                            $("#button_remind").show();
                            $('#message_remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);

                            setTimeout("$('#message_remind').html('').hide(),$('#block_remind').hide(),$('#input_email').show()", 3000);

                        }else
                        {
                            $(".auth_loading").hide();
                            $("#button_remind").show();
                            $('#message_remind').attr("class","message-remind-error").html(data).slideDown(400);

                        }
                    }
                });
            }
        });

        $('#auth_user').toggle(
            function() {
                $("#block_user").fadeIn(100);
            },
            function() {
                $("#block_user").fadeOut(100);
            }
        );

        $('#logout').click(function(){

            $.ajax({
                type: "POST",
                url: "logout.php",
                dataType: "html",
                cache: false,
                success: function(data) {

                    if (data == 'logout')
                    {
                        location.reload();
                        //$("#auth_user").fadeOut(100);
                        //$("#hider").fadeIn(100);
                    }

                }
            });
        });

        $("#add_tobasket").click(function(){

            var  tid = $(this).attr("tid");

            $.ajax({
                type: "POST",
                url: "addtocart.php",
                data: "id="+tid,
                dataType: "html",
                cache: false,
                success: function(data) {
                    loadcart();
                }
            });

        });
        function loadcart(){
            $.ajax({
                type: "POST",
                url: "loadcart.php",
                dataType: "html",
                cache: false,
                success: function(data) {

                    if (data == "0")
                    {

                        $("#basket > span").html("Ваша корзина 0 руб");

                    }else
                    {
                        $("#basket > span").html(data);

                    }

                }
            });

        }
        function fun_group_price(intprice) {

            var result_total = String(intprice);
            var lenstr = result_total.length;

            switch(lenstr) {
                case 4: {
                    groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
                    break;
                }
                case 5: {
                    groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
                    break;
                }
                case 6: {
                    groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6);
                    break;
                }
                case 7: {
                    groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7);
                    break;
                }
                default: {
                    groupprice = result_total;
                }
            }
            return groupprice;
        }

        $('.count_minus').click(function(){

            var iid = $(this).attr("iid");

            $.ajax({
                type: "POST",
                url: "count-minus.php",
                data: "id="+iid,
                dataType: "html",
                cache: false,
                success: function(data) {
                    $("#input_id"+iid).val(data);
                    loadcart();


                    var priceproduct = $("#tovar"+iid+" > p").attr("price");

                    result_total = Number(priceproduct) * Number(data);

                    $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
                    $("#tovar"+iid+" > h5 > .span_count").html(data);

                    itog_price();
                }
            });

        });

        $('.count_plus').click(function(){

            var iid = $(this).attr("iid");

            $.ajax({
                type: "POST",
                url: "count-plus.php",
                data: "id="+iid,
                dataType: "html",
                cache: false,
                success: function(data) {
                    $("#input_id"+iid).val(data);
                    loadcart();
                    var priceproduct = $("#tovar"+iid+" > p").attr("price");

                    result_total = Number(priceproduct) * Number(data);

                    $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
                    $("#tovar"+iid+" > h5 > .span_count").html(data);

                    itog_price();
                }
            });

        });

        $('.count_input').keypress(function(e){

            if(e.keyCode==13){

                var iid = $(this).attr("iid");
                var incount = $("#input_id"+iid).val();

                $.ajax({
                    type: "POST",
                    url: "count-input.php",
                    data: "id="+iid+"&count="+incount,
                    dataType: "html",
                    cache: false,
                    success: function(data) {
                        $("#input_id"+iid).val(data);
                        loadcart();

                        var priceproduct = $("#tovar"+iid+" > p").attr("price");

                        result_total = Number(priceproduct) * Number(data);


                        $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" руб");
                        $("#tovar"+iid+" > h5 > .span_count").html(data);
                        itog_price();

                    }
                });
            }
        });

        function  itog_price(){

            $.ajax({
                type: "POST",
                url: "itog_price.php",
                dataType: "html",
                cache: false,
                success: function(data) {

                    $(".itog_price > strong").html(data);

                }
            });

        }
        $("ul.tabs").jTabs({content: ".tabs_content", animate: true, effect:"fade"});

    });
</script>
<header>
    <a href="index.php" ><div id="logo"><h2>Zooshop</h2></div></a>
    <form method="get" action="search.php?q=">
        <input type="search" placeholder="Поиск" name="q" id="search">
        <input type="submit" value="Найти" id="button_search">
    </form>

    <a class="about" href="about.php">О нас </a>
    <a class="contacts" href="contacts.php" >Контакты </a>
    <a class="pay" href="pay.php" >Доставка и оплата</a>

    <p  id="auth_user"><img src="/img/user.png"/><span>Здравствуйте<?php echo' '.$_SESSION['auth_secondname'].'';?></span></p>
    <div id="hider">
        <a class="top_auth">Вход</a>
        <a class="owncab" href="registration.php" >Регистрация</a>
    </div>

    <div id="auth">
        <div class="corner"></div>
        <form id="input_email" method="post">
            <h3>Вход</h3>
            <p id="mist_mess">Неверный логин и(или) пароль</p>
            <center><input type="text" id="auth_login" placeholder="Логин или email"></center>
            <center><input type="password" id="auth_pass" placeholder="Пароль"><span id="button_view" class="pass_show"></span></center>
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Запомнить меня</label>
            <div class="clear"></div>
            <a id="remindpass" href="#">Забыли пароль?</a>
            <div class="clear"></div>
            <input type="button" value="Вход" id="auth_but">
            <img class="auth_loading" src="/img/loading.gif"/>
        </form>

        <div id="block_remind">
            <h3>Восстановление<br />пароля</h3>
            <p id="message_remind" class="message_remind_success" ></p>
            <center><input type="text" id="remind_email" placeholder="Ваш E-mail" /></center>
            <input type="button" align="right" id="button_remind" value="Готово" >
            <p align="right" class="auth_loading" ><img src="/img/loading.gif" /></p>
            <p id="prev_auth">Назад</p>
        </div>
    </div>
    <div id="block_user" >
        <div class="corner2"></div>

            <img src="/img/logout.png" /><a id="logout" >Выйти</a>

    </div>

    <a id="basket" href="basket.php?action=oneclick">
        <span>Ваша корзина 0 руб.</span>
    </a>

    <div class="clear"></div>
    <hr>
    <div id="nav">
        <a id="dog" href="dog.php?animal=dog">Собаки</a>
        <a id="cat" href="cat.php?animal=cat">Кошки</a>
        <a id="rodents" href="rodents.php?animal=rodents">Грызуны</a>
        <a id="bird" href="bird.php?animal=bird">Птицы</a>
        <a id="fish" href="fish.php?animal=fish">Рыбы</a>
        <a id="ferrets" href="ferrets.php?animal=ferrets">Хорьки</a>
        <a id="reptile" href="reptile.php?animal=reptile">Рептилии</a>
    </div>

</header>