<?php
require_once __DIR__ . '/functions.php';
require_logined_session();

$pdo = new pdo("sqlite:anohako.sqlite");
$pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$st = $pdo->query("select * from product");
$product = $st->fetchAll();

$st = $pdo->query("select * from user");
$user = $st->fetchAll();

$st = $pdo->query("select * from stock");
$stock = $st->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/10up-sanitize.css/4.1.0/sanitize.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <link rel="stylesheet" href="./style.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

  <title></title>
</head>
<body>
   <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
     <tr>
       <th class="mdl-data-table__cell--non-numeric">drink</th>
       <th>price</th>
       <th>stock</th>
     </tr>
<?php
foreach($product as $p) {
  print '<form action="shopping_submit.php" method="get">';
  print '<tr>';
  print '<td class="mdl-data-table__cell--non-numeric">' . $p["name"] . '</td>';
  print '<td>' . $p["price"] . '円</th>';
  print '<td>'.$stock[$p["id"]]["number"].'個</td>';
  print '<td><input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect buy" type="submit" value="buy"></td>';
  print '</tr>';
  print '</form>';
}
?>
</table>
</body>
</html>
