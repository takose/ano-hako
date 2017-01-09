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
    <title>Ano-hako-database</title>

  </head>
  <body>
    <h3>商品を選択してください</h3>
      <?php print $_SESSION['username'] . "の所持金は" . $money[0]['money']. "円です"; ?>
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
          print '<input type="hidden" name="username" value='.$_GET["username"].' >';
          ?>
       </table>
       <input type="submit" value="購入">
     </form>
     <a href="/logout.php?token=<?=h(generate_token())?>">ログアウト</a>
  </body>
</html>
