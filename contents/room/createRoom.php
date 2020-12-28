<?php
if(isset( $_POST["createRoom"] ))
{

  session_start();
  $accN   = $_SESSION['NAME'];
  $accID  = $_SESSION['ID'];
  $_SESSION['ROOMNAME'] = $_POST['roomname'];
  try {
      require_once __DIR__ . '/../../manager/dbManager.php';
      $conn = getDb( "user_info" );
      // set the PDO error mode to exception
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      /* User Table */
      $sql = "SELECT id, name FROM user WHERE id = $accID";
      $res = $conn->query($sql);

      // 取得したデータを出力
      foreach( $res as $value )
      {
        echo "$value[name]<br>";

      }
        echo "Table MyGuests created successfully:::::" . $_POST['gameselect'];
        require_once 'gameShort.php';
        $gameName = gameshort( $_POST['gameselect'] );

        // タイムゾーンを日本標準時に設定
        $date           = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        $unixTime       = str_replace(array(" ", "　"), "", $date->format('U') );
        $_SESSION['ROOMTIME'] = $unixTime;

        $newGameFolder  = "../chatroom/" . $gameName;
        $newFile        = $newGameFolder. "/" . $unixTime . ".txt";

        if( !mkdir( $newGameFolder, 0777, true ) )
        {
          if( file_exists( $newFile ) )
            echo '既に作られてる。';
          else {
            $fileData = $unixTime . "," . $_POST['passwd1'] . "," . $_POST['maxpeople'] . "," . $_POST['roomname'] . "," . $_POST['message'] . ",0,0,0\n"
                        . $accID . "," . $accN . "," . $unixTime . "\n";
            file_put_contents( $newFile, $fileData );
            echo 'ファイル作成した';
          }
        } else {
          if( file_exists( $newFile ) )
            echo '既に作られてる。';
          else {
            $fileData = $unixTime . "," . $_POST['passwd1'] . "," . $_POST['maxpeople'] . "," . $_POST['roomname'] . "," . $_POST['message'] . ",0,0,0\n"
                        . $accID . "," . $accN . "," . $unixTime . "\n";
            file_put_contents( $newFile, $fileData );
            echo 'ファイル作成した';
          }
        }

        header("Location: ./websocket.php");  // メイン画面へ遷移
        exit();
    } catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  $conn = null;
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/room.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Room</title>
  </head>
  <body>
    <form class="create-room" action="" method="POST">
      <div class="form-group">
        <label for="text1">Room Name</label>
        <input type="text" id="roomname" name="roomname" class="form-control">
      </div>
      <div class="form-group">
        <label for="passwd1">Password</label>
        <input type="password" id="passwd1" name="passwd1" class="form-control">
      </div>
      <div class="form-group">
        <label for="text1">最大人数</label>
        <input type="text" id="maxpeople" name="maxpeople" class="form-control">
      </div>
      <div class="form-group">
        <label for="text1">一言メッセージ</label>
        <input type="text" id="message" name="message" class="form-control">
      </div>
      <div class="form-group">
        <label for="gameselect">Select:</label>
        <select id="gameselect" name="gameselect" class="form-control">
          <?php
            require_once 'gameShort.php';
            gameselect();
          ?>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" id="createRoom" name="createRoom" class="btn btn-primary mb-2">Submit</button>
      </div>
    </form>
  </body>
</html>
