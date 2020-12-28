<?php
// セッション開始
session_start();
// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワード２が未入力です。';
    } else if (empty($_POST["email"])) {
        $errorMessage = 'e-mailが未入力です。';
    }

    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email    = $_POST["email"];
        $info     = "";

        // 3. エラー処理
        try {
            require_once __DIR__ . '/../manager/dbManager.php';
            $pdo = getDb( "user_info" );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $stmt = $pdo->prepare("INSERT INTO user(name, password, email, info) VALUES (?, ?, ?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $email, $info));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
             $e->getMessage(); /* でエラー内容を参照可能（デバッグ時のみ表示）*/
             echo $e->getMessage();
             $errorMessage = $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="../css/login.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <title>Sign Up</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="passCheck.js"></script>
    </head>
    <body>
      <div class="form-wrapper">
        <h1>Sign Up</h1>
        <form action="" method="POST">
          <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
          <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

          <div class="form-item">
            <label for="username"></label>
            <input type="text" id="username" name="username" placeholder="UserID" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
          </div>
          <div class="form-item">
            <label for="password"></label>
            <input type="password" id="password" name="password" value="" placeholder="Password"><span id="result" name="result"></span>
          </div>
          <div class="form-item">
            <label for="password2"></label>
            <input type="password" id="password2" name="password2" value="" placeholder="Password Again">
          </div>
          <div class="form-item">
            <label for="email"></label>
            <input type="email" id="email" name="email" value="" placeholder="e-mail">
          </div>
          <div class="button-panel">
            <input type="submit" class="button" id="signUp" name="signUp" value="Sign Up">
          </div>
        </form>

        <div class="form-footer">
          <p><a href="./Login.php">Return Sign In</a></p>
        </div>
      </div>
    </body>
</html>
