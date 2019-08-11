<?php
session_start();
include_once 'dbconnect.php';
date_default_timezone_set('Asia/Tokyo');
define('DIR', dirname(__FILE__).'/img/');
//CSRF対策
function setToken()	{
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['token'] = $token;
}
function checkToken(){
	if(empty($_SESSION['token']) || ($_SESSION['token'] !== $_POST['token'])) {
		echo "不正なPOSTが行われました！";
		exit;
	}
}
$user_id = 0;
if(isset($_SESSION['user'])){
	$user_id = $_SESSION['user'];
}


if(($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['message']))){
	checkToken();
	$message = trim($_POST['message']);
	$posted_at = $_POST['posted_at'];
	$imgName = "";
	// echo $_FILES['imageFile']['name'];
	//画像ファイルがあった場合
	if(!empty($_FILES['imageFile']['name'])){

		$imageFile = $_FILES['imageFile']['name'];
		//アップされた画像の拡張子を抜き出す
		$ext=substr($imageFile,-3);
		//拡張子を調べて画像のアップ
		if($ext!=="jpg" && $ext!=="gif" && $ext!=="png"){
			$er["image"]="拡張子がjpgとgifとpngのみアップできます";
		}else if(preg_match("/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[一-龠]+|[ａ-ｚＡ-Ｚ０-９]/u", $imageFile)){
			$er["name"]="半角英数字のファイルのみアップロードできます。";
		}
		if(empty ($er)){
			$imgName = $posted_at.$imageFile;
			//ファイルの保存先
			$dir = DIR.$imgName;
			//アップロードが正しく完了したかチェック
			if(move_uploaded_file($_FILES['imageFile']['tmp_name'], $dir)){
				echo '画像のアップロード完了';
			}else{
				echo 'アップロード失敗';
			}
		}else {
			foreach ($er as $e) {
				echo $e;
			}
		}
	}
	$comment_id = 0;
	if(isset($_GET['num'])){
		$comment_id = $_GET['num'];
	}
	try {
		$query = "INSERT INTO posts(user_id, message, imgName, posted_at, comment_id) VALUES(:user_id, :message, :imgName, :posted_at, :comment_id)";
		$stmt = $dbh->prepare($query);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindValue(':message', $message, PDO::PARAM_STR);
		$stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
		$stmt->bindValue(':posted_at', $posted_at, PDO::PARAM_STR);
		$stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
		$stmt->execute();
		// header("Location: index.php");
	}catch(PDOException $e) {
		echo '投稿エラー：'.$e->getMessage();
	}

}else {
	setToken();
	// echo 'トークンをセットしました';
}


?>

<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="utf-8" />
		<title>掲示板</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="top-wrapper">
			<?php if(!isset($_SESSION['user'])): ?>
				<a href="signUp.php">新規登録</a>する
			<?php else: ?>
				<a href="logOut.php">ログアウト</a>する
			<?php endif; ?>
		</div>
		<div class="post-wrapper">
			<div class="container">
				<form method="post" id="post_form" enctype="multipart/form-data">
					<h1>投稿する</h1>
					<div class="form-group">
						<label for="message">投稿内容</label><br>
						<textarea name="message" rows="5" cols="28" id="comment"></textarea>
						<p class="error message" id="message1"></p>
					</div>
					<div class="form-group">
						<label for="image">画像を投稿する</label><br>
						<input name="imageFile" type="file" id="image"/>
					</div>
					<div class="form-group">
						<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
						<input type="hidden" name="posted_at" value="<?php echo date('Y-m-d_H-i-s'); ?>">
					</div>
					<button type="submit" name="do_post" id="postButton">投稿する</button>
				</form>
			</div>
		</div>
		<a href="index.php">掲示板を見る</a>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/submit.js"></script>
	</body>
</html>
