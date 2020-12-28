<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>webssss</title>
    <style>
      body {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
      }
      .chatview {
        width: 50%;
        height: 100%;
        background-color: gray;
        margin-left: 25%;
        margin-top: 20%;

      }
    </style>
  </head>
  <body>
    <div class="chatview">
      <?php
        require('../../websock/chatConnect.php');
      ?>
    </div>
  </body>
</html>
