<?php require_once 'common_parts/head_part.php'; ?>
		<div class="main-wrapper">
			<div class="container">
				<form method="post" id="signup_form">
					<div class="error">
						<?php echo $m; ?>
					</div>
					<h1>新規登録フォーム</h1>
					<div class="form-group">
						<label for="user">ユーザー名</label>
						<input type="text" name="userName" id="user">
						<p class="error message1" id="message0"></p>
					</div>
					<div class="form-group">
						<label for="e-mail">メールアドレス</label>
						<input type="text" name="eMail" id="e-mail">
						<p class="error message1" id="message1"></p>
					</div>
					<div class="form-group">
						<label for="password">パスワード</label>
						<input type="password" name="Password" id="password">
						<p class="error message1" id="message2"></p>
					</div>
					<button type="submit" name="signUp">登録</button>
					<a href="logIn.php">ログインはこちら</a>
				</form>
			</div>
		</div>
<?php require_once 'common_parts/foot_part.php'; ?>
