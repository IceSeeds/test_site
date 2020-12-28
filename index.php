<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>Hyacinth</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  </head>
  <body>
    <header class="header">
      <p class="site-title-sub">You Notice New Friends</p>
      <h1 class="site-title">ヒヤシンス</h1>
      <p class="site-description">Have a good game life.</p>
      <div class="buttons">
        <?php
          session_start();
          if( !isset( $_SESSION["NAME"] ) )
          {
        ?>
            <button type="button" class="button btn btn-primary" onclick="location.href='./login/Login.php'">ログイン</button>
            <button type="button" class="button btn btn-info" onclick="location.href='./login/SignUp.php'">新規登録</button>
        <?php
          }else {
        ?>
          <div class="account">
            <span class="account-text"><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>でログイン中</span>
            <button type="button" class="button btn btn-primary" onclick="location.href='./login/Logout.php'">ログアウト</button>
          </div>
        <?php  } ?>
      </div>
    </header>
    <div class="main">
      <section class="about">
        <h2 class="heading">ABOUT</h2>
        <div class="about-text">
          tesutotesutotesut
          tesutsdutesu<br>
          Hyacinth<br>
          tesdefesdfesfdfesfesfd<br>
          fjekskdjfseikiskefs
        </div>
      </section>
      <section class="newgame">
        <h2 class="heading">NEW GAME</h2>
        <div class="newGameBox">
          <?php require_once __DIR__ . '/template/newGames.php'; ?>
        </div>
      </section>

      <section class="ranking">
        <h2 class="heading">TRAND GAME</h2>
        <div class="rankingBox">
          <section class="gameBox">
            <a href="./contents/gameBoard.php?select=r6s">
              <img src="./images/games/r6s.jpg" alt="r6s">
              <div class="ranking-gametitle">Tom Clancy's Rainbow Six Siege</div>
              <p class="ranking-info">説明が二行ぐらい表示されます</p>
            </a>
          </section>
          <section class="gameBox">
            <a href="./contents/gameBoard.php?select=r6s">
              <img src="./images/games/r6s.jpg" alt="r6s">
              <div class="ranking-gametitle">Tom Clancy's Rainbow Six Siege</div>
              <p class="ranking-info">説明が二行ぐらい表示されます</p>
            </a>
          </section>
          <section class="gameBox">
            <a href="./contents/gameBoard.php?select=r6s">
              <img src="./images/games/r6s.jpg" alt="r6s">
              <div class="ranking-gametitle">Tom Clancy's Rainbow Six Siege</div>
              <p class="ranking-info">説明が二行ぐらい表示されます</p>
            </a>
          </section>
          <section class="gameBox">
            <a href="./contents/gameBoard.php?select=r6s">
              <img src="./images/games/r6s.jpg" alt="r6s">
              <div class="ranking-gametitle">Tom Clancy's Rainbow Six Siege</div>
              <p class="ranking-info">説明が二行ぐらい表示されます</p>
            </a>
          </section>
        </div>
      </section>

      <section class="contents">
        <h2 class="heading">CONTENTS</h2>
        <div class="contents-wrapper">
          <div class="contents-box">
            <a href="./contents/gameList.php"><i class="contents-icon fas fa-list-alt"></i></a>
            <div class="contents-title">ゲームリスト</div>
            <p class="contents-text">
              ゲームリスト表示。
              なにかかんばえる
            </p>
          </div>
          <div class="contents-box">
            <a href="./contents/room/createRoom.php"><i class="contents-icon fas fa-door-open"></i></a>
            <div class="contents-title">部屋を作成</div>
            <p class="contents-text">
              部屋を作成する。
              なにかかんばえる
            </p>
          </div>
          <div class="contents-box">
            <a href="./contents/gameList.php"><i class="contents-icon far fa-handshake"></i></a>
            <div class="contents-title">仲間を募集</div>
            <p class="contents-text">
              仲間を募集する。
              なにかかんばえる
            </p>
          </div>
        </div>
      </section>
    </div>
    <footer class="footer">

    </footer>
  </body>
</html>
