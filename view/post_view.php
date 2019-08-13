<?php require_once 'common_parts/head_part.php'; ?>
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
<?php require_once 'common_parts/foot_part.php'; ?>
