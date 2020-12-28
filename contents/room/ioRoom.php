<?php
function joinRoom()
{
  //session_start();

  $select = $_SESSION['GAMESELECT'];
  $url = '../contents/chatroom/' . $select . '/*.txt';
  $result = glob( $url );
  $check = "false";
  foreach( $result as $fileName )
  {
    if( strpos( $fileName, $_SESSION['ROOMTIME'] ) !== false )
    {
      // タイムゾーンを日本標準時に設定
      $date           = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
      $unixTime       = str_replace(array(" ", "　"), "", $date->format('U') );

      $fp = fopen( $fileName, "a" );
      flock( $fp, LOCK_EX );
      $str = $_SESSION['ID'] . "," . $_SESSION['NAME'] . "," . $unixTime . "\n";
      fwrite( $fp, $str );
      flock( $fp, LOCK_UN );
      fclose( $fp );

      echo "joinRoom";
      $check = "true";
      break;
    }
  }
  if( $check == "true" )
  {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/test/contents/room/websocket.php">
          <p>'. __DIR__ . '</p>';
  }else {
      echo 'error : なして？';
  }
}

function leave()
{
  session_start();

  $select = $_SESSION['GAMESELECT'];
  $url = '../chatroom/' . $select . '/*.txt';
  $result = glob( $url );
  foreach( $result as $fileName )
  {
    if( strpos( $fileName, $_SESSION['ROOMTIME'] ) !== false )
    {
      $fp = fopen( $fileName, "a+");
      flock( $fp, LOCK_EX ); //ファイルをロック
      $check = $_SESSION['ID'] . "," . $_SESSION['NAME'];
      $cnt = 0;
      while( $dt = fgets( $fp ) )
      {
        if( strpos( $dt, $check ) !== false )
        {
          echo 'delete : ' . $dt;
        }else if( $cnt == 0 )
        {
          $tmp = $dt;
        }else if( $cnt >= 1 )
        {
          $tmp .= $dt;
        }
        $cnt++;
      }
      ftruncate( $fp, 0 );
      fseek( $fp, 0 );
      fwrite( $fp, $tmp );
      flock( $fp, LOCK_UN ); //ファイルのロック解除
      fclose( $fp );
    }
  }
  $_SESSION['JOINED'] = "false";

  header("Location: ../../index.php", true , 301);
  exit();
}
 ?>
