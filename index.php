<?php
session_start();
include_once 'dbconnect.php';

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function setArray(&$posts, &$ids){
	try {
		global $dbh;
		//投稿表示処理
		$query = "SELECT posts.id AS 'post_id', posts.user_id AS 'user_id', message, username, imgName, posted_at FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE comment_id = 0 ORDER BY posted_at DESC";
		$stmt = $dbh->prepare($query);
		$stmt->execute();

		foreach ($stmt as $row){
		  if($row["username"] === NULL) $row["username"] = "名無しさん";
		  $arr1 = array(
		    "投稿者名" => $row["username"],
		    "投稿内容" => $row["message"],
		    "投稿写真" => $row["imgName"],
		    "投稿時間" => $row["posted_at"]
		  );
		  $posts[] = $arr1;

		  $arr2 = array(
				"user_id" => $row["user_id"],
				"post_id"=> $row["post_id"]
		  );
		  $ids[] = $arr2;
		}
	}catch(PDOException $e) {
		echo '投稿情報取得エラー：'.$e->getMessage();
	}
	return array($posts,$ids);
}

function printPost($arr1, $arr2){
	for($i = 0; $i < count($arr1); $i++) {
		echo "<div class='pos pos".$arr2[$i]['post_id']."'>";
		foreach($arr1[$i] as $key => $value){
			// 写真がなければ、 次のループへ／あれば、表示
			if ($key === "投稿写真" && ($value === NULL || $value ==="")){

			}
			else if($key === "投稿写真"){
				echo "<img src='img/{$value}' alt='' width='100%'>";

			}else if($key === "投稿内容") {
				echo "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}else{
				echo "<p><span class='heading pos_heading'>{$key}：</span>{$value}</p>";
			}
		}
		echo "<a href='post.php?num={$arr2[$i]['post_id']}' class='create'><span class='far fa-comment-dots'></span>コメントする</a>";
		if(isset($_SESSION['user']) && $arr2[$i]['user_id'] === $_SESSION['user']){
				echo "<a href='index.php?post_id={$arr2[$i]['post_id']}' class='delete'><span class='fas fa-trash-alt'></span></a>";
		}
		echo "<div class='clear'></div>";
		echo "<div class='comment-wrapper' id='comment-{$arr2[$i]['post_id']}'></div>";
		echo "<button type='button' class='btn comment-display'>コメントを見る</button>";
		echo "<button type='button' class='btn comment-hidden'>コメントを閉じる</button>";
		echo "</div>";
	}
}

//投稿削除+画像削除　用関数　
function deletePosts($post_id){
	global $dbh, $count;
	try {
		$query = "SELECT imgName FROM posts WHERE id = :post_id";
		$stmt = $dbh->prepare($query);
		$stmt->bindValue(':post_id', $_GET['post_id']);
		$result = $stmt->execute();

		foreach ($stmt as $row) {
			if($row['imgName']!=="") unlink(dirname(__FILE__).'/img/'.$row['imgName']);
		}

		$query = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
		$stmt = $dbh->prepare($query);
		$stmt->bindValue(':post_id', $_GET['post_id']);
		$stmt->bindValue(':user_id', $_SESSION['user']);
		$stmt->execute();

	}catch(PDOException $e) {
		echo '投稿削除エラー：' . $e->getMessage();
	}
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

setArray($posts, $ids);
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
