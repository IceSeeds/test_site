<?php
if (isset($_POST["add"]))
{
  try {
      require_once 'dbManager.php';
      $conn = getDb( "gamelist" );

      // set the PDO error mode to exception
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      $title        = $_POST['title'];
      $title_r      = $_POST['title_r'];
      //$image    = $_POST['image'];
      $image        = "images/games/" . $_POST['title_r'] . ".jpg";
      $info         = nl2br( $_POST['info'], false );
      $release      = $_POST['release'];
      $pc           = $_POST['pc'];
      $playstation  = $_POST['playstation'];
      $nintendo     = $_POST['nintendo'];
      $genre_1      = $_POST['genre_1'];
      $genre_2      = $_POST['genre_2'];
      $genre_3      = $_POST['genre_3'];

      $sql = "INSERT INTO list VALUES (
        '" . $title . "',
        '" . $title_r . "',
        '" . $image . "',
        '" . $info . "',
        '" . $release . "',
        '" . $pc . "',
        '" . $playstation . "',
        '" . $nintendo . "',
        '" . $genre_1 . "',
        '" . $genre_2 . "',
        '" . $genre_3 . "')";

      $sql = $conn->prepare($sql);
      $sql->execute();

      echo "insert into sucsess!! : " . $title;

  } catch(PDOException $e)
  {
      echo $e->getMessage();
  }
  $conn = null;

/*  */
  $servername = "localhost";
  $username   = "admin";
  $password   = "admin";
  $dbname     = "board_db";

  try {
      $conn = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password );
      // set the PDO error mode to exception
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      $sql = "CREATE TABLE $title_r
      (
        id int not null auto_increment primary key,
        name varchar(20),
        comment text,
        date text
      ) engine=innodb default charset=utf8";

      $sql = $conn->prepare($sql);
      $sql->execute();

      echo "insert into sucsess!! : " . $title;

      $title_r .= "_friend";
      $sql = "CREATE TABLE $title_r
      (
        id int not null auto_increment primary key,
        name varchar(20),
        comment text,
        date text
      ) engine=innodb default charset=utf8";

      $sql = $conn->prepare($sql);
      $sql->execute();

      echo "insert into sucsess!! : " . $title_r;
/*
      header('Location: ./Addlist.php');
      exit();
*/
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
    <title>AddList</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      body {
        height: 100%;
        width: 100%;
      }
      .wr {
        width: 70%;
        height: 100%;
        padding: 5%;
      }
    </style>
  </head>
  <body>
    <div class="wr">
      <form action="" method="post">
        <div class="form-group">
          <label for="text1">title:</label>
          <input type="text" id="title" name="title" placeholder="記号に気を付けて" class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">title_r:</label>
          <input type="text" id="title_r" name="title_r" placeholder="大文字禁止!　小文字のみ" class="form-control">
        </div>
        <!--
        <div class="form-group">
          <label for="text1">image:</label>
          <input type="text" id="image" name="image" placeholder="ゲーム略.jpg" class="form-control">
        </div>
      -->
        <div class="form-group">
          <label for="text1">info:</label>
          <textarea id="info" name="info" placeholder="ゲーム説明" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="text1">pc:</label>
          <input type="text" id="pc" name="pc" placeholder="true = 0" class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">playstation:</label>
          <input type="text" id="playstation" name="playstation" placeholder="true = 0" class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">nintendo:</label>
          <input type="text" id="nintendo" name="nintendo" placeholder="true = 0" class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">release:</label>
          <input type="text" id="release" name="release" placeholder="2020-02-02" class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">genre_1:</label>
          <input type="text" id="genre_1" name="genre_1" placeholder="ex: FPS etc..." class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">genre_2:</label>
          <input type="text" id="genre_2" name="genre_2" placeholder="ex: TPS etc..." class="form-control">
        </div>
        <div class="form-group">
          <label for="text1">genre_3:</label>
          <input type="text" id="genre_3" name="genre_3" class="form-control">
        </div>
        <input type="submit" id="add" name="add" value="ADD" class="btn btn-outline-secondary"></input>
      </form>
    </div>
  </body>
</html>
