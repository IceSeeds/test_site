<?php
/*
function getImage( $gets )
{
  require_once __DIR__ . '/../manager/dbManager.php';
  $pdo = getDb( "my_image" );
  $getid = (int)$gets;

  $sql = "SELECT * FROM images WHERE image_id = $getid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $image = $stmt->fetch();

  header('Content-type: ' . $image['image_type']);
  //echo '<img src="' . $image['image_content'] . '" alt="画像">';
  echo $image['image_content'];

  unset($pdo);
  exit();
}
*/

  require_once __DIR__ . '/../manager/dbManager.php';
  $pdo = getDb( "my_image" );

  $dd = (int)$_GET['id'];

  $sql = 'SELECT * FROM images WHERE image_id = :image_id LIMIT 1';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':image_id', $dd, PDO::PARAM_INT);
  $stmt->execute();
  $image = $stmt->fetch();

  header('Content-type: ' . $image['image_type']);
  echo $image['image_content'];

  unset($pdo);
  exit();

?>
