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
	//deletePostsに削除したい投稿の投稿idを送る
	deletePosts($_GET['post_id']);
	header("Location: index.php");
}
//投稿内容に関する情報を格納
$posts = array();
$ids = array();
//
setArray($posts, $ids, 0);

//表示用ファイルの読み込み
require_once 'view/index_view.php'
?>
