<?php require_once 'common_parts/head_part.php'; ?>
		</div>
		<div class="main-wrapper">
			<div class="container">
				<form method="post" id ="login_form">
					<h1>ログインフォーム</h1>
					<div class="form-group">
						<label for="e-mail">メールアドレス</label>
						<input type="text" name="eMail" id="e-mail">
						<p class="error message1" id="message1"></p>
					</div>
					<div class="form-group">
						<label for="password">パスワード</label>
						<input type="password" name="Password" id="password">
						<p class="error message2" id="message2"></p>
					</div>
					<button class="login" type="submit" name="login">ログイン</button>
					<a href="signUp.php">新規登録はこちら</a>
				</form>
			</div>
		</div>
<?php require_once 'common_parts/foot_part.php'; ?>
