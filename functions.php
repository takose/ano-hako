<?php

function require_unlogined_session()
{
  // セッション開始
  @session_start();
  // ログインしていれば / に遷移
  if (isset($_SESSION['username'])) {
    header('Location: /toppage.php');
    exit;
  }
}
function require_logined_session()
{
  // セッション開始
  @session_start();
  // ログインしていなければ /login.php に遷移
  if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
  }
}

function generate_token()
{
  // セッションIDからハッシュを生成
  return hash('sha256', session_id());
}

function validate_token($token)
{
  // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
  return $token === generate_token();
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

