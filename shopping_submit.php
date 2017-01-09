<?php
require_once __DIR__ . '/functions.php';
require_logined_session();

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

$username = $_SESSION['username'];
$st = $pdo->query("select money from user where name = '" . $username . "';");
$money = $st->fetchAll();

$st = $pdo->query("select * from stock where product_id = '" . $product[0]['id'] . "';");
$stock = $st->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/10up-sanitize.css/4.1.0/sanitize.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>My Blog - コメント登録</title>

  </head>
  <body>
    <div class="container">
    <form action="userselect.php" method="get">
    <?php
      //残金の定義
      $money[0]['money'] = $money[0]['money'] - $product[0]['price'];

      print "Thanks!";
      print '<br>';
      print "残高:" . $money[0]['money'] . "円";
      $st = $pdo->query("update user set money = " . $money[0]['money'] . " where name = '" . $username . "';");

      print '<input type="hidden" name="money"  value='. $money[0]["money"].' >';
      print '<input type="hidden" name="number" value='.$_GET["number"].' >';
      $after_number = $stock[0]["number"]-1;
      $st = $pdo->query("update stock set number = " . $after_number . " where product_id = '" . $product[0]["id"] . "';");
      ?>
　　<p class="article_link mes"><a href="toppage.php" >buy more</a></p>
    </form>
  </div>
  </body>
</html>
