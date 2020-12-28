<?php
// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 3. エラー処理
        try {
            require_once __DIR__ . '/../manager/dbManager.php';
            $pdo = getDb( "user_info" );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $stmt = $pdo->prepare('SELECT * FROM user WHERE name = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['id'];
                    $sql = "SELECT * FROM user WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                    }
                    $_SESSION["ID"]      = $row['id'];
                    $_SESSION["NAME"]    = $row['name'];
                    $_SESSION["EMAIL"]   = $row['email'];
                    $_SESSION["INFO"]    = $row['info'];
                    $_SESSION["PS"]      = $row['ps'];
                    $_SESSION["DISCORD"] = $row['discord'];
                    $_SESSION["SKYPE"]   = $row['skype'];
                    $_SESSION["STEAM"]   = $row['steam'];

                    header("Location: ../index.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="../css/login.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <title>Sign In</title>
    </head>
    <body>
      <div class="form-wrapper">
        <h1>Sign In</h1>
        <form action="" method="POST">
          <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>

          <div class="form-item">
            <label for="email"></label>
            <input type="text" id="userid" name="userid" required="required" placeholder="UserID or e-mail" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>"></input>
          </div>
          <div class="form-item">
            <label for="password"></label>
            <input type="password" id="password" name="password" required="required" placeholder="Password"></input>
          </div>
          <div class="button-panel">
            <input type="submit" class="button" id="login" name="login" title="Sign In" value="Sign In"></input>
          </div>
        </form>

        <div class="form-footer">
          <p><a href="./SignUp.php">Create an account</a></p>
          <p><a href="#">Forgot password?</a></p>
        </div>
      </div>
    </body>
</html>
