    <?php
    include("db_connect.php");
    include("functions.php");
    //session_start();
    include("auth_cookie.php");
    $cat=clearstring($_GET["cat"]);
    $type=clearstring($_GET["type"]);
    $animal=clearstring($_GET["animal"]);
    $sorting=$_GET["sort"];
    switch($sorting)
    {
        case 'price-asc';
            $sorting='price ASC';
            $sort_name='От дешевых к дорогим';
            break;
        case 'price-desc';
            $sorting='price DESC';
            $sort_name='От дорогих к дешевым';
            break;
        case 'popular';
            $sorting='count DESC';
            $sort_name='Популярные';
            break;
        case 'news';
            $sorting='datetime DESC';
            $sort_name='Новинки';
            break;
        case 'brand';
            $sorting='brand';
            $sort_name='От А до Я';
            break;
        default:
            $sorting='products_id';
            $sort_name='Нет сортировки';
            break;
    }

    ?>
<!DOCTYPE html>
<html>
<head>
    <?php
    $title="Товары для собак";
    require_once "head.php"
    ?>
    <link href="/trackbar/trackbar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#leftcol > ul>li>a").click(function(){
                if($(this).attr('class') !='active'){
                    $("#leftcol > ul>li>ul").slideUp(400);
                    $(this).next().slideToggle(400);
                    $("#leftcol > ul>li>a").removeClass('active');
                    $(this).addClass("active");

                }
                else
                {
                    $('#leftcol > ul>li>a').removeClass('active');
                    $("#leftcol > ul>li>ul").slideUp(400);

                }
            });
            $("#inda").click(function(){
                if($(this).attr('class') !='active'){
                    $("#indu").slideUp(400);
                    $(this).next().slideToggle(400);
                    $("#inda").removeClass('active');
                    $(this).addClass("active");

                }
                else
                {
                    $('#inda').removeClass('active');
                    $("#indu").slideUp(400);

                }
            });
            $('#blocktrackbar').trackbar({
                onMove:function(){
                    document.getElementById("start-price").value=this.leftValue;
                    document.getElementById("end-price").value=this.rightValue;
                },
                width:160,
                leftLimit:10,
                leftValue:<?php
                if((int) $_GET["start-price"]>=10 and (int) $_GET["start-price"]<=10000)
                {
                    echo (int)$_GET["start-price"];
                }
                else
                {
                    echo "10";
                }
                ?>,
                rightLimit:10000,
                rightValue:<?php
                if((int) $_GET["end-price"]>=10 and (int) $_GET["end-price"]<=10000)
                {
                    echo (int)$_GET["end-price"];
                }
                else
                {
                    echo "8000";
                }
                ?>,
                roundup:100
            });
        });

    </script>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">

    <div id="leftcol">
        <h4>Каталог товаров</h4>
        <hr>
        <?php echo '<a class="animalname" href="dog.php?animal='.$animal.'">Товары категории:'.$animal.' </a>';?>
        <ul>
            <li>
                <a id="index1">Корм и лакомства</a>
                <ul>
                    <?php echo ' <li><a href="view_cat.php?animal='.$animal.'&type=korm"><strong>Все товары</strong></a></li>';?>
                    <?php
                    $result= mysql_query("select * from category where animal='$animal' and type='korm'",$link);
                    if(mysql_num_rows($result) >0)
                    {
                        $row=mysql_fetch_array($result);
                        do
                        {
                            echo '
                        <li>
                            <a href="view_cat.php?animal='.$animal.'&cat='.($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a>
                        </li>
                            ';
                        }
                        while($row=mysql_fetch_array($result));
                    }
                    ?>
                </ul>
            </li>
            <li>
                <a id="index2" >Наполнители для туалета</a>
                <ul>
                    <?php echo ' <li><a href="view_cat.php?animal='.$animal.'&type=napolnitel"><strong>Все товары</strong></a></li>';?>
                    <?php
                    $result= mysql_query("select * from category where animal='$animal' and type='napolnitel'",$link);
                    if(mysql_num_rows($result) >0)
                    {
                        $row=mysql_fetch_array($result);
                        do
                        {
                            echo '
                        <li>
                            <a href="view_cat.php?animal='.$animal.'&cat='.$row["brand"].'&type='.$row["type"].'">'.$row["brand"].'</a>
                        </li>
                            ';
                        }
                        while($row=mysql_fetch_array($result));
                    }
                    ?>
                </ul>
            </li>
            <li>
                <a id="index3">Ветеринарная аптека</a>
                <ul>
                    <?php echo ' <li><a href="view_cat.php?animal='.$animal.'&type=apteka"><strong>Все товары</strong></a></li>';?>
                    <?php
                    $result= mysql_query("select * from category where animal='$animal' and type='apteka'",$link);
                    if(mysql_num_rows($result) >0)
                    {
                        $row=mysql_fetch_array($result);
                        do
                        {
                            echo '
                        <li>
                            <a href="view_cat.php?animal='.$animal.'&cat='.($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a>
                        </li>
                            ';
                        }
                        while($row=mysql_fetch_array($result));
                    }
                    ?>
                </ul>
            </li>
            <li>
                <a id="index4">Средства для содержания </a>
                <ul>
                    <?php echo ' <li><a href="view_cat.php?animal='.$animal.'&type=soderganie"><strong>Все товары</strong></a></li>';?>
                    <?php
                    $result= mysql_query("select * from category where animal='$animal' and type='soderganie'",$link);
                    if(mysql_num_rows($result) >0)
                    {
                        $row=mysql_fetch_array($result);
                        do
                        {
                            echo '
                        <li>
                            <a href="view_cat.php?animal='.$animal.'&cat='.($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a>
                        </li>
                            ';
                        }
                        while($row=mysql_fetch_array($result));
                    }
                    ?>
                </ul>
            </li>
            <li>
                <a id="index5">Средства ухода и гигиены </a>
                <ul>
                    <?php echo ' <li><a href="view_cat.php?animal='.$animal.'&type=gigiena"><strong>Все товары</strong></a></li>';?>
                    <?php
                    $result= mysql_query("select * from category where animal='$animal' and type='gigiena'",$link);
                    if(mysql_num_rows($result) >0)
                    {
                        $row=mysql_fetch_array($result);
                        do
                        {
                            echo '
                        <li>
                            <a href="view_cat.php?animal='.$animal.'&cat='.($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a>
                        </li>
                            ';
                        }
                        while($row=mysql_fetch_array($result));
                    }
                    ?>
                </ul>
            </li>
        </ul>
        <p class="animalname">Фильтр</p>
        <ul><?php echo '
                <form method="GET" action="search_filter.php?animal='.$animal.'">';?>
                <li>
                    <a href="#">Стоимость</a>
                    <div id="block-input-price">
                        <ul>
                            <li><p>от:</p></li>
                            <li><input type="text" id="start-price" name="start-price" value="10" /></li>
                            <li><p>до:</p></li>
                            <li><input type="text" id="end-price" name="end-price" value="8000" /></li>
                            <li><p>руб.</p></li>
                        </ul>
                    </div>
                    <div id="blocktrackbar"></div>
                </li>
                <div class="clear"></div>
                <li>
                    <a id="inda">Название бренда</a>
                    <ul id="indu">
                        <?php

                        $result= mysql_query("select *, brand from category where animal='$animal' GROUP by brand",$link);
                        if(mysql_num_rows($result) >0)
                        {
                            $row=mysql_fetch_array($result);
                            do
                            {
                                echo '
                            <li>
                                <input type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrand'.$row["id"].'"/>
                                <label for="checkbrand'.$row["id"].'">'.$row["brand"].'</label>
                            </li>
                        ';
                            }
                            while($row=mysql_fetch_array($result));
                        }
                        ?>

                    </ul>
                </li>

                <input type="submit" name="submit" id="button-param-search" value="Найти">
            </form>
            <li>
                <a href="#">Сортировать</a>
                <ul id="ul_show"><?php echo '
                    <li>
                        <a href="view_cat.php?animal='.$animal.'&cat='.$cat.'&type='.$type.'&sort=price-asc">
                            От дешевых к дорогим
                        </a>
                    </li>
                    <li>
                        <a href="view_cat.php?animal='.$animal.'&cat='.$cat.'&type='.$type.'&sort=price-desc">
                            От дорогих к дешевым
                        </a>
                    </li>
                    <li>
                        <a href="view_cat.php?animal='.$animal.'&cat='.$cat.'&type='.$type.'&sort=brand">
                            От А до Я
                        </a>
                    </li>
                    <li>
                        <a href="view_cat.php?animal='.$animal.'&cat='.$cat.'&type='.$type.'&sort=popular">
                            Популярное
                        </a>
                    </li>
                    <li>
                        <a href="view_cat.php?animal='.$animal.'&cat='.$cat.'&type='.$type.'&sort=news">
                            Новинки
                        </a>
                    </li>
            ';?></ul>
            </li>

        </ul>
    </div>
    <div id="rightcol">
        <?php echo '<p>Все товары из категории "'.$type.'"</p>';?>
        <hr>
        <ul>
            <?php

            if(!empty($cat) && !empty($type))
            {
                $querycat="and brand='$cat' and type_tovara='$type'";
            }
            else
            {
                if(!empty($type)){
                    $querycat="and type_tovara='$type'";
                }
                else{
                    $querycat="";
                }
            }
            $num = 5;
            $page = (int)$_GET['page'];

            $count = mysql_query("SELECT COUNT(*) FROM table_products WHERE visible = '1' and animal='$animal' $querycat",$link);
            $temp = mysql_fetch_array($count);

            If ($temp[0] > 0)
            {
                $tempcount = $temp[0];


                $total = (($tempcount - 1) / $num) + 1;
                $total =  intval($total);

                $page = intval($page);

                if(empty($page) or $page < 0) $page = 1;

                if($page > $total) $page = $total;


                $start = $page * $num - $num;

                $qury_start_num = " LIMIT $start, $num";
            }
            $result= mysql_query("select * from table_products where visible='1' and animal='$animal' $querycat  ORDER BY $sorting $qury_start_num",$link);
            if(mysql_num_rows($result) >0)
            {
                $row=mysql_fetch_array($result);
                do
                {
                    echo '
                    <li id="block">
                        <div class="info">
                            <a href="tovar.php?id='.$row["products_id"].'"><img src="/upload_images/'.$row["image"].'"></a>
                            <a href="tovar.php?id='.$row["products_id"].'">'.$row["title"].'</a>
                            <hr>
                            <div id="price">'.group_numerals($row["price"]).'<small>руб.</small></div>
                            <input type="button" tid="'.$row["products_id"].'" id="add_tobasket" value="Купить">
                            <a href="tovar.php?id='.$row["products_id"].'"><span class="more">Подробнее</span></a>
                        </div>
                    </li>
                    ';
                }
                while($row=mysql_fetch_array($result));
            }
            else
            {
                echo '<h3>Категория не доступна или не создана</h3>';
            }
            echo '<div class="clear"></div>';

            if ($page != 1){ $pstr_prev = '<li><a id="pstr-prev" href="view_cat.php?animal='.$animal.'&page='.($page - 1).'">&lt;</a></li>';}
            if ($page != $total) $pstr_next = '<li><a id="pstr-next" href="view_cat.php?animal='.$animal.'&page='.($page + 1).'">&gt;</a></li>';



            if($page - 5 > 0) $page5left = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
            if($page - 4 > 0) $page4left = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
            if($page - 3 > 0) $page3left = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
            if($page - 2 > 0) $page2left = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
            if($page - 1 > 0) $page1left = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

            if($page + 5 <= $total) $page5right = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
            if($page + 4 <= $total) $page4right = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
            if($page + 3 <= $total) $page3right = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
            if($page + 2 <= $total) $page2right = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
            if($page + 1 <= $total) $page1right = '<li><a href="view_cat.php?animal='.$animal.'&page='.($page + 1).'">'.($page + 1).'</a></li>';


            if ($page+5 <= $total)
            {
                $strtotal = '<li><p id="nav-point">...</p></li><li><a href="view_cat.php?animal='.$animal.'&page='.$total.'">'.$total.'</a></li>';
            }else
            {
                $strtotal = "";
            }

            if ($total > 1)
            {
                echo '
    <div id="pstrnav">
    <ul>
    ';
                echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a id='pstr-active' href='view_cat.php?animal='.$animal.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
                echo '
    </ul>
    </div>
    ';
            }
            ?>
        </ul>

        <div class="clear"></div>
        <div id="aboutprod">
            <p>Коши удивительны по своему характеру и привычкам. Это необычайно нежные и жизнерадостные питомцы. Как и у всякого живого существа, у них есть свои потребности. Если они будут удовлетворены, в вашем доме будет царить позитивная атмосфера, а содержание пушистого друга принесет только положительные эмоции.</p>
            <h2>КОРМ И ЛАКОМСТВА ДЛЯ КОШЕК</h2>
            <p>Поскольку мурки и мурзики по своей природе хищники, то им полагается особый рацион. В природе они охотятся на саранчу, крупных кузнечиков, мышей, ящериц, лягушек, мелких птиц. Если повезет, находят и поедают яйца.

                Их организм рассчитан перерабатывать большое количество белка. В качестве минеральной составляющей служат кости и сухожилья животных. Кошки могут пополнять свой рацион овощами, некоторые любят арбузы или другие сочные фрукты. А с поеданием грызунов и птиц к ним в желудок попадает небольшое количество зерна.

                Сбалансированный корм стремится повторить естественное питание кошки. Однако мало кто из заводчиков имеет возможность и достаточно времени на то, чтобы готовить для кошачьего семейства каждый день особые блюда. Поэтому ветеринары разработали готовые диеты, которые легли в основу готовых кормов.

                Вам достаточно открыть пакетик или вскрыть баночку готового продукта, и предложить их содержимое пушистому другу.

                Сочные паштеты и рагу в консервированном виде нравятся кошкам, они охотно поедают вкусное желе и соусы, которыми приправлены аппетитные кусочки корма. Сухие гранулы удобны для автоматических кормушек. Они хороши  тех случаях, когда нужно оставит на длительный срок питомца дома или отправиться с ним  поездку.</p>
            <h2>НАПОЛНИТЕЛИ ДЛЯ КОШАЧЬЕГО ТУАЛЕТА</h2>
            <p>Кошачий туалет – это неотъемлемая часть ухода за питомцем. Даже если у вас частный дом, в ненастье или холод кошкам не нравится выходить из дому. Им нравятся теплые укромные уголки, где нет сквозняков.

                Наполнители для кошачьих туалетов – это хороший способ предложить питомцу то, что он ищет. В мелких гранулах можно порыться, пряча свой «клад». При этом лапы остаются чистыми и сухими.

                Основным признаком качественного материала для лотов можно считать способность поглощать влагу и купировать запахи. С этой задачей отлично справляются древесные и силикагелевые впитывающие гранулы, а также глиняные комкующиеся наполнители.

                Для кошек важно, чтобы лапкам было приятно ступать на лоток, а сам туалет был чистым и сухим, без искусственных резких запахов.</p>
            <h2>СРЕДСТВА ДЛЯ СОДЕРЖАНИЯ КОШЕК</h2>
            <p>Если имеются проблемы с принятием лотка, присмотритесь, чего ищет ваш питомец, что ему нравится. Если он упорно использует текстиль, то положите ему в туалет впитывающую многоразовую пеленку. Если забивается под мебель, и там оставляет метки, возможно, ему понравится закрытая модель туалета.

                Для тех же хозяев, которые не любят чистить лотки, инженеры придумали автоматические туалеты, которые смывают всю грязь в канализацию, оставляя лоток с наполнителем сухим и чистым.

                В период полового созревания кошки и коты начинают метить территорию в надежде привлечь вторую половинку. В этот период можно использовать подгузники и штанишки для кошек. Они помогут животным реализовать свои природные инстинкты, а ваша мебель и  ковры останутся чистыми.

                Каждому члену семьи нужен свой, хотя бы самый малый уголок, где он будет чувствовать себя хозяином территории. Для кошки это может стать мягкий домик или лежак. Многие модели совмещены с когтеточками, которые нравятся питомцам. Лежаки, гамаки, корзины и целые игровые комплексы позволят пушистикам чувствовать себя уютно.

                Чтобы ваши питомцы были в хорошей физической форме, им нужно много двигаться. Этого можно добиться при помощи ежедневных прогулок со шлейкой или ошейником.

                Для наших соотечественников еще не привычно видеть кота на поводке, однако если есть риск потерять дорогого любимца семьи, то шлейка  поможет организовать безопасную прогулку.

                Если же у вас нет времени для того, чтобы каждый день выгуливать котейку, можно предложить четвероногим друзьям игрушки, с которыми можно поноситься по комнатам.</p>
            <h2>СРЕДСТВА УХОДА И ГИГИЕНЫ ДЛЯ КОШЕК</h2>
            <p>Грациозная ухоженная кошечка – услада глаз для многих хозяев. Однако для того, чтобы шерсть имела привлекательный вид, необходимо ее периодически чистить. Для этого разработаны специальные кошачьи шампуни и кондиционеры. Средства гигиены для людей использовать крайне нежелательно при купании домашних питомцев. Это связано с тем, что у них другая структура кожи и ворса. Те шампуни, от которых девушки хорошеют, могут привести к печальным результатам на ваших пушистых друзьях.

                Чистоту дома поддерживать необходимо, т.к. мурки очень чувствительны к грязи и пыли. Чтобы случайные пятна не провоцировали кошку нарушать порядок, их стоит обрабатывать пятновыводителями и уничтожителями запахов. Эти средства успешно справляются с ароматами мочи, уничтожая ее кристаллы.

                Отвадить котейку оставлять кучи в неположенном месте поможет антигадин. А для сохранения мебели воспользуйтесь спреями с ароматами, которые не нравятся кошкам.  Прилепите  дивану и креслу двусторонний скотч, обрызгайте спреем, и покажите, где мурка может поточить коготки. Этот комплекс мер в большинстве случаев дает хороший результат, и мебель остается невредима.

                При несбалансированном питании или же нарушениях обмена веществ у кошки может развиваться зубной камень, вызывающий воспаление десен и выпадение зубов. Чтобы этого избежать, ветеринары предлагают чистить питомцам зубы пастами с запахом и вкусом мяса. Эта вкусная процедура понравится вашим любимцам. Особенно когда для этого используются специализированные зубные щетки.</p>
        </div>

    </div>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
