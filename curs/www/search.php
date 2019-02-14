<?php
include("db_connect.php");
include("functions.php");
session_start();
include("auth_cookie.php");

$search=clearstring($_GET["q"]);
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
    $title="Поиск-'.$search.'";
    require_once "head.php"
    ?>
    <link href="/trackbar/trackbar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {


        });

    </script>
</head>
<body>
<?php require_once "header.php"?>
<div id="wrapper">

    <div id="leftcol">

        <p class="animalname">Фильтр</p>

                <a style="color: #4D4D4D" href="#">Сортировать</a>
                <ul id="ul_show"><?php echo '
                    <li>
                        <a href="search.php?q='.$search.'&sort=price-asc">
                            От дешевых к дорогим
                        </a>
                    </li>
                    <li>
                        <a href="search.php?q='.$search.'&sort=price-desc">
                            От дорогих к дешевым
                        </a>
                    </li>
                    <li>
                        <a href="search.php?q='.$search.'&sort=brand">
                            От А до Я
                        </a>
                    </li>
                    <li>
                        <a href="search.php?q='.$search.'&sort=popular">
                            Популярное
                        </a>
                    </li>
                    <li>
                        <a href="search.php?q='.$search.'&sort=news">
                            Новинки
                        </a>
                    </li>
            ';?></ul>

    </div>
    <div id="rightcol">
       <p>Все товары</p>
        <hr>
        <ul>
            <?php
            $num = 1;
            $page = (int)$_GET['page'];

            $count = mysql_query("SELECT COUNT(*) FROM table_products WHERE title like '%$search%' and visible = '1'",$link);
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
            $result= mysql_query("select * from table_products where title like '%$search%' and visible='1'  ORDER BY $sorting $qury_start_num",$link);
            if(mysql_num_rows($result) >0)
            {
                $row=mysql_fetch_array($result);
                do
                {
                    echo '
                    <li id="block">
                        <div class="info">
                            <a href="tovar.php"><img src="/upload_images/'.$row["image"].'"></a>
                            <a href="tovar.php">'.$row["title"].'</a>
                            <hr>
                            <div id="price">'.$row["price"].'<small>руб.</small></div>
                            <input type="button" value="Купить">
                            <a href="tovar.php"><span class="more">Подробнее</span></a>
                        </div>
                    </li>
                    ';
                }
                while($row=mysql_fetch_array($result));
            }
            else
            {
                echo '<h3>Ничего не найдено!</h3>';
            }
            echo '<div class="clear"></div>';

            if ($page != 1){ $pstr_prev = '<li><a id="pstr-prev" href="search.php?q='.$search.'&page='.($page - 1).'">&lt;</a></li>';}
            if ($page != $total) $pstr_next = '<li><a id="pstr-next" href="search.php?q='.$search.'&page='.($page + 1).'">&gt;</a></li>';



            if($page - 5 > 0) $page5left = '<li><a href="search.php?q='.$search.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
            if($page - 4 > 0) $page4left = '<li><a href="search.php?q='.$search.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
            if($page - 3 > 0) $page3left = '<li><a href="search.php?q='.$search.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
            if($page - 2 > 0) $page2left = '<li><a href="search.php?q='.$search.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
            if($page - 1 > 0) $page1left = '<li><a href="search.php?q='.$search.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

            if($page + 5 <= $total) $page5right = '<li><a href="search.php?q='.$search.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
            if($page + 4 <= $total) $page4right = '<li><a href="search.php?q='.$search.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
            if($page + 3 <= $total) $page3right = '<li><a href="search.php?q='.$search.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
            if($page + 2 <= $total) $page2right = '<li><a href="search.php?q='.$search.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
            if($page + 1 <= $total) $page1right = '<li><a href="search.php?q='.$search.'&page='.($page + 1).'">'.($page + 1).'</a></li>';


            if ($page+5 <= $total)
            {
                $strtotal = '<li><p id="nav-point">...</p></li><li><a href="search.php?q='.$search.'&page='.$total.'">'.$total.'</a></li>';
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
                echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a id='pstr-active' href='search.php?q='.$search.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
                echo '
    </ul>
    </div>
    ';
            }
            ?>
        </ul>


    </div>
</div>
<div class="clear"></div>
<?php require_once "footer.php"?>
</body>
</html>
