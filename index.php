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
	header("Location: index.php");
}
$posts = array();
$ids = array();

setArray($posts, $ids, 0);

require_once 'view/index_view.php'
?>
