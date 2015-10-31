<?php if(isset($_SESSION["user"])):?>
    <div>
      <h3>ログアウト</h3>
      <form action="login.php" method="POST">
        <input type="submit" value="Logout" name="logout"/>
      </form>  
    </div>
<?php else:?>
  <h3>ログイン</h3>
    <form id="loginForm" name="loginForm" action="login.php" method="POST">
        <dl>
          <dt>メールアドレス</dt>
          <dd><input type="mail" name="mail" id="mail" required></dd>
        </dl>
        <dl>
          <dt>パスワード</dt>
          <dd><input type="password" name="password" id="password" required></dd>
        </dl>
        <input type="submit" value="Login" name="login"/>
    </form>
    <a href="register.php">こちらからユーザー登録ができます。</a><br />
    <a href="forget.php">パスワードを忘れた方はこちから</a>
<?php endif;?>