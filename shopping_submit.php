<?php
require_once __DIR__ . '/functions.php';
require_logined_session();

$pdo = new PDO("sqlite:anohako.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$Pname = $_GET["productname"];
if($Pname==""){
  header('Location: /toppage.php');
}
$st = $pdo->prepare('select * from product where name = ?;');
$st->execute(array($Pname));
$product = $st->fetchAll();

$username = $_SESSION['username'];
$st = $pdo->prepare('select money from user where name = ?;');
$st->execute(array($username));
$money = $st->fetchAll();

$st = $pdo->query('select * from stock where product_id = ?;');
$st->execute(array($product[0]['id']));
$stock = $st->fetchAll();

$money[0]['money'] = $money[0]['money'] - $product[0]['price'];
if($money[0]['money'] < 0){
  header('Location: /toppage.php');
} else {
  $st = $pdo->query('update user set money = ? where name = ?;');
  $st->execute(array($money[0]['money'], $username));
}

$after_number = $stock[0]["number"]-1;
if($after_number < 0){
  header('Location: /toppage.php');
} else {
  $st = $pdo->query('update stock set number = ? where product_id = ?;');
  $st->execute(array($after_number, $product[0]["id"]));
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/10up-sanitize.css/4.1.0/sanitize.min.css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="./style.css">
    <script src="//code.jquery.com/jquery-2.0.0.min.js"></script>
    <title>My Blog - コメント登録</title>

  </head>
  <body>
    <div class="container">
    <div class="blossom"></div>
    <div id="bought">
    </div>
    <div class="blossom"></div>
    <?php
      print "Thanks!";
      print '<br>';
      print "残高:" . $money[0]['money'] . "円<br>";
    ?>
    <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect article_link" type="button" onclick="location.href='toppage.php'"value="buy more">
  </div>
  <div id="server-id_data-provider" data-msg="<?=h($product[0]['id'])?>"></div>
  <div id="server-usr_data-provider" data-usr="<?=h($username)?>"></div>
  </body>
  <script src="//cdn.rawgit.com/cidreixd/webmo-library-javascript/master/dist/webmo.min.js"></script>
  <script>
    webmo1 = new Webmo.ws("192.168.10.4")
    webmo2 = new Webmo.ws("192.168.10.2")
    webmo3 = new Webmo.ws("192.168.10.3")
    const server_data = document.querySelector('#server-id_data-provider').dataset;
    function rotate_to_drop_top(webmo){
      webmo.rotateBy(60,90)
      setTimeout(function () {
        webmo.rotateBy(-60,90)
      }, 2000)
    }
    function rotate_to_drop_bottom(webmo){
      webmo.rotateBy(-60,90)
      setTimeout(function () {
        webmo.rotateBy(60,90)
      }, 2000)
    }
    webmo1.onopen = function () {
      if (server_data.msg == 1){
        rotate_to_drop_top(webmo1)
      } else if (server_data.msg == 2){
        rotate_to_drop_bottom(webmo1)
      } 
    }
    webmo2.onopen = function () {
      if (server_data.msg == 3){
        rotate_to_drop_top(webmo2)
      } else if (server_data.msg == 4){
        rotate_to_drop_bottom(webmo2)
      } 
    }
    webmo3.onopen = function () {
      if (server_data.msg == 5){
        rotate_to_drop_top(webmo3)
      } else if (server_data.msg == 6){
        rotate_to_drop_bottom(webmo3)
      } 
    }

    const usr_data = document.querySelector('#server-usr_data-provider').dataset;
    const reqURL = 'https://api.github.com/users/' + usr_data.usr + '/events'
    const day = new Date();
    const today = day.getFullYear()+"-"+("0"+(day.getMonth()+1)).slice(-2)+"-"+("0"+day.getDate()).slice(-2)
    var commits = 0
    console.log(today);
    $.getJSON(reqURL)
    .done(function(data) {
      $.each(data, function(index, val){
        if(val.type == "PushEvent" && val.created_at.substr(0, 10) == today){
          commits += val.payload.commits.length
        }
      })
      console.log(commits)
      var blossom = ''
      for(var i=0;i<commits;i++){
        blossom += "🌸" 
      }
      $('.blossom').text(blossom)
    })
  </script>
</html>
