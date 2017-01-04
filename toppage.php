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
$data = $st->fetchAll();

// $st = $pdo->query("select * from user where money =" .$username["name"] . ";");
// $data3 = $st->fetchAll();

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
        $name = $_GET["name"];
        print $username[$name]. "の所持金は";

      // foreach($data3 as $meney){
      //   print
      // }
    }

      foreach($data as $product) {
print '<div class="product">';
print '<p>商品名:' .$product["name"] . '</p>';
print '<p>値段:' . $product["price"] . '</p>';

$st = $pdo->query("select * from zaiko where id =" .$product["id"] . ";");
$data2 = $st->fetchAll();
foreach($data2 as $zaiko) {
print '<div class="zaiko">';
print '<p>商品の数:'.$zaiko["number"].'</p>';
print '<p>商品番号:'.$zaiko["priceid"].'</p>';
print '</div>';
print '</div>';
print '----------------------------------------';
}
}
       ?>
     </pre>

  </body>
</html>
