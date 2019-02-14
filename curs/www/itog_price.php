<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include('db_connect.php');
include('functions.php');

    $result = mysql_query("SELECT * FROM cart,table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
  
do
{
    $int = $int + ($row["price"] * $row["cart_count"]);

} while($row = mysql_fetch_array($result));


     echo group_numerals($int);

}
}
?>