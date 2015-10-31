<?php require_once("parts/header.php");?>
    <div class="top_img"><img src="images/top.jpg"></div>
<h2>ユーザー登録</h2>
    <section class="form">
	<p>すでに登録済みの方は<a href="login.php">こちらからログインできます。</a></p>

	<dl>
        <form action="confirm.php" method="POST">
		<dt>ニックネーム　<span class="alert">*必須項目</span></dt>
        <dd><input type="text" name="nickname" id="nickname" onchange="checkNickname()" maxlength="20" required></dd>
        <div id="nickname_message"></div>

        <dt>メールアドレス　<span class="alert">*必須項目</span></dt>
        <dd><input type="email" name="mail" id="mail" onchange="checkMail()" maxlength="30" required></dd>
        <div id="mail_message"></div>

        <dt>パスワード　<span class="alert">*必須項目</span></dt>
        <dd><input type="password" name="password1" id="password1" onchange="checkPassword()" maxlength="20" required></dd>

        <dt>パスワード（確認用）　<span class="alert">*必須項目</span></dt>
        <dd><input type="password" name="password2" id="password2" onchange="checkPassword()" maxlength="20" required></dd>
        <div id="password_message"></div>

        <dt>利用規約に同意する</dt>
        <dd><input type="checkbox" id="consent" onchange="checkConsent()"></dd>
        <div id="consent_message"></div>
  
        <button type="submit" id="register">登録する</button>
        </form>
    </dl>
    </section>

    <script>

    	//チェック項目の初期化
    	var chk_nickname = false;
    	var chk_mail = false;
    	var chk_password = false;
        var chk_consent = false;

        //jqueryで書いてはみたがエラー・・・なのでこちらで
        var nickname = document.getElementById("nickname");
        var mail = document.getElementById("mail");
        var password1 = document.getElementById("password1");
        var password2 = document.getElementById("password2");
        var consent = document.getElementById("consent");
        var register = document.getElementById("register");

        var nickname_message = document.getElementById("nickname_message");
        var mail_message = document.getElementById("mail_message");
        var password_message = document.getElementById("password_message");
        var consent_message = document.getElementById("consent_message");

        //初期状態でボタンを押せないように
        register.setAttribute("disabled","disabled");

    	//ニックネームの重複チェック
    	function checkNickname(){
            var input_nickname = nickname.value;
            if(input_nickname == ""){
                chk_nickname = false;
                return;
            }
    		$.ajax({
                type : "POST",
                url : "php/check.php",
                data: {
                    "item" : "1",
                    "value" : input_nickname
                }
            })
            .done(function(data){
                if(data == 1){
                    chk_nickname = false;
                    nickname_message.innerHTML = "<p class='alert'>このニックネームは既に使われています。</p>";
                }else if(data == 0){
                    chk_nickname = true;
                    nickname_message.innerHTML = "<p class='correct'>このニックネームは使用できます。</p>";
                } else {
                    chk_nickname = true;
                    nickname_message.innerHTML = "エラーです。";
                }
            })
            .fail(function(){console.log("NG");});
            checkAll();
        }


    	//メールの重複チェック
    	function checkMail(){
            var input_mail = mail.value;
            
            $.ajax({
                type : "POST",
                url : "php/check.php",
                data: {
                    "item" : "2",
                    "value" : input_mail
                }
            })
            .done(function(data){
                if(data == 1){
                    chk_mail = false;
                    mail_message.innerHTML = "<p class='alert'>このメールアドレスは既に登録済みです。</p>";
                }else if(data == 0){
                    chk_mail = true;
                    mail_message.innerHTML = "<p class='correct'>このメールアドレスは使用できます。</p>";
                } else {
                    chk_mail = true;
                    mail_message.innerHTML = "エラーです。";
                }
            })
            .fail(function(){console.log("NG");});
            checkAll();
    	}

    	//パスワードチェック
    	function checkPassword(){
            var input_password1 = password1.value;
            var input_password2 = password2.value;
            if(input_password2 == ""){
                chk_password = false;
                password_message.innerHTML = "<p class='alert'>確認パスワードを入力してください</p>";
                return;
            }
            
            if(input_password1 == input_password2){
                chk_password = true;
                password_message.innerHTML = "<p class='correct'>パスワード一致しました。</p>";
            } else {
                chk_password = false;
                password_message.innerHTML = "<p class='alert'>パスワードが一致しません。</p>";
            }

            checkAll();
    	}

        //利用規約同意
        function checkConsent(){
            if(consent.checked){
                chk_consent = true;
                consent_message.innerHTML = "<p class='correct'>同意いただきありがとうございます。</p>";
            }else{
                chk_consent = false;
                consent_message.innerHTML = "<p class='alert'>利用規約に同意してください。</p>";
            }

            checkAll();
        }

        //登録ボタンの有効化の判定
        function checkAll(){
            if(register.disabled){
                if(chk_nickname && chk_mail && chk_password && chk_consent){
                    register.removeAttribute("disabled");
                }
            }else{
                register.setAttribute("disabled","disabled");
            }
        }

    	//フォーム作成
		function registerUser(){
    		var form = document.createElement('form');
    		form.action = "confirm.php";
    		form.method = "post";
    		form.innerHTML = "<input name='nickname' type='hidden' value='" + nickname.value + "'>";
    		form.innerHTML += "<input name='mail' type='hidden' value='" + mail.value + "'>";
    		form.innerHTML += "<input name='password' type='hidden' value='" + password1.value + "'>";
    		document.body.appendChild(form); 
    		form.submit();
 	   }

    </script>
<?php require_once("parts/footer.php");?>