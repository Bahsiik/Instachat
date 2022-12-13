<?php
declare(strict_types=1);

use Src\Controllers\comments\GetCommentsFeed;

$title = 'Post';
$css = ['post-page.css', 'post.css', 'comment.css'];
$js = ['anchors.js', 'posts.js', 'popup.js', 'fetch-feed.js', 'comments.js'];

ob_start();
require_once 'components/toolbar.php';

global $post, $connected_user;
$comments = (new GetCommentsFeed())->execute($post->id);
?>
	<main class="post-page-container">
		<div class="title">
			<a class="arrow-back" href="/">
				<span class="material-symbols-outlined">arrow_back</span>
				<h2>Chat</h2>
			</a>
		</div>
		<?php
		require_once 'components/post-single.php' ?>
		<div class='comments'>
			<?php
			require_once 'components/comment-create.php';
			if (count($comments) > 0) {
				global $comment;
				foreach ($comments as $comment) require 'components/comment.php';
			} else {
				?>
				<div class="no-comments">
					<p>Aucun commentaire</p>
				</div>
				<?php
			}
			?>
		</div>
	</main>
<?php
require_once 'components/trends.php';
$content = ob_get_clean();
require_once 'layout.php';
