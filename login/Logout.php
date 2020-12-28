<?php
  session_start();

  if (isset($_SESSION["NAME"])) {
      $errorMessage = "ログアウトしました。";
  } else {
      $errorMessage = "セッションがタイムアウトしました。";
  }

  // セッションの変数のクリア
  $_SESSION = array();

  // セッションクリア
  @session_destroy();

  header("Location: ../index.php");  // メイン画面へ遷移
  exit();
?>
