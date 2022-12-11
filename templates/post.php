<?php
declare(strict_types=1);

use Controllers\Posts\GetComments;

$title = 'Post';
$css = ['post-page.css', 'post.css', 'comment.css'];
$js = ['homepage.js'];

ob_start();
require_once 'components/toolbar.php';

global $post;
global $connected_user;
$comments = (new GetComments())->execute($post->id);
?>
	<main class="post-page-container">
		<div class="title">
			<span class="material-symbols-outlined">arrow_back</span>
			<h2>Chat</h2>
		</div>
		<?php
		require_once 'components/post-single.php' ?>
		<div class='comments'>
			<?php
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
