<?php
  if( isset( $_GET['select'] ) )
  {
    $select = $_GET['select'];
    session_start();
    $_SESSION['GAMESELECT'] = $select . "_friend";
  }
  try {
        require_once __DIR__ . '/../manager/dbManager.php';
        $conn = getDb( "gamelist" );
        // set the PDO error mode to exception
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $sql = "SELECT * FROM list WHERE title_ry LIKE '" . $select . "'";

        $res = $conn->prepare($sql);
        $res->execute();
        foreach( $res as $value )
        {
          $imgsrc = "../" . $value['image'];
?>
              <!DOCTYPE html>
              <html lang="ja">
                <head>
                  <meta charset="utf-8">
                  <script type="text/javascript">
                  <?php
                  if( !isset( $_SESSION["NAME"] ) )
                  {
                  ?>
                    var result = window.confirm('ログインしてください。');
                    if( result ) {
                        console.log('OKがクリックされました');
                        <?php
                          header("Location: ../login/Login.php");  // メイン画面へ遷移
                          exit();
                        ?>
                    }
                    else {
                        console.log('キャンセルがクリックされました');
                        <?php
                          header("Location: ../index.php");  // メイン画面へ遷移
                          exit();
                        ?>
                    }
                  <?php } ?>
                  </script>
                  <title><?php echo $value['title'] ?></title>
                  <link rel="stylesheet" href="../css/template/games.css">
                  <link rel="stylesheet" href="../css/template/roomArea.css">
                  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
                </head>
                <body>
                  <div class="header">
                    <?php require('../template/header.php'); ?>
                  </div>
                  <span class="wrapper">
                    <div class="comment">
                      <div class="game-info">
                        <img src=" <?php echo $imgsrc ?>" alt="<?php echo $value['title_ry'] ?>">
                        å‹Ÿé›†<span class="game-title"><?php echo $value['title'] ?></span>
                        <span>
                          <a href="gameList.php"><i class="recruit-icon fas fa-list-alt"></i></a>
                          <a href="room/createRoom.php"><i class="recruit-icon fas fa-door-open"></i></a>
                          <a href="gameBoard.php?select=<?php echo $_GET['select'] ?>"><i class="fas fa-comments"></i></a>
                        </span>
                      </div>
                      <?php require("../template/comment.php"); ?>
                    </div>
                    <div class="side">
                      <?php require('../template/side.php'); ?>
                    </div>
                  </span>
                  <div class="footer">
                    <?php require("../template/footer.php"); ?>
                  </div>
                </body>
              </html>
<?php
        }
      } catch( PDOException $e )
      {
          echo $e->getMessage();
      }
      $conn = null;
?>
