<?php require_once 'common_parts/head_part.php'; ?>
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
<?php require_once 'common_parts/foot_part.php'; ?>
