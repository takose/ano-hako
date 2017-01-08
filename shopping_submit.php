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
$st = $pdo->query("select * from product where name = '" . $Pname . "';");
$product = $st->fetchAll();
//$Pnumber = $stock[0]["number"];
// $st = $pdo->query("select number from stock where id = '" . $Pid . "';");
// $number = $st->fetchAll();

$Uname = $_GET["username"];
$st = $pdo->query("select money from user where name = '" . $Uname . "';");
$money = $st->fetchAll();

$st = $pdo->query("select number from stock where product_id = '" . $product[0]["id"] . "';");
$stock = $st->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>My Blog - コメント登録</title>

  </head>
  <body>
<?php
print $stock[0]['number'];
?>
<form action="userselect.php" method="get">
    <?php
    if(isset($_GET["productname"])){
      //残金の定義
      $money[0]['money'] = $money[0]['money'] - $product[0]['price'];

      print $productname[$Pname] . "を買いました。";
      print '<br>';
      print $username[$Uname] . "の所持金は" . $money[0]['money'] . "円になりました";
      $st = $pdo->query("update user set money = " . $money[0]['money'] . " where name = '" . $Uname . "';");

      print '<input type="hidden" name="money"  value='. $money[0]["money"].' >';
      print '<input type="hidden" name="number" value='.$_GET["number"].' >';
      print '<br>';
      $after_number = $stock[0]["number"]-1;
      print  $productname[$Pname]. "の在庫は" . $after_number ."個となりました";
      $st = $pdo->query("update stock set number = " . $after_number . " where product_id = '" . $product[0]["id"] . "';");
  }
      ?>

　　<p class="article_link"><a href="userselect.php">トップページに戻る</a></p>
</form>

  </body>
</html>
