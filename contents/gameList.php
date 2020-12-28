
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link rel="stylesheet" href="list.css">
    <title>Game List</title>
  </head>
  <body>
    <?php require( '../template/header.php' ); ?>
    <div class="gamelist-title">Game List</div>
    <div class="col_4">
    <?php
      try {
          require_once __DIR__ . '/../manager/dbManager.php';
          $conn = getDb( "gamelist" );
          $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

          $sql = "SELECT * FROM list";

          $res = $conn->prepare($sql);
          $res->execute();
          foreach( $res as $value )
          {
            echo '<div class="box11">
                    <a href="gameBoard.php?select=' . $value['title_ry'] . '">
                      <img src="../' . $value['image'] . '" alt="' . $value['title_ry'] . '">
                      <div class="gamelist-gametitle"> ' . $value['title'] . '</div>
                      <p class="gamelist-gameinfo"> ' . $value['info'] . '</p>
                    </a>
                  </div>';
          }

      } catch( PDOException $e )
      {
        echo $e->getMessage();
      }
      $conn = null;
    ?>
    </div>
  </body>
</html>
