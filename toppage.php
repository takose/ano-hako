<?php
session_start();
  $username["tateoka"] = "楯岡さん";
  $username["takase"] = "高瀬さん";
  $username["nakazato"] = "中里さん";
  $username["kuroki"] = "黒木さん";

$pdo = new PDO("sqlite:anohako.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//在庫の表示
$st = $pdo->query("select * from product order by id desc");
$product = $st->fetchAll();

$Uname = $_GET["username"];
$st = $pdo->query("select money from user where name = '" . $Uname . "';");
$money = $st->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Ano-hako-database</title>

  </head>
  <body>
    <pre>
<form action="shopping_submit.php" method="get">
      <?php
      if(isset($_GET["username"])){

        print $username[$Uname] . "の所持金は" . $money[0]['money']. "円です";
        print '<input type="hidden" name="username" value='.$_GET["username"].' >';
     }
      ?>
      <table>
        <?php


        foreach($product as $p) {
          print '<tr>';
          print '<th>商品名:' .$p["name"] . '</th>';
          print '<th>値段:' . $p["price"] . '円</th>';
          $st = $pdo->query("select * from zaiko where id =" .$p["id"] . ";");
          $stock = $st->fetchAll();
          print '<td>商品の数:'.$stock[0]["number"].'個</td>';
          print '<td>商品番号:'.$stock[0]["priceid"].'</td>';
          //print '<input type="hidden" name="number" value='.$stock[0]["number"].' >';
          print '</tr>';
        }
        ?>

     </table>
     <form action="shopping_submit.php" method="get"> 商品を選択してください<br>
             <input type="checkbox" name="productname" value="コーラ">コーラ
             <input type="checkbox" name="productname" value="コーヒー">コーヒー
             <input type="checkbox" name="productname" value="ファンタオレンジ">ファンタオレンジ
             <input type="checkbox" name="productname" value="ファンタグレープ">ファンタグレープ
             <input type="checkbox" name="productname" value="サイダー">サイダー
             <input type="checkbox" name="productname" value="オレンジジュース">オレンジジュース
<input type="submit" value="購入">
</form>
   </pre>
  </body>
</html>
