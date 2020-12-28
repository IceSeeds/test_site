
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../css/template/comment.css">
  </head>
  <body>

<?php
$select = $_SESSION['GAMESELECT'];
if( !isset( $_SESSION["NAME"] ) )
{
  $name = "名無しのゲーム廃人";
}else {
  $name = $_SESSION["NAME"];
}

/*----------------------------------
|           PUSH  SEND
-----------------------------------*/
if( isset( $_POST['send'] ) === true )
{
  if( false === strpos( $_SESSION['GAMESELECT'], 'friend' ) )
    $select = $_SESSION['GAMESELECT'];
  else if( false !== strpos( $_SESSION['GAMESELECT'], 'friend' ) )
    $select .= "_friend";

    try {
        $name     = $_POST["name"];
        $comment = nl2br( $_POST['comment'], false );

        require_once __DIR__ . '/../manager/dbManager.php';
        $conn = getDb( "board_db" );

        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $date           = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        $unixTime       = str_replace(array(" ", "　"), "", $date->format('U') );

        $sql = "INSERT INTO $select ( name, comment, date ) VALUES ( '" . $name . "', '" . $comment . "', '" . $unixTime . "' )";

        $resinsert = $conn->prepare($sql);
        $resinsert->execute();

    } catch( PDOException $e )
    {
      echo $e->getMessage();
    }
    $conn = null;
}

try {
    require_once __DIR__ . '/../manager/dbManager.php';
    $conn = getDb( "board_db" );

    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = "SELECT * FROM $select ORDER BY date DESC";

    $res = $conn->prepare($sql);
    $res->execute();

    $sql = 'SELECT * FROM images ORDER BY created_at DESC';

} catch( PDOException $e )
{
  echo $e->getMessage();
}
$conn = null;

?>
    <form method="post" action="">
      <div class="send-comment">
        <p>コメントを投稿</p>
        <input type="text" name="name" class="form-control" placeholder=<?php echo " $name "?>>
        <textarea class="form-control" name="comment" rows="4" cols="20" wrap="hard" placeholder="コメントを書く" ></textarea>
        <input class="btn btn-outline-primary" type="submit" name="send" value="投稿" />
      </div>
    </form>
    <?php foreach( $res as $vals ){ ?>
      <div class="db-comment">
        <span class="box-title">
          <?php echo $vals['id'] . ' : ' . $vals['name'] . ' : ' . $vals['date'] ?>
        </span>
        <p class="comment-main"><?php echo $vals['comment'] ?></p>
      </div>
    <?php } ?>
  </body>
</html>
<?php /*<?php getImage( $vals['id'] ) . $vals['id'] . ' : ' . $vals['name'] . ' : ' . $vals['date']*/ ?>
