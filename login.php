<?php

require_once __DIR__ . '/functions.php';
require_unlogined_session();

// ユーザから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo = new pdo("sqlite:anohako.sqlite");
  $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $st = $pdo->query("select password from user where name = '" . $username . "';");
  $pass = $st->fetchAll();
  $hashes = [$username => password_hash($pass[0]['password'], PASSWORD_BCRYPT)];
  if (validate_token(filter_input(INPUT_POST, 'token')) && 
    password_verify($password, isset($hashes[$username])? $hashes[$username]: '$2y$10$abcdefghijklmnopqrstuv' )){
    session_regenerate_id(true);
    // ユーザ名をセット
    $_SESSION['username'] = $username;
    // ログイン完了後に / に遷移
    header('Location: /toppage.php');
    exit;
  }
  // 認証が失敗したとき
  // 「403 Forbidden」
  http_response_code(403);
}

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/10up-sanitize.css/4.1.0/sanitize.min.css">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <link rel="stylesheet" href="./style.css">
  <title></title>
</head>
<body>
  <div class="container">
  <h2>Login</h2>
  <div>//ユーザ名: takose, パスワード: passtakase でログインして下さい<div>
  <form method="post" action="">
    <input type="text" class="login_form" name="username" placeholder="username" value="">
    <input type="password" class="login_form" name="password" placeholder="password" value="">
    <input type="hidden" name="token" value="<?=h(generate_token())?>"><br>
    <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect buy" type="submit" value="buy drink">
  </form>
  <?php if (http_response_code() === 403): ?>
    <p style="color: red;">ユーザ名またはパスワードが違います</p>
  <?php endif; ?>
  </div>
</body>
</html>
