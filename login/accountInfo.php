<?php
/*----------------------
|         view
----------------------*/
session_start();
try {
    $accID = $_SESSION["ID"];
    require_once __DIR__ . '/../manager/dbManager.php';
    $conn = getDb( "user_info" );
    // set the PDO error mode to exception
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    /* User Table */
    $sql = "SELECT * FROM user where id = '" . $accID . "'";

    $res = $conn->prepare($sql);
    $res->execute();
} catch(PDOException $e)
{
    echo $e->getMessage();
}
$conn = null;

/*----------------------
|         edit
----------------------*/
if (isset($_POST["edit"]))
{
    $accID = $_SESSION["ID"];
    /* TODO バリデーション！ */
    $_SESSION['NAME']     = $_POST["e-name"]; //変えていいのか？？　変えた後の処理をもう少し考える
    $_SESSION['EMAIL']    = $_POST["e-email"];
    $_SESSION['INFO']     = $_POST["e-info"];
    $_SESSION['PS']       = $_POST["e-ps"];
    $_SESSION['DISCORD']  = $_POST["e-discord"];
    $_SESSION['SKYPE']    = $_POST["e-skype"];
    $_SESSION['STEAM']    = $_POST["e-steam"];

    $name     = $_POST["e-name"];
    $email    = $_POST["e-email"];
    $info     = $_POST["e-info"];
    $ps       = $_POST["e-ps"];
    $discord  = $_POST["e-discord"];
    $skype    = $_POST["e-skype"];
    $steam    = $_POST["e-steam"];

    try {
        require_once __DIR__ . '/../manager/dbManager.php';
        $conn = getDb( "user_info" );
        // set the PDO error mode to exception
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        /* User Table */
        $sql = "UPDATE user SET
          name    = '" . $name . "',
          email   = '" . $email . "',
          info    = '" . $info . "',
          ps      = '" . $ps . "',
          discord = '" . $discord . "',
          skype   = '" . $skype . "',
          steam   = '" . $steam . "'
        where id = '" . $accID . "'";

        $sql = $conn->prepare($sql);
        $sql->execute();
    } catch(PDOException $e)
    {
        echo $e->getMessage();
    }
  $conn = null;

  header('Location: ./accountInfo.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/accInfo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Account Info</title>
  </head>
  <body>
    <?php require('../template/header.php'); ?>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="item1-tab" data-toggle="tab" href="#item1" role="tab" aria-controls="item1" aria-selected="true">Item#1</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="item2-tab" data-toggle="tab" href="#item2" role="tab" aria-controls="item2" aria-selected="false">Item#2</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="item3-tab" data-toggle="tab" href="#item3" role="tab" aria-controls="item3" aria-selected="false">Item#3</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="item1" role="tabpanel" aria-labelledby="item1-tab">
        <div class="form-view">
          <?php
          foreach( $res as $vals )
          {
            echo "
              <div class='acc-wrap'>
                <div class='name'>Name : " . $vals['name'] . "</div>
                <div class='email'>E-Mail : " . $vals['email'] . "</div>
                <div class='info'>INFO : " . $vals['info'] . "</div>
                <hr>
                <div class='ps'>PSID : " . $vals['ps'] . "</div>
                <div class='discord'>DiscordID : " . $vals['discord'] . "</div>
                <div class='skype'>SkypeID : " . $vals['skype'] . "</div>
                <div class='steam'>STEAMID : " . $vals['steam'] . "</div>
              </div>
            ";
          }
          ?>
        </div>
        <hr>
        <li class="nav-list-item"><button type="button" id="item2-tab" data-toggle="tab" href="#item2" role="tab" aria-controls="item2" aria-selected="true" class="btn btn-outline-secondary">Edit</button></li>
      </div>
      <div class="tab-pane fade" id="item2" role="tabpanel" aria-labelledby="item2-tab">
        This is a text of item#2.
        <div class="form-edit">
          <form action="" method="post">
            <div class="form-group">
              <label for="text1">Name : </label>
              <input type="text" id="e-name" name="e-name" value=<?php echo $_SESSION['NAME'] ?> class="form-control">
            </div>
            <div class="form-item">
              <label for="email">E-Mail : </label>
              <input type="email" id="e-email" name="e-email" value=<?php echo $_SESSION['EMAIL'] ?> placeholder="e-mail">
            </div>
            <div class="form-group">
              <label for="textarea1">Info:</label>
              <textarea id="e-info" name="e-info" value=<?php echo $_SESSION['INFO'] ?> class="form-control"></textarea>
            </div>

            <hr>

            <div class="form-group">
              <label for="text1">PSID:</label>
              <input type="text" id="e-ps" name="e-ps" class="form-control" value=<?php echo $_SESSION['PS'] ?> >
            </div>
            <div class="form-group">
              <label for="text1">DiscordID:</label>
              <input type="text" id="e-discord" name="e-discord" class="form-control" value=<?php echo $_SESSION['DISCORD'] ?> >
            </div>
            <div class="form-group">
              <label for="text1">SkypeID:</label>
              <input type="text" id="e-skype" name="e-skype" class="form-control" value=<?php echo $_SESSION['SKYPE'] ?> >
            </div>
            <div class="form-group">
              <label for="text1">SteamID:</label>
              <input type="text" id="e-steam" name="e-steam" class="form-control" value=<?php echo $_SESSION['STEAM'] ?> >
            </div>
            <input type="submit" id="edit" name="edit" value="EDIT" class="btn btn-outline-secondary"></input>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="item3" role="tabpanel" aria-labelledby="item3-tab">
        This is a text of item#3.
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
