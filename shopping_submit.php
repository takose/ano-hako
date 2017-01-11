<?php
require_once __DIR__ . '/functions.php';
require_logined_session();

$pdo = new PDO("sqlite:anohako.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//在庫の表示
// $st = $pdo->query("select * from product order by id desc");
// $product = $st->fetchAll();

$Pname = $_GET["productname"];
if($Pname===""){
  header('Location: /toppage.php');
}
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
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="./style.css">
    <script src="//code.jquery.com/jquery-2.0.0.min.js"></script>
    <title>My Blog - コメント登録</title>

  </head>
  <body>
    <div class="container">
    <div class="blossom"></div>
    <div id="bought">
    <?php
      //残金の定義
      $money[0]['money'] = $money[0]['money'] - $product[0]['price'];

      print "Thanks!";
      print '<br><br>';
      print "残高:" . $money[0]['money'] . "円";
      $st = $pdo->query("update user set money = " . $money[0]['money'] . " where name = '" . $username . "';");

      $after_number = $stock[0]["number"]-1;
      $st = $pdo->query("update stock set number = " . $after_number . " where product_id = '" . $product[0]["id"] . "';");
?>
    </div>
    <div class="blossom"></div>
    <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect article_link" type="button" onclick="location.href='toppage.php'"value="buy more">
  </div>
  <div id="server-id_data-provider" data-msg="<?=h($product[0]['id'])?>"></div>
  <div id="server-usr_data-provider" data-usr="<?=h($username)?>"></div>
  </body>
  <script src="//cdn.rawgit.com/cidreixd/webmo-library-javascript/master/dist/webmo.min.js"></script>
  <script>
      
    webmo1 = new Webmo.ws("webmo-cmp25-0.local")
    webmo2 = new Webmo.ws("webmo-cmp25-1.local")
    webmo3 = new Webmo.ws("webmo-cmp25-2.local")
    const server_data = document.querySelector('#server-id_data-provider').dataset;
    webmo1.onopen = function () {
      if (server_data.msg == 1){
        console.log("rotate")
          webmo1.rotateBy(60,90)
          setTimeout(function () {
            webmo1.rotateBy(-60,90)
          }, 2000)
      } else if (server_data.msg == 2){
        console.log("rotate")
          webmo1.rotateBy(-60,90)
          setTimeout(function () {
            webmo1.rotateBy(60,90)
          }, 2000)
      } 
    }
    webmo2.onopen = function () {
      if (server_data.msg == 3){
        console.log("rotate")
          webmo2.rotateBy(60,90)
          setTimeout(function () {
            webmo2.rotateBy(-60,90)
          }, 2000)
      } else if (server_data.msg == 4){
        console.log("rotate")
          webmo2.rotateBy(-60,90)
          setTimeout(function () {
            webmo2.rotateBy(60,90)
          }, 2000)
      } 
    }
    webmo3.onopen = function () {
      if (server_data.msg == 5){
        console.log("rotate")
          webmo3.rotateBy(60,90)
          setTimeout(function () {
            webmo3.rotateBy(-60,90)
          }, 2000)
      } else if (server_data.msg == 6){
        console.log("rotate")
          webmo3.rotateBy(-60,90)
          setTimeout(function () {
            webmo3.rotateBy(60,90)
          }, 2000)
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
