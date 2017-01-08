<?php
session_start();
  $productname["コーラ"] = "コーラ";
  $productname["コーヒー"] = "コーヒー";
  $productname["ファンタオレンジ"] = "ファンタオレンジ";
  $productname["ファンタグレープ"] = "ファンタグレープ";
  $productname["サイダー"] = "サイダー";
  $productname["オレンジジュース"] = "オレンジジュース";

  $username["tateoka"] = "楯岡さん";
  $username["takase"] = "高瀬さん";
  $username["nakazato"] = "中里さん";
  $username["kuroki"] = "黒木さん";


$pdo = new PDO("sqlite:anohako.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//在庫の表示
// $st = $pdo->query("select * from product order by id desc");
// $product = $st->fetchAll();

$Pname = $_GET["productname"];
$st = $pdo->query("select price from product where name = '" . $Pname . "';");
$price = $st->fetchAll();

//$Pnumber = $stock[0]["number"];
// $st = $pdo->query("select number from zaiko where id = '" . $Pid . "';");
// $number = $st->fetchAll();

$Uname = $_GET["username"];
$st = $pdo->query("select money from user where name = '" . $Uname . "';");
$money = $st->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>My Blog - コメント登録</title>

  </head>
  <body>

<form action="userselect.php" method="get">
    <?php
    if(isset($_GET["productname"])){
      //残金の定義
      $money[0]['money'] = $money[0]['money'] - $price[0]['price'];

      print $productname[$Pname] . "を買いました。";
      print '<br>';
      print $username[$Uname] . "の所持金は" . $money[0]['money'] . "円になりました";

      print '<input type="hidden" name="money"  value='. $money[0]["money"].' >';
      print '<input type="hidden" name="number" value='.$_GET["number"].' >';
      $_GET["number"] = $_GET["number"]-1;
      print '<br>';
      print  $productname[$Pname]. "の在庫は" .$_GET["number"] ."個となりました";
  }
      ?>

　　<p class="article_link"><a href="userselect.php">トップページに戻る</a></p>
</form>

  </body>
</html>
