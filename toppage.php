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

$user = $_GET["username"];
$st = $pdo->query("select money from user where name = '" . $user . "';");
$money = $st->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Ano-hako-database</title>

  </head>
  <body>
      <?php
        print $username[$user] . "の所持金は" . $money[0]['money']. "円です";
        print '<input type="hidden" name="username" value='.$_GET["username"].' >';
      ?>
      <h3>商品を選択してください</h3>
      <form action="shopping_submit.php" method="get">
       <table>
         <tr>
           <th>drink</th>
           <th>price</th>
           <th>stock</th>
           <th>No.</th>
         </tr>
         <?php
         foreach($product as $p) {
           print '<tr>';
           print '<td><input type="radio" name="productname" value="'. $p["name"] .'">' . $p["name"] . '</th>';
           print '<td>' . $p["price"] . '円</th>';
           $st = $pdo->query("select * from stock where id =" .$p["id"] . ";");
           $stock = $st->fetchAll();
           print '<td>'.$stock[0]["number"].'個</td>';
           print '<td>'.$stock[0]["product_id"].'</td>';
           //print '<input type="hidden" name="number" value='.$stock[0]["number"].' >';
           print '</tr>';
         }
         ?>
        </table>
        <input type="submit" value="購入">
      </form>
  </body>
</html>
