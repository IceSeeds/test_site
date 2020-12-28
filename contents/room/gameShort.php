<?php
  function gameshort( $gamename )
  {
    $res = "nullsse";
    try {
          require_once __DIR__ . '/../../manager/dbManager.php';
          $conn = getDb( "gamelist" );
          // set the PDO error mode to exception
          $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

          $sql = 'SELECT * FROM list WHERE title LIKE "' . $gamename . '"';

          $res = $conn->prepare($sql);
          $res->execute();
          foreach( $res as $value )
          {
            $res = $value['title_ry'];
          }
        } catch( PDOException $e )
        {
            echo $e->getMessage();
        }
    $conn = null;

    return $res;
  }

  function gameselect()
  {
    try {
          require_once __DIR__ . '/../../manager/dbManager.php';
          $conn = getDb( "gamelist" );
          // set the PDO error mode to exception
          $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

          $sql = "SELECT * FROM list";

          $res = $conn->prepare($sql);
          $res->execute();
          foreach( $res as $value )
          {
  ?>
            <option><?php echo $value['title']; ?></option>
  <?php
          }
        } catch( PDOException $e )
        {
            echo $e->getMessage();
        }
    $conn = null;
  }

?>
