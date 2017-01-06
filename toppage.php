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

$name = $_GET["name"];
$st = $pdo->query("select money from user where name = '" . $name . "';");
$money = $st->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Ano-hako-database</title>
<!-- <link rel="stylesheet" href="myblog_style.css"> -->
  </head>
  <body>
    <pre>
<?php
if(isset($_GET["name"])){
  //[0]なんとかする
  print $username[$name] . "の所持金は" . $money[0]['money'];

  // foreach($data3 as $meney){
  //   print
  // }
}
?>
<table>
<?php
foreach($product as $p) {
  print '<tr>';
  print '<th>商品名:' .$p["name"] . '</th>';
  print '<th>値段:' . $p["price"] . '</th>';

  $st = $pdo->query("select * from zaiko where id =" .$p["id"] . ";");
  $stock = $st->fetchAll();
  print '<td>商品の数:'.$stock[0]["number"].'</td>';
  print '<td>商品番号:'.$stock[0]["priceid"].'</td>';
  print '<td>購入</td>'
  print '</tr>';
}
?>
</table>
     </pre>

  </body>
</html>
