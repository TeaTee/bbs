<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="utf-8" />
		<title>掲示板</title>
		<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="top-wrapper">
			<div class="container">
				<a href="index.php">掲示板</a>
				<?php if(!isset($_SESSION['user'])): ?>
					<a href="signUp.php">新規登録</a>
					<a href="logIn.php">ログイン</a>
				<?php else: ?>
					<a href="logOut.php">ログアウト</a>
				<?php endif; ?>
				<div class="clear"></div>
			</div>
		</div>
