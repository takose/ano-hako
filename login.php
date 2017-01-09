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
  <title></title>
</head>
<body>
  <h1>Login</h1>
  <form method="post" action="">
    <input type="text" name="username" placeholder="username" value="">
    <input type="password" name="password" placeholder="password" value="">
    <input type="hidden" name="token" value="<?=h(generate_token())?>">
    <input type="submit" value="buy drink">
  </form>
  <?php if (http_response_code() === 403): ?>
    <p style="color: red;">ユーザ名またはパスワードが違います</p>
  <?php endif; ?>
  <?php print $pass[0]['password'] ?>
</body>
</html>
