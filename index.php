<?php
session_start();
require_once 'dbconnect.php';
require_once 'function/dbcontrol.php';
require_once 'function/viewcontrol.php';

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}


$m ="";
$count = 0;
// 投稿削除処理
if(isset($_GET['post_id'])){
	if(!isset($_SESSION['user'])) {
	  header("Location: index.php");
		exit();
	}
	deletePosts($_GET['post_id']);
	// header("Location: index.php");
}
$posts = array();
$ids = array();

setArray($posts, $ids, 0);
?>


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
		<div class="bbs-wrapper">
			<div class="container">
					<div class="bbses">
					  <a href="post.php" class="btn"><span class="fas fa-pencil-alt"></span>新規投稿する</a>
					  <h2>投稿一覧（<?php echo count($posts); ?>件）</h2>
						<?php if(count($posts) > 0): ?>
						  <p id="delete_message"><?php echo $m; ?></p>
						  <?php printPost($posts, $ids); ?>
						<?php else: ?>
						  <h4>まだ投稿はありません。</h3>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/click.js"></script>
	</body>
</html>
