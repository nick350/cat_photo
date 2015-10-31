<?php require_once("parts/header.php");
require_once('php/password.php');

// エラーメッセージの初期化
$error_message = "";

//ログアウト処理
if(isset($_POST["logout"])){
  $_SESSION["user"] = null;
  $error_message = "ログアウトしました。";
  $user_name = "ゲストユーザー";
}

if (isset($_POST["login"])) {
  //ユーザIDの入力チェック
  if (empty($_POST["mail"])) {
    $error_message = "メールアドレスを入力してください。";
  } else if (empty($_POST["password"])) {
    $error_message = "パスワードを入力してください。";
  } 

  // ユーザIDとパスワードが入力されていたら認証
  if (!empty($_POST["mail"]) && !empty($_POST["password"])) {
    $mail = $_POST["mail"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `users` WHERE `mail` = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(1, $mail, PDO::PARAM_STR);
    $result = $sth->execute();

    while ($row = $sth->fetch()) {
 		$db_hashed_pwd = $row["password"];
    $id = $row["user_id"];
    $nickname = $row["nickname"];
    } 

    // パスワードの比較
    if (isset($db_hashed_pwd) && password_verify($password, $db_hashed_pwd)) {
      // 認証成功なら、セッションIDを新規発行画面変性
      session_regenerate_id(true);
      $_SESSION["user"] = array($id,$nickname);
      	echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
      exit;
    } 
    else {
      // 失敗
      $error_message = "ユーザーあるいはパスワードに誤りがあります。";
    } 
  } else {
    // 未入力なら何もしない
  } 
}

?>
  <div class="top_img"><img src="images/top.jpg" alt="秋だにゃ！"></div>
  <h2>ログイン</h2>

<?=$error_message;?>
<section class="form">
<?php require_once("parts/login_form.php");?>
</section>

<?php require_once("parts/footer.php");?>