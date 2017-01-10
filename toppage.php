<?php
require_once __DIR__ . '/functions.php';
require_logined_session();

$pdo = new pdo("sqlite:anohako.sqlite");
$pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//在庫の表示
$st = $pdo->query("select * from product order by id desc");
$product = $st->fetchAll();

$user = $_SESSION['username'];
$st = $pdo->query("select money from user where name = '" . $user . "';");
$money = $st->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/10up-sanitize.css/4.1.0/sanitize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="./style.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <title>Ano-hako-database</title>
  </head>
  <body>
    <div class="container">
      <div class="mes"><?php print "残高: " . $money[0]['money']. "円"; ?></div>
      <form action="shopping_submit.php" method="get">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
          <tr>
            <th class="mdl-data-table__cell--non-numeric">drink</th>
            <th>price</th>
            <th>stock</th>
          </tr>
          <?php
          foreach($product as $p) {
            print '<tr>';
            print '<td class="mdl-data-table__cell--non-numeric"><input type="radio" name="productname" value="'. $p["name"] .'">' . $p["name"] . '</th>';
            print '<td>' . $p["price"] . '円</th>';
            $st = $pdo->query("select * from stock where id =" .$p["id"] . ";");
            $stock = $st->fetchAll();
            print '<td>'.$stock[0]["number"].'個</td>';
            //print '<input type="hidden" name="number" value='.$stock[0]["number"].' >';
            print '</tr>';
          }
          print '<input type="hidden" name="username" value='.$_GET["username"].' >';
          ?>
       </table>
       <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect buy" type="submit" value="購入">
     </form>
  </div>
  <a href="/logout.php?token=<?=h(generate_token())?>">ログアウト</a>
  </body>
</html>
