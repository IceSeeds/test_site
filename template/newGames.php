<?php

  try {
      require_once __DIR__ . '/../manager/dbManager.php';
      $conn = getDb( "gamelist" );

      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      $sql = "SELECT * FROM list ORDER BY release_date DESC LIMIT 4";

      $res = $conn->prepare($sql);
      $res->execute();
      foreach( $res as $value )
      {
        echo '<div class="gameBox">
                <a href="./contents/gameBoard.php?select=' . $value['title_ry'] . '">
                  <img src="' . $value['image'] . '" alt="' . $value['title_ry'] . '">
                  <div class="newGame-gametitle">' . $value['title'] . '</div>
                  <p class="newGame-info"> ' . $value['info'] . '</p>
                </a>
              </div>';
      }
  } catch( PDOException $e )
  {
    echo $e->getMessage();
  }
  $conn = null;
?>
