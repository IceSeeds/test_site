<?php
  $_SESSION['JOINED'] = "false";

  if(isset( $_POST["joinRoom"] ))
  {
    $_SESSION['ROOMNAME'] = $_POST['selectRoom'];
    $_SESSION['ROOMTIME'] = $_POST['roomTime'];
    //echo $_SESSION['ROOMNAME'] . "だそ！";
    $join = $_SESSION['JOINED'];
    if( $join == "false" )
    {
      echo "なして????";
      $_SESSION['JOINED'] = "true";

      require_once __DIR__ . '/../contents/room/ioRoom.php';
      joinRoom();

      /* TODO Comment.phpとどっか競合してるらしい。。。*/
    }
  }
  $select = $_SESSION['GAMESELECT'];
  $url = "../contents/chatroom/" . $select . "/*.txt";
  $result = glob( $url );
  foreach( $result as $fileName )
  {
    //データ読み取り開始番号
    $dtcnt = 1;
    $select = 0;
    $times = 0;
    //ファイルを開く
    $roomdata = fopen( $fileName, "r" );
    // ファイルを1行ずつ取得する
    while( $dt = fgets( $roomdata ) )
    {
      if( $dtcnt == 1 )
      {
        $room_info = preg_split( '/,/', $dt );
        //部屋情報
        // $unixTime . "," . $_POST['passwd1'] . "," . $_POST['maxpeople'] . "," . $_POST['roomname'] . "," . $_POST['message'] . ",0,0,0\n"
        $createtime  = $room_info[0];
        $roomkey     = $room_info[1];
        $maxp        = $room_info[2];
        $roomtitle   = $room_info[3];
        $roomcomment = $room_info[4];
        $yobi1       = $room_info[5];
        $yobi2       = $room_info[6];

        $rom = [ $select => $roomtitle ];
        $romtime = [ $times  => $createtime ];
        $dtcnt++;
?>
      <div class='wrap'>
        <div class='xmain'>
          <span class='room-lock'>true</span>
          <span class='room-title'><?php echo $rom[$select] ?></span><?php echo $maxp ?>
          <div class='cn1'>
            <span class='mess'><?php echo $roomcomment ?></span>
          </div>
          <div class='line'></div>
          <div class='in-button'>
            <form action="" method="post">
              <input type="hidden" name="selectRoom" value="<?php echo $rom[$select] ?>">
              <input type="hidden" name="roomTime" value="<?php echo $romtime[$times] ?>">
              <button type="submit" id="joinRoom" name="joinRoom" class="btn btn-primary mb-2">Join</button>
            </form>
          </div>
        </div>
      </div>
      <hr>
<?php
      }
    }
    $select++;
    // ファイルを閉じる
    fclose($roomdata);
  }
?>
