<?php
require_once 'dbconnect.php';
require_once 'function/dbcontrol.php';
require_once 'function/viewcontrol.php';

$post_id = filter_input(INPUT_GET, 'post_id');
header('Content-type:application/json; character=utf-8');
session_start();

//htmlコードを文字列として代入するための変数
$result = "";
//DBから取得したコメント情報を保存するための変数(表示する情報：投稿者名，投稿内容，…)
$comments = array();
// DBから取得したコメント情報を保存するための変数（表示しない情報：ユーザーidと投稿id：<button>などのidに使用する）
$ids = array();
// $post_idへのコメントの情報を$idsと、$post_idに格納する
setArray($comments, $ids, $post_id);

// $comment等に格納された情報を使用して、$resultにhtmlコードを格納。
$result .= printP($comments, $ids, $result);

//$resultの内容をjson形式に変換して終了
echo json_encode($result);
// exit();
?>
